<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Models\Cart\Order;
use App\Models\Payment;
use App\Models\Shop\ProductShop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use RuntimeException;

class PaymentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | نمایش درگاه پرداخت آزمایشی
    |--------------------------------------------------------------------------
    */

    public function show(string $locale, Order $order)
    {
        $this->checkOrderAccess($order);

        if (in_array($order->status, [
            'paid',
            'processing',
            'shipped',
            'delivered',
        ], true)) {

            return redirect()
                ->route('checkout.success', [
                    'locale' => $locale,
                    'order'  => $order->id,
                ])
                ->with('error', 'این سفارش قبلاً پرداخت شده است.');
        }

        if ($order->status === 'cancelled') {

            return redirect()
                ->route('checkout.success', [
                    'locale' => $locale,
                    'order'  => $order->id,
                ])
                ->with('error', 'این سفارش لغو شده است.');
        }

        $payment = DB::transaction(function () use ($order) {

            $lockedOrder = Order::whereKey($order->id)
                ->lockForUpdate()
                ->firstOrFail();

            // بررسی پرداخت موفق قبلی
            $successfulPayment = $lockedOrder
                ->successfulPayment()
                ->first();

            if ($successfulPayment) {
                return $successfulPayment;
            }

            if ($lockedOrder->status === 'cancelled') {
                abort(403, 'این سفارش لغو شده است.');
            }

            return $this->createOrGetPendingPayment(
                $lockedOrder
            );

        }, 5);

        if ($payment->status === 'success') {

            return redirect()->route('payment.success', [
                'locale'  => $locale,
                'payment' => $payment->id,
            ]);
        }

        if ($payment->status !== 'pending') {

            return redirect()
                ->route('payment.failed', [
                    'locale'  => $locale,
                    'payment' => $payment->id,
                ])
                ->with('error', 'این پرداخت دیگر قابل استفاده نیست.');
        }

        return view(
            'shop.payment.gateway',
            compact('order', 'payment', 'locale')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | پردازش پرداخت
    |--------------------------------------------------------------------------
    */

    public function process(
        Request $request,
        string $locale,
        Order $order
    ) {

        $this->checkOrderAccess($order);

        $validated = $request->validate([

            'payment_id' => [
                'required',
                'integer',
            ],

            'action' => [
                'required',
                'in:success,failed,canceled',
            ],

        ]);

        $payment = DB::transaction(function () use (
            $order,
            $validated
        ) {

            // قفل سفارش
            $lockedOrder = Order::whereKey($order->id)
                ->lockForUpdate()
                ->firstOrFail();

            // قفل پرداخت
            $lockedPayment = Payment::whereKey(
                $validated['payment_id']
            )
                ->where('order_id', $lockedOrder->id)
                ->lockForUpdate()
                ->firstOrFail();

            // جلوگیری از پرداخت مجدد
            $successfulPayment = $lockedOrder
                ->successfulPayment()
                ->first();

            if ($successfulPayment) {
                return $successfulPayment;
            }

            if ($lockedOrder->status === 'cancelled') {
                abort(403, 'این سفارش لغو شده است.');
            }

            // فقط پرداخت pending قابل پردازش است
            if ($lockedPayment->status !== 'pending') {
                return $lockedPayment;
            }

            /*
            |--------------------------------------------------------------------------
            | پرداخت موفق
            |--------------------------------------------------------------------------
            */

            if ($validated['action'] === 'success') {

                // بررسی و قفل موجودی محصولات
                $this->assertStockAvailable($lockedOrder);

                // ثبت پرداخت موفق
                $lockedPayment->markAsSuccess(
                    gatewayResponse: [

                        'message' => 'Sandbox payment successful',

                        'processed_at' => now()->toDateTimeString(),

                        'raw' => [
                            'gateway' => 'sandbox',
                            'action'  => 'success',
                        ],

                    ]
                );

                // ثبت زمان پرداخت
                $lockedOrder->update([
                    'paid_at' => now(),
                ]);

                // کاهش موجودی
                $this->decreaseStock($lockedOrder);

            }

            /*
            |--------------------------------------------------------------------------
            | پرداخت ناموفق
            |--------------------------------------------------------------------------
            */

            elseif ($validated['action'] === 'failed') {

                $lockedPayment->markAsFailed(
                    reason: 'Sandbox payment failed',

                    gatewayResponse: [

                        'message' => 'Sandbox payment failed',

                        'processed_at' => now()->toDateTimeString(),

                        'raw' => [
                            'gateway' => 'sandbox',
                            'action'  => 'failed',
                        ],

                    ]
                );

            }

            /*
            |--------------------------------------------------------------------------
            | لغو پرداخت
            |--------------------------------------------------------------------------
            */

            elseif ($validated['action'] === 'canceled') {

                $lockedPayment->markAsCanceled(
                    'User canceled payment'
                );

            }

            return $lockedPayment->fresh();

        }, 5);


        /*
        |--------------------------------------------------------------------------
        | انتقال به صفحه نتیجه
        |--------------------------------------------------------------------------
        */

        $routes = [

            'success'  => 'payment.success',

            'failed'   => 'payment.failed',

            'canceled' => 'payment.canceled',

            'refunded' => 'payment.success',

        ];

        return redirect()->route(

            $routes[$payment->status] ?? 'payment.failed',

            [
                'locale'  => $locale,
                'payment' => $payment->id,
            ]

        );
    }


    /*
    |--------------------------------------------------------------------------
    | صفحه پرداخت موفق
    |--------------------------------------------------------------------------
    */

    public function success(string $locale, Payment $payment)
    {
        return $this->showResult(
            $payment,
            $locale,
            'success'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | صفحه پرداخت ناموفق
    |--------------------------------------------------------------------------
    */

    public function failed(string $locale, Payment $payment)
    {
        return $this->showResult(
            $payment,
            $locale,
            'failed'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | صفحه پرداخت لغوشده
    |--------------------------------------------------------------------------
    */

    public function canceled(string $locale, Payment $payment)
    {
        return $this->showResult(
            $payment,
            $locale,
            'canceled'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | نمایش نتیجه پرداخت
    |--------------------------------------------------------------------------
    */

    private function showResult(
        Payment $payment,
        string $locale,
        string $status
    ) {

        $payment->load('order');

        abort_if(
            !$payment->order,
            404
        );

        $this->checkOrderAccess($payment->order);

        abort_unless(
            $payment->status === $status,
            404
        );

        $payment->load('order.items');

        return view(
            'shop.payment.' . $status,
            compact('payment', 'locale')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ایجاد یا بازیابی پرداخت در انتظار
    |--------------------------------------------------------------------------
    */

    private function createOrGetPendingPayment(
        Order $lockedOrder
    ): Payment {

        // بررسی پرداخت pending قبلی
        $existing = Payment::where('order_id', $lockedOrder->id)
            ->where('status', 'pending')
            ->first();

        if ($existing) {
            return $existing;
        }

        // ایجاد پرداخت جدید
        return Payment::createAtomic([

            'order_id' => $lockedOrder->id,

            'status' => 'pending',

            'transaction_id' =>
                'SBX-' . strtoupper(Str::random(12)),

            'amount' => (int) $lockedOrder->total_amount,

            'currency' => 'toman',

            'gateway' => 'sandbox',

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | بررسی موجودی محصولات
    |--------------------------------------------------------------------------
    */

    private function assertStockAvailable(Order $order): void
    {
        $order->loadMissing('items');

        foreach ($order->items as $item) {

            $product = ProductShop::whereKey(
                $item->product_shop_id
            )
                ->lockForUpdate()
                ->first();

            if (!$product) {

                throw new RuntimeException(
                    'محصول «' .
                    ($item->product_name ?? $item->product_shop_id) .
                    '» دیگر موجود نیست.'
                );
            }

            $stock = (int) ($product->stock_quantity ?? 0);

            $quantity = (int) $item->quantity;

            if ($stock < $quantity) {

                throw new RuntimeException(
                    sprintf(
                        'موجودی محصول «%s» کافی نیست. موجودی: %d، تعداد درخواستی: %d',
                        $product->name ?? $item->product_name,
                        $stock,
                        $quantity
                    )
                );
            }
        }
    }


    /*
    |--------------------------------------------------------------------------
    | کاهش موجودی محصولات پس از پرداخت
    |--------------------------------------------------------------------------
    */

    private function decreaseStock(Order $order): void
    {
        $order->loadMissing('items');

        foreach ($order->items as $item) {

            $product = ProductShop::whereKey(
                $item->product_shop_id
            )
                ->lockForUpdate()
                ->firstOrFail();

            $quantity = (int) $item->quantity;

            $product->decrement(
                'stock_quantity',
                $quantity
            );

            Log::info('Product stock decreased', [

                'order_id' => $order->id,

                'product_id' => $product->id,

                'quantity' => $quantity,

                'remaining_stock' =>
                    $product->fresh()->stock_quantity,

            ]);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | بازگرداندن موجودی محصولات
    |--------------------------------------------------------------------------
    */

    public function restoreStock(Order $order): void
    {
        DB::transaction(function () use ($order) {

            $order->loadMissing('items');

            foreach ($order->items as $item) {

                $product = ProductShop::whereKey(
                    $item->product_shop_id
                )
                    ->lockForUpdate()
                    ->first();

                if ($product) {

                    $product->increment(
                        'stock_quantity',
                        (int) $item->quantity
                    );

                }
            }

            Log::info(
                'Stock restored for order',
                ['order_id' => $order->id]
            );

        }, 5);
    }


    /*
    |--------------------------------------------------------------------------
    | بررسی دسترسی به سفارش
    |--------------------------------------------------------------------------
    */

    private function checkOrderAccess(Order $order): void
    {
        $currentUserId = auth()->id();

        $orderUserId = $order->user_id;

        // سفارش کاربران ثبت‌نام‌شده
        if ($orderUserId !== null) {

            abort_unless(

                (int) $orderUserId === (int) $currentUserId,

                403,

                'این سفارش متعلق به شما نیست.'

            );

            return;
        }

        // سفارش مهمان
        $hasDirectAccess =

            session()->get(
                'checkout_order_' . $order->id
            ) === $order->tracking_code;


        $guestOrderIds = array_map(
            'intval',
            session()->get('guest_order_ids', [])
        );


        $hasListAccess = in_array(
            (int) $order->id,
            $guestOrderIds,
            true
        );


        abort_unless(

            $hasDirectAccess || $hasListAccess,

            403,

            'دسترسی به این سفارش مجاز نیست.'

        );
    }
}

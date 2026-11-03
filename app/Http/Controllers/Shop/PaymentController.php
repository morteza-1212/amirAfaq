<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Cart\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    /**
     * نمایش صفحه درگاه آزمایشی
     */
    public function show(string $locale, Order $order)
    {
        if ($order->status !== 'pending') {
            return redirect()
                ->route('checkout.success', ['locale' => $locale, 'order' => $order->id])
                ->with('error', 'این سفارش قبلاً پردازش شده است.');
        }

        // ✅ بررسی مالکیت با متد مشترک
        $this->checkOrderAccess($order);

        $payment = Payment::firstOrCreate(
            [
                'order_id' => $order->id,
                'status'   => 'pending',
            ],
            [
                'transaction_id' => 'SBX-' . strtoupper(Str::random(12)),
                'amount'         => (int) $order->total_amount,
                'currency'       => 'toman',
                'gateway'        => 'sandbox',
            ]
        );

        return view('shop.payment.gateway', compact('order', 'payment', 'locale'));
    }

    /**
     * پردازش پرداخت آزمایشی
     */
    public function process(
        Request $request,
        string $locale,
        Order $order
    ) {
        $this->checkOrderAccess($order);

        $validated = $request->validate([
            'payment_id' => ['required', 'integer'],
            'action' => ['required', 'in:success,failed,canceled'],
        ]);

        $payment = DB::transaction(function () use (
            $order,
            $validated
        ) {
            $lockedOrder = Order::whereKey($order->id)
                ->lockForUpdate()
                ->firstOrFail();

            $lockedPayment = Payment::where('id', $validated['payment_id'])
                ->where('order_id', $lockedOrder->id)
                ->lockForUpdate()
                ->firstOrFail();

            // اگر سفارش قبلاً پرداخت شده باشد
            if ($lockedOrder->status === 'paid') {
                return $lockedOrder->successfulPayment()->firstOrFail();
            }

            // جلوگیری از پرداخت مجدد
            if ($lockedOrder->successfulPayment()->exists()) {
                return $lockedOrder->successfulPayment()->firstOrFail();
            }

            if ($lockedOrder->status === 'cancelled') {
                abort(403, 'این سفارش لغو شده است.');
            }

            // جلوگیری از تغییر نتیجه پرداخت قبلی
            if ($lockedPayment->status !== 'pending') {
                return $lockedPayment;
            }

            $action = $validated['action'];

            if ($action === 'success') {

                $lockedPayment->update([
                    'status' => 'success',
                    'paid_at' => now(),
                    'metadata' => [
                        'message' => 'Sandbox payment successful',
                        'processed_at' => now()->toDateTimeString(),
                    ],
                ]);

                $lockedOrder->update([
                    'status' => 'paid',
                ]);

            } elseif ($action === 'failed') {

                $lockedPayment->update([
                    'status' => 'failed',
                    'metadata' => [
                        'message' => 'Sandbox payment failed',
                        'processed_at' => now()->toDateTimeString(),
                    ],
                ]);

            } elseif ($action === 'canceled') {

                $lockedPayment->update([
                    'status' => 'canceled',
                    'metadata' => [
                        'message' => 'User canceled payment',
                        'processed_at' => now()->toDateTimeString(),
                    ],
                ]);
            }

            return $lockedPayment;
        });

        // هدایت به صفحه متناسب با نتیجه پرداخت
        $routes = [
            'success' => 'payment.success',
            'failed' => 'payment.failed',
            'canceled' => 'payment.canceled',
        ];

        return redirect()->route(
            $routes[$payment->status],
            [
                'locale' => $locale,
                'payment' => $payment->id,
            ]
        );
    }

    /**
     * نمایش پرداخت موفق
     */
    public function success(string $locale, Payment $payment)
    {
        return $this->showResult($payment, $locale, 'success');
    }

    /**
     * نمایش پرداخت ناموفق
     */
    public function failed(string $locale, Payment $payment)
    {
        return $this->showResult($payment, $locale, 'failed');
    }

    /**
     * نمایش انصراف از پرداخت
     */
    public function canceled(string $locale, Payment $payment)
    {
        return $this->showResult($payment, $locale, 'canceled');
    }

    /**
     * نمایش صفحه نتیجه پرداخت
     */
    private function showResult(
        Payment $payment,
        string $locale,
        string $status
    ) {
        $this->checkOrderAccess($payment->order);

        abort_unless($payment->status === $status, 404);

        $payment->load('order');

        return view(
            'shop.payment.' . $status,
            compact('payment', 'locale')
        );
    }

    /**
     * بررسی مالکیت سفارش
     */
    private function checkOrderAccess(Order $order): void
    {
        $currentUserId = auth()->id();
        $orderUserId   = $order->user_id;

        // اگر سفارش متعلق به کاربر خاصی است
        if ($orderUserId !== null) {
            abort_unless(
                (int) $orderUserId === (int) $currentUserId,
                403,
                'این سفارش متعلق به شما نیست.'
            );
            return;
        }

        // سفارش مهمان — بررسی session
        $sessionKey = 'checkout_order_' . $order->id;
        abort_unless(
            session()->get($sessionKey) === $order->tracking_code,
            403,
            'دسترسی به این سفارش مجاز نیست.'
        );
    }
}

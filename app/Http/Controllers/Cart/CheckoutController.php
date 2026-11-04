<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Models\Cart\Order;
<<<<<<< HEAD
use App\Models\Cart\OrderItem;
use App\Models\User;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function __construct(private CartService $cartService) {}

    /**
     * نمایش صفحه نهایی‌سازی سفارش
     */
    public function index(Request $request)
    {
        $cart = $this->cartService->resolveCart($request)->load('items.product');

        if (! $cart->items || $cart->items->isEmpty()) {
=======
use App\Services\CartService;
use App\Services\Checkout as CheckoutService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    public function __construct(
        private CartService     $cartService,
        private CheckoutService $checkoutService,
    ) {}

    /*
    |--------------------------------------------------------------------------
    | نمایش صفحه نهایی‌سازی سفارش
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $cart = $this->cartService->resolveCart($request)->load('items.productShop');

        if ($cart->items_count === 0 || $cart->items->isEmpty()) {
>>>>>>> a96f8e3 (complateforCartshoping)
            return redirect()
                ->route('cart.show', ['locale' => $request->route('locale')])
                ->with('error', 'سبد خرید شما خالی است.');
        }

<<<<<<< HEAD
        if ($cart->isGuest() && (! $cart->guest_name || ! $cart->guest_phone)) {
=======
        if ($cart->isGuest() && (blank($cart->guest_name) || blank($cart->guest_phone))) {
>>>>>>> a96f8e3 (complateforCartshoping)
            return redirect()
                ->route('cart.show', ['locale' => $request->route('locale')])
                ->with('error', 'لطفاً ابتدا اطلاعات تماس خود را در صفحه سبد خرید وارد کنید.');
        }

<<<<<<< HEAD
        $user    = $request->user();
        $address = $user?->addresses()->where('is_default', true)->first();

        return view('cart.checkout.index', [
            'cart'    => $cart,
            'user'    => $user,
            'address' => $address,
        ]);
    }

    /**
     * ثبت سفارش → هدایت به درگاه پرداخت
     */
=======
        $prepared = $this->cartService->prepareForCheckout($cart);

        $user    = $request->user();
        // ✅ آدرس روی خود User ذخیره شده است
        $address = $user;   // همان کاربر به‌عنوان منبع آدرس

        return view('cart.checkout.index', [
            'cart'          => $cart,
            'user'          => $user,
            'address'       => $address,
            'prepared'      => $prepared,
            'price_changes' => $prepared['price_changes'],
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | ثبت سفارش → هدایت به درگاه پرداخت
    |--------------------------------------------------------------------------
    */
>>>>>>> a96f8e3 (complateforCartshoping)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'shipping_address'  => ['required', 'string', 'max:500'],
            'shipping_city'     => ['required', 'string', 'max:100'],
            'shipping_postcode' => ['nullable', 'string', 'max:20'],
            'shipping_phone'    => ['required', 'string', 'regex:/^09\d{9}$/'],
            'recipient_name'    => ['required', 'string', 'max:150'],
            'notes'             => ['nullable', 'string', 'max:1000'],
            'payment_method'    => ['required', 'in:cod,online'],
            'shipping_province' => ['required', 'string', 'max:100'],
        ]);

<<<<<<< HEAD
        $cart = $this->cartService->resolveCart($request)->load('items.product');

        if (! $cart->items || $cart->items->isEmpty()) {
=======
        $cart = $this->cartService->resolveCart($request)->load('items.productShop');

        if ($cart->items->isEmpty()) {
>>>>>>> a96f8e3 (complateforCartshoping)
            return redirect()
                ->route('cart.show', ['locale' => $request->route('locale')])
                ->with('error', 'سبد خرید شما خالی است.');
        }

<<<<<<< HEAD
        try {
            $order = DB::transaction(function () use ($request, $validated, $cart) {
                // ساخت سفارش
                $order = Order::create([
                    'user_id'          => $request->user()?->id,
                    'tracking_code'    => strtoupper(Str::random(12)),

                    'customer_name'    => $validated['recipient_name'],
                    'customer_phone'   => $validated['shipping_phone'],
                    'customer_email'   => $cart->guest_email,

                    'shipping_address' => $validated['shipping_address'],
                    'postal_code'      => $validated['shipping_postcode'] ?? null,
                    'city'             => $validated['shipping_city'],
                    'province'         => $validated['shipping_province'],

                    'subtotal'         => (int) $cart->subtotal,
                    'shipping_cost'    => 0,
                    'discount'         => 0,
                    'total_amount'     => (int) $cart->subtotal,

                    'payment_method'   => $validated['payment_method'],
                    'status'           => 'pending',
                ]);

                // آیتم‌های سفارش
                foreach ($cart->items as $item) {
                    OrderItem::create([
                        'order_id'        => $order->id,
                        'product_shop_id' => $item->product_shop_id,
                        'product_name'    => $item->product?->name ?? 'محصول حذف شده',
                        'unit_price'      => (int) $item->unit_price,
                        'quantity'        => (int) $item->quantity,
                        'total_price'     => (int) $item->total_price,
                    ]);
                }

                // خالی کردن سبد
                $this->cartService->clear($cart);

                return $order;
            });

            // ✅ ذخیره دسترسی سفارش در session (خارج از تراکنش)
            session()->put('checkout_order_' . $order->id, $order->tracking_code);

            if (! $request->user()) {
                session()->push('guest_order_ids', $order->id);
            }

            // 🎯 هدایت بر اساس روش پرداخت
            if ($validated['payment_method'] === 'online') {
                return redirect()->route('payment.gateway', [
                    'locale' => $request->route('locale'),
                    'order'  => $order->id,
                ]);
            }

            return redirect()->route('checkout.success', [
                'locale' => $request->route('locale'),
                'order'  => $order->id,
            ]);

        } catch (\Throwable $e) {
            Log::error('Checkout store error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->withInput()->with('error', 'خطا در ثبت سفارش: ' . $e->getMessage());
        }
    }

    /**
     * صفحه موفقیت سفارش
     */
=======
        // ✅ جلوگیری از ثبت تکراری همزمان (double-click / retry)
        $lockKey = 'checkout_lock:' . ($request->user()?->id ?? $request->session()->getId());

        if (! Cache::add($lockKey, true, 15)) {
            return back()
                ->withInput()
                ->with('error', 'درخواست شما در حال پردازش است. لطفاً چند لحظه صبر کنید.');
        }

        try {
            // ✅ منطق ثبت سفارش در سرویس Checkout
            $order = $this->checkoutService->checkout($cart, [
                'customer_name'    => $validated['recipient_name'],
                'customer_phone'   => $validated['shipping_phone'],
                'customer_email'   => $cart->guest_email ?? $request->user()?->email,
                'shipping_address' => $validated['shipping_address'],
                'postal_code'      => $validated['shipping_postcode'] ?? null,
                'city'             => $validated['shipping_city'],
                'province'         => $validated['shipping_province'],
                'payment_method'   => $validated['payment_method'],
                'shipping_cost'    => 0,
                'discount'         => 0,
                'notes'            => $validated['notes'] ?? null,
            ]);

            // ✅ ذخیره دسترسی سفارش در session
            $this->grantSessionAccess($request, $order);

            // 🎯 هدایت بر اساس روش پرداخت
            return $this->redirectAfterOrder($request, $order, $validated['payment_method']);

        } catch (ValidationException $e) {
            return back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', $e->getMessage());
        } catch (\Throwable $e) {
            Log::error('Checkout store error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'cart'  => $cart->id ?? null,
                'user'  => $request->user()?->id,
            ]);

            return back()
                ->withInput()
                ->with('error', 'خطا در ثبت سفارش. لطفاً مجدداً تلاش کنید.');
        } finally {
            // ✅ آزادسازی قفل در هر حالت
            Cache::forget($lockKey);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | صفحه موفقیت سفارش
    |--------------------------------------------------------------------------
    */
>>>>>>> a96f8e3 (complateforCartshoping)
    public function success(Request $request)
    {
        $orderId = $request->query('order') ?? $request->route('order');

<<<<<<< HEAD
        $order = Order::with('items')->findOrFail($orderId);

        $currentUserId = $request->user()?->id;
        $orderUserId   = $order->user_id;

        // اگر سفارش متعلق به کاربر دیگری است
        if ($orderUserId !== null && (int) $orderUserId !== (int) $currentUserId) {
            abort(403, 'این سفارش متعلق به شما نیست.');
        }

        // اگر سفارش مهمان است، بررسی session
        if ($orderUserId === null) {
            $allowed = $request->session()->get('guest_order_ids', []);
            abort_unless(
                in_array($order->id, $allowed, true),
                403,
                'دسترسی به این سفارش مجاز نیست.'
            );
        }

        return view('cart.checkout.success', ['order' => $order]);
    }
=======
        $order = Order::with(['items', 'successfulPayment'])->findOrFail($orderId);

        $this->ensureOrderAccess($request, $order);

        return view('cart.checkout.success', ['order' => $order]);
    }

    /*
    |--------------------------------------------------------------------------
    | Helper: دسترسی session برای سفارش
    |--------------------------------------------------------------------------
    */
    private function grantSessionAccess(Request $request, Order $order): void
    {
        $request->session()->put(
            'checkout_order_' . $order->id,
            $order->tracking_code
        );

        if (! $request->user()) {
            $guestIds   = $request->session()->get('guest_order_ids', []);
            $guestIds[] = $order->id;
            $request->session()->put('guest_order_ids', array_unique($guestIds));
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Helper: بررسی مالکیت سفارش
    |--------------------------------------------------------------------------
    */
    private function ensureOrderAccess(Request $request, Order $order): void
    {
        $currentUserId = $request->user()?->id;

        // سفارش متعلق به کاربر
        if ($order->user_id !== null) {
            abort_unless(
                (int) $order->user_id === (int) $currentUserId,
                403,
                'این سفارش متعلق به شما نیست.'
            );
            return;
        }

        // سفارش مهمان — بررسی session (هر دو روش برای سازگاری)
        $hasDirectAccess = $request->session()->get('checkout_order_' . $order->id) === $order->tracking_code;
        $hasListAccess   = in_array($order->id, $request->session()->get('guest_order_ids', []), true);

        abort_unless(
            $hasDirectAccess || $hasListAccess,
            403,
            'دسترسی به این سفارش مجاز نیست.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Helper: هدایت پس از ثبت سفارش
    |--------------------------------------------------------------------------
    */
    private function redirectAfterOrder(Request $request, Order $order, string $paymentMethod)
    {
        $locale = $request->route('locale');

        if ($paymentMethod === 'online') {
            return redirect()->route('payment.gateway', [
                'locale' => $locale,
                'order'  => $order->id,
            ]);
        }

        // پرداخت در محل
        return redirect()->route('checkout.success', [
            'locale' => $locale,
            'order'  => $order->id,
        ]);
    }
    public function invoice(Request $request, string $locale, Order $order)
    {
        $this->ensureOrderAccess($request, $order);

        $order->load(['items', 'successfulPayment']);

        return view('cart.checkout.invoice', [
            'order'  => $order,
            'locale' => $locale,
        ]);
    }
    public function downloadInvoice(Request $request, string $locale, Order $order)
    {
        $this->ensureOrderAccess($request, $order);

        $order->load(['items', 'successfulPayment']);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('cart.checkout.invoice-pdf', [
            'order'  => $order,
            'locale' => $locale,
        ])->setPaper('a4', 'portrait');

        $filename = 'invoice-' . ($order->order_number ?? $order->id) . '.pdf';

        return $pdf->download($filename);
    }
>>>>>>> a96f8e3 (complateforCartshoping)
}

<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Models\Cart\Order;
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
            return redirect()
                ->route('cart.show', ['locale' => $request->route('locale')])
                ->with('error', 'سبد خرید شما خالی است.');
        }

        if ($cart->isGuest() && (! $cart->guest_name || ! $cart->guest_phone)) {
            return redirect()
                ->route('cart.show', ['locale' => $request->route('locale')])
                ->with('error', 'لطفاً ابتدا اطلاعات تماس خود را در صفحه سبد خرید وارد کنید.');
        }

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

        $cart = $this->cartService->resolveCart($request)->load('items.product');

        if (! $cart->items || $cart->items->isEmpty()) {
            return redirect()
                ->route('cart.show', ['locale' => $request->route('locale')])
                ->with('error', 'سبد خرید شما خالی است.');
        }

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
    public function success(Request $request)
    {
        $orderId = $request->query('order') ?? $request->route('order');

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
}

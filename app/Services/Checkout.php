<?php

namespace App\Services;

use App\Models\Cart\Cart;
use App\Models\Cart\Order;
use App\Models\Cart\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class Checkout
{
    public function __construct(
        private CartService $cartService
    ) {}

    /*
    |--------------------------------------------------------------------------
    | ثبت سفارش
    |--------------------------------------------------------------------------
    */

    /**
     * تبدیل سبد خرید به سفارش.
     *
     * اطلاعات ورودی:
     * customer_name
     * customer_phone
     * customer_email
     * shipping_address
     * postal_code
     * city
     * province
     * shipping_cost
     * discount
     * payment_method
     * shipping_method
     */
    public function checkout(Cart $cart, array $data): Order
    {
        /*
         * بررسی اطلاعات تماس مهمان
         */
        if ($cart->isGuest()) {

            $phone = $cart->guest_phone
                ?? ($data['customer_phone'] ?? null);

            if (empty($phone)) {
                throw ValidationException::withMessages([
                    'customer_phone' => 'شماره تماس الزامی است.',
                ]);
            }
        }

        /*
         * آماده‌سازی و اعتبارسنجی سبد خرید
         */
        $prepared = $this->cartService->prepareForCheckout($cart);

        if ($prepared['has_errors']) {
            throw ValidationException::withMessages([
                'cart' => $prepared['errors'],
            ]);
        }

        /*
         * ایجاد سفارش در تراکنش دیتابیس
         */
        return DB::transaction(function () use ($cart, $data) {

            /*
             * قفل سبد خرید برای جلوگیری از ثبت هم‌زمان سفارش
             */
            $lockedCart = Cart::query()
                ->whereKey($cart->id)
                ->lockForUpdate()
                ->firstOrFail();

            if (!$lockedCart->isActive()) {
                throw ValidationException::withMessages([
                    'cart' => 'این سبد خرید قبلاً ثبت یا غیرفعال شده است.',
                ]);
            }

            /*
             * دریافت مجدد اقلام و محصولات
             */
            $lockedCart->load('items.productShop');

            if ($lockedCart->items->isEmpty()) {
                throw ValidationException::withMessages([
                    'cart' => 'سبد خرید شما خالی است.',
                ]);
            }

            /*
             * محاسبه مبالغ
             */
            $lockedCart->recalculate();

            $lockedCart->load('items.productShop');

            $subtotal = (int) $lockedCart->subtotal;

            $shipping = max(
                0,
                (int) ($data['shipping_cost'] ?? 0)
            );

            $discount = max(
                0,
                (int) ($data['discount'] ?? 0)
            );

            $total = max(
                0,
                $subtotal + $shipping - $discount
            );

            /*
             * ایجاد سفارش
             */
            $order = Order::create([

                'user_id' => $lockedCart->user_id,

                'cart_id' => $lockedCart->id,

                'customer_name' =>
                    $data['customer_name']
                    ?? $lockedCart->guest_name,

                'customer_phone' =>
                    $data['customer_phone']
                    ?? $lockedCart->guest_phone,

                'customer_email' =>
                    $data['customer_email']
                    ?? $lockedCart->guest_email,

                'shipping_address' =>
                    $data['shipping_address'],

                'postal_code' =>
                    $data['postal_code'] ?? null,

                'city' =>
                    $data['city'],

                'province' =>
                    $data['province'],

                'subtotal' => $subtotal,

                'shipping_cost' => $shipping,

                'discount' => $discount,

                'total_amount' => $total,

                'payment_method' =>
                    $data['payment_method'] ?? 'online',

                'shipping_method' =>
                    $data['shipping_method'] ?? null,

                'tracking_code' =>
                    $this->generateTrackingCode(),

                'status' => 'pending',
            ]);

            /*
             * ثبت جزئیات محصولات سفارش
             */
            foreach ($lockedCart->items as $item) {

                $product = $item->productShop;

                OrderItem::create([

                    'order_id' => $order->id,

                    'product_shop_id' => $item->product_shop_id,

                    'product_name' =>
                        $item->product_name
                        ?? $product?->name
                            ?? 'محصول حذف شده',

                    'product_sku' =>
                        $product?->sku,

                    'product_image' =>
                        $product?->image,

                    'unit_price' =>
                        (int) $item->unit_price,

                    'quantity' =>
                        (int) $item->quantity,

                    'total_price' =>
                        (int) $item->total_price,

                    'discount' => 0,
                ]);
            }

            /*
             * تبدیل سبد خرید به سفارش ثبت‌شده
             */
            $lockedCart->markAsConverted();

            /*
             * حذف اقلام از سبد خرید
             */
            $lockedCart->items()->delete();

            /*
             * صفر کردن مبالغ و تعداد اقلام سبد
             */
            $lockedCart->update([
                'subtotal' => 0,
                'items_count' => 0,
            ]);

            return $order->fresh(['items']);

        }, 5);
    }

    /*
    |--------------------------------------------------------------------------
    | تولید کد رهگیری
    |--------------------------------------------------------------------------
    */

    private function generateTrackingCode(): string
    {
        do {
            $code = 'TRK-' . strtoupper(Str::random(10));

        } while (
            Order::where('tracking_code', $code)->exists()
        );

        return $code;
    }
}

<?php

namespace App\Services;
use App\Services\CartService;
use App\Models\Cart\Cart;
use App\Models\Cart\Order;
use Nette\Schema\ValidationException;


class Checkout
{
    public function checkout(Cart $cart, array $data): Order
    {
        // اگر کاربر مهمان است، اطلاعات تماس الزامی است
        if ($cart->isGuest()) {
            if (empty($cart->guest_phone) && empty($data['customer_phone'])) {
                throw ValidationException::withMessages([
                    'customer_phone' => 'شماره تماس الزامی است.',
                ]);
            }
        }

        $prepared = $this->cartService->prepareForCheckout($cart);

        if ($prepared['has_errors']) {
            throw ValidationException::withMessages(['cart' => $prepared['errors']]);
        }

        return DB::transaction(function () use ($cart, $data) {

            $order = Order::create([
                'user_id'          => $cart->user_id, // null برای مهمان
                'tracking_code'    => $this->generateTrackingCode(),
                'customer_name'    => $data['customer_name'] ?? $cart->guest_name,
                'customer_phone'   => $data['customer_phone'] ?? $cart->guest_phone,
                'customer_email'   => $data['customer_email'] ?? $cart->guest_email,
                'shipping_address' => $data['shipping_address'],
                'postal_code'      => $data['postal_code'] ?? null,
                'city'             => $data['city'],
                'province'         => $data['province'],
                'subtotal'         => $cart->subtotal,
                'shipping_cost'    => $data['shipping_cost'] ?? 0,
                'discount'         => $data['discount'] ?? 0,
                'total_amount'     => $cart->subtotal + ($data['shipping_cost'] ?? 0) - ($data['discount'] ?? 0),
                'status'           => 'pending',
            ]);

            foreach ($cart->items as $item) {
                $order->items()->create([
                    'product_shop_id' => $item->product_shop_id,
                    'product_name'    => $item->product->name, // snapshot
                    'quantity'        => $item->quantity,
                    'unit_price'      => $item->unit_price,
                    'total_price'     => $item->total_price,
                ]);
            }

            // سبد را به converted تغییر بده
            $cart->update(['status' => 'converted']);

            return $order;
        });
    }

    protected function generateTrackingCode(): string
    {
        do {
            $code = 'ORD-' . strtoupper(Str::random(10));
        } while (Order::where('tracking_code', $code)->exists());

        return $code;
    }

}

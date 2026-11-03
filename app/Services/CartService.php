<?php

namespace App\Services;

use App\Models\Cart\Cart;
use App\Models\Cart\CartItem;
use App\Models\Shop\ProductShop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CartService
{
    /**
     * دریافت یا ساخت سبد فعال.
     * اولویت: کاربر لاگین‌شده > توکن کوکی > سبد جدید مهمان
     */
    public function resolveCart(Request $request): Cart
    {
        $userId = auth()->id();
        $token  = $request->cookie('cart_token');

        // ۱. کاربر لاگین‌شده: سبد فعالش را بگیر
        if ($userId) {
            $cart = Cart::active()->where('user_id', $userId)->first();

            // اگر توکن مهمان هم دارد، سبد مهمان را ادغام کن
            if ($token) {
                $guestCart = Cart::active()->where('token', $token)->whereNull('user_id')->first();
                if ($guestCart) {
                    return $this->mergeGuestIntoUser($guestCart, $userId);
                }
            }

            if ($cart) {
                return $cart;
            }

            return $this->createCart($userId, $request);
        }

        // ۲. مهمان با توکن معتبر
        if ($token) {
            $cart = Cart::active()->where('token', $token)->whereNull('user_id')->first();
            if ($cart) {
                $cart->update(['last_activity_at' => now()]);
                return $cart;
            }
        }

        // ۳. سبد جدید مهمان
        return $this->createCart(null, $request);
    }

    protected function createCart(?int $userId, Request $request): Cart
    {
        $cart = Cart::create([
            'user_id'          => $userId,
            'token'            => Str::random(64),
            'status'           => 'active',
            'ip_address'       => $request->ip(),
            'user_agent'       => substr((string) $request->userAgent(), 0, 255),
            'last_activity_at' => now(),
        ]);

        // توکن را در کوکی ۳۰ روزه ذخیره کن
        cookie()->queue(
            cookie('cart_token', $cart->token, 60 * 24 * 30, '/', null, false, true)
        );

        return $cart;
    }

    /**
     * افزودن محصول به سبد (مشترک برای مهمان و کاربر)
     */
    public function addItem(Cart $cart, int $productId, int $quantity = 1): CartItem
    {
        if ($quantity < 1) {
            throw ValidationException::withMessages([
                'quantity' => 'تعداد باید حداقل ۱ باشد.',
            ]);
        }

        return DB::transaction(function () use ($cart, $productId, $quantity) {

            $product = ProductShop::findOrFail($productId);

            if ($product->status !== 'published') {
                throw ValidationException::withMessages([
                    'product' => 'این محصول در دسترس نیست.',
                ]);
            }

            $existingItem = CartItem::where('cart_id', $cart->id)
                ->where('product_shop_id', $product->id)
                ->first();

            $newQty = ($existingItem?->quantity ?? 0) + $quantity;

            if ($product->manage_stock
                && $newQty > $product->stock_quantity
                && ! $product->allow_backorder) {
                throw ValidationException::withMessages([
                    'quantity' => 'موجودی کافی نیست. حداکثر: ' . $product->stock_quantity,
                ]);
            }

            if ($existingItem) {
                $existingItem->update([
                    'quantity'    => $newQty,
                    'total_price' => $newQty * $existingItem->unit_price,
                ]);
                $item = $existingItem;
            } else {
                $item = CartItem::create([
                    'cart_id'         => $cart->id,
                    'product_shop_id' => $product->id,
                    'quantity'        => $quantity,
                    'unit_price'      => $product->price,
                    'total_price'     => $product->price * $quantity,
                ]);
            }

            $cart->recalculate();
            return $item;
        });
    }

    public function updateQuantity(Cart $cart, int $itemId, int $quantity): CartItem
    {
        if ($quantity < 1) {
            throw ValidationException::withMessages([
                'quantity' => 'تعداد باید حداقل ۱ باشد.',
            ]);
        }

        return DB::transaction(function () use ($cart, $itemId, $quantity) {

            $item = CartItem::where('cart_id', $cart->id)->findOrFail($itemId);
            $product = $item->product;

            if ($product->manage_stock
                && $quantity > $product->stock_quantity
                && ! $product->allow_backorder) {
                throw ValidationException::withMessages([
                    'quantity' => 'موجودی کافی نیست.',
                ]);
            }

            $item->update([
                'quantity'    => $quantity,
                'total_price' => $item->unit_price * $quantity,
            ]);

            $cart->recalculate();
            return $item->fresh();
        });
    }

    public function removeItem(Cart $cart, int $itemId): void
    {
        DB::transaction(function () use ($cart, $itemId) {
            CartItem::where('cart_id', $cart->id)->where('id', $itemId)->delete();
            $cart->recalculate();
        });
    }

    public function clear(Cart $cart): void
    {
        DB::transaction(function () use ($cart) {
            $cart->items()->delete();
            $cart->recalculate();
        });
    }

    /**
     * ثبت اطلاعات تماس مهمان (قبل از Checkout)
     */
    public function setGuestContact(Cart $cart, string $name, string $phone, ?string $email = null): Cart
    {
        if (! $cart->isGuest()) {
            throw ValidationException::withMessages([
                'cart' => 'این سبد متعلق به کاربر است.',
            ]);
        }

        $cart->update([
            'guest_name'  => $name,
            'guest_phone' => $phone,
            'guest_email' => $email,
        ]);

        return $cart->fresh();
    }

    /**
     * ادغام سبد مهمان با سبد کاربر هنگام لاگین/ثبت‌نام
     */
    public function mergeGuestIntoUser(Cart $guestCart, int $userId): Cart
    {
        return DB::transaction(function () use ($guestCart, $userId) {

            $userCart = Cart::active()->where('user_id', $userId)->first();

            if (! $userCart) {
                // سبد مهمان را به کاربر منتقل کن
                $guestCart->update([
                    'user_id'      => $userId,
                    'guest_name'   => null,
                    'guest_email'  => null,
                    'guest_phone'  => null,
                ]);
                return $guestCart;
            }

            // ادغام آیتم‌ها
            foreach ($guestCart->items as $guestItem) {
                $existing = $userCart->items()
                    ->where('product_shop_id', $guestItem->product_shop_id)
                    ->first();

                if ($existing) {
                    $newQty = $existing->quantity + $guestItem->quantity;
                    $existing->update([
                        'quantity'    => $newQty,
                        'total_price' => $existing->unit_price * $newQty,
                    ]);
                } else {
                    $guestItem->update(['cart_id' => $userCart->id]);
                }
            }

            $guestCart->items()->delete();
            $guestCart->update(['status' => 'converted']);
            $userCart->recalculate();

            return $userCart;
        });
    }

    /**
     * آماده‌سازی نهایی سبد برای تبدیل به سفارش
     * (اعتبارسنجی قیمت‌ها و موجودی)
     */
    public function prepareForCheckout(Cart $cart): array
    {
        if ($cart->isEmpty()) {
            throw ValidationException::withMessages([
                'cart' => 'سبد خرید خالی است.',
            ]);
        }

        $cart->load('items.product');
        $errors  = [];
        $changes = [];

        foreach ($cart->items as $item) {
            $product = $item->product;

            // محصول حذف شده؟
            if (! $product) {
                $errors[] = "محصول آیتم #{$item->id} حذف شده است.";
                continue;
            }

            // قیمت تغییر کرده؟
            if ($product->price !== $item->unit_price) {
                $changes[] = [
                    'item_id'  => $item->id,
                    'old_price' => $item->unit_price,
                    'new_price' => $product->price,
                ];
            }

            // موجودی کافی نیست؟
            if ($product->manage_stock
                && $item->quantity > $product->stock_quantity
                && ! $product->allow_backorder) {
                $errors[] = "موجودی «{$product->name}» کافی نیست.";
            }
        }

        return [
            'has_errors'    => ! empty($errors),
            'errors'        => $errors,
            'price_changes' => $changes,
            'cart'          => $cart,
        ];
    }
}

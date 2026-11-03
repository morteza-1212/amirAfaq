<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Models\Cart\Cart;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function __construct(private CartService $cartService) {}

    /**
     * نمایش صفحه سبد خرید (HTML) یا دریافت داده (JSON)
     */
    public function index(Request $request)
    {
        $cart = $this->cartService->resolveCart($request)->load('items.product');

        // اگر درخواست AJAX بود، JSON برگردان
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'data' => $this->formatCart($cart),
            ]);
        }

        // در غیر این صورت، ویو را رندر کن
        // داده‌ها در ویو با AJAX از همین endpoint دریافت می‌شوند
        return view('cart.index');
    }

    /**
     * افزودن محصول به سبد
     */
    public function add(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer', 'exists:product_shops,id'],
            'quantity'   => ['nullable', 'integer', 'min:1'],
        ]);

        try {
            $cart = $this->cartService->resolveCart($request);
            $this->cartService->addItem(
                $cart,
                $validated['product_id'],
                $validated['quantity'] ?? 1
            );

            $cart = $cart->fresh();

            return response()->json([
                'success'     => true,
                'message'     => 'محصول به سبد خرید اضافه شد.',
                'items_count' => (int) $cart->items_count,
                'subtotal'    => (int) $cart->subtotal,
            ], 201);

        } catch (\Exception $e) {
            Log::error('Cart add error: ' . $e->getMessage(), [
                'product_id' => $validated['product_id'],
                'trace'      => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'خطا در افزودن محصول به سبد خرید: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * به‌روزرسانی تعداد یک آیتم
     */
    public function update(Request $request, int $itemId)
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        try {
            $cart = $this->cartService->resolveCart($request);
            $this->cartService->updateQuantity($cart, $itemId, $validated['quantity']);

            $cart = $cart->fresh();

            return response()->json([
                'success'     => true,
                'message'     => 'تعداد بروزرسانی شد.',
                'items_count' => (int) $cart->items_count,
                'subtotal'    => (int) $cart->subtotal,
            ]);

        } catch (\Exception $e) {
            Log::error('Cart update error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'خطا در بروزرسانی: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * حذف یک آیتم از سبد
     */
    public function remove(Request $request, int $itemId)
    {
        try {
            $cart = $this->cartService->resolveCart($request);
            $this->cartService->removeItem($cart, $itemId);

            $cart = $cart->fresh();

            return response()->json([
                'success'     => true,
                'message'     => 'محصول از سبد خرید حذف شد.',
                'items_count' => (int) $cart->items_count,
                'subtotal'    => (int) $cart->subtotal,
            ]);

        } catch (\Exception $e) {
            Log::error('Cart remove error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'خطا در حذف: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * خالی کردن سبد
     */
    public function clear(Request $request)
    {
        try {
            $cart = $this->cartService->resolveCart($request);
            $this->cartService->clear($cart);

            return response()->json([
                'success'     => true,
                'message'     => 'سبد خرید خالی شد.',
                'items_count' => 0,
                'subtotal'    => 0,
            ]);

        } catch (\Exception $e) {
            Log::error('Cart clear error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'خطا در خالی کردن سبد: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * ذخیره اطلاعات تماس مهمان
     */
    public function setGuestContact(Request $request)
    {
        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:150'],
            'phone' => ['required', 'string', 'regex:/^09\d{9}$/'],
            'email' => ['nullable', 'email', 'max:150'],
        ]);

        $cart = $this->cartService->resolveCart($request);

        if (! $cart->isGuest()) {
            return response()->json([
                'success' => false,
                'message' => 'شما وارد شده‌اید؛ اطلاعات تماس از حساب شما خوانده می‌شود.',
            ], 422);
        }

        try {
            $this->cartService->setGuestContact(
                $cart,
                $validated['name'],
                $validated['phone'],
                $validated['email'] ?? null
            );

            $cart = $cart->fresh();

            return response()->json([
                'success' => true,
                'message' => 'اطلاعات تماس ذخیره شد.',
                'contact' => [
                    'name'  => $cart->guest_name,
                    'phone' => $cart->guest_phone,
                    'email' => $cart->guest_email,
                ],
            ]);

        } catch (\Exception $e) {
            Log::error('Cart setGuestContact error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'خطا در ذخیره اطلاعات: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * فرمت کردن داده سبد برای خروجی JSON
     */
    private function formatCart(Cart $cart): array
    {
        return [
            'token'       => $cart->token,
            'is_guest'    => $cart->isGuest(),
            'items_count' => (int) $cart->items_count,
            'subtotal'    => (int) $cart->subtotal,
            'contact'     => [
                'name'  => $cart->guest_name,
                'phone' => $cart->guest_phone,
                'email' => $cart->guest_email,
            ],
            'items' => $cart->items->map(fn ($item) => [
                'id'          => $item->id,
                'product_id'  => $item->product_shop_id,
                'name'        => $item->product?->name ?? 'محصول حذف شده',
                'image'       => $item->product?->image,
                'slug'        => $item->product?->slug,
                'quantity'    => (int) $item->quantity,
                'unit_price'  => (int) $item->unit_price,
                'total_price' => (int) $item->total_price,
            ])->values()->toArray(),
        ];
    }
}

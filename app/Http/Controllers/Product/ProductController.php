<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Shop\ProductShop;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * لیست محصولات با فیلتر، جستجو، مرتب‌سازی و صفحه‌بندی
     *
     * GET /api/products
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'q'            => ['nullable', 'string', 'max:100'],
            'category_id'  => ['nullable', 'integer', 'exists:category_shops,id'],
            'brand'        => ['nullable', 'string', 'max:150'],
            'min_price'    => ['nullable', 'integer', 'min:0'],
            'max_price'    => ['nullable', 'integer', 'min:0', 'gte:min_price'],
            'in_stock'     => ['nullable', 'boolean'],
            'is_featured'  => ['nullable', 'boolean'],
            'product_type' => ['nullable', 'in:physical,digital'],
            'sort'         => ['nullable', 'in:newest,oldest,price_asc,price_desc,popular'],
            'per_page'     => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        $query = ProductShop::query()
            ->where('status', 'published')
            ->where(function ($q) {
                $q->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->with('category');

        // جستجو در نام و توضیح کوتاه و برند
        if (! empty($validated['q'])) {
            $q = $validated['q'];
            $query->where(function ($w) use ($q) {
                $w->where('name', 'like', "%{$q}%")
                    ->orWhere('short_description', 'like', "%{$q}%")
                    ->orWhere('brand', 'like', "%{$q}%");
            });
        }

        // فیلتر دسته‌بندی
        if (! empty($validated['category_id'])) {
            $query->where('category_shop_id', $validated['category_id']);
        }

        // فیلتر برند
        if (! empty($validated['brand'])) {
            $query->where('brand', $validated['brand']);
        }

        // فیلتر قیمت
        if (isset($validated['min_price'])) {
            $query->where('price', '>=', $validated['min_price']);
        }
        if (isset($validated['max_price'])) {
            $query->where('price', '<=', $validated['max_price']);
        }

        // فیلتر موجودی
        if (isset($validated['in_stock']) && $validated['in_stock']) {
            $query->where(function ($w) {
                $w->where('manage_stock', false)
                    ->orWhere('stock_quantity', '>', 0)
                    ->orWhere('allow_backorder', true);
            });
        }

        // فیلتر ویژه
        if (isset($validated['is_featured']) && $validated['is_featured']) {
            $query->where('is_featured', true);
        }

        // نوع محصول
        if (! empty($validated['product_type'])) {
            $query->where('product_type', $validated['product_type']);
        }

        // مرتب‌سازی
        match ($validated['sort'] ?? 'newest') {
            'newest'     => $query->orderByDesc('published_at')->orderByDesc('id'),
            'oldest'     => $query->orderBy('published_at')->orderBy('id'),
            'price_asc'  => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'popular'    => $query->orderByDesc('is_featured')->orderByDesc('sort_order'),
        };

        // صفحه‌بندی
        $perPage = $validated['per_page'] ?? 15;
        $products = $query->paginate($perPage)->withQueryString();

        return ProductResource::collection($products);
    }

    /**
     * جزئیات یک محصول
     *
     * GET /api/products/{slug}
     */
    public function show(string $slug)
    {
        $product = ProductShop::query()
            ->where('slug', $slug)
            ->where('status', 'published')
            ->with('category')
            ->firstOrFail();

        // اگر published_at در آینده است، برای کاربر عادی نمایش نده
        if ($product->published_at && $product->published_at->isFuture()) {
            abort(404);
        }

        return new ProductResource($product);
    }

    /**
     * محصولات مرتبط (همان دسته‌بندی، غیر از خود محصول)
     *
     * GET /api/products/{slug}/related
     */
    public function related(string $slug)
    {
        $product = ProductShop::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $related = ProductShop::query()
            ->where('status', 'published')
            ->where('category_shop_id', $product->category_shop_id)
            ->where('id', '!=', $product->id)
            ->orderByDesc('is_featured')
            ->orderByDesc('sort_order')
            ->limit(8)
            ->with('category')
            ->get();

        return ProductResource::collection($related);
    }

    /**
     * محصولات ویژه (برای صفحه اصلی)
     *
     * GET /api/products/featured
     */
    public function featured()
    {
        $products = ProductShop::query()
            ->where('status', 'published')
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->limit(12)
            ->with('category')
            ->get();

        return ProductResource::collection($products);
    }
}

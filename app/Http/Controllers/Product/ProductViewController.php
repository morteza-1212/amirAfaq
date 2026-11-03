<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Shop\CategoryShop;
use App\Models\Shop\ProductShop;
use Illuminate\Http\Request;

class ProductViewController extends Controller
{
    public function index(Request $request)
    {
        $query = ProductShop::query()
            ->where('status', 'published');   // ✅ جای is_active

        // ========== جستجو ==========
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('sku', 'like', "%{$q}%")
                    ->orWhere('brand', 'like', "%{$q}%");
            });
        }

        // ========== دسته‌بندی ==========
        if ($request->filled('category_id')) {
            $query->where('category_shop_id', $request->category_id);  // ✅ نام درست
        }

        // ========== برند ==========
        if ($request->filled('brand')) {
            $query->where('brand', $request->brand);
        }

        // ========== محدوده قیمت ==========
        if ($request->filled('min_price')) {
            $query->where('price', '>=', (int) $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', (int) $request->max_price);
        }

        // ========== موجودی ==========
        if ($request->boolean('in_stock')) {
            $query->where('stock_quantity', '>', 0);  // ✅ ستون درست
        }

        // ========== محصول ویژه ==========
        if ($request->boolean('is_featured')) {
            $query->where('is_featured', true);  // ✅ ستون درست
        }

        // ========== مرتب‌سازی ==========
        match ($request->get('sort', 'newest')) {
            'oldest'     => $query->orderBy('created_at', 'asc'),
            'price_asc'  => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'popular'    => $query->orderByDesc('sort_order')
                ->orderByDesc('created_at'),  // ✅ views_count وجود ندارد
            default      => $query->orderByDesc('created_at'),
        };

        $products = $query->paginate(12)->withQueryString();

        // ✅ مدل دسته‌بندی درست است
        $categories = CategoryShop::orderBy('name')->get();

        $brands = ProductShop::whereNotNull('brand')
            ->where('brand', '!=', '')
            ->where('status', 'published')
            ->distinct()
            ->orderBy('brand')
            ->pluck('brand');

        return view('Products.index', compact('products', 'categories', 'brands'));
    }

    public function show(ProductShop $product)
    {
        if (! $product->isPublished()) {
            abort(404);
        }

        $product->load(['categoryShop', 'images', 'primaryImage']);

        $related = ProductShop::query()
            ->published()
            ->where('category_shop_id', $product->category_shop_id)
            ->where('id', '!=', $product->id)
            ->orderByDesc('is_featured')
            ->orderByDesc('sort_order')
            ->limit(4)
            ->get();

        return view('Products.show', compact('product', 'related'));
    }

    public function featured()
    {
        $products = ProductShop::query()
            ->published()
            ->featured()
            ->orderBy('sort_order')
            ->limit(12)
            ->with(['categoryShop', 'primaryImage'])
            ->get();

        return view('Products.featured', compact('products'));
    }
}

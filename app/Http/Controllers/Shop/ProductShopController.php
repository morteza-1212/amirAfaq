<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shop\StoreProductShopRequest;
use App\Http\Requests\Shop\UpdateProductShopRequest;
use App\Models\Shop\CategoryShop;
use App\Models\Shop\ProductShop;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductShopController extends Controller
{
    public function index()
    {
        $products = ProductShop::with('categoryShop')
            ->orderBy('sort_order')
            ->latest()
            ->get();

        return view('panelAdmin.shop.productShop.index', compact('products'));
    }

    public function create()
    {
        $categories = CategoryShop::orderBy('name')->get();
        $nextSku    = $this->generateNextSku();

        return view('panelAdmin.shop.productShop.create', compact('categories', 'nextSku'));
    }

    public function store(StoreProductShopRequest $request)
    {
        $data = $request->validated();

        $data['slug'] = $this->generateSlug($data['slug'] ?? null, $data['name']);

        // اگر SKU خالی بود، خودکار تولید کن
        if (empty($data['sku'])) {
            $data['sku'] = $this->generateNextSku();
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('product_shops', 'public');
        }

        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        ProductShop::create($data);

        return redirect()
            ->route('admin.productShop.index')
            ->with('success', 'محصول با موفقیت ایجاد شد.');
    }

    public function edit(ProductShop $productShop)
    {
        $categories = CategoryShop::orderBy('name')->get();

        return view('panelAdmin.shop.productShop.edit', compact('productShop', 'categories'));
    }

    public function update(UpdateProductShopRequest $request, ProductShop $productShop)
    {
        $data = $request->validated();

        $data['slug'] = $this->generateSlug(
            $data['slug'] ?? null,
            $data['name'],
            $productShop->id
        );

        if (empty($data['sku'])) {
            $data['sku'] = $productShop->sku ?: $this->generateNextSku();
        }

        if ($request->hasFile('image')) {
            if ($productShop->image && Storage::disk('public')->exists($productShop->image)) {
                Storage::disk('public')->delete($productShop->image);
            }
            $data['image'] = $request->file('image')->store('product_shops', 'public');
        }

        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        $productShop->update($data);

        return redirect()
            ->route('admin.productShop.index')
            ->with('success', 'محصول با موفقیت ویرایش شد.');
    }

    public function destroy(ProductShop $productShop)
    {
        if ($productShop->image && Storage::disk('public')->exists($productShop->image)) {
            Storage::disk('public')->delete($productShop->image);
        }

        $productShop->delete();

        return redirect()
            ->route('admin.productShop.index')
            ->with('success', 'محصول با موفقیت حذف شد.');
    }

    /**
     * تولید SKU بعدی: از 100 شروع می‌شود و به ترتیب افزایش می‌یابد
     */
    private function generateNextSku(): string
    {
        // بزرگ‌ترین SKU عددی موجود
        $maxSku = ProductShop::whereRaw('sku REGEXP "^[0-9]+$"')
            ->selectRaw('MAX(CAST(sku AS UNSIGNED)) as max_sku')
            ->value('max_sku');

        $next = $maxSku ? ((int) $maxSku + 1) : 100;

        // اگر به هر دلیلی برخورد کرد (مثلاً SKU دستی)، یکی زیاد کن
        while (ProductShop::where('sku', (string) $next)->exists()) {
            $next++;
        }

        return (string) $next;
    }

    private function generateSlug(?string $slug, string $name, ?int $ignoreId = null): string
    {
        if ($slug) {
            $slug = Str::slug($slug);
        }

        if (empty($slug)) {
            $slug = $this->makeSlugFromName($name);
        }

        if (empty($slug)) {
            $slug = 'product-' . time();
        }

        $original = $slug;
        $counter  = 1;

        while (
        ProductShop::where('slug', $slug)
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists()
        ) {
            $slug = $original . '-' . $counter++;
        }

        return $slug;
    }

    private function makeSlugFromName(string $name): string
    {
        $slug = trim($name);
        $slug = preg_replace('/[\s_،,\.]+/u', '-', $slug);
        $slug = preg_replace('/[^\p{L}\p{N}\-]+/u', '', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        $slug = trim($slug, '-');
        return mb_strtolower($slug);
    }
}

<?php

namespace App\Http\Controllers\panelAdmin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with([
            'category',
            'translations',
        ]);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('code', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%")
                    ->orWhereHas('translations', function ($translation) use ($search) {
                        $translation
                            ->where('name', 'like', "%{$search}%")
                            ->orWhere('slug', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where(
                'is_active',
                $request->status === 'active'
            );
        }

        $products = $query
            ->orderBy('sort_order')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('panelAdmin.product.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::with('translations')
            ->orderBy('id')
            ->get();

        return view(
            'panelAdmin.product.create',
            compact('categories')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([

            'category_id' => [
                'required',
                'exists:categories,id',
            ],

//            'code' => [
//                'required',
//                'string',
//                'max:100',
//                'unique:products,code',
//            ],

            'sku' => [
                'nullable',
                'string',
                'max:100',
                'unique:products,sku',
            ],

            'type' => [
                'required',
                'in:export,import,both',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'gallery.*' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'unit' => [
                'nullable',
                'string',
                'max:50',
            ],

            'weight' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'origin_country' => [
                'nullable',
                'string',
                'max:100',
            ],

            'minimum_order' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'preparation_days' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'stock_status' => [
                'required',
                'in:in_stock,out_of_stock,on_request',
            ],

            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],

            'is_featured' => [
                'nullable',
                'boolean',
            ],
        ]);
        $validated['code'] = $this->generateUniqueCode();

        if ($request->hasFile('image')) {
            $validated['image'] = $request
                ->file('image')
                ->store('products', 'public');
        }

        $gallery = [];

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $gallery[] = $image->store(
                    'products/gallery',
                    'public'
                );
            }
        }

        $validated['gallery'] = $gallery;

        $validated['is_active'] =
            $request->boolean('is_active');

        $validated['is_featured'] =
            $request->boolean('is_featured');

        $product = Product::create($validated);

        return redirect()
            ->route('admin.product.index', $product)
            ->with(
                'success',
                'محصول با موفقیت ایجاد شد. اکنون ترجمه‌های محصول را اضافه کنید.'
            );
    }

    public function show(Product $product)
    {
        $product->load([
            'category',
            'translations',
        ]);

        return view(
            'panelAdmin.products.show',
            compact('product')
        );
    }

    public function edit(Product $product)
    {
        $product->load('translations');

        $categories = Category::with('translations')
            ->orderBy('id')
            ->get();

        return view(
            'panelAdmin.product.edit',
            compact('product', 'categories')
        );
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([

            'category_id' => [
                'required',
                'exists:categories,id',
            ],

//            'code' => [
//                'required',
//                'string',
//                'max:100',
//                'unique:products,code,' . $product->id,
//            ],

            'sku' => [
                'nullable',
                'string',
                'max:100',
                'unique:products,sku,' . $product->id,
            ],

            'type' => [
                'required',
                'in:export,import,both',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'gallery.*' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'unit' => [
                'nullable',
                'string',
                'max:50',
            ],

            'weight' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'origin_country' => [
                'nullable',
                'string',
                'max:100',
            ],

            'minimum_order' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'preparation_days' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'stock_status' => [
                'required',
                'in:in_stock,out_of_stock,on_request',
            ],

            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],

            'is_featured' => [
                'nullable',
                'boolean',
            ],
        ]);
        $validated['code'] = $this->generateUniqueCode();

        if ($request->hasFile('image')) {

            if ($product->image) {
                Storage::disk('public')
                    ->delete($product->image);
            }

            $validated['image'] = $request
                ->file('image')
                ->store('products', 'public');
        }

        $gallery = $product->gallery ?? [];

        if ($request->hasFile('gallery')) {

            foreach ($request->file('gallery') as $image) {
                $gallery[] = $image->store(
                    'products/gallery',
                    'public'
                );
            }
        }

        $validated['gallery'] = $gallery;

        $validated['is_active'] =
            $request->boolean('is_active');

        $validated['is_featured'] =
            $request->boolean('is_featured');

        $product->update($validated);

        return redirect()
            ->route('admin.product.edit', $product)
            ->with(
                'success',
                'اطلاعات محصول با موفقیت بروزرسانی شد.'
            );
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')
                ->delete($product->image);
        }

        if ($product->gallery) {
            foreach ($product->gallery as $image) {
                Storage::disk('public')
                    ->delete($image);
            }
        }

        $product->delete();

        return redirect()
            ->route('admin.product.index')
            ->with(
                'success',
                'محصول با موفقیت حذف شد.'
            );
    }
    /**
     * تولید کد عددی یکتا در بازه ۱۰ تا ۱,۰۰۰,۰۰۰
     */
    private function generateUniqueCode(): string
    {
        $min = 10;

        // بیشترین کد عددی موجود در دیتابیس
        $maxCode = Product::max('code');

        if ($maxCode === null) {
            // اگر هیچ محصولی وجود ندارد، از min شروع کن
            return (string) $min;
        }

        // اگر maxCode کمتر از min بود (مثلاً کدهای متنی قدیمی)، از min شروع کن
        if (!is_numeric($maxCode) || (int) $maxCode < $min) {
            return (string) $min;
        }

        return (string) ((int) $maxCode + 1);
    }
}

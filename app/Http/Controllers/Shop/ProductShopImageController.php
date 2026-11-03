<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shop\StoreProductShopImageRequest;
use App\Http\Requests\Shop\UpdateProductShopImageRequest;
use App\Models\Shop\ProductShop;
use App\Models\Shop\ProductShopImage;
use Illuminate\Support\Facades\Storage;

class ProductShopImageController extends Controller
{
    public function index()
    {
        $images = ProductShopImage::with('product')
            ->orderBy('sort_order')
            ->latest()
            ->get();

        return view('panelAdmin.shop.productShopImage.index', compact('images'));
    }

    public function create()
    {
        $products = ProductShop::orderBy('name')->get();

        return view('panelAdmin.shop.productShopImage.create', compact('products'));
    }

    public function store(StoreProductShopImageRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image_path')) {
            $data['image_path'] = $request->file('image_path')->store('product_shop_images', 'public');
        }

        // اگر تصویر اصلی است، بقیه تصاویر همین محصول را غیراصلی کن
        if (!empty($data['is_primary'])) {
            ProductShopImage::where('product_shop_id', $data['product_shop_id'])
                ->update(['is_primary' => false]);
        }

        ProductShopImage::create($data);

        return redirect()
            ->route('admin.productShopImage.index')
            ->with('success', 'تصویر محصول با موفقیت اضافه شد.');
    }

    public function edit(ProductShopImage $productShopImage)
    {
        $products = ProductShop::orderBy('name')->get();

        return view('panelAdmin.shop.productShopImage.edit', compact('productShopImage', 'products'));
    }

    public function update(UpdateProductShopImageRequest $request, ProductShopImage $productShopImage)
    {
        $data = $request->validated();

        if ($request->hasFile('image_path')) {
            if ($productShopImage->image_path && Storage::disk('public')->exists($productShopImage->image_path)) {
                Storage::disk('public')->delete($productShopImage->image_path);
            }
            $data['image_path'] = $request->file('image_path')->store('product_shop_images', 'public');
        } else {
            // اگر فایل جدید نیست، مقدار قبلی حفظ شود
            unset($data['image_path']);
        }

        if (!empty($data['is_primary'])) {
            ProductShopImage::where('product_shop_id', $data['product_shop_id'])
                ->where('id', '!=', $productShopImage->id)
                ->update(['is_primary' => false]);
        }

        $productShopImage->update($data);

        return redirect()
            ->route('admin.productShopImage.index')
            ->with('success', 'تصویر محصول با موفقیت ویرایش شد.');
    }

    public function destroy(ProductShopImage $productShopImage)
    {
        if ($productShopImage->image_path && Storage::disk('public')->exists($productShopImage->image_path)) {
            Storage::disk('public')->delete($productShopImage->image_path);
        }

        $productShopImage->delete();

        return redirect()
            ->route('admin.productShopImage.index')
            ->with('success', 'تصویر محصول با موفقیت حذف شد.');
    }
}

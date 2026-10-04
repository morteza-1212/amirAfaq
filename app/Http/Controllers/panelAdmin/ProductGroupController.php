<?php

namespace App\Http\Controllers\panelAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductGroupRequest;
use App\Http\Requests\UpdateProductGroupRequest;
use App\Models\ProductGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductGroupController extends Controller
{
    /**
     * نمایش لیست گروه‌های محصول
     */
    public function index(Request $request)
    {
        $query = ProductGroup::query();

        // جستجو بر اساس کد
        if ($request->filled('search')) {
            $query->where('code', 'like', '%' . $request->search . '%');
        }

        // فیلتر نوع
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // فیلتر وضعیت
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $productGroups = $query->orderBy('sort_order', 'asc')
            ->paginate(15)
            ->withQueryString();

        return view('panelAdmin.productGroup.index', compact('productGroups'));
    }

    /**
     * نمایش فرم ایجاد گروه جدید
     */
    public function create()
    {
        return view('panelAdmin.productGroup.create');
    }

    /**
     * ذخیره گروه جدید
     */
    public function store(StoreProductGroupRequest $request)
    {
        $data = $request->validated();

        // آپلود تصویر
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('product-groups', 'public');
        }

        ProductGroup::create($data);

        return redirect()
            ->route('admin.productGroup.index')
            ->with('success', 'گروه محصول با موفقیت ایجاد شد.');
    }

    /**
     * نمایش جزئیات گروه
     */
//    public function show(ProductGroup $productGroup)
//    {
//        return view('panelAdmin.productGroup.show', compact('productGroup'));
//    }

    /**
     * نمایش فرم ویرایش
     */
    public function edit(ProductGroup $productGroup)
    {
        return view('panelAdmin.productGroup.edit', compact('productGroup'));
    }

    /**
     * بروزرسانی گروه
     */
    public function update(UpdateProductGroupRequest $request, ProductGroup $productGroup)
    {
        $data = $request->validated();

        // آپلود تصویر جدید
        if ($request->hasFile('image')) {
            // حذف تصویر قدیمی
            if ($productGroup->image && Storage::disk('public')->exists($productGroup->image)) {
                Storage::disk('public')->delete($productGroup->image);
            }
            $data['image'] = $request->file('image')->store('product-groups', 'public');
        }

        $productGroup->update($data);

        return redirect()
            ->route('admin.productGroup.index')
            ->with('success', 'گروه محصول با موفقیت بروزرسانی شد.');
    }

    /**
     * حذف گروه
     */
    public function destroy(ProductGroup $productGroup)
    {
        // حذف تصویر
        if ($productGroup->image && Storage::disk('public')->exists($productGroup->image)) {
            Storage::disk('public')->delete($productGroup->image);
        }

        $productGroup->delete();

        return redirect()
            ->route('admin.productGroup.index')
            ->with('success', 'گروه محصول با موفقیت حذف شد.');
    }
}

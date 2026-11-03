<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shop\StoreParentCategoryRequest;
use App\Http\Requests\Shop\UpdateParentCategoryRequest;
use App\Models\Shop\ParentCategory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ParentCategoryController extends Controller
{
    public function index()
    {
        $categories = ParentCategory::all();

        return view('panelAdmin.shop.parent.index', compact('categories'));
    }
    public function create()
    {
        return view('panelAdmin.shop.parent.create');
    }

    public function store(StoreParentCategoryRequest $request)
    {
        $data = $request->validated();

        $data['slug'] = $this->generateSlug($data['slug'] ?? null, $data['name']);

        // ذخیره تصویر
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('parent_categories', 'public');        }

       $parents= ParentCategory::create($data);

        return redirect()
            ->route('admin.parentShop.index',compact('parents'))
            ->with('success', 'دسته‌بندی اصلی با موفقیت ایجاد شد.');
    }

    public function edit(ParentCategory $parentCategory)
    {
        return view('panelAdmin.shop.parent.edit', compact('parentCategory'));
    }

    public function update(UpdateParentCategoryRequest $request, ParentCategory $parentCategory)
    {
        $data = $request->validated();

        $data['slug'] = $this->generateSlug(
            $data['slug'] ?? null,
            $data['name'],
            $parentCategory->id
        );

        // اگر فایل جدید آپلود شده
        if ($request->hasFile('image')) {
            // حذف تصویر قبلی از دیسک (اگر وجود داشت)
            if ($parentCategory->image && Storage::disk('public')->exists($parentCategory->image)) {
                Storage::disk('public')->delete($parentCategory->image);
            }

            // ذخیره فایل جدید
            $data['image'] = $request->file('image')->store('parent_categories', 'public');
        }

        $parentCategory->update($data);

        return redirect()
            ->route('admin.parentShop.index')
            ->with('success', 'دسته‌بندی اصلی با موفقیت ویرایش شد.');
    }

    public function destroy(ParentCategory $parentCategory)
    {
        $parentCategory->delete();

        return redirect()
            ->route('admin.parentShop.index')
            ->with('success', 'دسته‌بندی اصلی حذف شد.');
    }

    /**
     * تولید Slug یکتا
     */
    private function generateSlug(?string $slug, string $name, ?int $ignoreId = null): string
    {
        $slug = $slug ? Str::slug($slug) : Str::slug($name);

        if (empty($slug)) {
            $slug = 'category-' . time();
        }

        $original = $slug;
        $counter  = 1;

        while (
        ParentCategory::where('slug', $slug)
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists()
        ) {
            $slug = $original . '-' . $counter++;
        }

        return $slug;
    }
}

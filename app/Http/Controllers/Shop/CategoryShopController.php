<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shop\StoreCategoryShopRequest;
use App\Http\Requests\Shop\UpdateCategoryShopRequest;
use App\Models\Shop\CategoryShop;
use App\Models\Shop\ParentCategory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryShopController extends Controller
{
    public function index()
    {
        $categories = CategoryShop::with(['parentCategory', 'parent'])
            ->orderBy('sort_order')
            ->get();

        return view('panelAdmin.shop.category.index', compact('categories'));
    }

    public function create()
    {
        $parentCategories = ParentCategory::orderBy('name')->get();
        $parents = CategoryShop::orderBy('name')->get();

        return view('panelAdmin.shop.category.create', compact('parentCategories', 'parents'));
    }

    public function store(StoreCategoryShopRequest $request)
    {
        $data = $request->validated();

        $data['slug'] = $this->generateSlug($data['slug'] ?? null, $data['name']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('category_shops', 'public');
        }

        CategoryShop::create($data);

        return redirect()
            ->route('admin.categoryShop.index')
            ->with('success', 'زیردسته با موفقیت ایجاد شد.');
    }

    public function edit(CategoryShop $categoryShop)
    {
        $parentCategories = ParentCategory::orderBy('name')->get();
        $parents = CategoryShop::where('id', '!=', $categoryShop->id)
            ->orderBy('name')
            ->get();

        return view('panelAdmin.shop.category.edit', compact('categoryShop', 'parentCategories', 'parents'));
    }

    public function update(UpdateCategoryShopRequest $request, CategoryShop $categoryShop)
    {
        $data = $request->validated();

        $data['slug'] = $this->generateSlug(
            $data['slug'] ?? null,
            $data['name'],
            $categoryShop->id
        );

        if ($request->hasFile('image')) {
            if ($categoryShop->image && Storage::disk('public')->exists($categoryShop->image)) {
                Storage::disk('public')->delete($categoryShop->image);
            }
            $data['image'] = $request->file('image')->store('category_shops', 'public');
        }

        $categoryShop->update($data);

        return redirect()
            ->route('admin.categoryShop.index')
            ->with('success', 'زیردسته با موفقیت ویرایش شد.');
    }

    public function destroy(CategoryShop $categoryShop)
    {
        if ($categoryShop->children()->exists()) {
            return redirect()
                ->route('admin.categoryShop.index')
                ->with('error', 'این دسته دارای زیردسته است و قابل حذف نیست.');
        }

        if ($categoryShop->image && Storage::disk('public')->exists($categoryShop->image)) {
            Storage::disk('public')->delete($categoryShop->image);
        }

        $categoryShop->delete();

        return redirect()
            ->route('admin.categoryShop.index')
            ->with('success', 'زیردسته با موفقیت حذف شد.');
    }

    /**
     * تولید Slug یکتا از نام (اگر Slug خالی باشد)
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
        CategoryShop::where('slug', $slug)
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists()
        ) {
            $slug = $original . '-' . $counter++;
        }

        return $slug;
    }
}

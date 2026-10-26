<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shop\StoreParentCategoryRequest;
use App\Http\Requests\Shop\UpdateParentCategoryRequest;
use App\Models\Shop\ParentCategory;
use Illuminate\Support\Str;

class ParentCategoryController extends Controller
{
    public function index()
    {
        $categories = ParentCategory::orderBy('sort_order')
            ->orderByDesc('id')
            ->paginate(15);

        return view('admin.parent-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.parent-categories.create');
    }

    public function store(StoreParentCategoryRequest $request)
    {
        $data = $request->validated();

        $data['slug'] = $this->generateSlug($data['slug'] ?? null, $data['name']);

        ParentCategory::create($data);

        return redirect()
            ->route('admin.parent-categories.index')
            ->with('success', 'دسته‌بندی اصلی با موفقیت ایجاد شد.');
    }

    public function edit(ParentCategory $parentCategory)
    {
        return view('admin.parent-categories.edit', compact('parentCategory'));
    }

    public function update(UpdateParentCategoryRequest $request, ParentCategory $parentCategory)
    {
        $data = $request->validated();

        $data['slug'] = $this->generateSlug(
            $data['slug'] ?? null,
            $data['name'],
            $parentCategory->id
        );

        $parentCategory->update($data);

        return redirect()
            ->route('admin.parent-categories.index')
            ->with('success', 'دسته‌بندی اصلی با موفقیت ویرایش شد.');
    }

    public function destroy(ParentCategory $parentCategory)
    {
        $parentCategory->delete();

        return redirect()
            ->route('admin.parent-categories.index')
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

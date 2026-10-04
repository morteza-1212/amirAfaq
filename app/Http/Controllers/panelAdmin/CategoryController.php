<?php

namespace App\Http\Controllers\panelAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\ProductGroup;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Index
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $categories = Category::with([
            'productGroup',
            'parent',
            'translations',
        ])
            ->orderBy('sort_order')
            ->paginate(20);

        return view(
            'panelAdmin.category.index',
            compact('categories')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $productGroups = ProductGroup::with('translations')->get();

        $categories = Category::with('translations')
            ->whereNull('parent_id')
            ->get();

        return view(
            'panelAdmin.category.create',
            compact('productGroups', 'categories')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Store
    |--------------------------------------------------------------------------
    */

    public function store(StoreCategoryRequest $request)
    {
        $data = $request->validated();

        /*
        |--------------------------------------------------------------------------
        | ۱. آپلود تصویر
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')
                ->store('categories', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | ۲. مقادیر پیش‌فرض برای checkbox ها
        |--------------------------------------------------------------------------
        */

        $data['status']      = $request->boolean('status');
        $data['is_featured'] = $request->boolean('is_featured');
        $data['sort_order']  = $data['sort_order'] ?? 0;

        /*
        |--------------------------------------------------------------------------
        | ۳. جدا کردن فیلدهای ترجمه از فیلدهای جدول categories
        |--------------------------------------------------------------------------
        |
        |   name, slug, short_description, description
        |   به جدول category_translations می‌روند.
        |
        */

        $translationFields = [
            'name',
            'slug',
            'short_description',
            'description',
        ];

        $translationData = [];

        foreach ($translationFields as $field) {
            if (array_key_exists($field, $data)) {
                $translationData[$field] = $data[$field];
                unset($data[$field]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | ۴. ساخت اسلاگ اگر وارد نشده بود
        |--------------------------------------------------------------------------
        */

        if (empty($translationData['slug'])) {
            $translationData['slug'] = Str::slug($translationData['name'])
                ?: 'category-' . time();
        }

        /*
        |--------------------------------------------------------------------------
        | ۵. ایجاد دسته
        |--------------------------------------------------------------------------
        |
        |   کد (code) به صورت خودکار در مدل Category تولید می‌شود
        |   (متد booted + generateNextCode در مدل).
        |
        */

        $category = Category::create($data);

        /*
        |--------------------------------------------------------------------------
        | ۶. ایجاد ترجمه فارسی
        |--------------------------------------------------------------------------
        */

        $translationData['locale'] = 'fa';

        $category->translations()->create($translationData);

        return redirect()
            ->route('admin.category.index')
            ->with('success', 'دسته‌بندی ایجاد شد');
    }


    /*
    |--------------------------------------------------------------------------
    | Show
    |--------------------------------------------------------------------------
    */

    public function show(Category $category)
    {
        $category->load([
            'productGroup',
            'parent',
            'children',
            'translations',
        ]);

        return view(
            'panelAdmin.categories.show',
            compact('category')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Edit
    |--------------------------------------------------------------------------
    */

    public function edit(Category $category)
    {
        $productGroups = ProductGroup::all();

        $categories = Category::where('id', '!=', $category->id)
            ->whereNull('parent_id')
            ->get();

        return view(
            'panelAdmin.category.edit',
            compact(
                'category',
                'productGroups',
                'categories'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    public function update(
        UpdateCategoryRequest $request,
        Category $category
    ) {
        $data = $request->validated();

        /*
        |--------------------------------------------------------------------------
        | ۱. آپلود تصویر جدید (و حذف تصویر قبلی)
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {

            // حذف تصویر قبلی از storage
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }

            $data['image'] = $request->file('image')
                ->store('categories', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | ۲. مقادیر پیش‌فرض
        |--------------------------------------------------------------------------
        */

        $data['status']      = $request->boolean('status');
        $data['is_featured'] = $request->boolean('is_featured');
        $data['sort_order']  = $data['sort_order'] ?? 0;

        /*
        |--------------------------------------------------------------------------
        | ۳. جدا کردن فیلدهای ترجمه
        |--------------------------------------------------------------------------
        */

        $translationFields = [
            'name',
            'slug',
            'short_description',
            'description',
        ];

        $translationData = [];

        foreach ($translationFields as $field) {
            if (array_key_exists($field, $data)) {
                $translationData[$field] = $data[$field];
                unset($data[$field]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | ۴. ساخت اسلاگ اگر وارد نشده بود
        |--------------------------------------------------------------------------
        */

        if (
            !empty($translationData['name']) &&
            empty($translationData['slug'])
        ) {
            $translationData['slug'] = Str::slug($translationData['name'])
                ?: 'category-' . $category->id;
        }

        /*
        |--------------------------------------------------------------------------
        | ۵. بروزرسانی دسته
        |--------------------------------------------------------------------------
        */

        $category->update($data);

        /*
        |--------------------------------------------------------------------------
        | ۶. بروزرسانی یا ایجاد ترجمه فارسی
        |--------------------------------------------------------------------------
        */

        $translation = $category->translations()
            ->where('locale', 'fa')
            ->first();

        if ($translation) {
            $translation->update($translationData);
        } else {
            $translationData['locale'] = 'fa';
            $category->translations()->create($translationData);
        }

        return redirect()
            ->route('admin.category.index')
            ->with('success', 'دسته‌بندی بروزرسانی شد');
    }


    /*
    |--------------------------------------------------------------------------
    | Destroy
    |--------------------------------------------------------------------------
    */

    public function destroy(Category $category)
    {
        /*
        |--------------------------------------------------------------------------
        | حذف تصویر از storage
        |--------------------------------------------------------------------------
        */

        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        /*
        |--------------------------------------------------------------------------
        | حذف ترجمه‌ها
        |--------------------------------------------------------------------------
        */

        $category->translations()->delete();

        /*
        |--------------------------------------------------------------------------
        | حذف دسته
        |--------------------------------------------------------------------------
        */

        $category->delete();

        return redirect()
            ->route('admin.category.index')
            ->with('success', 'دسته‌بندی حذف شد');
    }
}

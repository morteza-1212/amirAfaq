<?php

namespace App\Http\Controllers\panelAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryTranslationRequest;
use App\Http\Requests\UpdateCategoryTranslationRequest;
use App\Models\Category;
use App\Models\CategoryTranslation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CategoryTranslationController extends Controller
{
    /**
     * لیست ترجمه‌ها
     */
    public function index(): View
    {
        $translations = CategoryTranslation::with('category')
            ->latest()
            ->paginate(20);

        return view(
            'panelAdmin.category.categoryTranslation.index',
            compact('translations')
        );
    }

    /**
     * فرم ایجاد ترجمه
     */
    public function create(): View
    {
        $categories = Category::with('translations')->get();

        return view(
            'panelAdmin.category.categoryTranslation.create',
            compact('categories')
        );
    }

    /**
     * ذخیره ترجمه جدید
     */
    public function store(StoreCategoryTranslationRequest $request): RedirectResponse
    {
        $validated = $request->validate(
            $this->validationRules(),
            $this->validationMessages()
        );

        CategoryTranslation::create($validated);

        return redirect()
            ->route('admin.category.translation.index')
            ->with('success', 'ترجمه دسته‌بندی با موفقیت ایجاد شد.');
    }

    /**
     * نمایش ترجمه
     */
    public function show(CategoryTranslation $categoryTranslation): View
    {
        $categoryTranslation->load('category');

        return view(
            'panelAdmin.categories.translations.show',
            compact('categoryTranslation')
        );
    }

    /**
     * فرم ویرایش ترجمه
     */
    public function edit(CategoryTranslation $categoryTranslation): View
    {
        $categories = Category::with('translations')->get();

        return view(
            'panelAdmin.category.categoryTranslation.edit',
            compact('categoryTranslation', 'categories')
        );
    }

    /**
     * بروزرسانی ترجمه
     */
    public function update(
        UpdateCategoryTranslationRequest $request,
        CategoryTranslation $categoryTranslation
    ): RedirectResponse {

        $validated = $request->validate(
            $this->validationRules($categoryTranslation),
            $this->validationMessages()
        );

        $categoryTranslation->update($validated);

        return redirect()
            ->route('admin.category.translation.index')
            ->with('success', 'ترجمه دسته‌بندی با موفقیت بروزرسانی شد.');
    }

    /**
     * حذف ترجمه
     */
    public function destroy(
        CategoryTranslation $categoryTranslation
    ): RedirectResponse {

        $categoryTranslation->delete();

        return redirect()
            ->route('admin.category.translation.index')
            ->with('success', 'ترجمه دسته‌بندی با موفقیت حذف شد.');
    }

    /**
     * قوانین اعتبارسنجی
     */
    protected function validationRules(
        ?CategoryTranslation $translation = null
    ): array {

        $translationId = $translation?->id;

        return [

            /*
            |--------------------------------------------------------------------------
            | دسته‌بندی
            |--------------------------------------------------------------------------
            */
            'category_id' => [
                'required',
                'integer',
                'exists:categories,id',
            ],

            /*
            |--------------------------------------------------------------------------
            | زبان
            |--------------------------------------------------------------------------
            */
            'locale' => [
                'required',
                'string',
                Rule::in(['fa', 'en', 'ar']),

                // هر دسته فقط یک ترجمه برای هر زبان
                Rule::unique('category_translations')
                    ->where(function ($query) use ($translation) {
                        return $query->where(
                            'category_id',
                            request('category_id')
                        );
                    })
                    ->ignore($translationId),
            ],

            /*
            |--------------------------------------------------------------------------
            | نام
            |--------------------------------------------------------------------------
            */
            'name' => [
                'required',
                'string',
                'min:2',
                'max:255',
            ],

            /*
            |--------------------------------------------------------------------------
            | Slug
            |--------------------------------------------------------------------------
            */
            'slug' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',

                // slug در هر زبان یکتا باشد
                Rule::unique('category_translations')
                    ->where(function ($query) use ($translation) {
                        return $query->where(
                            'locale',
                            request('locale')
                        );
                    })
                    ->ignore($translationId),
            ],

            /*
            |--------------------------------------------------------------------------
            | توضیح کوتاه
            |--------------------------------------------------------------------------
            */
            'short_description' => [
                'nullable',
                'string',
                'max:500',
            ],

            /*
            |--------------------------------------------------------------------------
            | توضیحات کامل
            |--------------------------------------------------------------------------
            */
            'description' => [
                'nullable',
                'string',
            ],

            /*
            |--------------------------------------------------------------------------
            | عنوان سئو
            |--------------------------------------------------------------------------
            */
            'meta_title' => [
                'nullable',
                'string',
                'max:255',
            ],

            /*
            |--------------------------------------------------------------------------
            | توضیحات سئو
            |--------------------------------------------------------------------------
            */
            'meta_description' => [
                'nullable',
                'string',
                'max:500',
            ],

            /*
            |--------------------------------------------------------------------------
            | کلمات کلیدی سئو
            |--------------------------------------------------------------------------
            */
            'meta_keywords' => [
                'nullable',
                'string',
                'max:500',
            ],
        ];
    }

    /**
     * پیام‌های اعتبارسنجی
     */
    protected function validationMessages(): array
    {
        return [

            'category_id.required' =>
                'انتخاب دسته‌بندی الزامی است.',

            'category_id.integer' =>
                'شناسه دسته‌بندی نامعتبر است.',

            'category_id.exists' =>
                'دسته‌بندی انتخاب‌شده وجود ندارد.',

            'locale.required' =>
                'انتخاب زبان الزامی است.',

            'locale.in' =>
                'زبان انتخاب‌شده معتبر نیست.',

            'locale.unique' =>
                'برای این دسته‌بندی، ترجمه این زبان قبلاً ثبت شده است.',

            'name.required' =>
                'نام دسته‌بندی الزامی است.',

            'name.min' =>
                'نام دسته‌بندی باید حداقل ۲ کاراکتر باشد.',

            'name.max' =>
                'نام دسته‌بندی نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.',

            'slug.required' =>
                'Slug الزامی است.',

            'slug.max' =>
                'Slug نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.',

            'slug.regex' =>
                'Slug باید فقط شامل حروف انگلیسی کوچک، اعداد و خط تیره باشد.',

            'slug.unique' =>
                'این Slug قبلاً برای این زبان استفاده شده است.',

            'short_description.max' =>
                'توضیح کوتاه نمی‌تواند بیشتر از ۵۰۰ کاراکتر باشد.',

            'meta_title.max' =>
                'عنوان سئو نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.',

            'meta_description.max' =>
                'توضیحات سئو نمی‌تواند بیشتر از ۵۰۰ کاراکتر باشد.',

            'meta_keywords.max' =>
                'کلمات کلیدی نمی‌تواند بیشتر از ۵۰۰ کاراکتر باشد.',
        ];
    }
}

<?php

namespace App\Http\Requests\Shop;

use Illuminate\Foundation\Http\FormRequest;

class StoreParentCategoryRequest extends FormRequest
{
    /**
     * تعیین سطح دسترسی (در صورت نیاز به Gate/Policy تغییر دهید)
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * قوانین اعتبارسنجی
     */
    public function rules(): array
    {
        return [
            'name'             => ['required', 'string', 'max:150'],
            'slug'             => ['nullable', 'string', 'max:180', 'unique:parent_categories,slug'],
            'description'      => ['nullable', 'string'],
            'image'            => ['nullable', 'string', 'max:255'],
            'icon'             => ['nullable', 'string', 'max:100'],
            'meta_title'       => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'sort_order'       => ['nullable', 'integer', 'min:0'],
            'is_active'        => ['nullable', 'boolean'],
        ];
    }

    /**
     * پیام‌های خطا
     */
    public function messages(): array
    {
        return [
            'name.required'            => 'نام دسته‌بندی الزامی است.',
            'name.string'              => 'نام دسته‌بندی باید متن باشد.',
            'name.max'                 => 'نام دسته‌بندی نباید بیشتر از ۱۵۰ کاراکتر باشد.',

            'slug.max'                 => 'Slug نباید بیشتر از ۱۸۰ کاراکتر باشد.',
            'slug.unique'              => 'این آدرس اختصاصی قبلاً استفاده شده است.',

            'description.string'       => 'توضیحات باید متن باشد.',

            'image.max'                => 'مسیر تصویر نباید بیشتر از ۲۵۵ کاراکتر باشد.',

            'icon.max'                 => 'آیکون نباید بیشتر از ۱۰۰ کاراکتر باشد.',

            'meta_title.max'           => 'عنوان سئو نباید بیشتر از ۲۵۵ کاراکتر باشد.',

            'meta_description.max'     => 'توضیحات سئو نباید بیشتر از ۵۰۰ کاراکتر باشد.',

            'sort_order.integer'       => 'ترتیب نمایش باید عدد باشد.',
            'sort_order.min'           => 'ترتیب نمایش نمی‌تواند منفی باشد.',

            'is_active.boolean'        => 'وضعیت فعال بودن باید مقدار صحیح/غلط باشد.',
        ];
    }

    /**
     * نام فیلدها برای نمایش زیباتر در خطاها
     */
    public function attributes(): array
    {
        return [
            'name'             => 'نام',
            'slug'             => 'آدرس اختصاصی',
            'description'      => 'توضیحات',
            'image'            => 'تصویر',
            'icon'             => 'آیکون',
            'meta_title'       => 'عنوان سئو',
            'meta_description' => 'توضیحات سئو',
            'sort_order'       => 'ترتیب نمایش',
            'is_active'        => 'وضعیت',
        ];
    }

    /**
     * آماده‌سازی داده‌ها قبل از اعتبارسنجی
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'sort_order' => $this->filled('sort_order') ? (int) $this->sort_order : 0,
            'is_active'  => $this->boolean('is_active'),
        ]);
    }
}

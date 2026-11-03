<?php

namespace App\Http\Requests\Shop;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryShopRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'parent_category_id' => ['required', 'exists:parent_categories,id'],
            'parent_id'          => ['nullable', 'exists:category_shops,id'],
            'name'               => ['required', 'string', 'max:150'],
            'slug'               => ['nullable', 'string', 'max:180', 'unique:category_shops,slug'],
            'description'        => ['nullable', 'string'],
            'image'              => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'icon'               => ['nullable', 'string', 'max:100'],
            'meta_title'         => ['nullable', 'string', 'max:255'],
            'meta_description'   => ['nullable', 'string', 'max:500'],
            'sort_order'         => ['nullable', 'integer', 'min:0'],
            'is_active'          => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'parent_category_id.required' => 'انتخاب دسته‌بندی اصلی الزامی است.',
            'parent_category_id.exists'   => 'دسته‌بندی اصلی انتخاب‌شده معتبر نیست.',
            'parent_id.exists'            => 'زیردسته والد انتخاب‌شده معتبر نیست.',
            'name.required'               => 'نام دسته‌بندی الزامی است.',
            'slug.unique'                 => 'این آدرس اختصاصی قبلاً استفاده شده است.',
            'image.image'                 => 'فایل انتخاب‌شده باید تصویر باشد.',
            'image.mimes'                 => 'فرمت تصویر باید jpeg، png، jpg، gif یا webp باشد.',
            'image.max'                   => 'حجم تصویر نباید بیشتر از ۲ مگابایت باشد.',
        ];
    }

    public function attributes(): array
    {
        return [
            'parent_category_id' => 'دسته‌بندی اصلی',
            'parent_id'          => 'زیردسته والد',
            'name'               => 'نام',
            'slug'               => 'آدرس اختصاصی',
            'description'        => 'توضیحات',
            'image'              => 'تصویر',
            'icon'               => 'آیکون',
            'meta_title'         => 'عنوان سئو',
            'meta_description'   => 'توضیحات سئو',
            'sort_order'         => 'ترتیب نمایش',
            'is_active'          => 'وضعیت',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'sort_order' => $this->filled('sort_order') ? (int) $this->sort_order : 0,
            'is_active'  => $this->boolean('is_active'),
        ]);
    }
}

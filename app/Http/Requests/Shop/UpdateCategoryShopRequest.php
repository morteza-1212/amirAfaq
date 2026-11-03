<?php

namespace App\Http\Requests\Shop;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryShopRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $categoryId = $this->route('categoryShop')?->id
            ?? $this->route('category_shop')?->id;

        return [
            'parent_category_id' => ['required', 'exists:parent_categories,id'],
            'parent_id'          => [
                'nullable',
                'exists:category_shops,id',
                Rule::notIn([$categoryId]),
            ],
            'name'               => ['required', 'string', 'max:150'],
            'slug'               => [
                'nullable',
                'string',
                'max:180',
                Rule::unique('category_shops', 'slug')->ignore($categoryId),
            ],
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
            'parent_id.not_in'            => 'یک دسته‌بندی نمی‌تواند والد خودش باشد.',
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
            'image'              => 'تصویر',
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

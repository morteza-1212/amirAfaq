<?php

namespace App\Http\Requests\Shop;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductShopImageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_shop_id' => ['required', 'exists:product_shops,id'],
            'image_path'      => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'alt_text'        => ['nullable', 'string', 'max:255'],
            'sort_order'      => ['nullable', 'integer', 'min:0'],
            'is_primary'      => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'product_shop_id.required' => 'انتخاب محصول الزامی است.',
            'product_shop_id.exists'   => 'محصول انتخاب‌شده معتبر نیست.',
            'image_path.image'         => 'فایل انتخاب‌شده باید تصویر باشد.',
            'image_path.mimes'         => 'فرمت تصویر باید jpeg، png، jpg، gif یا webp باشد.',
            'image_path.max'           => 'حجم تصویر نباید بیشتر از ۲ مگابایت باشد.',
        ];
    }

    public function attributes(): array
    {
        return [
            'product_shop_id' => 'محصول',
            'image_path'      => 'تصویر',
            'alt_text'        => 'متن جایگزین',
            'sort_order'      => 'ترتیب نمایش',
            'is_primary'      => 'تصویر اصلی',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'sort_order' => $this->filled('sort_order') ? (int) $this->sort_order : 0,
            'is_primary' => $this->boolean('is_primary'),
        ]);
    }
}

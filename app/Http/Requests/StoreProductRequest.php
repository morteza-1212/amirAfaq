<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'category_id' => ['required', 'exists:categories,id'],
//            'code'        => ['nullable', 'string', 'max:100', 'unique:products,code'],
            'sku'         => ['nullable', 'string', 'max:100', 'unique:products,sku'],
            'type'        => ['required', Rule::in(array_keys(Product::TYPES))],
            'stock_status' => ['required', Rule::in(array_keys(Product::STOCK_STATUSES))],
            'unit'        => ['nullable', 'string', 'max:50'],
            'weight'      => ['nullable', 'numeric', 'min:0'],
            'origin_country' => ['nullable', 'string', 'max:100'],
            'minimum_order'  => ['nullable', 'numeric', 'min:0'],
            'preparation_days' => ['nullable', 'integer', 'min:0'],
            'sort_order'  => ['nullable', 'integer', 'min:0'],
            'is_active'   => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],

            'image'     => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'gallery'   => ['nullable', 'array'],
            'gallery.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ];

        // فیلدهای چندزبانه — توجه: نام جدول product_tranlations
        foreach (array_keys(Product::LOCALES) as $locale) {
            $required = $locale === Product::DEFAULT_LOCALE ? 'required' : 'nullable';

            $rules["translations.{$locale}.name"]              = [$required, 'string', 'max:255'];
            $rules["translations.{$locale}.slug"]              = [
                'nullable', 'string', 'max:255',
                Rule::unique('product_tranlations', 'slug')->where('locale', $locale),
            ];
            $rules["translations.{$locale}.short_description"] = ['nullable', 'string', 'max:1000'];
            $rules["translations.{$locale}.description"]       = ['nullable', 'string'];
            $rules["translations.{$locale}.specifications"]    = ['nullable', 'string'];
            $rules["translations.{$locale}.features"]          = ['nullable', 'string'];
            $rules["translations.{$locale}.packaging"]         = ['nullable', 'string'];
            $rules["translations.{$locale}.shipping_info"]     = ['nullable', 'string'];
            $rules["translations.{$locale}.meta_title"]        = ['nullable', 'string', 'max:255'];
            $rules["translations.{$locale}.meta_description"]  = ['nullable', 'string', 'max:500'];
            $rules["translations.{$locale}.meta_keywords"]     = ['nullable', 'string', 'max:500'];
            $rules["translations.{$locale}.alt_text"]          = ['nullable', 'string', 'max:255'];
        }

        return $rules;
    }

    public function attributes(): array
    {
        $attrs = [
            'category_id' => 'دسته‌بندی',
            'code'        => 'کد محصول',
            'sku'         => 'SKU',
            'type'        => 'نوع محصول',
            'stock_status' => 'وضعیت موجودی',
            'unit'        => 'واحد',
            'weight'      => 'وزن',
            'origin_country' => 'کشور مبدا',
            'minimum_order'  => 'حداقل سفارش',
            'preparation_days' => 'مدت آماده‌سازی',
            'sort_order'  => 'ترتیب نمایش',
            'is_active'   => 'وضعیت فعال',
            'is_featured' => 'محصول ویژه',
            'image'       => 'تصویر اصلی',
            'gallery'     => 'گالری تصاویر',
        ];

        foreach (Product::LOCALES as $code => $label) {
            $attrs["translations.{$code}.name"]              = "نام ({$label})";
            $attrs["translations.{$code}.slug"]              = "نامک ({$label})";
            $attrs["translations.{$code}.short_description"] = "توضیح کوتاه ({$label})";
            $attrs["translations.{$code}.description"]       = "توضیحات ({$label})";
            $attrs["translations.{$code}.specifications"]    = "مشخصات ({$label})";
            $attrs["translations.{$code}.features"]          = "ویژگی‌ها ({$label})";
            $attrs["translations.{$code}.packaging"]         = "بسته‌بندی ({$label})";
            $attrs["translations.{$code}.shipping_info"]     = "اطلاعات حمل ({$label})";
            $attrs["translations.{$code}.meta_title"]        = "عنوان متا ({$label})";
            $attrs["translations.{$code}.meta_description"]  = "توضیحات متا ({$label})";
            $attrs["translations.{$code}.meta_keywords"]     = "کلمات کلیدی ({$label})";
            $attrs["translations.{$code}.alt_text"]          = "متن جایگزین ({$label})";
        }

        return $attrs;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active'   => $this->boolean('is_active', true),
            'is_featured' => $this->boolean('is_featured', false),
            'sort_order'  => $this->input('sort_order', 0),
        ]);
    }
}

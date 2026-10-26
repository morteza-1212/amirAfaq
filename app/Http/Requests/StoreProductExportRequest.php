<?php

namespace App\Http\Requests;

use App\Models\ProductExport;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductExportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'category_id'             => ['nullable', 'exists:categories,id'],
            'sku'                     => ['nullable', 'string', 'max:100', 'unique:product_exports,sku'],
            'product_type'            => ['required', Rule::in(array_keys(ProductExport::PRODUCT_TYPES))],
            'unit'                    => ['nullable', Rule::in(array_keys(ProductExport::UNITS))],
            'minimum_order_quantity'  => ['nullable', 'numeric', 'min:0'],
            'maximum_supply_quantity' => ['nullable', 'numeric', 'min:0'],
            'origin_country'          => ['nullable', 'string', 'max:100'],
            'packaging_type'          => ['nullable', 'string', 'max:150'],
            'storage_conditions'      => ['nullable', 'string', 'max:255'],
            'shelf_life'              => ['nullable', 'string', 'max:100'],
            'is_exportable'           => ['nullable', 'boolean'],
            'is_available_domestic'   => ['nullable', 'boolean'],
            'is_featured'             => ['nullable', 'boolean'],
            'is_active'               => ['nullable', 'boolean'],
            'sort_order'              => ['nullable', 'integer', 'min:0'],
            'specifications'          => ['nullable', 'string'], // JSON string از فرم
            'image'                   => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'gallery'                 => ['nullable', 'array'],
            'gallery.*'               => ['image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ];

        foreach (array_keys(ProductExport::LOCALES) as $locale) {
            $required = $locale === ProductExport::DEFAULT_LOCALE ? 'required' : 'nullable';

            $rules["translations.{$locale}.name"]                  = [$required, 'string', 'max:255'];
            $rules["translations.{$locale}.meta_title"]            = ['nullable', 'string', 'max:255'];
            $rules["translations.{$locale}.short_description"]     = ['nullable', 'string', 'max:500'];
            $rules["translations.{$locale}.description"]           = ['nullable', 'string'];
            $rules["translations.{$locale}.features"]              = ['nullable', 'string'];
            $rules["translations.{$locale}.packaging_description"] = ['nullable', 'string'];
            $rules["translations.{$locale}.meta_keywords"]         = ['nullable', 'string', 'max:500'];
            $rules["translations.{$locale}.meta_description"]      = ['nullable', 'string', 'max:500'];
        }

        return $rules;
    }

    public function attributes(): array
    {
        $attrs = [
            'category_id'             => 'دسته‌بندی',
            'sku'                     => 'SKU',
            'product_type'            => 'نوع محصول',
            'unit'                    => 'واحد',
            'minimum_order_quantity'  => 'حداقل سفارش',
            'maximum_supply_quantity' => 'حداکثر تأمین',
            'origin_country'          => 'کشور مبدا',
            'packaging_type'          => 'نوع بسته‌بندی',
            'storage_conditions'      => 'شرایط نگهداری',
            'shelf_life'              => 'مدت ماندگاری',
            'is_exportable'           => 'قابلیت صادرات',
            'is_available_domestic'   => 'عرضه داخلی',
            'is_featured'             => 'ویژه',
            'is_active'               => 'وضعیت فعال',
            'sort_order'              => 'ترتیب نمایش',
            'specifications'          => 'مشخصات فنی',
            'image'                   => 'تصویر اصلی',
            'gallery'                 => 'گالری',
        ];

        foreach (ProductExport::LOCALES as $code => $label) {
            $attrs["translations.{$code}.name"]                  = "نام ({$label})";
            $attrs["translations.{$code}.meta_title"]            = "عنوان متا ({$label})";
            $attrs["translations.{$code}.short_description"]     = "توضیح کوتاه ({$label})";
            $attrs["translations.{$code}.description"]           = "توضیحات ({$label})";
            $attrs["translations.{$code}.features"]              = "ویژگی‌ها ({$label})";
            $attrs["translations.{$code}.packaging_description"] = "توضیحات بسته‌بندی ({$label})";
            $attrs["translations.{$code}.meta_keywords"]         = "کلمات کلیدی ({$label})";
            $attrs["translations.{$code}.meta_description"]      = "توضیحات متا ({$label})";
        }

        return $attrs;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_exportable'          => $this->boolean('is_exportable', true),
            'is_available_domestic'  => $this->boolean('is_available_domestic', false),
            'is_featured'            => $this->boolean('is_featured', false),
            'is_active'              => $this->boolean('is_active', true),
            'sort_order'             => $this->input('sort_order', 0),
        ]);
    }
}

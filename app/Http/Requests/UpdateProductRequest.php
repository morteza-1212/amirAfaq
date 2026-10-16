<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $product   = $this->route('product');
        $productId = $product?->id;

        $rules = [
            'category_id' => ['required', 'exists:categories,id'],
            'sku'         => ['nullable', 'string', 'max:100',
                Rule::unique('products', 'sku')->ignore($productId),
            ],
            'type'         => ['required', Rule::in(array_keys(Product::TYPES))],
            'stock_status' => ['required', Rule::in(array_keys(Product::STOCK_STATUSES))],
            'unit'         => ['nullable', Rule::in(array_keys(Product::UNITS))],
            'weight'       => ['nullable', 'numeric', 'min:0'],
            'origin_country' => ['nullable', 'string', 'max:100'],
            'minimum_order'  => ['nullable', 'numeric', 'min:0'],
            'preparation_days' => ['nullable', 'integer', 'min:0'],
            'sort_order'   => ['nullable', 'integer', 'min:0'],
            'is_active'    => ['nullable', 'boolean'],
            'is_featured'  => ['nullable', 'boolean'],

            'image'     => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'gallery'   => ['nullable', 'array'],
            'gallery.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ];

        foreach (array_keys(Product::LOCALES) as $locale) {
            $required = $locale === Product::DEFAULT_LOCALE ? 'required' : 'nullable';

            $rules["translations.{$locale}.name"] = [$required, 'string', 'max:255'];

            // ✅ اصلاح: نادیده گرفتن ترجمه‌های همان محصول
            $rules["translations.{$locale}.slug"] = [
                'nullable', 'string', 'max:255',
                Rule::unique('product_tranlations', 'slug')
                    ->where(function ($q) use ($locale, $productId) {
                        $q->where('locale', $locale);
                        if ($productId) {
                            $q->where('product_id', '!=', $productId);
                        }
                    }),
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
        return (new StoreProductRequest())->attributes();
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active'   => $this->boolean('is_active', false),
            'is_featured' => $this->boolean('is_featured', false),
            'sort_order'  => $this->input('sort_order', 0),
        ]);
    }
}

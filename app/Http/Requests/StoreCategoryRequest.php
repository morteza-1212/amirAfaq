<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'product_group_id' => ['required', 'exists:product_groups,id'],
            'parent_id'        => ['nullable', 'exists:categories,id'],
            'icon'             => ['nullable', 'string', 'max:100'],
            'sort_order'       => ['nullable', 'integer', 'min:0'],
            'status'           => ['nullable', 'boolean'],
            'is_featured'      => ['nullable', 'boolean'],
            'image'            => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
        ];

        foreach (array_keys(Category::LOCALES) as $locale) {
            $required = $locale === Category::DEFAULT_LOCALE ? 'required' : 'nullable';

            $rules["translations.{$locale}.name"] = [$required, 'string', 'max:255'];
            $rules["translations.{$locale}.slug"] = [
                'nullable', 'string', 'max:255',
                Rule::unique('category_translations', 'slug')->where('locale', $locale),
            ];
            $rules["translations.{$locale}.short_description"] = ['nullable', 'string', 'max:500'];
            $rules["translations.{$locale}.description"]       = ['nullable', 'string', 'max:5000'];
            $rules["translations.{$locale}.meta_title"]        = ['nullable', 'string', 'max:255'];
            $rules["translations.{$locale}.meta_description"]  = ['nullable', 'string', 'max:500'];
            $rules["translations.{$locale}.meta_keywords"]     = ['nullable', 'string', 'max:255'];
        }

        return $rules;
    }

    public function attributes(): array
    {
        $attrs = [
            'product_group_id' => 'گروه محصول',
            'parent_id'        => 'دسته والد',
            'icon'             => 'آیکون',
            'sort_order'       => 'ترتیب نمایش',
            'status'           => 'وضعیت',
            'is_featured'      => 'دسته ویژه',
            'image'            => 'تصویر',
        ];

        foreach (Category::LOCALES as $code => $label) {
            $attrs["translations.{$code}.name"]              = "نام ({$label})";
            $attrs["translations.{$code}.slug"]              = "نامک ({$label})";
            $attrs["translations.{$code}.short_description"] = "توضیح کوتاه ({$label})";
            $attrs["translations.{$code}.description"]       = "توضیحات ({$label})";
            $attrs["translations.{$code}.meta_title"]        = "عنوان متا ({$label})";
            $attrs["translations.{$code}.meta_description"]  = "توضیحات متا ({$label})";
            $attrs["translations.{$code}.meta_keywords"]     = "کلمات کلیدی ({$label})";
        }

        return $attrs;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'status'      => $this->boolean('status', true),
            'is_featured' => $this->boolean('is_featured', false),
            'sort_order'  => $this->input('sort_order', 0),
        ]);
    }
}

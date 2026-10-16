<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $category   = $this->route('category');
        $categoryId = $category?->id;

        $rules = [
            'product_group_id' => ['required', 'exists:product_groups,id'],
            'parent_id'        => [
                'nullable',
                'exists:categories,id',
                // جلوگیری از انتخاب خود به‌عنوان والد
                Rule::notIn([$categoryId]),
            ],
            'icon'       => ['nullable', 'string', 'max:100'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'status'     => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
            'image'      => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
        ];

        foreach (array_keys(Category::LOCALES) as $locale) {
            $required = $locale === Category::DEFAULT_LOCALE ? 'required' : 'nullable';

            $rules["translations.{$locale}.name"] = [$required, 'string', 'max:255'];

            // ✅ نادیده گرفتن ترجمه‌های همین دسته
            $rules["translations.{$locale}.slug"] = [
                'nullable', 'string', 'max:255',
                Rule::unique('category_translations', 'slug')
                    ->where(function ($q) use ($locale, $categoryId) {
                        $q->where('locale', $locale);
                        if ($categoryId) {
                            $q->where('category_id', '!=', $categoryId);
                        }
                    }),
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
        return (new StoreCategoryRequest())->attributes();
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'status'      => $this->boolean('status', false),
            'is_featured' => $this->boolean('is_featured', false),
            'sort_order'  => $this->input('sort_order', 0),
        ]);
    }
}

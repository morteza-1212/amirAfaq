<?php

namespace App\Http\Requests;

use App\Models\Gallery;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreGalleryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $galleryId = $this->route('gallery')?->id;

        $rules = [
            'image' => [
                $this->isMethod('post') ? 'required' : 'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],
            'activity_type' => [
                'required',
                Rule::in(array_keys(Gallery::ACTIVITY_TYPES)),
            ],
            'is_active'  => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];

        // فیلدهای چندزبانه
        foreach (array_keys(Gallery::LOCALES) as $locale) {
            $required = $locale === Gallery::DEFAULT_LOCALE ? 'required' : 'nullable';

            $rules["translations.{$locale}.title"]       = [$required, 'string', 'max:255'];
            $rules["translations.{$locale}.slug"]        = [
                'nullable',
                'string',
                'max:255',
                Rule::unique('gallery_translations', 'slug')
                    ->where('locale', $locale)
                    ->when($galleryId, fn ($q) =>
                    $q->where('gallery_id', '!=', $galleryId)
                    ),
            ];
            $rules["translations.{$locale}.description"] = ['nullable', 'string', 'max:5000'];
            $rules["translations.{$locale}.alt_text"]    = ['nullable', 'string', 'max:255'];
        }

        return $rules;
    }

    public function attributes(): array
    {
        $attrs = [
            'image'         => 'تصویر',
            'activity_type' => 'نوع فعالیت',
            'is_active'     => 'وضعیت فعال',
            'sort_order'    => 'ترتیب نمایش',
        ];

        foreach (Gallery::LOCALES as $code => $label) {
            $attrs["translations.{$code}.title"]       = "عنوان ({$label})";
            $attrs["translations.{$code}.slug"]        = "نامک ({$label})";
            $attrs["translations.{$code}.description"] = "توضیحات ({$label})";
            $attrs["translations.{$code}.alt_text"]    = "متن جایگزین ({$label})";
        }

        return $attrs;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active'  => $this->boolean('is_active', true),
            'sort_order' => $this->input('sort_order', 0),
        ]);
    }
}

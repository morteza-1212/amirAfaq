<?php

namespace App\Http\Requests;

use App\Models\Gallery;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateGalleryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $gallery = $this->route('gallery');
        $galleryId = $gallery?->id;

        $rules = [
            // فیلدهای غیرچندزبانه
            'image' => [
                'nullable',
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

            $rules["translations.{$locale}.title"] = [
                $required,
                'string',
                'max:255',
            ];

            $rules["translations.{$locale}.slug"] = [
                'nullable',
                'string',
                'max:255',
                Rule::unique('gallery_translations', 'slug')
                    ->where('locale', $locale)
                    ->when($galleryId, fn ($q) => $q->where('gallery_id', '!=', $galleryId)),
            ];

            $rules["translations.{$locale}.description"] = [
                'nullable',
                'string',
                'max:5000',
            ];

            $rules["translations.{$locale}.alt_text"] = [
                'nullable',
                'string',
                'max:255',
            ];
        }

        return $rules;
    }

    /**
     * نام فیلدها برای پیام‌های خطا.
     */
    public function attributes(): array
    {
        $attributes = [
            'image'         => 'تصویر',
            'activity_type' => 'نوع فعالیت',
            'is_active'     => 'وضعیت فعال',
            'sort_order'    => 'ترتیب نمایش',
        ];

        foreach (Gallery::LOCALES as $code => $label) {
            $attributes["translations.{$code}.title"]       = "عنوان ({$label})";
            $attributes["translations.{$code}.slug"]        = "نامک ({$label})";
            $attributes["translations.{$code}.description"] = "توضیحات ({$label})";
            $attributes["translations.{$code}.alt_text"]    = "متن جایگزین ({$label})";
        }

        return $attributes;
    }

    /**
     * پیام‌های خطای سفارشی.
     */
    public function messages(): array
    {
        return [
            'activity_type.required' => 'انتخاب نوع فعالیت الزامی است.',
            'activity_type.in'       => 'نوع فعالیت انتخاب‌شده معتبر نیست.',
            'image.image'            => 'فایل انتخاب‌شده باید تصویر باشد.',
            'image.mimes'            => 'فرمت تصویر باید JPG، PNG یا WEBP باشد.',
            'image.max'              => 'حجم تصویر نباید بیشتر از ۴ مگابایت باشد.',
        ];
    }

    /**
     * آماده‌سازی داده‌ها قبل از اعتبارسنجی.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active'  => $this->boolean('is_active', true),
            'sort_order' => $this->input('sort_order', 0),
        ]);
    }
}

<?php

namespace App\Http\Requests;

use App\Models\Gallery;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreGalleryTranslationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'locale' => [
                'required',
                'string',
                'max:5',
                Rule::in(array_keys(Gallery::LOCALES)),
                // هر گالری فقط یک ترجمه برای هر زبان
                Rule::unique('gallery_translations', 'locale')
                    ->where('gallery_id', $this->route('gallery')->id),
            ],
            'title'       => ['required', 'string', 'max:255'],
            'slug'        => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('gallery_translations', 'slug')
                    ->where('locale', $this->input('locale')),
            ],
            'description' => ['nullable', 'string', 'max:5000'],
            'alt_text'    => ['nullable', 'string', 'max:255'],
        ];
    }

    public function attributes(): array
    {
        return [
            'locale'      => 'زبان',
            'title'       => 'عنوان',
            'slug'        => 'نامک',
            'description' => 'توضیحات',
            'alt_text'    => 'متن جایگزین',
        ];
    }
}

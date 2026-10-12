<?php

namespace App\Http\Requests;

use App\Models\Gallery;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateGalleryTranslationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $translation = $this->route('galleryTranslation');
        $gallery     = $this->route('gallery');

        return [
            'locale' => [
                'required',
                'string',
                'max:5',
                Rule::in(array_keys(Gallery::LOCALES)),
                Rule::unique('gallery_translations', 'locale')
                    ->where('gallery_id', $gallery->id)
                    ->ignore($translation->id),
            ],
            'title'       => ['required', 'string', 'max:255'],
            'slug'        => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('gallery_translations', 'slug')
                    ->where('locale', $this->input('locale'))
                    ->ignore($translation->id),
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

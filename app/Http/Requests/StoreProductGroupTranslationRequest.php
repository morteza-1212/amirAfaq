<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductGroupTranslationRequest extends FormRequest
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
                'in:fa,en,ar',
                Rule::unique('product_group_translations')
                    ->where(function ($query) {
                        return $query->where(
                            'product_group_id',
                            $this->route('productGroup')->id
                        );
                    }),
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('product_group_translations')
                    ->where(function ($query) {
                        return $query->where(
                            'locale',
                            $this->input('locale')
                        );
                    }),
            ],

            'short_description' => [
                'nullable',
                'string',
                'max:500',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'meta_title' => [
                'nullable',
                'string',
                'max:255',
            ],

            'meta_description' => [
                'nullable',
                'string',
            ],

            'meta_keywords' => [
                'nullable',
                'string',
                'max:255',
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'locale' => 'زبان',
            'name' => 'نام',
            'slug' => 'اسلاگ',
            'short_description' => 'توضیح کوتاه',
            'description' => 'توضیحات',
            'meta_title' => 'عنوان سئو',
            'meta_description' => 'توضیحات سئو',
            'meta_keywords' => 'کلمات کلیدی',
        ];
    }
}

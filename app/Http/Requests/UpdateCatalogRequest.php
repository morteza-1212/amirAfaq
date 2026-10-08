<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCatalogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // شناسه کاتالوگ در حال ویرایش
        $catalogId = $this->route('catalog')?->id;

        return [
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[a-z0-9\-]+$/',
                Rule::unique('catalogs', 'slug')->ignore($catalogId),
            ],
            'is_active'  => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'slug.unique' => 'این اسلاگ قبلاً استفاده شده است. لطفاً اسلاگ دیگری وارد کنید.',
            'slug.regex'  => 'اسلاگ فقط می‌تواند شامل حروف کوچک انگلیسی، اعداد و خط تیره باشد.',
            'slug.max'    => 'اسلاگ نباید بیشتر از ۲۵۵ کاراکتر باشد.',
            'sort_order.integer' => 'ترتیب نمایش باید یک عدد باشد.',
            'sort_order.min'     => 'ترتیب نمایش نمی‌تواند منفی باشد.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active'  => $this->boolean('is_active'),
            'sort_order' => $this->input('sort_order', 0),
        ]);
    }
}

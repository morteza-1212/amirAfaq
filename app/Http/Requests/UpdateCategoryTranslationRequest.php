<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryTranslationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // پشتیبانی از نام‌های مختلف پارامتر route
        $categoryTranslation = $this->route('categoryTranslation')
            ?? $this->route('category_translation')
            ?? $this->route('translation');

        $translationId = $categoryTranslation?->id;

        return [

            'category_id' => [
                'bail',
                'required',
                'integer',
                'exists:categories,id',
            ],

            'locale' => [
                'bail',
                'required',
                'string',
                'max:5',
                'regex:/^[a-z]{2}(-[A-Z]{2})?$/',
                Rule::in(['fa', 'en', 'ar']),
                Rule::unique('category_translations', 'locale')
                    ->where(fn ($q) => $q->where('category_id', $this->input('category_id')))
                    ->ignore($translationId),
            ],

            'name' => [
                'bail',
                'required',
                'string',
                'min:2',
                'max:255',
            ],

            'slug' => [
                'bail',
                'required',
                'string',
                'min:2',
                'max:255',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('category_translations', 'slug')
                    ->where(fn ($q) => $q->where('locale', $this->input('locale')))
                    ->ignore($translationId),
            ],

            'short_description' => ['nullable', 'string', 'max:500'],
            'description'       => ['nullable', 'string'],

            'meta_title'       => ['nullable', 'string', 'max:60'],
            'meta_description' => ['nullable', 'string', 'max:160'],
            'meta_keywords'    => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'انتخاب دسته‌بندی الزامی است.',
            'category_id.integer'  => 'شناسه دسته‌بندی باید عددی باشد.',
            'category_id.exists'   => 'دسته‌بندی انتخاب‌شده وجود ندارد.',

            'locale.required' => 'انتخاب زبان الزامی است.',
            'locale.string'   => 'کد زبان باید به صورت متنی باشد.',
            'locale.max'      => 'کد زبان حداکثر می‌تواند ۵ کاراکتر باشد.',
            'locale.regex'    => 'فرمت کد زبان معتبر نیست (مثال: fa, en, ar).',
            'locale.in'       => 'زبان انتخاب‌شده معتبر نیست.',
            'locale.unique'   => 'این زبان قبلاً برای این دسته‌بندی ثبت شده است.',

            'name.required' => 'نام دسته‌بندی الزامی است.',
            'name.string'   => 'نام دسته‌بندی باید به صورت متنی باشد.',
            'name.min'      => 'نام دسته‌بندی باید حداقل ۲ کاراکتر باشد.',
            'name.max'      => 'نام دسته‌بندی نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.',

            'slug.required' => 'Slug الزامی است.',
            'slug.string'   => 'Slug باید به صورت متنی باشد.',
            'slug.min'      => 'Slug باید حداقل ۲ کاراکتر باشد.',
            'slug.max'      => 'Slug نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.',
            'slug.regex'    => 'Slug فقط باید شامل حروف انگلیسی کوچک، اعداد و خط تیره باشد.',
            'slug.unique'   => 'این Slug قبلاً برای این زبان استفاده شده است.',

            'short_description.string' => 'توضیح کوتاه باید به صورت متنی باشد.',
            'short_description.max'    => 'توضیح کوتاه نمی‌تواند بیشتر از ۵۰۰ کاراکتر باشد.',

            'description.string' => 'توضیحات باید به صورت متنی باشد.',

            'meta_title.string' => 'عنوان سئو باید به صورت متنی باشد.',
            'meta_title.max'    => 'عنوان سئو نمی‌تواند بیشتر از ۶۰ کاراکتر باشد.',

            'meta_description.string' => 'توضیحات سئو باید به صورت متنی باشد.',
            'meta_description.max'    => 'توضیحات سئو نمی‌تواند بیشتر از ۱۶۰ کاراکتر باشد.',

            'meta_keywords.string' => 'کلمات کلیدی باید به صورت متنی باشند.',
            'meta_keywords.max'    => 'کلمات کلیدی نمی‌توانند بیشتر از ۵۰۰ کاراکتر باشند.',
        ];
    }

    public function attributes(): array
    {
        return [
            'category_id'      => 'دسته‌بندی',
            'locale'           => 'زبان',
            'name'             => 'نام دسته‌بندی',
            'slug'             => 'اسلاگ',
            'short_description'=> 'توضیح کوتاه',
            'description'      => 'توضیحات',
            'meta_title'       => 'عنوان سئو',
            'meta_description' => 'توضیحات سئو',
            'meta_keywords'    => 'کلمات کلیدی سئو',
        ];
    }
}

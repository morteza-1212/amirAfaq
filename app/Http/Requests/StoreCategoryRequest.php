<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'product_group_id' => [
                'required',
                'exists:product_groups,id'
            ],

            'parent_id' => [
                'nullable',
                'exists:categories,id'
            ],

            // ✅ code حذف شد (خودکار تولید می‌شود)
            // 'code' => ['required', 'string', 'max:50', 'unique:categories,code'],

            'name' => [
                'required',
                'string',
                'max:255'
            ],

            'slug' => [
                'nullable',
                'string',
                'max:255',
                'unique:category_translations,slug'
            ],

            'short_description' => [
                'nullable',
                'string'
            ],

            'description' => [
                'nullable',
                'string'
            ],

            'image' => [
                'nullable',
                'image',
                'max:2048'
            ],

            'icon' => [
                'nullable',
                'string',
                'max:255'
            ],

            'sort_order' => [
                'nullable',
                'integer'
            ],

            'status' => [
                'nullable',
                'boolean'
            ],

            'is_featured' => [
                'nullable',
                'boolean'
            ],
        ];
    }
}

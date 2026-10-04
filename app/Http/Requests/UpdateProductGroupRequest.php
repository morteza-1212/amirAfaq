<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductGroupRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $productGroup = $this->route('productGroup');

        return [
            'code'        => [
                'required', 'string', 'max:255',
                Rule::unique('product_groups', 'code')->ignore($productGroup->id),
            ],
            'type'        => 'required|in:agricultural,industrial,raw_material',
            'icon'        => 'nullable|string|max:255',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'sort_order'  => 'nullable|integer|min:0',
            'status'      => 'required|boolean',
            'is_featured' => 'nullable|boolean',
        ];
    }

    public function attributes(): array
    {
        return [
            'code'        => 'کد گروه',
            'type'        => 'نوع',
            'icon'        => 'آیکون',
            'image'       => 'تصویر',
            'sort_order'  => 'ترتیب',
            'status'      => 'وضعیت',
            'is_featured' => 'ویژه',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'status'      => $this->boolean('status'),
            'is_featured' => $this->boolean('is_featured'),
            'sort_order'  => $this->input('sort_order', 0),
        ]);
    }
}

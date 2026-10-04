<?php

namespace App\Http\Requests;

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

        $category = $this->route('category');


        return [

            'product_group_id'=>[
                'required',
                'exists:product_groups,id'
            ],


            'parent_id'=>[
                'nullable',
                'exists:categories,id'
            ],


            'code'=>[
                'required',
                'string',
                'max:50',
                Rule::unique('categories','code')
                    ->ignore($category->id)
            ],


            'image'=>[
                'nullable',
                'image',
                'max:2048'
            ],


            'icon'=>[
                'nullable',
                'string',
                'max:255'
            ],


            'sort_order'=>[
                'nullable',
                'integer'
            ],


            'status'=>[
                'nullable',
                'boolean'
            ],


            'is_featured'=>[
                'nullable',
                'boolean'
            ],

        ];
    }
}

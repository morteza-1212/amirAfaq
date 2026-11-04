<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Middleware ادمین کار را انجام داده
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_name'          => ['required', 'string', 'max:150'],
            'customer_phone'         => ['required', 'string', 'max:20'],
            'customer_email'         => ['nullable', 'email', 'max:150'],
            'shipping_address'       => ['required', 'string'],
            'postal_code'            => ['nullable', 'string', 'max:10'],
            'city'                   => ['required', 'string', 'max:100'],
            'province'               => ['required', 'string', 'max:100'],
            'shipping_method'        => ['nullable', 'string', 'max:50'],
            'shipping_tracking_code' => ['nullable', 'string', 'max:50'],
            'admin_note'             => ['nullable', 'string', 'max:2000'],
        ];
    }
}

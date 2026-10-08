<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBuyerRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'product'              => 'required|string|max:255',
            'quantity'             => 'required|string|max:255',
            'destination_country'  => 'required|string|max:255',
            'destination_port'     => 'nullable|string|max:255',
            'packaging'            => 'nullable|string|max:255',
            'delivery_time'        => 'nullable|string|max:255',
            'incoterms'            => 'nullable|string|max:10',
            'payment_terms'        => 'nullable|string|max:50',
            'company_information'  => 'required|string|max:5000',
            'name'                 => 'nullable|string|max:255',
            'email'                => 'nullable|email|max:255',
            'phone'                => 'nullable|string|max:50',
            'message'              => 'nullable|string|max:5000',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'product.required'             => __('buyers.validation.product_required'),
            'product.string'               => __('buyers.validation.product_string'),
            'product.max'                  => __('buyers.validation.product_max'),

            'quantity.required'            => __('buyers.validation.quantity_required'),
            'quantity.string'              => __('buyers.validation.quantity_string'),
            'quantity.max'                 => __('buyers.validation.quantity_max'),

            'destination_country.required' => __('buyers.validation.destination_country_required'),
            'destination_country.string'   => __('buyers.validation.destination_country_string'),
            'destination_country.max'      => __('buyers.validation.destination_country_max'),

            'destination_port.string'      => __('buyers.validation.destination_port_string'),
            'destination_port.max'         => __('buyers.validation.destination_port_max'),

            'packaging.string'             => __('buyers.validation.packaging_string'),
            'packaging.max'                => __('buyers.validation.packaging_max'),

            'delivery_time.string'         => __('buyers.validation.delivery_time_string'),
            'delivery_time.max'            => __('buyers.validation.delivery_time_max'),

            'incoterms.string'             => __('buyers.validation.incoterms_string'),
            'incoterms.max'                => __('buyers.validation.incoterms_max'),

            'payment_terms.string'         => __('buyers.validation.payment_terms_string'),
            'payment_terms.max'            => __('buyers.validation.payment_terms_max'),

            'company_information.required' => __('buyers.validation.company_information_required'),
            'company_information.string'   => __('buyers.validation.company_information_string'),
            'company_information.max'      => __('buyers.validation.company_information_max'),

            'name.string'                  => __('buyers.validation.name_string'),
            'name.max'                     => __('buyers.validation.name_max'),

            'email.email'                  => __('buyers.validation.email_invalid'),
            'email.max'                    => __('buyers.validation.email_max'),

            'phone.string'                 => __('buyers.validation.phone_string'),
            'phone.max'                    => __('buyers.validation.phone_max'),

            'message.string'               => __('buyers.validation.message_string'),
            'message.max'                  => __('buyers.validation.message_max'),
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'product'              => __('buyers.product'),
            'quantity'             => __('buyers.quantity'),
            'destination_country'  => __('buyers.destination_country'),
            'destination_port'     => __('buyers.destination_port'),
            'packaging'            => __('buyers.packaging'),
            'delivery_time'        => __('buyers.delivery_time'),
            'incoterms'            => __('buyers.incoterms'),
            'payment_terms'        => __('buyers.payment_terms'),
            'company_information'  => __('buyers.company_information'),
            'name'                 => __('buyers.contact_name'),
            'email'                => __('buyers.email'),
            'phone'                => __('buyers.phone'),
            'message'              => __('buyers.message'),
        ];
    }
}

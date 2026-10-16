<?php

namespace App\Http\Requests;

use App\Models\TradeTransaction;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Verta;

class UpdateTradeTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'transaction_type' => ['required', Rule::in(array_keys(TradeTransaction::TRANSACTION_TYPES))],
            'quantity'         => ['nullable', 'numeric', 'min:0'],
            'unit'             => ['required', Rule::in(array_keys(TradeTransaction::UNITS))],
            'transport_method' => ['nullable', Rule::in(array_keys(TradeTransaction::TRANSPORT_METHODS))],
            'delivery_time'    => ['nullable', 'string', 'max:255'],

            'contract_date'    => ['nullable', 'date'],
            'delivery_date'    => ['nullable', 'date', 'after_or_equal:contract_date'],

            'sort_order'       => ['nullable', 'integer', 'min:0'],
            'is_published'     => ['nullable', 'boolean'],

            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ];

        foreach (array_keys(TradeTransaction::LOCALES) as $locale) {
            $required = $locale === TradeTransaction::DEFAULT_LOCALE ? 'required' : 'nullable';

            $rules["translations.{$locale}.title"]               = [$required, 'string', 'max:255'];
            $rules["translations.{$locale}.product"]             = [$required, 'string', 'max:255'];
            $rules["translations.{$locale}.origin_country"]      = ['nullable', 'string', 'max:100'];
            $rules["translations.{$locale}.destination_country"] = [$required, 'string', 'max:100'];
            $rules["translations.{$locale}.packaging"]           = ['nullable', 'string', 'max:255'];
            $rules["translations.{$locale}.alt_text"]            = ['nullable', 'string', 'max:255'];
            $rules["translations.{$locale}.description"]         = ['nullable', 'string', 'max:5000'];
        }

        return $rules;
    }

    public function attributes(): array
    {
        return (new StoreTradeTransactionRequest())->attributes();
    }

    protected function prepareForValidation(): void
    {
        $data = [
            'is_published' => $this->boolean('is_published', false),
            'sort_order'   => $this->input('sort_order', 0),
        ];

        if ($this->filled('contract_date')) {
            $data['contract_date'] = $this->convertJalaliToGregorian($this->input('contract_date'));
        }

        if ($this->filled('delivery_date')) {
            $data['delivery_date'] = $this->convertJalaliToGregorian($this->input('delivery_date'));
        }

        $this->merge($data);
    }

    protected function convertJalaliToGregorian(?string $jalaliDate): ?string
    {
        if (empty($jalaliDate)) {
            return null;
        }

        $jalaliDate = str_replace(
            ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹',
                '٠','١','٢','٣','٤','٥','٦','٧','٨','٩'],
            ['0','1','2','3','4','5','6','7','8','9',
                '0','1','2','3','4','5','6','7','8','9'],
            $jalaliDate
        );

        $jalaliDate = str_replace('-', '/', $jalaliDate);
        $jalaliDate = preg_replace('/\s+/', '', $jalaliDate);

        try {
            return Verta::parse($jalaliDate)->formatGregorian('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }
}

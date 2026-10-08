<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BuyerController extends Controller
{
    /**
     * نمایش صفحه درخواست خریداران
     */
    public function index(): View
    {
        return view('buyers.index');
    }

    /**
     * ذخیره درخواست جدید
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
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
        ], [
            'product.required'             => __('buyers.validation.product_required'),
            'quantity.required'            => __('buyers.validation.quantity_required'),
            'destination_country.required' => __('buyers.validation.destination_country_required'),
            'company_information.required' => __('buyers.validation.company_information_required'),
            'email.email'                  => __('buyers.validation.email_invalid'),
        ]);

        Buyer::create($validated);

        return redirect()
            ->route('buyers.index')
            ->with('success', __('buyers.success_message'));
    }
}

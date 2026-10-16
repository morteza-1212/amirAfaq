@extends('layouts.home')

@section('title', __('buyers.title'))

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/buyer/buyer.css') }}?v=2" media="print" onload="this.media='all'">
@endsection

@section('content')
    @php
        // زبان جاری
        $currentLocale = app()->getLocale();

        // زبان‌های پشتیبانی‌شده
        $supportedLocales = [
            'fa' => 'فارسی',
            'ar' => 'العربية',
            'en' => 'English',
        ];

        // آیکون‌های نوع فعالیت
        $activityIcons = [
            'commerce'       => 'fa-shopping-cart',
            'logistics'      => 'fa-truck',
            'exhibition'     => 'fa-store',
            'exports'        => 'fa-ship',
            'imports'        => 'fa-plane-arrival',
            'global_markets' => 'fa-globe',
        ];
    @endphp

    <div class="buyers-page">

        {{-- Hero Section --}}
        <section class="buyers-hero">
            <div class="container">
                <div class="buyers-hero-content">
                    <span class="section-label">
                        {{ __('buyers.label') }}
                    </span>

                    <h1>
                        {{ __('buyers.hero_title') }}
                    </h1>

                    <p>
                        {{ __('buyers.hero_description') }}
                    </p>
                </div>
            </div>
        </section>


        {{-- Buyer Request Section --}}
        <section class="buyer-request-section">
            <div class="container">

                <div class="section-heading">
                    <span class="section-label">
                        {{ __('buyers.request_label') }}
                    </span>

                    <h2>
                        {{ __('buyers.request_title') }}
                    </h2>

                    <p>
                        {{ __('buyers.request_description') }}
                    </p>
                </div>


                <div class="buyer-request-wrapper">

                    {{-- Success Message --}}
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- General Validation Errors --}}
                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <strong>{{ __('buyers.validation.errors_title') }}</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                    <form action="{{ route('buyer.store', ['locale' => app()->getLocale()]) }}"
                          method="POST"
                          class="buyer-request-form"
                          novalidate>

                        @csrf

                        {{-- Product --}}
                        <div class="form-group {{ $errors->has('product') ? 'has-error' : '' }}">
                            <label for="product">
                                {{ __('buyers.product') }}
                                <span>*</span>
                            </label>

                            <input
                                type="text"
                                id="product"
                                name="product"
                                value="{{ old('product') }}"
                                placeholder="{{ __('buyers.product_placeholder') }}"
                            >

                            @error('product')
                            <small class="form-error">{{ $message }}</small>
                            @enderror
                        </div>


                        {{-- Quantity --}}
                        <div class="form-group {{ $errors->has('quantity') ? 'has-error' : '' }}">
                            <label for="quantity">
                                {{ __('buyers.quantity') }}
                                <span>*</span>
                            </label>

                            <input
                                type="text"
                                id="quantity"
                                name="quantity"
                                value="{{ old('quantity') }}"
                                placeholder="{{ __('buyers.quantity_placeholder') }}"
                            >

                            @error('quantity')
                            <small class="form-error">{{ $message }}</small>
                            @enderror
                        </div>


                        {{-- Destination Country --}}
                        <div class="form-group {{ $errors->has('destination_country') ? 'has-error' : '' }}">
                            <label for="destination_country">
                                {{ __('buyers.destination_country') }}
                                <span>*</span>
                            </label>

                            <input
                                type="text"
                                id="destination_country"
                                name="destination_country"
                                value="{{ old('destination_country') }}"
                                placeholder="{{ __('buyers.destination_country_placeholder') }}"
                            >

                            @error('destination_country')
                            <small class="form-error">{{ $message }}</small>
                            @enderror
                        </div>


                        {{-- Destination Port --}}
                        <div class="form-group {{ $errors->has('destination_port') ? 'has-error' : '' }}">
                            <label for="destination_port">
                                {{ __('buyers.destination_port') }}
                            </label>

                            <input
                                type="text"
                                id="destination_port"
                                name="destination_port"
                                value="{{ old('destination_port') }}"
                                placeholder="{{ __('buyers.destination_port_placeholder') }}"
                            >

                            @error('destination_port')
                            <small class="form-error">{{ $message }}</small>
                            @enderror
                        </div>


                        {{-- Packaging --}}
                        <div class="form-group {{ $errors->has('packaging') ? 'has-error' : '' }}">
                            <label for="packaging">
                                {{ __('buyers.packaging') }}
                            </label>

                            <select id="packaging" name="packaging">

                                <option value="">
                                    {{ __('buyers.select_option') }}
                                </option>

                                <option value="bulk" {{ old('packaging') == 'bulk' ? 'selected' : '' }}>
                                    {{ __('buyers.packaging_bulk') }}
                                </option>

                                <option value="bag" {{ old('packaging') == 'bag' ? 'selected' : '' }}>
                                    {{ __('buyers.packaging_bag') }}
                                </option>

                                <option value="box" {{ old('packaging') == 'box' ? 'selected' : '' }}>
                                    {{ __('buyers.packaging_box') }}
                                </option>

                                <option value="custom" {{ old('packaging') == 'custom' ? 'selected' : '' }}>
                                    {{ __('buyers.packaging_custom') }}
                                </option>

                            </select>

                            @error('packaging')
                            <small class="form-error">{{ $message }}</small>
                            @enderror
                        </div>


                        {{-- Delivery Time --}}
                        <div class="form-group {{ $errors->has('delivery_time') ? 'has-error' : '' }}">
                            <label for="delivery_time">
                                {{ __('buyers.delivery_time') }}
                            </label>

                            <input
                                type="text"
                                id="delivery_time"
                                name="delivery_time"
                                value="{{ old('delivery_time') }}"
                                placeholder="{{ __('buyers.delivery_time_placeholder') }}"
                            >

                            @error('delivery_time')
                            <small class="form-error">{{ $message }}</small>
                            @enderror
                        </div>


                        {{-- Incoterms --}}
                        <div class="form-group incoterms-group {{ $errors->has('incoterms') ? 'has-error' : '' }}">

                            <label for="incoterms">
                                {{ __('buyers.incoterms') }}
                            </label>

                            <select id="incoterms" name="incoterms">

                                <option value="">
                                    {{ __('buyers.select_option') }}
                                </option>

                                <option value="EXW" {{ old('incoterms') == 'EXW' ? 'selected' : '' }}>
                                    {{ __('buyers.incoterm_exw') }}
                                </option>

                                <option value="FCA" {{ old('incoterms') == 'FCA' ? 'selected' : '' }}>
                                    {{ __('buyers.incoterm_fca') }}
                                </option>

                                <option value="FOB" {{ old('incoterms') == 'FOB' ? 'selected' : '' }}>
                                    {{ __('buyers.incoterm_fob') }}
                                </option>

                                <option value="CFR" {{ old('incoterms') == 'CFR' ? 'selected' : '' }}>
                                    {{ __('buyers.incoterm_cfr') }}
                                </option>

                                <option value="CIF" {{ old('incoterms') == 'CIF' ? 'selected' : '' }}>
                                    {{ __('buyers.incoterm_cif') }}
                                </option>

                                <option value="DAP" {{ old('incoterms') == 'DAP' ? 'selected' : '' }}>
                                    {{ __('buyers.incoterm_dap') }}
                                </option>

                                <option value="DDP" {{ old('incoterms') == 'DDP' ? 'selected' : '' }}>
                                    {{ __('buyers.incoterm_ddp') }}
                                </option>

                            </select>

                            {{-- Incoterms Information --}}
                            <div class="incoterms-info" id="incoterms-info">

                                <div class="incoterms-info-icon">
                                    <span>i</span>
                                </div>

                                <div class="incoterms-info-content">

                                    <strong id="incoterms-title">
                                        {{ __('buyers.incoterms_help_title') }}
                                    </strong>

                                    <p id="incoterms-description">
                                        {{ __('buyers.incoterms_help_description') }}
                                    </p>

                                </div>

                            </div>

                            @error('incoterms')
                            <small class="form-error">{{ $message }}</small>
                            @enderror
                        </div>


                        {{-- Payment Terms --}}
                        <div class="form-group {{ $errors->has('payment_terms') ? 'has-error' : '' }}">
                            <label for="payment_terms">
                                {{ __('buyers.payment_terms') }}
                            </label>

                            <select id="payment_terms" name="payment_terms">

                                <option value="">
                                    {{ __('buyers.select_option') }}
                                </option>

                                <option value="advance" {{ old('payment_terms') == 'advance' ? 'selected' : '' }}>
                                    {{ __('buyers.payment_advance') }}
                                </option>

                                <option value="lc" {{ old('payment_terms') == 'lc' ? 'selected' : '' }}>
                                    {{ __('buyers.payment_lc') }}
                                </option>

                                <option value="tt" {{ old('payment_terms') == 'tt' ? 'selected' : '' }}>
                                    {{ __('buyers.payment_tt') }}
                                </option>

                                <option value="other" {{ old('payment_terms') == 'other' ? 'selected' : '' }}>
                                    {{ __('buyers.payment_other') }}
                                </option>

                            </select>

                            @error('payment_terms')
                            <small class="form-error">{{ $message }}</small>
                            @enderror
                        </div>


                        {{-- Company Information --}}
                        <div class="form-group form-group-full {{ $errors->has('company_information') ? 'has-error' : '' }}">

                            <label for="company_information">
                                {{ __('buyers.company_information') }}
                                <span>*</span>
                            </label>

                            <textarea
                                id="company_information"
                                name="company_information"
                                rows="5"
                                placeholder="{{ __('buyers.company_information_placeholder') }}">{{ old('company_information') }}</textarea>

                            @error('company_information')
                            <small class="form-error">{{ $message }}</small>
                            @enderror
                        </div>


                        {{-- Contact Information --}}
                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label for="name">
                                {{ __('buyers.contact_name') }}
                            </label>

                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                placeholder="{{ __('buyers.contact_name_placeholder') }}"
                            >

                            @error('name')
                            <small class="form-error">{{ $message }}</small>
                            @enderror
                        </div>


                        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                            <label for="email">
                                {{ __('buyers.email') }}
                            </label>

                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="{{ __('buyers.email_placeholder') }}"
                            >

                            @error('email')
                            <small class="form-error">{{ $message }}</small>
                            @enderror
                        </div>


                        <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                            <label for="phone">
                                {{ __('buyers.phone') }}
                            </label>

                            <input
                                type="text"
                                id="phone"
                                name="phone"
                                value="{{ old('phone') }}"
                                placeholder="{{ __('buyers.phone_placeholder') }}"
                            >

                            @error('phone')
                            <small class="form-error">{{ $message }}</small>
                            @enderror
                        </div>


                        {{-- Message --}}
                        <div class="form-group form-group-full {{ $errors->has('message') ? 'has-error' : '' }}">

                            <label for="message">
                                {{ __('buyers.message') }}
                            </label>

                            <textarea
                                id="message"
                                name="message"
                                rows="5"
                                placeholder="{{ __('buyers.message_placeholder') }}">{{ old('message') }}</textarea>

                            @error('message')
                            <small class="form-error">{{ $message }}</small>
                            @enderror
                        </div>


                        {{-- Submit --}}
                        <div class="form-submit form-group-full">

                            <button type="submit" class="btn btn-primary" id="buyer-submit-btn">

                                {{ __('buyers.submit') }}

                                <span class="btn-arrow">
                                    →
                                </span>

                            </button>

                        </div>

                    </form>

                </div>

            </div>
        </section>


        {{-- Partnership CTA --}}
        <section class="buyers-cta">

            <div class="container">

                <div class="buyers-cta-content">

                    <span class="section-label">
                        {{ __('buyers.cta_label') }}
                    </span>

                    <h2>
                        {{ __('buyers.cta_title') }}
                    </h2>

                    <p>
                        {{ __('buyers.cta_description') }}
                    </p>
                    <a href="{{ route('contact', ['locale' => $currentLocale]) }}"
                       class="gallery-btn">
                        {{ __('gallery.contact_us') }}
                        <i class="fas fa-arrow-left"></i>
                    </a>

                </div>

            </div>

        </section>

    </div>

@endsection

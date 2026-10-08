@extends('layouts.home')

@section('title', __('contact.title'))

@section('styles')
    <link rel="stylesheet"
          href="{{ asset('css/contact/contact.css') }}?v=1"
          media="print"
          onload="this.media='all'">
@endsection

@section('content')

    <div class="contact-page">

        {{-- Hero Section --}}
        <section class="contact-hero">
            <div class="container">
                <div class="contact-hero-content">
                    <span class="section-label">{{ __('contact.label') }}</span>
                    <h1>{{ __('contact.hero_title') }}</h1>
                    <p>{{ __('contact.hero_description') }}</p>
                </div>
            </div>
        </section>


        {{-- Contact Information --}}
        <section class="contact-information-section">
            <div class="container">

                <div class="section-heading">
                    <span class="section-label">{{ __('contact.info_label') }}</span>
                    <h2>{{ __('contact.info_title') }}</h2>
                    <p>{{ __('contact.info_description') }}</p>
                </div>

                <div class="contact-information-grid">

                    {{-- Head Office --}}
                    <div class="contact-info-card">
                        <div class="contact-info-icon">
                            <i class="bi bi-building"></i>
                        </div>
                        <div class="contact-info-content">
                            <span class="contact-info-label">{{ __('contact.office') }}</span>
                            <h3>{{ __('contact.office_title') }}</h3>
                            <p>{{ __('contact.office_description') }}</p>
                        </div>
                    </div>

                    {{-- Phone --}}
                    <div class="contact-info-card">
                        <div class="contact-info-icon">
                            <i class="bi bi-telephone"></i>
                        </div>
                        <div class="contact-info-content">
                            <span class="contact-info-label">{{ __('contact.phone_label') }}</span>
                            <h3>{{ $contact?->phone ?? __('contact.not_available') }}</h3>
                            @if(!empty($contact?->phone))
                                <a href="tel:{{ $contact->phone }}">{{ __('contact.call_us') }}</a>
                            @endif
                        </div>
                    </div>

                    {{-- Instagram --}}
                    <div class="contact-info-card">
                        <div class="contact-info-icon">
                            <i class="bi bi-instagram"></i>
                        </div>
                        <div class="contact-info-content">
                            <span class="contact-info-label">اینستاگرام</span>
                            <h3>{{ $contact?->whatsapp ?? __('contact.not_available') }}</h3>
                            @if(!empty($contact?->whatsapp))
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contact->whatsapp) }}"
                                   target="_blank" rel="noopener">
                                    {{ __('contact.whatsapp_us') }}
                                </a>
                            @endif
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="contact-info-card">
                        <div class="contact-info-icon">
                            <i class="bi bi-envelope"></i>
                        </div>
                        <div class="contact-info-content">
                            <span class="contact-info-label">{{ __('contact.email_label') }}</span>
                            <h3>{{ $contact?->email ?? __('contact.not_available') }}</h3>
                            @if(!empty($contact?->email))
                                <a href="mailto:{{ $contact->email }}">{{ __('contact.email_us') }}</a>
                            @endif
                        </div>
                    </div>

                    {{-- Address --}}
                    <div class="contact-info-card contact-info-card-wide">
                        <div class="contact-info-icon">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                        <div class="contact-info-content">
                            <span class="contact-info-label">{{ __('contact.address_label') }}</span>
                            <h3>{{ __('contact.address_title') }}</h3>
                            <p>{{ $contact?->address ?? __('contact.not_available') }}</p>
                        </div>
                    </div>

                    {{-- Working Hours --}}
                    <div class="contact-info-card contact-info-card-wide">
                        <div class="contact-info-icon">
                            <i class="bi bi-clock"></i>
                        </div>
                        <div class="contact-info-content">
                            <span class="contact-info-label">{{ __('contact.working_hours_label') }}</span>
                            <h3>{{ __('contact.working_hours_title') }}</h3>
                            <p>{{ $contact?->working_hours ?? __('contact.not_available') }}</p>
                        </div>
                    </div>

                </div>
            </div>
        </section>


        {{-- Address & Map --}}
        <section class="contact-location-section">
            <div class="container">
                <div class="contact-location-grid">

                    {{-- ستون متن --}}
                    <div class="contact-location-content">

                        <span class="section-label">{{ __('contact.location_label') }}</span>
                        <h2>{{ __('contact.location_title') }}</h2>
                        <p>{{ __('contact.location_description') }}</p>

                        @if(!empty($contact?->address))
                            <div class="contact-address">
                                <div class="contact-address-icon">
                                    <i class="bi bi-geo-alt"></i>
                                </div>
                                <div>
                                    <strong>{{ __('contact.address_label') }}</strong>
                                    <p>{{ $contact->address }}</p>
                                </div>
                            </div>
                        @endif

                        @if(!empty($contact?->working_hours))
                            <div class="contact-working-hours">
                                <div class="contact-address-icon">
                                    <i class="bi bi-clock"></i>
                                </div>
                                <div>
                                    <strong>{{ __('contact.working_hours_label') }}</strong>
                                    <p>{{ $contact->working_hours }}</p>
                                </div>
                            </div>
                        @endif

                    </div>

                    {{-- ستون نقشه --}}
                    <div class="contact-map">

                        @if(!empty($contact?->google_map))

                            {!! $contact->google_map !!}

                        @else

                            <img
                                src="https://api.neshan.org/v5/static?key={{ config('services.neshan.key') }}&style=light&width=600&height=450&zoom=15&latitude=35.231&longitude=58.464&marker=red"
                                alt="{{ __('contact.location_title') }}"
                                width="600"
                                height="450"
                                loading="lazy"
                                style="width: 100%; height: auto; border-radius: 8px;"
                            >

                        @endif

                    </div>

                </div>
            </div>
        </section>


        {{-- Contact Form --}}
        <section class="contact-form-section">
            <div class="container">

                <div class="section-heading">
                    <span class="section-label">{{ __('contact.form_label') }}</span>
                    <h2>{{ __('contact.form_title') }}</h2>
                    <p>{{ __('contact.form_description') }}</p>
                </div>

                <div class="contact-form-wrapper">

                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <strong>{{ __('contact.validation.errors_title') }}</strong>
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="" method="POST" class="contact-form" novalidate>
                        @csrf

                        {{-- Name --}}
                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label for="name">{{ __('contact.name') }} <span>*</span></label>
                            <input type="text" id="name" name="name"
                                   value="{{ old('name') }}"
                                   placeholder="{{ __('contact.name_placeholder') }}">
                            @error('name')
                            <small class="form-error">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                            <label for="email">{{ __('contact.email') }} <span>*</span></label>
                            <input type="email" id="email" name="email"
                                   value="{{ old('email') }}"
                                   placeholder="{{ __('contact.email_placeholder') }}">
                            @error('email')
                            <small class="form-error">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Phone --}}
                        <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                            <label for="phone">{{ __('contact.phone') }}</label>
                            <input type="text" id="phone" name="phone"
                                   value="{{ old('phone') }}"
                                   placeholder="{{ __('contact.phone_placeholder') }}">
                            @error('phone')
                            <small class="form-error">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Subject --}}
                        <div class="form-group {{ $errors->has('subject') ? 'has-error' : '' }}">
                            <label for="subject">{{ __('contact.subject') }} <span>*</span></label>
                            <input type="text" id="subject" name="subject"
                                   value="{{ old('subject') }}"
                                   placeholder="{{ __('contact.subject_placeholder') }}">
                            @error('subject')
                            <small class="form-error">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Message --}}
                        <div class="form-group form-group-full {{ $errors->has('message') ? 'has-error' : '' }}">
                            <label for="message">{{ __('contact.message') }} <span>*</span></label>
                            <textarea id="message" name="message" rows="6"
                                      placeholder="{{ __('contact.message_placeholder') }}">{{ old('message') }}</textarea>
                            @error('message')
                            <small class="form-error">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Submit --}}
                        <div class="form-submit form-group-full">
                            <button type="submit" class="btn btn-primary" id="contact-submit-btn">
                                {{ __('contact.submit') }}
                                <span class="btn-arrow">→</span>
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </section>


        {{-- CTA --}}
        <section class="contact-cta">
            <div class="container">
                <div class="contact-cta-content">
                    <span class="section-label">{{ __('contact.cta_label') }}</span>
                    <h2>{{ __('contact.cta_title') }}</h2>
                    <p>{{ __('contact.cta_description') }}</p>
                    @if(!empty($contact?->phone))
                        <a href="tel:{{ $contact->phone }}" class="btn btn-outline">
                            {{ __('contact.call_us') }}
                        </a>
                    @endif
                </div>
            </div>
        </section>

    </div>

@endsection

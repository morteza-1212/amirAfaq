
@extends('layouts.home')

@section('title', __('import.page_title'))

@section('styles')

    <link rel="stylesheet" href="{{asset('css/import/import.css')}}">

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

    <div class="import-page">

        {{-- =====================================================
             HERO
        ====================================================== --}}

        <section class="import-hero">

            <div class="import-hero-container">

                <div class="import-hero-content">

                    <div class="import-eyebrow">
                        {{ __('import.hero_label') }}
                    </div>

                    <h1>
                        {{ __('import.hero_title') }}
                        <span>{{ __('import.hero_title_en') }}</span>
                    </h1>

                    <p>
                        {{ __('import.hero_description') }}
                    </p>

                </div>

            </div>

        </section>


        {{-- =====================================================
             INTRO
        ====================================================== --}}

        <section class="import-intro">

        <span class="import-section-label">
            {{ __('import.intro_label') }}
        </span>

            <h2>
                {{ __('import.intro_title') }}
            </h2>

            <p>
                {{ __('import.intro_description') }}
            </p>

        </section>


        {{-- =====================================================
             PROCESS
        ====================================================== --}}

        <section class="import-process">

            <div class="import-process-header">

            <span class="import-section-label">
                {{ __('import.process_label') }}
            </span>

                <h2>
                    {{ __('import.process_title') }}
                </h2>

                <p>
                    {{ __('import.process_description') }}
                </p>

            </div>


            <div class="import-steps">

                @foreach(range(1, 10) as $step)

                    <article class="import-step">

                        <div class="import-step-number">
                            {{ sprintf('%02d', $step) }}
                        </div>

                        <div class="import-step-content">

                            <h3>
                                {{ __("import.steps.$step.title") }}
                            </h3>

                            <p>
                                {{ __("import.steps.$step.description") }}
                            </p>

                        </div>

                    </article>

                @endforeach

            </div>

        </section>


        {{-- =====================================================
             CTA
        ====================================================== --}}

        <section class="import-cta">

            <div class="import-cta-content">

                <h2>
                    {{ __('import.cta_title') }}
                </h2>

                <p>
                    {{ __('import.cta_description') }}
                </p>
                <a href="{{ route('contact', ['locale' => $currentLocale]) }}"
                   class="gallery-btn">
                    {{ __('gallery.contact_us') }}
                    <i class="fas fa-arrow-left"></i>
                </a>

            </div>

        </section>

    </div>

@endsection

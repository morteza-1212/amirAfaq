@extends('layouts.home')

@section('title', __('projects.title'))

@section('styles')
    <link rel="stylesheet"
          href="{{ asset('css/projects/projects.css') }}?v=1"
          media="print"
          onload="this.media='all'">
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
{{--    @php--}}
{{--        // زبان‌های پشتیبانی‌شده--}}
{{--        $supportedLocales = [--}}
{{--            'fa' => 'فارسی',--}}
{{--            'ar' => 'العربية',--}}
{{--            'en' => 'English',--}}
{{--        ];--}}

{{--        // زبان جاری از session یا app--}}
{{--        $currentLocale = app()->getLocale();--}}
{{--    @endphp--}}

    <main class="projects-page" dir="{{ $currentLocale === 'en' ? 'ltr' : 'rtl' }}">

        {{-- =====================================================
             HERO
        ====================================================== --}}
        <section class="projects-hero">
            <div class="container">

                {{-- Language Switcher --}}
{{--                <div class="projects-lang-switcher">--}}
{{--                    @foreach($supportedLocales as $code => $label)--}}
{{--                        <a href="{{ route('trad', ['locale' => $code]) }}"--}}
{{--                           class="projects-lang-btn @if($currentLocale === $code) active @endif"--}}
{{--                           title="{{ $label }}">--}}
{{--                            {{ strtoupper($code) }}--}}
{{--                        </a>--}}
{{--                    @endforeach--}}
{{--                </div>--}}

                <div class="projects-hero-content">
                    <span class="projects-hero-label">
                        {{ __('projects.eyebrow') }}
                    </span>

                    <h1>{{ __('projects.title') }}</h1>

                    <p>{{ __('projects.description') }}</p>
                </div>

            </div>
        </section>

        {{-- =====================================================
             INTRO
        ====================================================== --}}
        <section class="projects-intro">
            <div class="container">
                <div class="projects-intro-grid">

                    <div class="projects-intro-content">
                        <span class="projects-section-label">
                            {{ __('projects.intro_eyebrow') }}
                        </span>
                        <h2>{{ __('projects.intro_title') }}</h2>
                        <p>{{ __('projects.intro_description') }}</p>
                    </div>

                    <div class="projects-intro-badge">
                        <div class="projects-badge-icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <strong>{{ __('projects.trust_title') }}</strong>
                        <span>{{ __('projects.trust_description') }}</span>
                    </div>

                </div>
            </div>
        </section>

        {{-- =====================================================
             PROJECTS
        ====================================================== --}}
        <section class="projects-section">
            <div class="container">

                <div class="projects-heading">
                    <span class="projects-section-label">
                        {{ __('projects.projects_eyebrow') }}
                    </span>
                    <h2>{{ __('projects.projects_title') }}</h2>
                    <p>{{ __('projects.projects_description') }}</p>
                </div>

                <div class="projects-grid">

                    @forelse($trads as $index => $project)
                        @php
                            // ترجمه زبان جاری
                            $t = $project->translation($currentLocale);
                        @endphp

                        <article class="project-card">

                            {{-- تصویر پروژه --}}
                            @if($project->image)
                                <div class="project-card-image">
                                    <img src="{{ $project->image_url }}"
                                         alt="{{ $t?->alt_text ?? $t?->title ?? '' }}"
                                         loading="lazy">
                                </div>
                            @endif

                            {{-- شماره و وضعیت --}}
                            <div class="project-card-top">
                                <div class="project-number">
                                    {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                </div>

                                <span class="project-status">
                                    @if($project->transaction_type === 'export')
                                        <i class="fas fa-arrow-up me-1"></i>
                                    @else
                                        <i class="fas fa-arrow-down me-1"></i>
                                    @endif
                                    {{ $project->transaction_type_label }}
                                </span>
                            </div>

                            {{-- آیکون --}}
                            <div class="project-card-icon">
                                <i class="fas {{ $project->transport_icon ?? 'fa-handshake' }}"></i>
                            </div>

                            {{-- عنوان --}}
                            <h3>{{ $t?->title ?? '—' }}</h3>

                            {{-- مقصد --}}
                            @if($t?->destination_country)
                                <div class="project-destination">
                                    <i class="fas fa-location-dot"></i>
                                    <span>{{ $t->destination_country }}</span>
                                </div>
                            @endif

                            {{-- جزئیات --}}
                            <div class="project-details">

                                @if($t?->product)
                                    <div class="project-detail">
                                        <span>
                                            <i class="fas fa-box"></i>
                                            {{ __('projects.product') }}
                                        </span>
                                        <strong>{{ $t->product }}</strong>
                                    </div>
                                @endif

                                @if($project->quantity)
                                    <div class="project-detail">
                                        <span>
                                            <i class="fas fa-weight-hanging"></i>
                                            {{ __('projects.quantity') }}
                                        </span>
                                        <strong>
                                            {{ number_format($project->quantity, 2) }}
                                            {{ $project->unit_label }}
                                        </strong>
                                    </div>
                                @endif

                                @if($t?->packaging)
                                    <div class="project-detail">
                                        <span>
                                            <i class="fas fa-cube"></i>
                                            {{ __('projects.packaging') }}
                                        </span>
                                        <strong>{{ $t->packaging }}</strong>
                                    </div>
                                @endif

                                @if($project->transport_method_label)
                                    <div class="project-detail">
                                        <span>
                                            <i class="fas fa-truck"></i>
                                            {{ __('projects.transport') }}
                                        </span>
                                        <strong>{{ $project->transport_method_label }}</strong>
                                    </div>
                                @endif

                                @if($project->delivery_time)
                                    <div class="project-detail">
                                        <span>
                                            <i class="fas fa-clock"></i>
                                            {{ __('projects.delivery_time') }}
                                        </span>
                                        <strong>{{ $project->delivery_time }}</strong>
                                    </div>
                                @endif

                                @if($t?->origin_country)
                                    <div class="project-detail">
                                        <span>
                                            <i class="fas fa-flag"></i>
                                            {{ __('projects.origin_country') }}
                                        </span>
                                        <strong>{{ $t->origin_country }}</strong>
                                    </div>
                                @endif
                            </div>

                            {{-- توضیحات --}}
                            @if($t?->description)
                                <div class="project-description">
                                    {{ \Illuminate\Support\Str::limit($t->description, 150) }}
                                </div>
                            @endif

                            {{-- تاریخ قرارداد (اختیاری) --}}
                            @if($project->contract_date)
                                <div class="project-date">
                                    <i class="fas fa-calendar-alt"></i>
                                    {{ $project->contract_date_jalali ?? $project->contract_date->format('Y/m/d') }}
                                </div>
                            @endif

                        </article>

                    @empty
                        <div class="projects-empty">
                            <i class="fas fa-inbox"></i>
                            <p>{{ __('projects.empty') ?? 'هیچ پروژه‌ای یافت نشد.' }}</p>
                        </div>
                    @endforelse

                </div>
            </div>
        </section>

        {{-- =====================================================
             CONFIDENTIALITY
        ====================================================== --}}
        <section class="projects-confidentiality">
            <div class="container">
                <div class="confidentiality-box">
                    <div class="confidentiality-icon">
                        <i class="fas fa-shield-halved"></i>
                    </div>
                    <div class="confidentiality-content">
                        <span class="projects-section-label">
                            {{ __('projects.confidentiality_eyebrow') }}
                        </span>
                        <h2>{{ __('projects.confidentiality_title') }}</h2>
                        <p>{{ __('projects.confidentiality_description') }}</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- =====================================================
             CTA
        ====================================================== --}}
        <section class="projects-cta">
            <div class="container">
                <div class="projects-cta-box">
                    <div>
                        <span class="projects-section-label">
                            {{ __('projects.cta_eyebrow') }}
                        </span>
                        <h2>{{ __('projects.cta_title') }}</h2>
                        <p>{{ __('projects.cta_description') }}</p>
                    </div>
                    <a href="{{ route('contact', ['locale' => $currentLocale]) }}"
                       class="gallery-btn">
                        {{ __('gallery.contact_us') }}
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
            </div>
        </section>

    </main>
@endsection

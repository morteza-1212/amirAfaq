@extends('layouts.home')

@section('title', __('export.meta.title'))

@section('meta')
    <meta name="description" content="{{ __('export.meta.description') }}">
    <link rel="preload" as="image" href="{{ asset('img/header/hero.webp') }}" fetchpriority="high">
    <link rel="preload" as="style" href="{{ asset('css/export/export.css') }}?v=1">
@endsection

@section('styles')
    {{-- Critical CSS - فقط Hero برای لود اولیه --}}
    <style>
        .export-hero{position:relative;min-height:680px;display:flex;align-items:center;overflow:hidden;background:linear-gradient(90deg,rgba(7,35,21,.98) 0%,rgba(7,35,21,.88) 42%,rgba(7,35,21,.45) 75%,rgba(7,35,21,.18) 100%),url('/img/header/hero.webp') center/cover no-repeat}
        [dir="rtl"] .export-hero{background:linear-gradient(270deg,rgba(7,35,21,.98) 0%,rgba(7,35,21,.88) 42%,rgba(7,35,21,.45) 75%,rgba(7,35,21,.18) 100%),url('/img/header/hero.webp') center/cover no-repeat}
        .export-hero-content{position:relative;z-index:2;max-width:820px;padding:100px 0;color:#fff}
        .export-hero h1{margin:0 0 20px;color:#fff;font-size:clamp(44px,6vw,78px);font-weight:800;line-height:1.2;letter-spacing:-1px}
        .export-hero h1 span{color:#e2c16c}
        .export-hero h2{max-width:750px;margin:0 0 24px;color:#fff;font-size:clamp(21px,2.5vw,31px);font-weight:500;line-height:1.65}
        .export-hero-description{max-width:760px;margin-bottom:34px;color:rgba(255,255,255,.82);font-size:17px;line-height:2.1}
    </style>

    {{-- بقیه CSS به صورت Async --}}
    <link rel="stylesheet" href="{{ asset('css/export/export.css') }}?v=1" media="print" onload="this.media='all'">
    <noscript>
        <link rel="stylesheet" href="{{ asset('css/export/export.css') }}?v=1">
    </noscript>
@endsection

@php
    $locale = app()->getLocale();
    $isRtl  = in_array($locale, ['fa', 'ar']);
@endphp

@section('content')

    <div class="export-page" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">

        {{-- =========================================================
             HERO
        ========================================================== --}}

        <section class="export-hero">
            <div class="export-container">
                <div class="export-hero-content">

                    <div class="export-hero-label">
                        <i class="fa-solid fa-globe"></i>
                        {{ __('export.hero.label') }}
                    </div>

                    <h1>
                        @if ($locale === 'en')
                            {{ __('export.hero.title_1') }}
                            <span>{{ __('export.hero.title_2') }}</span>
                            {{ __('export.hero.title_3') }}
                        @else
                            {{ __('export.hero.title_1') }}
                            <span>{{ __('export.hero.title_2') }}</span>
                            {{ __('export.hero.title_3') }}
                        @endif
                    </h1>

                    <h2>{{ __('export.hero.subtitle') }}</h2>

                    <div class="export-hero-description">
                        {{ __('export.hero.description') }}
                    </div>

                    <div class="export-hero-buttons">
                        <a href="{{ url($locale . '/contact') }}" class="export-btn-primary">
                            <i class="fa-solid fa-paper-plane"></i>
                            {{ __('export.hero.btn_primary') }}
                        </a>

                        <a href="#export-process" class="export-btn-outline">
                            <i class="fa-solid fa-arrow-down"></i>
                            {{ __('export.hero.btn_outline') }}
                        </a>
                    </div>

                    <div class="export-hero-stats">
                        @for ($i = 1; $i <= 4; $i++)
                            <div class="export-stat">
                                <strong>0{{ $i }}</strong>
                                <span>{{ __('export.hero.stats.item' . $i) }}</span>
                            </div>
                        @endfor
                    </div>

                </div>
            </div>
        </section>

        {{-- =========================================================
             INTRO
        ========================================================== --}}

        <section class="export-intro">
            <div class="export-container">
                <div class="export-intro-grid">

                    <div>
                        <span class="export-intro-label">{{ __('export.intro.label') }}</span>
                        <h2>{{ __('export.intro.title') }}</h2>
                        <p>{{ __('export.intro.paragraph1') }}</p>
                        <p>{{ __('export.intro.paragraph2') }}</p>
                    </div>

                    <div class="export-intro-card">
                        <div class="export-intro-card-inner">
                            <div class="export-intro-card-icon">
                                <i class="fa-solid fa-earth-americas"></i>
                            </div>
                            <div>
                                <h3>{{ __('export.intro.card_title') }}</h3>
                                <p>{{ __('export.intro.card_text') }}</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        {{-- =========================================================
             SERVICES
        ========================================================== --}}

        <section class="export-services">
            <div class="export-container">

                <div class="export-heading">
                    <span class="export-section-label">{{ __('export.services.label') }}</span>
                    <h2>{{ __('export.services.title') }}</h2>
                    <p>{{ __('export.services.description') }}</p>
                </div>

                <div class="export-services-grid">
                    @php
                        $serviceIcons = [
                            'fa-boxes-stacked',
                            'fa-award',
                            'fa-box-open',
                            'fa-file-lines',
                            'fa-building-columns',
                            'fa-truck-fast',
                            'fa-location-dot',
                            'fa-network-wired',
                        ];
                    @endphp

                    @for ($i = 1; $i <= 8; $i++)
                        <div class="export-service-card">
                            <span class="export-service-number">0{{ $i }}</span>
                            <div class="export-service-icon">
                                <i class="fa-solid {{ $serviceIcons[$i - 1] }}"></i>
                            </div>
                            <h3>{{ __('export.services.items.item' . $i . '.title') }}</h3>
                            <p>{{ __('export.services.items.item' . $i . '.text') }}</p>
                        </div>
                    @endfor
                </div>
            </div>
        </section>

        {{-- =========================================================
             TRANSPORT METHODS
        ========================================================== --}}

        <section class="export-transport">
            <div class="export-container">

                <div class="export-heading">
                    <span class="export-section-label">{{ __('export.transport.label') }}</span>
                    <h2>{{ __('export.transport.title') }}</h2>
                    <p>{{ __('export.transport.description') }}</p>
                </div>

                <div class="export-transport-grid">
                    @php
                        $transports = [
                            ['key' => 'sea',  'icon' => 'fa-ship'],
                            ['key' => 'land', 'icon' => 'fa-truck'],
                            ['key' => 'air',  'icon' => 'fa-plane-departure'],
                        ];
                    @endphp

                    @foreach ($transports as $t)
                        <div class="export-transport-card">
                            <i class="fa-solid {{ $t['icon'] }}"></i>
                            <h3>{{ __('export.transport.items.' . $t['key'] . '.title') }}</h3>
                            <p>{{ __('export.transport.items.' . $t['key'] . '.text') }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- =========================================================
             PROCESS
        ========================================================== --}}

        <section class="export-process" id="export-process">
            <div class="export-container">

                <div class="export-heading">
                    <span class="export-section-label">{{ __('export.process.label') }}</span>
                    <h2>{{ __('export.process.title') }}</h2>
                    <p>{{ __('export.process.description') }}</p>
                </div>

                <div class="export-process-wrapper">
                    <div class="export-process-line"></div>

                    <div class="export-process-grid">
                        @php
                            // اعداد بومی‌شده بر اساس زبان
                            $numbers = match ($locale) {
                                'fa' => ['۱','۲','۳','۴','۵','۶','۷','۸','۹','۱۰'],
                                'ar' => ['١','٢','٣','٤','٥','٦','٧','٨','٩','١٠'],
                                default => ['1','2','3','4','5','6','7','8','9','10'],
                            };
                        @endphp

                        @for ($i = 1; $i <= 10; $i++)
                            <div class="export-process-item">
                                <div class="export-process-number">{{ $numbers[$i - 1] }}</div>
                                <h3>{{ __('export.process.steps.step' . $i) }}</h3>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </section>

        {{-- =========================================================
             WHY US
        ========================================================== --}}

        <section class="export-why">
            <div class="export-container">
                <div class="export-why-grid">

                    <div class="export-why-content">
                        <span class="export-section-label">{{ __('export.why.label') }}</span>
                        <h2>{{ __('export.why.title') }}</h2>
                        <p>{{ __('export.why.description') }}</p>

                        <div class="export-benefits">
                            @php
                                $benefitIcons = [
                                    'fa-check',
                                    'fa-shield-halved',
                                    'fa-file-circle-check',
                                    'fa-headset',
                                ];
                            @endphp

                            @for ($i = 1; $i <= 4; $i++)
                                <div class="export-benefit">
                                    <div class="export-benefit-icon">
                                        <i class="fa-solid {{ $benefitIcons[$i - 1] }}"></i>
                                    </div>
                                    <div>
                                        <h4>{{ __('export.why.benefits.item' . $i . '.title') }}</h4>
                                        <p>{{ __('export.why.benefits.item' . $i . '.text') }}</p>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>

                    <div class="export-why-visual">
                        <div class="export-why-visual-content">
                            <strong>{{ __('export.why.visual_title') }}</strong>
                            <span>{{ __('export.why.visual_text') }}</span>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        {{-- =========================================================
             SUPPLY CHAIN
        ========================================================== --}}

        <section class="export-chain">
            <div class="export-container">

                <div class="export-chain-content">
                    <span class="export-section-label">{{ __('export.chain.label') }}</span>
                    <h2>{{ __('export.chain.title') }}</h2>
                    <p>{{ __('export.chain.description') }}</p>
                </div>

                <div class="export-chain-flow">
                    @php
                        $chainIcons = [
                            'fa-boxes-stacked',
                            'fa-file-signature',
                            'fa-award',
                            'fa-file-lines',
                            'fa-truck-fast',
                            'fa-location-dot',
                        ];
                    @endphp

                    @for ($i = 1; $i <= 6; $i++)
                        <div class="export-chain-step">
                            <div class="export-chain-icon">
                                <i class="fa-solid {{ $chainIcons[$i - 1] }}"></i>
                            </div>
                            <span>{{ __('export.chain.steps.step' . $i) }}</span>
                        </div>
                    @endfor
                </div>
            </div>
        </section>

        {{-- =========================================================
             CTA
        ========================================================== --}}

        <section class="export-cta">
            <div class="export-container">
                <div class="export-cta-box">

                    <h2>{{ __('export.cta.title') }}</h2>
                    <p>{{ __('export.cta.text') }}</p>

                    <a href="{{ url($locale . '/contact') }}" class="export-btn-primary">
                        <i class="fa-solid fa-paper-plane"></i>
                        {{ __('export.cta.button') }}
                    </a>

                </div>
            </div>
        </section>

    </div>

@endsection

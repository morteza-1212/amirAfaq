@extends('layouts.home')

@php
    $locale = app()->getLocale();

    $isRtl = in_array($locale, ['fa', 'ar']);
    $direction = $isRtl ? 'rtl' : 'ltr';

    /*
    |--------------------------------------------------------------------------
    | Supplier Countries
    |--------------------------------------------------------------------------
    |
    | فقط کشورهایی را در این آرایه قرار دهید که شرکت واقعاً با آنها
    | همکاری تأمین دارد.
    |
    */

    $supplierCountries = [
        [
            'key' => 'iran',
            'flag' => '🇮🇷',
            'icon' => 'bi-building',
        ],
        [
            'key' => 'azerbaijan',
            'flag' => '🇦🇿',
            'icon' => 'bi-geo-alt',
        ],
        [
            'key' => 'turkey',
            'flag' => '🇹🇷',
            'icon' => 'bi-truck',
        ],
        [
            'key' => 'russia',
            'flag' => '🇷🇺',
            'icon' => 'bi-globe-europe-africa',
        ],
        [
            'key' => 'china',
            'flag' => '🇨🇳',
            'icon' => 'bi-globe-asia-australia',
        ],
        [
            'key' => 'india',
            'flag' => '🇮🇳',
            'icon' => 'bi-box-seam',
        ],
        [
            'key' => 'kazakhstan',
            'flag' => '🇰🇿',
            'icon' => 'bi-compass',
        ],
    ];
@endphp


@section('title', __('suppliers.meta_title'))


@section('styles')

    <style>

        /* =========================================================
           GLOBAL
        ========================================================= */

        .suppliers-page {
            direction: {{ $direction }};
            background: #f7f8f4;
            color: #20362a;
            overflow: hidden;
        }

        .suppliers-page * {
            box-sizing: border-box;
        }

        .suppliers-container {
            width: min(1180px, calc(100% - 32px));
            margin: auto;
        }


        /* =========================================================
           HERO
        ========================================================= */

        .suppliers-hero {
            position: relative;
            min-height: 570px;

            display: flex;
            align-items: center;

            overflow: hidden;

            background:
                linear-gradient(
                    90deg,
                    rgba(16, 48, 33, .96),
                    rgba(16, 48, 33, .72),
                    rgba(16, 48, 33, .35)
                ),
                url('{{ asset('img/header/Duck-ai-image-2026-09-27-14-24.jpeg') }}')
                center / cover no-repeat;
        }

        .suppliers-hero-content {
            max-width: 850px;
            padding: 100px 0;

            color: #fff;

            position: relative;
            z-index: 2;

            text-align: left;
        }

        [dir="rtl"] .suppliers-hero-content {
            text-align: left;
        }

        .supplier-hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;

            padding: 9px 20px;

            border-radius: 50px;

            background: rgba(204, 167, 69, .15);
            border: 1px solid rgba(227, 195, 103, .6);

            color: #e4c76c;

            font-size: 14px;
            font-weight: 700;

            margin-bottom: 25px;
        }

        .suppliers-hero h1 {
            font-size: clamp(38px, 5vw, 64px);
            line-height: 1.25;

            font-weight: 850;

            margin: 0 0 25px;

            color: #f5e6b8;

            text-shadow: 0 2px 18px rgba(0, 0, 0, .35);
        }

        .suppliers-hero p {
            max-width: 800px;

            font-size: 18px;
            line-height: 2;

            color: rgba(255,255,255,.88);

            margin: 0;

            text-shadow: 0 1px 10px rgba(0,0,0,.25);
        }


        /* =========================================================
           INTRO
        ========================================================= */

        .suppliers-intro {
            padding: 90px 0;
            background: #fff;
        }

        .suppliers-intro-content {
            max-width: 850px;

            margin: auto;

            text-align: center;
        }

        .supplier-eyebrow {
            display: block;

            color: #b18a2c;

            font-size: 14px;
            font-weight: 800;

            margin-bottom: 12px;
        }

        .suppliers-intro-content h2 {
            color: #1e3829;

            font-size: clamp(30px, 4vw, 45px);

            font-weight: 800;

            margin: 0 0 20px;
        }

        .suppliers-intro-content p {
            color: #68736b;

            line-height: 2;

            margin-bottom: 12px;
        }


        /* =========================================================
           WORLD MAP
        ========================================================= */

        .supplier-map-section {
            padding: 80px 0;

            background:
                linear-gradient(
                    180deg,
                    #f3f5ef,
                    #f8f9f5
                );
        }

        .supplier-map-wrapper {
            position: relative;

            min-height: 460px;

            display: flex;
            align-items: center;
            justify-content: center;

            margin-bottom: 70px;

            border-radius: 30px;

            overflow: hidden;

            background:
                radial-gradient(
                    circle at center,
                    rgba(192,154,55,.14),
                    transparent 45%
                ),
                #173b2a;

            box-shadow:
                0 25px 70px rgba(22, 55, 38, .15);
        }

        .supplier-map-wrapper img {
            width: 90%;
            max-width: 950px;

            opacity: .92;

            filter:
                brightness(1.08)
                contrast(.95);
        }

        .supplier-map-title {
            position: absolute;

            top: 35px;
            left: 50%;

            transform: translateX(-50%);

            color: rgba(255,255,255,.78);

            font-size: 13px;

            letter-spacing: 3px;

            text-transform: uppercase;

            white-space: nowrap;
        }


        /* =========================================================
           COUNTRY SECTION
        ========================================================= */

        .suppliers-heading {
            max-width: 760px;

            margin: 0 auto 50px;

            text-align: center;
        }

        .suppliers-heading h2 {
            color: #1f3929;

            font-size: clamp(30px, 4vw, 43px);

            font-weight: 800;

            margin: 0 0 15px;
        }

        .suppliers-heading p {
            color: #69746c;

            line-height: 2;

            margin: 0;
        }


        /* =========================================================
           COUNTRIES GRID
        ========================================================= */

        .supplier-countries-grid {
            display: grid;

            grid-template-columns: repeat(3, 1fr);

            gap: 22px;
        }

        .supplier-country-card {
            position: relative;

            background: #fff;

            border: 1px solid #e2e7df;

            border-radius: 22px;

            padding: 30px;

            transition: .3s ease;

            overflow: hidden;
        }

        .supplier-country-card::before {
            content: '';

            position: absolute;

            top: 0;
            left: 0;
            right: 0;

            height: 3px;

            background: #c39b3b;

            transform: scaleX(0);

            transform-origin: center;

            transition: .3s ease;
        }

        .supplier-country-card:hover {
            transform: translateY(-8px);

            border-color: rgba(178,138,44,.45);

            box-shadow:
                0 20px 45px rgba(28,57,39,.1);
        }

        .supplier-country-card:hover::before {
            transform: scaleX(1);
        }

        .supplier-country-icon {
            width: 65px;
            height: 65px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 17px;

            background: #edf2e9;

            color: #b18a2c;

            font-size: 27px;

            margin-bottom: 20px;
        }

        .supplier-country-flag {
            font-size: 34px;

            margin-bottom: 15px;

            display: block;
        }

        .supplier-country-card h3 {
            color: #213a2b;

            font-size: 22px;

            font-weight: 800;

            margin: 0 0 12px;
        }

        .supplier-country-card p {
            color: #69746c;

            font-size: 14px;

            line-height: 1.9;

            margin: 0;
        }


        /* =========================================================
           SUPPLY NETWORK
        ========================================================= */

        .supplier-network-section {
            padding: 90px 0;

            background: #fff;
        }

        .supplier-network-grid {
            display: grid;

            grid-template-columns: .9fr 1.1fr;

            gap: 65px;

            align-items: center;
        }

        .supplier-network-content h2 {
            color: #1e3829;

            font-size: 40px;

            font-weight: 800;

            margin: 10px 0 20px;
        }

        .supplier-network-content p {
            color: #68736b;

            line-height: 2;

            margin-bottom: 25px;
        }

        .supplier-network-list {
            display: grid;

            grid-template-columns: repeat(2, 1fr);

            gap: 12px;

            padding: 0;

            margin: 0;

            list-style: none;
        }

        .supplier-network-list li {
            padding: 14px 15px;

            background: #f4f6f1;

            border-radius: 10px;

            color: #314839;

            font-weight: 600;

            display: flex;

            align-items: center;

            gap: 10px;
        }

        .supplier-network-list li i {
            color: #b18a2c;
        }

        .supplier-network-visual {
            min-height: 390px;

            border-radius: 25px;

            background:
                linear-gradient(
                    rgba(21,57,39,.2),
                    rgba(21,57,39,.35)
                ),
                url('{{ asset('img/header/Duck-ai-image-2026-09-27-14-24.jpeg') }}')
                center / cover no-repeat;
        }


        /* =========================================================
           QUALITY / TRUST
        ========================================================= */

        .supplier-trust-section {
            padding: 90px 0;

            background: #f3f5ef;
        }

        .supplier-trust-heading {
            max-width: 760px;

            margin: 0 auto 50px;

            text-align: center;
        }

        .supplier-trust-heading h2 {
            color: #1e3829;

            font-size: clamp(30px, 4vw, 43px);

            font-weight: 800;

            margin-bottom: 16px;
        }

        .supplier-trust-heading p {
            color: #69746c;

            line-height: 2;
        }

        .supplier-trust-grid {
            display: grid;

            grid-template-columns: repeat(3, 1fr);

            gap: 22px;
        }

        .supplier-trust-card {
            background: #fff;

            border-radius: 18px;

            padding: 30px;

            border-bottom: 3px solid #c39b3b;
        }

        .supplier-trust-card-icon {
            width: 55px;
            height: 55px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 14px;

            background: #edf2e9;

            color: #b18a2c;

            font-size: 23px;

            margin-bottom: 20px;
        }

        .supplier-trust-card h3 {
            color: #213b2b;

            font-size: 20px;

            font-weight: 800;

            margin-bottom: 12px;
        }

        .supplier-trust-card p {
            color: #68746c;

            font-size: 14px;

            line-height: 1.9;

            margin: 0;
        }


        /* =========================================================
           CTA
        ========================================================= */

        .suppliers-cta {
            padding: 90px 0;

            background: #fff;
        }

        .supplier-cta-box {
            padding: 70px 35px;

            text-align: center;

            border-radius: 28px;

            background:
                linear-gradient(
                    135deg,
                    #173b29,
                    #28543d
                );

            color: #fff;
        }

        .supplier-cta-box h2 {
            font-size: clamp(30px, 4vw, 43px);

            font-weight: 800;

            margin-bottom: 18px;
        }

        .supplier-cta-box p {
            max-width: 720px;

            margin: 0 auto 30px;

            color: rgba(255,255,255,.78);

            line-height: 2;
        }

        .supplier-cta-button {
            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 9px;

            padding: 14px 30px;

            border-radius: 10px;

            background: #d1ab4e;

            color: #172d20;

            font-weight: 750;

            text-decoration: none;

            transition: .3s;
        }

        .supplier-cta-button:hover {
            background: #e4c46a;

            color: #172d20;

            transform: translateY(-2px);
        }


        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 1050px) {

            .supplier-countries-grid,
            .supplier-trust-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }


        @media (max-width: 800px) {

            .supplier-network-grid {
                grid-template-columns: 1fr;
            }

            .supplier-network-visual {
                min-height: 300px;
            }
        }


        @media (max-width: 600px) {

            .suppliers-hero {
                min-height: 520px;
            }

            .suppliers-hero-content {
                padding: 75px 0;
            }

            .suppliers-hero h1 {
                font-size: 35px;
            }

            .suppliers-hero p {
                font-size: 15px;
            }

            .supplier-countries-grid,
            .supplier-trust-grid {
                grid-template-columns: 1fr;
            }

            .supplier-network-list {
                grid-template-columns: 1fr;
            }

            .supplier-map-wrapper {
                min-height: 300px;
            }

            .supplier-map-wrapper img {
                width: 115%;
            }

            .supplier-cta-box {
                padding: 50px 22px;
            }
        }
        /* =====================================================
           SUPPLIERS HERO
        ====================================================== */

        .suppliers-hero {
            position: relative;
            min-height: 570px;
            display: flex;
            align-items: center;
            overflow: hidden;

            background:
                linear-gradient(
                    90deg,
                    rgba(17, 48, 34, .95),
                    rgba(17, 48, 34, .70),
                    rgba(17, 48, 34, .35)
                ),
                url('{{ asset('img/header/Duck-ai-image-2026-09-27-14-24.jpeg') }}')
                center / cover no-repeat;
        }

        .suppliers-container {
            width: min(1180px, calc(100% - 32px));
            margin: auto;
            position: relative;
            z-index: 2;
        }

        /* =====================================================
           HERO CONTENT — متن در سمت چپ (در همه زبان‌ها)
        ====================================================== */

        .suppliers-hero-content {
            max-width: 850px;
            padding: 100px 0;
            color: #fff;
            margin-left: 0;
            margin-right: auto;
            text-align: left;
        }

        /* RTL (فارسی/عربی): متن همچنان در سمت چپ تصویر */
        [dir="rtl"] .suppliers-hero-content {
            margin-left: 0;
            margin-right: auto;
            text-align: left;
        }

        /* =====================================================
           BADGE
        ====================================================== */

        .supplier-hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 9px 19px;
            border: 1px solid rgba(225, 194, 101, .6);
            border-radius: 40px;
            background: rgba(201, 166, 66, .15);
            color: #e4c76b;
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 25px;
        }

        .supplier-hero-badge i {
            font-size: 16px;
        }

        /* =====================================================
           H1 — رنگ روشن برای وضوح روی تصویر
        ====================================================== */

        .suppliers-hero h1 {
            font-size: clamp(35px, 5vw, 62px);
            line-height: 1.25;
            font-weight: 800;
            margin: 0 0 25px;
            color: #f5e6b8;
            text-shadow: 0 2px 18px rgba(0, 0, 0, .35);
        }

        .suppliers-hero h1 span {
            color: #e4c76b;
        }

        /* =====================================================
           PARAGRAPH
        ====================================================== */

        .suppliers-hero p {
            max-width: 780px;
            font-size: 18px;
            line-height: 2;
            color: rgba(255, 255, 255, .88);
            margin: 0;
            text-shadow: 0 1px 10px rgba(0, 0, 0, .25);
        }

        /* =====================================================
           RESPONSIVE
        ====================================================== */

        @media (max-width: 850px) {

            .suppliers-hero {
                min-height: 480px;
            }

            .suppliers-hero-content {
                padding: 75px 0;
            }

        }

        @media (max-width: 600px) {

            .suppliers-hero {
                min-height: 420px;
            }

            .suppliers-hero h1 {
                font-size: 34px;
            }

            .suppliers-hero p {
                font-size: 15px;
            }

        }
    </style>

@endsection


@section('content')

    <div class="suppliers-page">


        {{-- =====================================================
             HERO
        ====================================================== --}}

        <section class="suppliers-hero">

            <div class="suppliers-container">

                <div class="suppliers-hero-content">

                <span class="supplier-hero-badge">
                    <i class="bi bi-globe2"></i>
                    {{ __('suppliers.hero.badge') }}
                </span>

                    <h1>
                        {{ __('suppliers.hero.title') }}
                    </h1>

                    <p>
                        {{ __('suppliers.hero.text') }}
                    </p>

                </div>

            </div>

        </section>


        {{-- =====================================================
             INTRO
        ====================================================== --}}

        <section class="suppliers-intro">

            <div class="suppliers-container">

                <div class="suppliers-intro-content">

                <span class="supplier-eyebrow">
                    {{ __('suppliers.intro.eyebrow') }}
                </span>

                    <h2>
                        {{ __('suppliers.intro.title') }}
                    </h2>

                    <p>
                        {{ __('suppliers.intro.text') }}
                    </p>

                    <p>
                        {{ __('suppliers.intro.text_2') }}
                    </p>

                </div>

            </div>

        </section>


        {{-- =====================================================
             WORLD MAP
        ====================================================== --}}

        <section class="supplier-map-section">

            <div class="suppliers-container">

                <div class="supplier-map-wrapper">

                <span class="supplier-map-title">
                    {{ __('suppliers.map.title') }}
                </span>

                    <img
                        src="{{ asset('img/markets/Duck-ai-image-2026-10-06-15-41.webp') }}"
                        alt="{{ __('suppliers.map.alt') }}"
                    >

                </div>


                {{-- =================================================
                     COUNTRIES
                ================================================== --}}

                <div class="suppliers-heading">

                <span class="supplier-eyebrow">
                    {{ __('suppliers.countries.eyebrow') }}
                </span>

                    <h2>
                        {{ __('suppliers.countries.title') }}
                    </h2>

                    <p>
                        {{ __('suppliers.countries.text') }}
                    </p>

                </div>


                <div class="supplier-countries-grid">

                    @foreach($supplierCountries as $country)

                        <article class="supplier-country-card">

                        <span class="supplier-country-flag">
                            {{ $country['flag'] }}
                        </span>

                            <div class="supplier-country-icon">

                                <i class="bi {{ $country['icon'] }}"></i>

                            </div>

                            <h3>
                                {{ __("suppliers.country.{$country['key']}.title") }}
                            </h3>

                            <p>
                                {{ __("suppliers.country.{$country['key']}.text") }}
                            </p>

                        </article>

                    @endforeach

                </div>

            </div>

        </section>


        {{-- =====================================================
             SUPPLY NETWORK
        ====================================================== --}}

        <section class="supplier-network-section">

            <div class="suppliers-container">

                <div class="supplier-network-grid">

                    <div class="supplier-network-content">

                    <span class="supplier-eyebrow">
                        {{ __('suppliers.network.eyebrow') }}
                    </span>

                        <h2>
                            {{ __('suppliers.network.title') }}
                        </h2>

                        <p>
                            {{ __('suppliers.network.text') }}
                        </p>


                        <ul class="supplier-network-list">

                            <li>
                                <i class="bi bi-check-circle-fill"></i>
                                {{ __('suppliers.network.items.quality') }}
                            </li>

                            <li>
                                <i class="bi bi-check-circle-fill"></i>
                                {{ __('suppliers.network.items.continuity') }}
                            </li>

                            <li>
                                <i class="bi bi-check-circle-fill"></i>
                                {{ __('suppliers.network.items.logistics') }}
                            </li>

                            <li>
                                <i class="bi bi-check-circle-fill"></i>
                                {{ __('suppliers.network.items.reliability') }}
                            </li>

                        </ul>

                    </div>


                    <div class="supplier-network-visual"></div>

                </div>

            </div>

        </section>


        {{-- =====================================================
             TRUST
        ====================================================== --}}

        <section class="supplier-trust-section">

            <div class="suppliers-container">

                <div class="supplier-trust-heading">

                <span class="supplier-eyebrow">
                    {{ __('suppliers.trust.eyebrow') }}
                </span>

                    <h2>
                        {{ __('suppliers.trust.title') }}
                    </h2>

                    <p>
                        {{ __('suppliers.trust.text') }}
                    </p>

                </div>


                <div class="supplier-trust-grid">


                    <article class="supplier-trust-card">

                        <div class="supplier-trust-card-icon">

                            <i class="bi bi-patch-check"></i>

                        </div>

                        <h3>
                            {{ __('suppliers.trust.items.quality.title') }}
                        </h3>

                        <p>
                            {{ __('suppliers.trust.items.quality.text') }}
                        </p>

                    </article>


                    <article class="supplier-trust-card">

                        <div class="supplier-trust-card-icon">

                            <i class="bi bi-diagram-3"></i>

                        </div>

                        <h3>
                            {{ __('suppliers.trust.items.network.title') }}
                        </h3>

                        <p>
                            {{ __('suppliers.trust.items.network.text') }}
                        </p>

                    </article>


                    <article class="supplier-trust-card">

                        <div class="supplier-trust-card-icon">

                            <i class="bi bi-shield-check"></i>

                        </div>

                        <h3>
                            {{ __('suppliers.trust.items.reliability.title') }}
                        </h3>

                        <p>
                            {{ __('suppliers.trust.items.reliability.text') }}
                        </p>

                    </article>


                </div>

            </div>

        </section>


        {{-- =====================================================
             CTA
        ====================================================== --}}

        <section class="suppliers-cta">

            <div class="suppliers-container">

                <div class="supplier-cta-box">

                    <h2>
                        {{ __('suppliers.cta.title') }}
                    </h2>

                    <p>
                        {{ __('suppliers.cta.text') }}
                    </p>

                    <a
                        href="{{ url($locale . '/contact') }}"
                        class="supplier-cta-button"
                    >

                        {{ __('suppliers.cta.button') }}

                        <i class="bi bi-arrow-left"></i>

                    </a>

                </div>

            </div>

        </section>


    </div>

@endsection

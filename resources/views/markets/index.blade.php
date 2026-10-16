@extends('layouts.home')

@php

    $locale = app()->getLocale();

    $isRtl = in_array($locale, ['fa', 'ar']);

    $direction = $isRtl ? 'rtl' : 'ltr';

    /*
    |--------------------------------------------------------------------------
    | Regions
    |--------------------------------------------------------------------------
    */

    $regions = [
        [
            'key' => 'middle_east',
            'icon' => 'bi-moon-stars',
        ],
        [
            'key' => 'cis',
            'icon' => 'bi-globe-europe-africa',
        ],
        [
            'key' => 'central_asia',
            'icon' => 'bi-compass',
        ],
        [
            'key' => 'asia',
            'icon' => 'bi-globe-asia-australia',
        ],
        [
            'key' => 'europe',
            'icon' => 'bi-globe-europe-africa',
        ],
        [
            'key' => 'africa',
            'icon' => 'bi-globe-africa',
        ],
        [
            'key' => 'americas',
            'icon' => 'bi-globe-americas',
        ],
    ];

    /*
    |--------------------------------------------------------------------------
    | Focus Markets
    |--------------------------------------------------------------------------
    */

    $focusMarkets = __('markets.focus.items');

@endphp


@section('title', __('markets.meta_title'))


@section('styles')

    <style>

        /* =========================================================
           GLOBAL
        ========================================================= */

        .markets-page {
            direction: {{ $direction }};
            background: #f7f8f4;
            color: #20362a;
            overflow: hidden;
        }

        .markets-page * {
            box-sizing: border-box;
        }

        .markets-container {
            width: min(1180px, calc(100% - 32px));
            margin: auto;
        }


        /* =========================================================
           HERO
        ========================================================= */

        {{--.markets-hero {--}}
        {{--    min-height: 570px;--}}

        {{--    display: flex;--}}
        {{--    align-items: center;--}}

        {{--    position: relative;--}}

        {{--    background:--}}
        {{--        linear-gradient(--}}
        {{--            90deg,--}}
        {{--            rgba(16, 48, 33, .95),--}}
        {{--            rgba(16, 48, 33, .70),--}}
        {{--            rgba(16, 48, 33, .35)--}}
        {{--        ),--}}
        {{--        url('{{'img/imageheader/globalmarket.webp'}}')--}}
        {{--        center / cover no-repeat;--}}
        {{--}--}}

        .markets-hero-content {
            max-width: 850px;
            padding: 100px 0;
            color: #fff;
        }

        .hero-badge {
            display: inline-flex;

            padding: 9px 20px;

            border-radius: 50px;

            background: rgba(204, 167, 69, .15);
            border: 1px solid rgba(227, 195, 103, .6);

            color: #e4c76c;

            font-size: 14px;
            font-weight: 700;

            margin-bottom: 25px;
        }

        .markets-hero h1 {
            font-size: clamp(38px, 5vw, 64px);
            line-height: 1.2;
            font-weight: 850;

            margin: 0 0 25px;
        }

        .markets-hero p {
            max-width: 800px;

            font-size: 18px;
            line-height: 2;

            color: rgba(255,255,255,.85);

            margin: 0;
        }


        /* =========================================================
           INTRO
        ========================================================= */

        .markets-intro {
            padding: 90px 0;
            background: #fff;
        }

        .intro-content {
            max-width: 850px;
            margin: auto;
            text-align: center;
        }

        .eyebrow {
            display: block;

            color: #b18a2c;

            font-size: 14px;
            font-weight: 800;

            margin-bottom: 12px;
        }

        .intro-content h2 {
            color: #1e3829;

            font-size: clamp(30px, 4vw, 45px);

            font-weight: 800;

            margin: 0 0 20px;
        }

        .intro-content p {
            color: #68736b;

            line-height: 2;

            margin-bottom: 12px;
        }


        /* =========================================================
           WORLD MAP
        ========================================================= */

        .world-map-section {
            padding: 80px 0;

            background:
                linear-gradient(
                    180deg,
                    #f3f5ef,
                    #f8f9f5
                );
        }

        .map-wrapper {
            position: relative;

            min-height: 480px;

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

        /*
        |--------------------------------------------------------------------------
        | World Map Graphic
        |--------------------------------------------------------------------------
        */

        .world-map {
            width: 90%;
            max-width: 950px;

            opacity: .9;

            filter:
                brightness(1.1)
                contrast(.9);
        }

        .map-title {
            position: absolute;

            top: 35px;
            left: 50%;

            transform: translateX(-50%);

            color: rgba(255,255,255,.75);

            font-size: 13px;

            letter-spacing: 3px;

            text-transform: uppercase;
        }


        /* =========================================================
           REGIONS
        ========================================================= */

        .regions-heading {
            max-width: 750px;

            margin: 0 auto 50px;

            text-align: center;
        }

        .regions-heading h2 {
            color: #1f3929;

            font-size: clamp(30px, 4vw, 43px);

            font-weight: 800;

            margin-bottom: 15px;
        }

        .regions-heading p {
            color: #69746c;

            line-height: 2;
        }

        .regions-grid {
            display: grid;

            grid-template-columns: repeat(3, 1fr);

            gap: 22px;
        }

        .region-card {
            background: #fff;

            border: 1px solid #e2e7df;

            border-radius: 20px;

            padding: 28px;

            transition: .3s ease;
        }

        .region-card:hover {
            transform: translateY(-7px);

            border-color: rgba(178,138,44,.45);

            box-shadow:
                0 20px 45px rgba(28,57,39,.1);
        }

        .region-icon {
            width: 60px;
            height: 60px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 16px;

            background: #edf2e9;

            color: #b18a2c;

            font-size: 27px;

            margin-bottom: 20px;
        }

        .region-card h3 {
            color: #213a2b;

            font-size: 22px;

            font-weight: 800;

            margin-bottom: 12px;
        }

        .region-description {
            color: #69746c;

            font-size: 14px;

            line-height: 1.9;

            margin-bottom: 22px;
        }

        .country-list {
            display: flex;

            flex-wrap: wrap;

            gap: 8px;

            padding: 0;

            margin: 0;

            list-style: none;
        }

        .country-list li {
            padding: 7px 10px;

            border-radius: 8px;

            background: #f4f6f1;

            color: #33483a;

            font-size: 13px;
        }


        /* =========================================================
           NEIGHBORS
        ========================================================= */

        .neighbors-section {
            padding: 90px 0;

            background: #fff;
        }

        .neighbors-grid {
            display: grid;

            grid-template-columns: .8fr 1.2fr;

            gap: 65px;

            align-items: center;
        }

        .neighbors-content h2 {
            color: #1e3829;

            font-size: 40px;

            font-weight: 800;

            margin: 10px 0 20px;
        }

        .neighbors-content p {
            color: #68736b;

            line-height: 2;

            margin-bottom: 25px;
        }

        .neighbor-list {
            display: grid;

            grid-template-columns: repeat(2, 1fr);

            gap: 12px;

            padding: 0;

            margin: 0;

            list-style: none;
        }

        .neighbor-list li {
            padding: 13px 15px;

            background: #f4f6f1;

            border-radius: 10px;

            color: #314839;

            font-weight: 600;
        }

        .neighbors-visual {
            min-height: 390px;

            border-radius: 25px;

            background:
                linear-gradient(
                    rgba(21,57,39,.2),
                    rgba(21,57,39,.3)
                ),
                {{--url('{{ asset('img/header/Duck-ai-image-2026-09-27-14-24.jpeg') }}')--}}
                {{--center / cover no-repeat;--}}
        }


        /* =========================================================
           FOCUS MARKETS
        ========================================================= */

        .focus-section {
            padding: 90px 0;

            background: #f3f5ef;
        }

        .focus-heading {
            max-width: 750px;

            margin: 0 auto 50px;

            text-align: center;
        }

        .focus-heading h2 {
            color: #1e3829;

            font-size: clamp(30px, 4vw, 43px);

            font-weight: 800;

            margin-bottom: 16px;
        }

        .focus-heading p {
            color: #69746c;

            line-height: 2;
        }

        .focus-grid {
            display: grid;

            grid-template-columns: repeat(3, 1fr);

            gap: 22px;
        }

        .focus-card {
            background: #fff;

            border-radius: 18px;

            padding: 30px;

            border-bottom: 3px solid #c39b3b;
        }

        .focus-card h3 {
            color: #213b2b;

            font-size: 20px;

            font-weight: 800;

            margin-bottom: 12px;
        }

        .focus-card p {
            color: #68746c;

            font-size: 14px;

            line-height: 1.9;

            margin: 0;
        }


        /* =========================================================
           CTA
        ========================================================= */

        .markets-cta {
            padding: 90px 0;

            background: #fff;
        }

        .cta-box {
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

        .cta-box h2 {
            font-size: clamp(30px, 4vw, 43px);

            font-weight: 800;

            margin-bottom: 18px;
        }

        .cta-box p {
            max-width: 720px;

            margin: 0 auto 30px;

            color: rgba(255,255,255,.78);

            line-height: 2;
        }

        .cta-button {
            display: inline-flex;

            padding: 14px 30px;

            border-radius: 10px;

            background: #d1ab4e;

            color: #172d20;

            font-weight: 750;

            text-decoration: none;

            transition: .3s;
        }

        .cta-button:hover {
            background: #e4c46a;

            color: #172d20;

            transform: translateY(-2px);
        }


        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 1050px) {

            .regions-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .focus-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 800px) {

            .neighbors-grid {
                grid-template-columns: 1fr;
            }

            .neighbors-visual {
                min-height: 300px;
            }
        }

        @media (max-width: 600px) {

            .markets-hero-content {
                padding: 75px 0;
            }

            .markets-hero h1 {
                font-size: 35px;
            }

            .markets-hero p {
                font-size: 15px;
            }

            .regions-grid,
            .focus-grid {
                grid-template-columns: 1fr;
            }

            .neighbor-list {
                grid-template-columns: 1fr;
            }

            .map-wrapper {
                min-height: 300px;
            }

            .world-map {
                width: 110%;
            }

            .cta-box {
                padding: 50px 22px;
            }
        }
        /* =====================================================
           MARKETS HERO
        ====================================================== */

        .markets-hero {
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
                url('{{ asset('img/imageheader/globalmarket.webp') }}')
                center / cover no-repeat;
        }

        .markets-container {
            width: min(1180px, calc(100% - 32px));
            margin: auto;
            position: relative;
            z-index: 2;
        }

        /* =====================================================
           HERO CONTENT — متن در سمت چپ (در همه حالت‌ها)
        ====================================================== */

        .markets-hero-content {
            max-width: 850px;
            padding: 100px 0;
            color: #fff;
            margin-left: 0;
            margin-right: auto;
            text-align: left;
        }

        /* RTL (فارسی/عربی): متن همچنان در سمت چپ تصویر */
        [dir="rtl"] .markets-hero-content {
            margin-left: 0;
            margin-right: auto;
            text-align: left;
        }

        /* =====================================================
           BADGE
        ====================================================== */

        .markets-hero .hero-badge {
            display: inline-flex;
            padding: 9px 19px;
            border: 1px solid rgba(225, 194, 101, .6);
            border-radius: 40px;
            background: rgba(201, 166, 66, .15);
            color: #e4c76b;
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 25px;
        }

        /* =====================================================
           H1 — رنگ روشن (طلایی) برای وضوح روی تصویر
        ====================================================== */

        .markets-hero h1 {
            font-size: clamp(35px, 5vw, 62px);
            line-height: 1.25;
            font-weight: 800;
            margin: 0 0 25px;
            color: #f5e6b8;               /* رنگ روشن طلایی/کرم */
            text-shadow: 0 2px 18px rgba(0, 0, 0, .35);
        }

        /* اگر خواستید کلمه کلیدی داخل h1 با رنگ طلایی متمایز باشد */
        .markets-hero h1 span {
            color: #e4c76b;
        }

        /* =====================================================
           PARAGRAPH
        ====================================================== */

        .markets-hero p {
            max-width: 780px;
            font-size: 18px;
            line-height: 2;
            color: rgba(255, 255, 255, .88);
            margin: 0;
            text-shadow: 0 1px 10px rgba(0, 0, 0, .25);
        }

    </style>

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

    <div class="markets-page">

        {{-- =====================================================
             HERO
        ====================================================== --}}

        <section class="markets-hero">

            <div class="markets-container">

                <div class="markets-hero-content">

                <span class="hero-badge">
                    {{ __('markets.hero.badge') }}
                </span>

                    <h1>
                        {{ __('markets.hero.title') }}
                    </h1>

                    <p>
                        {{ __('markets.hero.text') }}
                    </p>

                </div>

            </div>

        </section>


        {{-- =====================================================
             INTRO
        ====================================================== --}}

        <section class="markets-intro">

            <div class="markets-container">

                <div class="intro-content">

                <span class="eyebrow">
                    {{ __('markets.intro.eyebrow') }}
                </span>

                    <h2>
                        {{ __('markets.intro.title') }}
                    </h2>

                    <p>
                        {{ __('markets.intro.text') }}
                    </p>

                    <p>
                        {{ __('markets.intro.text_2') }}
                    </p>

                </div>

            </div>

        </section>


        {{-- =====================================================
             WORLD MAP + REGIONS
        ====================================================== --}}

        <section class="world-map-section">

            <div class="markets-container">

                <div class="map-wrapper">

                <span class="map-title">
                    {{ __('markets.regions.title') }}
                </span>

                    {{-- جای نقشه جهان --}}
{{--                    <svg--}}
{{--                        class="world-map"--}}
{{--                        viewBox="0 0 1000 500"--}}
{{--                        xmlns="http://www.w3.org/2000/svg"--}}
{{--                        aria-hidden="true"--}}
{{--                    >--}}

{{--                        <path--}}
{{--                            d="M105 180--}}
{{--                           C145 135 205 120 260 135--}}
{{--                           C305 145 330 170 365 180--}}
{{--                           C405 165 445 150 485 160--}}
{{--                           C525 170 550 190 590 180--}}
{{--                           C640 165 690 150 740 170--}}
{{--                           C795 190 845 185 885 215--}}
{{--                           C850 245 815 255 780 250--}}
{{--                           C740 245 710 265 680 290--}}
{{--                           C650 315 615 320 580 305--}}
{{--                           C550 292 525 300 500 320--}}
{{--                           C470 340 435 350 405 335--}}
{{--                           C375 320 350 300 320 290--}}
{{--                           C285 280 260 270 230 250--}}
{{--                           C200 230 170 225 140 220--}}
{{--                           C115 215 95 200 105 180Z"--}}
{{--                            fill="rgba(214,180,83,.16)"--}}
{{--                            stroke="rgba(214,180,83,.65)"--}}
{{--                            stroke-width="2"--}}
{{--                        />--}}

{{--                        <circle--}}
{{--                            cx="520"--}}
{{--                            cy="215"--}}
{{--                            r="7"--}}
{{--                            fill="#e1c365"--}}
{{--                        />--}}

{{--                        <circle--}}
{{--                            cx="590"--}}
{{--                            cy="235"--}}
{{--                            r="7"--}}
{{--                            fill="#e1c365"--}}
{{--                        />--}}

{{--                        <circle--}}
{{--                            cx="675"--}}
{{--                            cy="205"--}}
{{--                            r="7"--}}
{{--                            fill="#e1c365"--}}
{{--                        />--}}

{{--                        <circle--}}
{{--                            cx="760"--}}
{{--                            cy="300"--}}
{{--                            r="7"--}}
{{--                            fill="#e1c365"--}}
{{--                        />--}}

{{--                    </svg>--}}
                    <img src="{{asset('img/markets/Duck-ai-image-2026-10-06-15-41.webp')}}" alt="">

                </div>


                <div class="regions-heading">

                <span class="eyebrow">
                    {{ __('markets.regions.title') }}
                </span>

                    <h2>
                        {{ __('markets.regions.subtitle') }}
                    </h2>

                </div>


                <div class="regions-grid">

                    @foreach($regions as $region)

                        <article class="region-card">

                            <div class="region-icon">

                                <i class="bi {{ $region['icon'] }}"></i>

                            </div>

                            <h3>
                                {{ __("markets.regions.{$region['key']}.title") }}
                            </h3>

                            <p class="region-description">
                                {{ __("markets.regions.{$region['key']}.description") }}
                            </p>

                            <ul class="country-list">

                                @foreach(__("markets.regions.{$region['key']}.countries") as $country)

                                    <li>
                                        {{ $country }}
                                    </li>

                                @endforeach

                            </ul>

                        </article>

                    @endforeach

                </div>

            </div>

        </section>


        {{-- =====================================================
             IRAN NEIGHBORS
        ====================================================== --}}

        <section class="neighbors-section">

            <div class="markets-container">

                <div class="neighbors-grid">

                    <div class="neighbors-content">

                    <span class="eyebrow">
                        {{ __('markets.iran_neighbors.eyebrow') }}
                    </span>

                        <h2>
                            {{ __('markets.iran_neighbors.title') }}
                        </h2>

                        <p>
                            {{ __('markets.iran_neighbors.text') }}
                        </p>

                        <ul class="neighbor-list">

                            @foreach(__('markets.iran_neighbors.countries') as $country)

                                <li>
                                    {{ $country }}
                                </li>

                            @endforeach

                        </ul>

                    </div>


                    <div class="neighbors-visual"></div>

                </div>

            </div>

        </section>


        {{-- =====================================================
             FOCUS MARKETS
        ====================================================== --}}

        <section class="focus-section">

            <div class="markets-container">

                <div class="focus-heading">

                <span class="eyebrow">
                    {{ __('markets.focus.eyebrow') }}
                </span>

                    <h2>
                        {{ __('markets.focus.title') }}
                    </h2>

                    <p>
                        {{ __('markets.focus.text') }}
                    </p>

                </div>


                <div class="focus-grid">

                    @foreach($focusMarkets as $market)

                        <article class="focus-card">

                            <h3>
                                {{ $market['title'] }}
                            </h3>

                            <p>
                                {{ $market['text'] }}
                            </p>

                        </article>

                    @endforeach

                </div>

            </div>

        </section>


        {{-- =====================================================
             CTA
        ====================================================== --}}

        <section class="markets-cta">

            <div class="markets-container">

                <div class="cta-box">

                    <h2>
                        {{ __('markets.cta.title') }}
                    </h2>

                    <p>
                        {{ __('markets.cta.text') }}
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

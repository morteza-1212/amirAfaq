@extends('layouts.home')

@php
    $locale = app()->getLocale();

    $isRtl = in_array($locale, ['fa', 'ar']);
    $direction = $isRtl ? 'rtl' : 'ltr';

    $services = [
        ['key' => 'sea', 'icon' => 'bi-water'],
        ['key' => 'road', 'icon' => 'bi-truck'],
        ['key' => 'air', 'icon' => 'bi-airplane'],
        ['key' => 'rail', 'icon' => 'bi-train-front'],
        ['key' => 'container', 'icon' => 'bi-box-seam'],
        ['key' => 'refrigerated', 'icon' => 'bi-snow2'],
        ['key' => 'warehousing', 'icon' => 'bi-building'],
        ['key' => 'cold_storage', 'icon' => 'bi-thermometer-snow'],
        ['key' => 'cold_chain', 'icon' => 'bi-diagram-3'],
        ['key' => 'insurance', 'icon' => 'bi-shield-check'],
        ['key' => 'customs', 'icon' => 'bi-file-earmark-check'],
    ];
@endphp

@section('title', __('logistics.meta_title'))

@section('styles')

    <style>

        .logistics-page {
            direction: {{ $direction }};
            background: #f7f8f4;
            color: #20362a;
            overflow: hidden;
        }

        .logistics-page * {
            box-sizing: border-box;
        }

        .logistics-container {
            width: min(1180px, calc(100% - 32px));
            margin: auto;
        }

        /* =====================================================
           HERO
        ===================================================== */

        .logistics-hero {
            min-height: 570px;
            display: flex;
            align-items: center;

            background:
                linear-gradient(
                    90deg,
                    rgba(17, 48, 34, .95),
                    rgba(17, 48, 34, .70),
                    rgba(17, 48, 34, .35)
                ),
                url('{{ asset('img/imageheader/logistic2.webp') }}')
                center / cover no-repeat;
        }

        .logistics-hero-content {
            max-width: 850px;
            padding: 100px 0;
            color: #fff;
        }

        .hero-badge {
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

        .logistics-hero h1 {
            font-size: clamp(35px, 5vw, 62px);
            line-height: 1.25;
            font-weight: 800;
            margin: 0 0 25px;
        }

        .logistics-hero p {
            max-width: 780px;
            font-size: 18px;
            line-height: 2;
            color: rgba(255,255,255,.86);
            margin: 0;
        }

        /* =====================================================
           SECTIONS
        ===================================================== */

        .logistics-section {
            padding: 90px 0;
        }

        .section-heading {
            max-width: 760px;
            margin: 0 auto 55px;
            text-align: center;
        }

        .section-heading .eyebrow {
            display: block;
            color: #b28a2c;
            font-size: 14px;
            font-weight: 800;
            margin-bottom: 12px;
        }

        .section-heading h2 {
            color: #1e3829;
            font-size: clamp(29px, 4vw, 43px);
            font-weight: 800;
            margin: 0 0 18px;
        }

        .section-heading p {
            color: #69756c;
            line-height: 2;
            margin: 0;
        }

        /* =====================================================
           INTRO
        ===================================================== */

        .intro-section {
            background: #fff;
        }

        .intro-grid {
            display: grid;
            grid-template-columns: 1fr 1.1fr;
            gap: 65px;
            align-items: center;
        }

        .intro-image {
            min-height: 440px;
            border-radius: 25px;

            background:
                linear-gradient(
                    rgba(20, 54, 37, .15),
                    rgba(20, 54, 37, .25)
                ),
                url('{{ asset('img/header/Duck-ai-image-2026-09-27-14-24.jpeg') }}')
                center / cover no-repeat;
        }

        .intro-content .eyebrow {
            color: #b28a2c;
            font-size: 14px;
            font-weight: 800;
        }

        .intro-content h2 {
            color: #1e3829;
            font-size: 40px;
            font-weight: 800;
            margin: 12px 0 22px;
        }

        .intro-content p {
            color: #667269;
            line-height: 2.15;
            margin-bottom: 15px;
        }

        /* =====================================================
           SERVICES
        ===================================================== */

        .services-section {
            background: #f3f5ef;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .service-card {
            min-height: 245px;
            padding: 28px 24px;
            background: #fff;
            border: 1px solid #e3e8e0;
            border-radius: 19px;
            transition: .3s ease;
        }

        .service-card:hover {
            transform: translateY(-7px);
            box-shadow: 0 18px 45px rgba(27, 57, 39, .1);
            border-color: rgba(178,138,44,.4);
        }

        .service-icon {
            width: 58px;
            height: 58px;
            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 15px;
            background: #edf2e9;
            color: #b18a2c;

            font-size: 26px;
            margin-bottom: 20px;
        }

        .service-card h3 {
            color: #213b2b;
            font-size: 19px;
            font-weight: 750;
            margin-bottom: 12px;
        }

        .service-card p {
            color: #69746c;
            font-size: 14px;
            line-height: 1.9;
            margin: 0;
        }

        /* =====================================================
           COLD CHAIN
        ===================================================== */

        .cold-chain-section {
            background:
                linear-gradient(
                    135deg,
                    #143a29,
                    #24523b
                );
            color: #fff;
        }

        .cold-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 70px;
            align-items: center;
        }

        .cold-content .eyebrow {
            color: #e1c365;
            font-size: 14px;
            font-weight: 800;
        }

        .cold-content h2 {
            font-size: clamp(30px, 4vw, 45px);
            line-height: 1.35;
            font-weight: 800;
            margin: 12px 0 22px;
        }

        .cold-content p {
            color: rgba(255,255,255,.78);
            line-height: 2;
            margin-bottom: 12px;
        }

        .cold-list {
            list-style: none;
            padding: 0;
            margin: 28px 0 0;
        }

        .cold-list li {
            display: flex;
            align-items: center;
            gap: 12px;
            color: rgba(255,255,255,.9);
            margin-bottom: 14px;
        }

        .cold-list i {
            color: #e0bf58;
        }

        .cold-image {
            min-height: 450px;
            border-radius: 25px;

            background:
                linear-gradient(
                    rgba(16,52,36,.35),
                    rgba(16,52,36,.55)
                ),
                url('{{ asset('img/header/Duck-ai-image-2026-09-27-14-24.jpeg') }}')
                center / cover no-repeat;
        }

        /* =====================================================
           PROCESS
        ===================================================== */

        .process-section {
            background: #fff;
        }

        .process-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 18px;
        }

        .process-card {
            padding: 28px 22px;
            background: #fafbf8;
            border: 1px solid #e1e7df;
            border-radius: 18px;
        }

        .process-number {
            color: #c19a3a;
            font-size: 35px;
            font-weight: 900;
            margin-bottom: 18px;
        }

        .process-card h3 {
            color: #213b2b;
            font-size: 18px;
            margin-bottom: 12px;
        }

        .process-card p {
            color: #69746c;
            font-size: 14px;
            line-height: 1.9;
            margin: 0;
        }

        /* =====================================================
           ADVANTAGES
        ===================================================== */

        .advantages-section {
            background: #f3f5ef;
        }

        .advantages-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 22px;
        }

        .advantage-card {
            padding: 32px 25px;
            background: #fff;
            border-radius: 18px;
            text-align: center;
            border-bottom: 3px solid #c39b3b;
        }

        .advantage-card h3 {
            color: #20382a;
            font-size: 19px;
            margin-bottom: 13px;
        }

        .advantage-card p {
            color: #68746c;
            font-size: 14px;
            line-height: 1.9;
            margin: 0;
        }

        /* =====================================================
           CTA
        ===================================================== */

        .logistics-cta {
            padding: 90px 0;
            background: #fff;
        }

        .cta-box {
            position: relative;
            overflow: hidden;

            padding: 70px 35px;
            border-radius: 28px;

            text-align: center;

            background:
                linear-gradient(
                    135deg,
                    #173b29,
                    #28543d
                );

            color: #fff;
        }

        .cta-box h2 {
            position: relative;
            font-size: clamp(29px, 4vw, 42px);
            font-weight: 800;
            margin-bottom: 18px;
        }

        .cta-box p {
            position: relative;
            max-width: 700px;
            margin: 0 auto 30px;

            color: rgba(255,255,255,.78);
            line-height: 2;
        }

        .cta-button {
            position: relative;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            padding: 14px 30px;
            border-radius: 10px;

            background: #d1ab4e;
            color: #172d20;

            font-weight: 750;
            text-decoration: none;

            transition: .3s ease;
        }

        .cta-button:hover {
            background: #e4c46a;
            color: #172d20;
            transform: translateY(-2px);
        }

        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media (max-width: 1100px) {

            .services-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .process-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .advantages-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 850px) {

            .intro-grid,
            .cold-grid {
                grid-template-columns: 1fr;
            }

            .intro-image,
            .cold-image {
                min-height: 330px;
            }

            .services-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .process-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {

            .logistics-section {
                padding: 65px 0;
            }

            .logistics-hero-content {
                padding: 75px 0;
            }

            .logistics-hero h1 {
                font-size: 34px;
            }

            .logistics-hero p {
                font-size: 15px;
            }

            .services-grid,
            .process-grid,
            .advantages-grid {
                grid-template-columns: 1fr;
            }

            .intro-content h2 {
                font-size: 30px;
            }

            .cta-box {
                padding: 50px 22px;
            }
        }
        /* =====================================================
   HERO
====================================================== */

        .logistics-hero {
            min-height: 570px;
            display: flex;
            align-items: center;

            background:
                linear-gradient(
                    90deg,
                    rgba(17, 48, 34, .78) 0%,
                    rgba(17, 48, 34, .50) 45%,
                    rgba(17, 48, 34, .15) 100%
                ),
                url('{{ asset('img/imageheader/logistic2.webp') }}')
                center / cover no-repeat;
        }

        /* پیش‌فرض (LTR): متن در سمت چپ */
        .logistics-hero-content {
            max-width: 850px;
            padding: 100px 0;
            color: #fff;
            margin-left: 0;
            margin-right: auto;
            text-align: left;
        }

        /* RTL (فارسی/عربی): متن همچنان در سمت چپ تصویر */
        [dir="rtl"] .logistics-hero-content {
            margin-left: 0;
            margin-right: auto;
            text-align: left;
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
    <div class="logistics-page">

        {{-- =====================================================
             HERO
        ====================================================== --}}

        <section class="logistics-hero">

            <div class="logistics-container">

                <div class="logistics-hero-content">

                <span class="hero-badge">
                    {{ __('logistics.hero.badge') }}
                </span>

                    <h1 style="color:whitesmoke;">
                        {{ __('logistics.hero.title') }}
                    </h1>

                    <p>
                        {{ __('logistics.hero.text') }}
                    </p>

                </div>

            </div>

        </section>


        {{-- =====================================================
             INTRO
        ====================================================== --}}

        <section class="logistics-section intro-section">

            <div class="logistics-container">

                <div class="intro-grid">

                    <div class="intro-image"></div>

                    <div class="intro-content">

                    <span class="eyebrow">
                        {{ __('logistics.intro.eyebrow') }}
                    </span>

                        <h2>
                            {{ __('logistics.intro.title') }}
                        </h2>

                        <p>
                            {{ __('logistics.intro.text') }}
                        </p>

                        <p>
                            {{ __('logistics.intro.text_2') }}
                        </p>

                    </div>

                </div>

            </div>

        </section>


        {{-- =====================================================
             SERVICES
        ====================================================== --}}

        <section class="logistics-section services-section">

            <div class="logistics-container">

                <div class="section-heading">

                <span class="eyebrow">
                    {{ __('logistics.services.eyebrow') }}
                </span>

                    <h2>
                        {{ __('logistics.services.title') }}
                    </h2>

                    <p>
                        {{ __('logistics.services.subtitle') }}
                    </p>

                </div>


                <div class="services-grid">

                    @foreach($services as $service)

                        <article class="service-card">

                            <div class="service-icon">

                                <i class="bi {{ $service['icon'] }}"></i>

                            </div>

                            <h3>
                                {{ __("logistics.services.{$service['key']}.title") }}
                            </h3>

                            <p>
                                {{ __("logistics.services.{$service['key']}.text") }}
                            </p>

                        </article>

                    @endforeach

                </div>

            </div>

        </section>


        {{-- =====================================================
             COLD CHAIN
        ====================================================== --}}

{{--        <section class="logistics-section cold-chain-section">--}}

{{--            <div class="logistics-container">--}}

{{--                <div class="cold-grid">--}}

{{--                    <div class="cold-content">--}}

{{--                    <span class="eyebrow">--}}
{{--                        {{ __('logistics.cold_chain.eyebrow') }}--}}
{{--                    </span>--}}

{{--                        <h2>--}}
{{--                            {{ __('logistics.cold_chain.title') }}--}}
{{--                        </h2>--}}

{{--                        <p>--}}
{{--                            {{ __('logistics.cold_chain.text') }}--}}
{{--                        </p>--}}

{{--                        <p>--}}
{{--                            {{ __('logistics.cold_chain.text_2') }}--}}
{{--                        </p>--}}

{{--                        <ul class="cold-list">--}}

{{--                            @foreach(__('logistics.cold_chain.items') as $item)--}}

{{--                                <li>--}}
{{--                                    <i class="bi bi-check-circle-fill"></i>--}}

{{--                                    <span>--}}
{{--                                    {{ $item }}--}}
{{--                                </span>--}}
{{--                                </li>--}}

{{--                            @endforeach--}}

{{--                        </ul>--}}

{{--                    </div>--}}


{{--                    <div class="cold-image"></div>--}}

{{--                </div>--}}

{{--            </div>--}}

{{--        </section>--}}


        {{-- =====================================================
             PROCESS
        ====================================================== --}}

{{--        <section class="logistics-section process-section">--}}

{{--            <div class="logistics-container">--}}

{{--                <div class="section-heading">--}}

{{--                <span class="eyebrow">--}}
{{--                    {{ __('logistics.process.eyebrow') }}--}}
{{--                </span>--}}

{{--                    <h2>--}}
{{--                        {{ __('logistics.process.title') }}--}}
{{--                    </h2>--}}

{{--                    <p>--}}
{{--                        {{ __('logistics.process.subtitle') }}--}}
{{--                    </p>--}}

{{--                </div>--}}


{{--                <div class="process-grid">--}}

{{--                    @foreach(__('logistics.process.steps') as $step)--}}

{{--                        <article class="process-card">--}}

{{--                            <div class="process-number">--}}
{{--                                {{ $step['number'] }}--}}
{{--                            </div>--}}

{{--                            <h3>--}}
{{--                                {{ $step['title'] }}--}}
{{--                            </h3>--}}

{{--                            <p>--}}
{{--                                {{ $step['text'] }}--}}
{{--                            </p>--}}

{{--                        </article>--}}

{{--                    @endforeach--}}

{{--                </div>--}}

{{--            </div>--}}

{{--        </section>--}}


        {{-- =====================================================
             ADVANTAGES
        ====================================================== --}}

{{--        <section class="logistics-section advantages-section">--}}

{{--            <div class="logistics-container">--}}

{{--                <div class="section-heading">--}}

{{--                <span class="eyebrow">--}}
{{--                    {{ __('logistics.advantages.eyebrow') }}--}}
{{--                </span>--}}

{{--                    <h2>--}}
{{--                        {{ __('logistics.advantages.title') }}--}}
{{--                    </h2>--}}

{{--                </div>--}}


{{--                <div class="advantages-grid">--}}

{{--                    @foreach(__('logistics.advantages.items') as $item)--}}

{{--                        <article class="advantage-card">--}}

{{--                            <h3>--}}
{{--                                {{ $item['title'] }}--}}
{{--                            </h3>--}}

{{--                            <p>--}}
{{--                                {{ $item['text'] }}--}}
{{--                            </p>--}}

{{--                        </article>--}}

{{--                    @endforeach--}}

{{--                </div>--}}

{{--            </div>--}}

{{--        </section>--}}


        {{-- =====================================================
             CTA
        ====================================================== --}}

        <section class="logistics-cta">

            <div class="logistics-container">

                <div class="cta-box">

                    <h2>
                        {{ __('logistics.cta.title') }}
                    </h2>

                    <p>
                        {{ __('logistics.cta.text') }}
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

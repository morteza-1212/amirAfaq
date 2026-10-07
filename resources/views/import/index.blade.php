
@extends('layouts.home')

@section('title', __('import.page_title'))

@section('styles')

    <style>

        /* =========================================================
           IMPORT PAGE
        ========================================================= */

        .import-page {
            overflow: hidden;
            background: #f7f8f4;
            color: #20362a;
        }

        .import-page * {
            box-sizing: border-box;
        }


        /* =========================================================
           HERO
        ========================================================= */

        .import-hero {
            position: relative;
            min-height: 430px;
            display: flex;
            align-items: center;
            overflow: hidden;
            background:
                linear-gradient(
                    90deg,
                    rgba(17, 53, 37, .96),
                    rgba(17, 53, 37, .82),
                    rgba(17, 53, 37, .62)
                ),
                url('{{ asset('img/header/Duck-ai-image-2026-09-27-14-24.jpeg') }}')
                center/cover no-repeat;
        }

        .import-hero::after {
            content: "";
            position: absolute;
            width: 420px;
            height: 420px;
            border: 1px solid rgba(218, 177, 77, .30);
            border-radius: 50%;
            right: -120px;
            top: -100px;
        }

        [dir="rtl"] .import-hero::after {
            right: auto;
            left: -120px;
        }

        .import-hero-container {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 1200px;
            margin: auto;
            padding: 70px 25px;
        }

        .import-hero-content {
            max-width: 760px;
        }

        .import-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 18px;
            color: #d9b24f;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: .8px;
        }

        .import-eyebrow::before {
            content: "";
            width: 38px;
            height: 2px;
            background: #d9b24f;
        }

        .import-hero h1 {
            margin: 0 0 18px;
            color: #fff;
            font-size: clamp(34px, 5vw, 60px);
            line-height: 1.25;
            font-weight: 800;
        }

        .import-hero h1 span {
            color: #d9b24f;
        }

        .import-hero p {
            margin: 0;
            max-width: 680px;
            color: rgba(255,255,255,.86);
            font-size: 17px;
            line-height: 2;
        }


        /* =========================================================
           INTRO
        ========================================================= */

        .import-intro {
            max-width: 1000px;
            margin: auto;
            padding: 85px 25px 60px;
            text-align: center;
        }

        .import-section-label {
            display: block;
            margin-bottom: 12px;
            color: #b38a28;
            font-size: 14px;
            font-weight: 800;
            letter-spacing: .7px;
        }

        .import-intro h2 {
            margin: 0 auto 20px;
            color: #20362a;
            font-size: clamp(28px, 4vw, 42px);
            line-height: 1.5;
            font-weight: 800;
        }

        .import-intro p {
            max-width: 820px;
            margin: auto;
            color: #647067;
            font-size: 16px;
            line-height: 2.1;
        }


        /* =========================================================
           PROCESS
        ========================================================= */

        .import-process {
            max-width: 1200px;
            margin: auto;
            padding: 25px 25px 90px;
        }

        .import-process-header {
            text-align: center;
            margin-bottom: 55px;
        }

        .import-process-header h2 {
            margin: 0;
            color: #20362a;
            font-size: clamp(27px, 4vw, 40px);
            font-weight: 800;
        }

        .import-process-header p {
            margin: 14px auto 0;
            max-width: 700px;
            color: #737c76;
            line-height: 2;
        }


        /* =========================================================
           STEPS
        ========================================================= */

        .import-steps {
            position: relative;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
        }

        .import-steps::before {
            content: "";
            position: absolute;
            top: 45px;
            bottom: 45px;
            width: 1px;
            background: linear-gradient(
                to bottom,
                transparent,
                rgba(179,138,40,.45),
                transparent
            );
            left: 50%;
        }

        .import-step {
            position: relative;
            display: flex;
            align-items: flex-start;
            gap: 22px;
            min-height: 150px;
            padding: 30px;
            background: #fff;
            border: 1px solid rgba(32,54,42,.08);
            border-radius: 18px;
            box-shadow: 0 10px 35px rgba(30,55,40,.06);
            transition: all .3s ease;
        }

        .import-step:hover {
            transform: translateY(-5px);
            border-color: rgba(179,138,40,.35);
            box-shadow: 0 18px 45px rgba(30,55,40,.10);
        }

        .import-step-number {
            flex: 0 0 62px;
            width: 62px;
            height: 62px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #20362a;
            color: #d9b24f;
            font-size: 20px;
            font-weight: 800;
            border: 5px solid #eef1eb;
        }

        .import-step-content {
            flex: 1;
        }

        .import-step-content h3 {
            margin: 3px 0 9px;
            color: #20362a;
            font-size: 19px;
            font-weight: 800;
        }

        .import-step-content p {
            margin: 0;
            color: #737c76;
            font-size: 14px;
            line-height: 1.9;
        }


        /* =========================================================
           CTA
        ========================================================= */

        .import-cta {
            position: relative;
            max-width: 1150px;
            margin: 0 auto 90px;
            padding: 60px 50px;
            overflow: hidden;
            border-radius: 24px;
            background:
                linear-gradient(
                    120deg,
                    #183c2b,
                    #28563f
                );
            text-align: center;
        }

        .import-cta::before,
        .import-cta::after {
            content: "";
            position: absolute;
            border: 1px solid rgba(217,178,79,.18);
            border-radius: 50%;
        }

        .import-cta::before {
            width: 280px;
            height: 280px;
            left: -120px;
            top: -130px;
        }

        .import-cta::after {
            width: 220px;
            height: 220px;
            right: -90px;
            bottom: -110px;
        }

        .import-cta-content {
            position: relative;
            z-index: 2;
        }

        .import-cta h2 {
            margin: 0 0 15px;
            color: #fff;
            font-size: clamp(26px, 4vw, 38px);
            font-weight: 800;
        }

        .import-cta p {
            max-width: 700px;
            margin: 0 auto 28px;
            color: rgba(255,255,255,.78);
            line-height: 2;
        }

        .import-cta-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 180px;
            padding: 13px 28px;
            border-radius: 50px;
            background: #d9b24f;
            color: #20362a;
            font-size: 15px;
            font-weight: 800;
            text-decoration: none;
            transition: all .3s ease;
        }

        .import-cta-button:hover {
            background: #fff;
            color: #20362a;
            transform: translateY(-3px);
        }


        /* =========================================================
           RTL
        ========================================================= */

        [dir="rtl"] .import-eyebrow::before {
            order: 2;
        }

        [dir="rtl"] .import-step {
            text-align: right;
        }


        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 991px) {

            .import-hero {
                min-height: 380px;
            }

            .import-steps {
                grid-template-columns: 1fr;
            }

            .import-steps::before {
                display: none;
            }

            .import-step {
                min-height: auto;
            }

        }


        @media (max-width: 575px) {

            .import-hero-container {
                padding: 60px 20px;
            }

            .import-hero p {
                font-size: 15px;
            }

            .import-intro {
                padding: 65px 20px 40px;
            }

            .import-process {
                padding: 20px 15px 65px;
            }

            .import-step {
                gap: 15px;
                padding: 22px 18px;
                border-radius: 14px;
            }

            .import-step-number {
                flex: 0 0 52px;
                width: 52px;
                height: 52px;
                font-size: 17px;
            }

            .import-step-content h3 {
                font-size: 17px;
            }

            .import-cta {
                margin: 0 15px 60px;
                padding: 45px 22px;
                border-radius: 18px;
            }

        }
        /* پیش‌فرض (LTR): متن در سمت چپ */
        .import-hero-content {
            max-width: 760px;
            margin-left: 0;
            margin-right: auto;
            text-align: left;
        }

        /* RTL: متن همچنان در سمت چپ تصویر */
        [dir="rtl"] .import-hero-content {
            margin-left: 0;
            margin-right: auto;
            text-align: left;
        }

    </style>

@endsection


@section('content')

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

                <a href="{{ url(app()->getLocale() . '/contact') }}"
                   class="import-cta-button">
                    {{ __('import.cta_button') }}
                </a>

            </div>

        </section>

    </div>

@endsection

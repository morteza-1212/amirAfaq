@extends('layouts.home')

@section('title', __('export_blog.title'))

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/blog/export.css') }}?v=2" media="print" onload="this.media='all'">
    <style>
        /* =========================================================
           چیدمان پایه: مقاله اصلی
           ========================================================= */
        .export-blog {
            max-width: 900px;
            margin: 0 auto;
            padding: 2rem 1rem;
            line-height: 2;
        }

        .export-blog h1 { font-size: 2rem; margin-bottom: .5rem; }
        .export-blog h2 {
            margin-top: 2.5rem;
            font-size: 1.4rem;
            border-inline-start: 4px solid #2f855a;
            padding-inline-start: .75rem;
        }
        .export-blog h3 { margin-top: 1.5rem; font-size: 1.15rem; }
        .export-blog .meta { color: #718096; font-size: .9rem; margin-bottom: 2rem; }
        .export-blog .note {
            background: #f0fff4;
            border: 1px solid #c6f6d5;
            padding: 1rem;
            border-radius: .5rem;
            margin: 1.5rem 0;
        }
        .export-blog table { width: 100%; border-collapse: collapse; margin: 1.5rem 0; }
        .export-blog th,
        .export-blog td { border: 1px solid #e2e8f0; padding: .6rem; }
        .export-blog th { background: #f7fafc; }
        .export-blog .toc {
            background: #f7fafc;
            padding: 1rem 1.5rem;
            border-radius: .5rem;
        }
        .export-blog .lang-switch { text-align: center; margin-bottom: 1.5rem; }
        .export-blog .lang-switch a {
            margin: 0 .5rem;
            text-decoration: none;
            color: #2f855a;
            font-weight: bold;
        }

        /* =========================================================
           چیدمان دو ستونی: لوگو (fixed) + محتوای اصلی
           ========================================================= */
        .export-layout {
            direction: rtl;
            padding-left: 420px;   /* فضای خالی سمت چپ برای لوگو در دسکتاپ بزرگ */
        }

        /* =========================================================
           لوگوی ثابت سمت چپ
           ========================================================= */
        .export-logo {
            position: fixed;
            top: 120px;
            left: 200px;
            width: clamp(220px, 20vw, 300px);
            z-index: 50;
            margin-top: 5%;
        }

        .export-logo img {
            width: 100%;
            height: auto;
            border-radius: .75rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .12);
            background: #fff;
            padding: .5rem;
            display: block;
        }

        /* =========================================================
           دسکتاپ متوسط (۱۲۰۰px تا ۱۴۰۰px)
           ========================================================= */
        @media (max-width: 1400px) {
            .export-layout {
                padding-left: 340px;
            }
            .export-logo {
                left: 150px;
                width: clamp(180px, 18vw, 250px);
            }
        }

        /* =========================================================
           لپ‌تاپ (۱۰۰۰px تا ۱۲۰۰px)
           ========================================================= */
        @media (max-width: 1200px) {
            .export-layout {
                padding-left: 260px;
            }
            .export-logo {
                left: 100px;
                width: clamp(150px, 16vw, 200px);
                top: 110px;
            }
        }

        /* =========================================================
           تبلت افقی (۹۰۰px تا ۱۰۰۰px)
           ========================================================= */
        @media (max-width: 1000px) {
            .export-layout {
                padding-left: 200px;
            }
            .export-logo {
                left: 30px;
                width: clamp(130px, 15vw, 160px);
                top: 100px;
            }
            .export-logo img {
                padding: .35rem;
            }
        }

        /* =========================================================
           تبلت عمودی (۷۶۸px تا ۹۰۰px)
           ========================================================= */
        @media (max-width: 900px) {
            .export-layout {
                padding-left: 160px;
            }
            .export-logo {
                left: 20px;
                width: 130px;
            }
        }

        /* =========================================================
           موبایل (کمتر از ۷۶۸px) — لوگو بالای محتوا
           ========================================================= */
        @media (max-width: 768px) {
            .export-layout {
                padding-left: 0;
                padding-top: 1rem;
            }
            .export-logo {
                position: static;
                top: auto;
                left: auto;
                width: 100%;
                max-width: 180px;
                margin: 0 auto 1rem;
            }
            .export-logo img {
                padding: .4rem;
            }

            /* بهبود نمایش جدول در موبایل */
            .export-blog table {
                font-size: .85rem;
            }
            .export-blog th,
            .export-blog td {
                padding: .4rem;
            }
        }

        /* =========================================================
           موبایل کوچک (کمتر از ۴۸۰px)
           ========================================================= */
        @media (max-width: 480px) {
            .export-logo {
                max-width: 140px;
            }
            .export-logo img {
                padding: .3rem;
                border-radius: .5rem;
            }
            .export-blog h1 { font-size: 1.4rem; }
            .export-blog h2 { font-size: 1.15rem; }
            .export-blog h3 { font-size: 1rem; }
            .export-blog {
                padding: 1rem .75rem;
            }
        }

        /* =========================================================
           موبایل خیلی کوچک (کمتر از ۳۶۰px)
           ========================================================= */
        @media (max-width: 360px) {
            .export-logo {
                max-width: 110px;
            }
            .export-blog h1 { font-size: 1.25rem; }
        }
    </style>
@endpush

@php
    $steps = [
        ['title' => __('export_blog.step_1_title'), 'desc' => __('export_blog.step_1_desc')],
        ['title' => __('export_blog.step_2_title'), 'desc' => __('export_blog.step_2_desc')],
        ['title' => __('export_blog.step_3_title'), 'desc' => __('export_blog.step_3_desc')],
        ['title' => __('export_blog.step_4_title'), 'desc' => __('export_blog.step_4_desc')],
        ['title' => __('export_blog.step_5_title'), 'desc' => __('export_blog.step_5_desc')],
        ['title' => __('export_blog.step_6_title'), 'desc' => __('export_blog.step_6_desc')],
        ['title' => __('export_blog.step_7_title'), 'desc' => __('export_blog.step_7_desc')],
    ];

    $documents = [
        __('export_blog.doc_1'),
        __('export_blog.doc_2'),
        __('export_blog.doc_3'),
        __('export_blog.doc_4'),
        __('export_blog.doc_5'),
        __('export_blog.doc_6'),
        __('export_blog.doc_7'),
    ];
@endphp

@section('content')
    {{-- ===== لایه دو ستونی: لوگو + محتوا ===== --}}
    <div class="export-layout">

        {{-- ===== لوگوی ثابت سمت چپ ===== --}}
        <aside class="export-logo" aria-label="{{ __('export_blog.title') }}">
            {{-- مسیر تصویر لوگو را جایگزین کنید --}}
            <img src="{{ asset('img/markets/Duck-ai-image-2026-10-06-15-41.webp') }}"
                 alt="{{ __('export_blog.title') }}">
        </aside>

        {{-- ===== محتوای اصلی صفحه (بدون تغییر) ===== --}}
        <div class="export-blog">

            {{-- Language Switch --}}
            {{-- <div class="lang-switch">
                <a href="{{ url('/fa/blog/export') }}">{{ __('export_blog.lang_fa') }}</a> |
                <a href="{{ url('/ar/blog/export') }}">{{ __('export_blog.lang_ar') }}</a> |
                <a href="{{ url('/en/blog/export') }}">{{ __('export_blog.lang_en') }}</a>
            </div> --}}

            <article>

                {{-- Header --}}
                <header>
                    <h1>{{ __('export_blog.title') }}</h1>
                    <p class="meta">
                        {{ __('export_blog.author') }}
                        &middot;
                        {{ __('export_blog.read_time') }}
                        &middot;
                        {{ __('export_blog.published') }}: {{ now()->format('Y/m/d') }}
                    </p>
                </header>

                {{-- Table of Contents --}}
                <nav class="toc" aria-label="{{ __('export_blog.toc') }}">
                    <strong>{{ __('export_blog.toc') }}</strong>
                    <ol>
                        <li><a href="#intro">{{ __('export_blog.toc_intro') }}</a></li>
                        <li><a href="#why">{{ __('export_blog.toc_why') }}</a></li>
                        <li><a href="#steps">{{ __('export_blog.toc_steps') }}</a></li>
                        <li><a href="#docs">{{ __('export_blog.toc_docs') }}</a></li>
                        <li><a href="#transport">{{ __('export_blog.toc_transport') }}</a></li>
                        <li><a href="#payment">{{ __('export_blog.toc_payment') }}</a></li>
                        <li><a href="#risks">{{ __('export_blog.toc_risks') }}</a></li>
                        <li><a href="#tips">{{ __('export_blog.toc_tips') }}</a></li>
                        <li><a href="#faq">{{ __('export_blog.toc_faq') }}</a></li>
                    </ol>
                </nav>

                {{-- Introduction --}}
                <section id="intro">
                    <h2>{{ __('export_blog.intro_title') }}</h2>
                    <p>{{ __('export_blog.intro_text') }}</p>
                </section>

                {{-- Why Neighbors --}}
                <section id="why">
                    <h2>{{ __('export_blog.why_title') }}</h2>
                    <ul>
                        <li><strong>{{ __('export_blog.why_1_title') }}:</strong> {{ __('export_blog.why_1_desc') }}</li>
                        <li><strong>{{ __('export_blog.why_2_title') }}:</strong> {{ __('export_blog.why_2_desc') }}</li>
                        <li><strong>{{ __('export_blog.why_3_title') }}:</strong> {{ __('export_blog.why_3_desc') }}</li>
                        <li><strong>{{ __('export_blog.why_4_title') }}:</strong> {{ __('export_blog.why_4_desc') }}</li>
                    </ul>
                    <div class="note">
                        {{ __('export_blog.why_note') }}
                    </div>
                </section>

                {{-- Steps --}}
                <section id="steps">
                    <h2>{{ __('export_blog.steps_title') }}</h2>
                    @foreach ($steps as $index => $step)
                        <h3>{{ $index + 1 }}. {{ $step['title'] }}</h3>
                        <p>{{ $step['desc'] }}</p>
                    @endforeach
                </section>

                {{-- Documents --}}
                <section id="docs">
                    <h2>{{ __('export_blog.docs_title') }}</h2>
                    <p>{{ __('export_blog.docs_intro') }}</p>
                    <ul>
                        @forelse ($documents as $doc)
                            <li>{{ $doc }}</li>
                        @empty
                            <li>{{ __('export_blog.docs_empty') }}</li>
                        @endforelse
                    </ul>
                </section>

                {{-- Transport --}}
                <section id="transport">
                    <h2>{{ __('export_blog.transport_title') }}</h2>
                    <table>
                        <thead>
                        <tr>
                            <th>{{ __('export_blog.transport_method') }}</th>
                            <th>{{ __('export_blog.transport_advantage') }}</th>
                            <th>{{ __('export_blog.transport_limit') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{ __('export_blog.transport_road') }}</td>
                            <td>{{ __('export_blog.transport_road_adv') }}</td>
                            <td>{{ __('export_blog.transport_road_lim') }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('export_blog.transport_rail') }}</td>
                            <td>{{ __('export_blog.transport_rail_adv') }}</td>
                            <td>{{ __('export_blog.transport_rail_lim') }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('export_blog.transport_sea') }}</td>
                            <td>{{ __('export_blog.transport_sea_adv') }}</td>
                            <td>{{ __('export_blog.transport_sea_lim') }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('export_blog.transport_air') }}</td>
                            <td>{{ __('export_blog.transport_air_adv') }}</td>
                            <td>{{ __('export_blog.transport_air_lim') }}</td>
                        </tr>
                        </tbody>
                    </table>
                    <p>{{ __('export_blog.transport_note') }}</p>
                </section>

                {{-- Payment --}}
                <section id="payment">
                    <h2>{{ __('export_blog.payment_title') }}</h2>
                    <p>{{ __('export_blog.payment_text') }}</p>
                </section>

                {{-- Risks --}}
                <section id="risks">
                    <h2>{{ __('export_blog.risks_title') }}</h2>
                    <ul>
                        <li><strong>{{ __('export_blog.risk_1_title') }}:</strong> {{ __('export_blog.risk_1_desc') }}</li>
                        <li><strong>{{ __('export_blog.risk_2_title') }}:</strong> {{ __('export_blog.risk_2_desc') }}</li>
                        <li><strong>{{ __('export_blog.risk_3_title') }}:</strong> {{ __('export_blog.risk_3_desc') }}</li>
                        <li><strong>{{ __('export_blog.risk_4_title') }}:</strong> {{ __('export_blog.risk_4_desc') }}</li>
                    </ul>
                </section>

                {{-- Tips --}}
                <section id="tips">
                    <h2>{{ __('export_blog.tips_title') }}</h2>
                    <ol>
                        <li>{{ __('export_blog.tip_1') }}</li>
                        <li>{{ __('export_blog.tip_2') }}</li>
                        <li>{{ __('export_blog.tip_3') }}</li>
                        <li>{{ __('export_blog.tip_4') }}</li>
                        <li>{{ __('export_blog.tip_5') }}</li>
                    </ol>
                </section>

                {{-- FAQ --}}
                <section id="faq">
                    <h2>{{ __('export_blog.faq_title') }}</h2>

                    <h3>{{ __('export_blog.faq_q1') }}</h3>
                    <p>{{ __('export_blog.faq_a1') }}</p>

                    <h3>{{ __('export_blog.faq_q2') }}</h3>
                    <p>{{ __('export_blog.faq_a2') }}</p>

                    <h3>{{ __('export_blog.faq_q3') }}</h3>
                    <p>{{ __('export_blog.faq_a3') }}</p>
                </section>

                {{-- Footer --}}
{{--                <footer style="margin-top:3rem;">--}}
{{--                    <a href="{{ url('/' . app()->getLocale() . '/blog') }}">--}}
{{--                        &rarr; {{ __('export_blog.back_to_blog') }}--}}
{{--                    </a>--}}
{{--                </footer>--}}

            </article>
        </div>

    </div>
@endsection

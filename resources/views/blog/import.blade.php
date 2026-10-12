@extends('layouts.home')

@section('title', __('blog_import.title'))

@section('meta')
    <meta name="description" content="{{ __('blog_import.meta_description') }}">
    <meta name="keywords" content="{{ __('blog_import.meta_keywords') }}">
    <meta property="og:title" content="{{ __('blog_import.title') }}">
    <meta property="og:description" content="{{ __('blog_import.meta_description') }}">
    <meta property="og:type" content="article">
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/blog/import.css') }}?v=2">

    <style>
        /* =========================================================
           چیدمان دو ستونی: لوگو (fixed) + محتوای اصلی
           ========================================================= */
        .import-layout {
            direction: rtl;
            padding-left: 420px;   /* فضای خالی سمت چپ برای لوگو در دسکتاپ بزرگ */
        }

        /* =========================================================
           لوگوی ثابت سمت چپ
           ========================================================= */
        .import-logo {
            position: fixed;
            top: 120px;
            left: 200px;
            width: clamp(220px, 20vw, 300px);
            z-index: 50;
            margin-top: 20%;
        }

        .import-logo img {
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
            .import-layout {
                padding-left: 340px;
            }
            .import-logo {
                left: 150px;
                width: clamp(180px, 18vw, 250px);
            }
        }

        /* =========================================================
           لپ‌تاپ (۱۰۰۰px تا ۱۲۰۰px)
           ========================================================= */
        @media (max-width: 1200px) {
            .import-layout {
                padding-left: 260px;
            }
            .import-logo {
                left: 100px;
                width: clamp(150px, 16vw, 200px);
                top: 110px;
            }
        }

        /* =========================================================
           تبلت افقی (۹۰۰px تا ۱۰۰۰px)
           ========================================================= */
        @media (max-width: 1000px) {
            .import-layout {
                padding-left: 200px;
            }
            .import-logo {
                left: 30px;
                width: clamp(130px, 15vw, 160px);
                top: 100px;
            }
            .import-logo img {
                padding: .35rem;
            }
        }

        /* =========================================================
           تبلت عمودی (۷۶۸px تا ۹۰۰px)
           ========================================================= */
        @media (max-width: 900px) {
            .import-layout {
                padding-left: 160px;
            }
            .import-logo {
                left: 20px;
                width: 130px;
            }
        }

        /* =========================================================
           موبایل (کمتر از ۷۶۸px) — لوگو بالای محتوا
           ========================================================= */
        @media (max-width: 768px) {
            .import-layout {
                padding-left: 0;
                padding-top: 1rem;
            }
            .import-logo {
                position: static;
                top: auto;
                left: auto;
                width: 100%;
                max-width: 180px;
                margin: 0 auto 1rem;
            }
            .import-logo img {
                padding: .4rem;
            }
        }

        /* =========================================================
           موبایل کوچک (کمتر از ۴۸۰px)
           ========================================================= */
        @media (max-width: 480px) {
            .import-logo {
                max-width: 140px;
            }
            .import-logo img {
                padding: .3rem;
                border-radius: .5rem;
            }
        }

        /* =========================================================
           موبایل خیلی کوچک (کمتر از ۳۶۰px)
           ========================================================= */
        @media (max-width: 360px) {
            .import-logo {
                max-width: 110px;
            }
        }
    </style>
@endpush

@php
    $keyPoints = [
        ['title' => __('blog_import.kp_1_title'), 'desc' => __('blog_import.kp_1_desc')],
        ['title' => __('blog_import.kp_2_title'), 'desc' => __('blog_import.kp_2_desc')],
        ['title' => __('blog_import.kp_3_title'), 'desc' => __('blog_import.kp_3_desc')],
        ['title' => __('blog_import.kp_4_title'), 'desc' => __('blog_import.kp_4_desc')],
        ['title' => __('blog_import.kp_5_title'), 'desc' => __('blog_import.kp_5_desc')],
        ['title' => __('blog_import.kp_6_title'), 'desc' => __('blog_import.kp_6_desc')],
    ];

    $documents = [
        __('blog_import.doc_1'),
        __('blog_import.doc_2'),
        __('blog_import.doc_3'),
        __('blog_import.doc_4'),
        __('blog_import.doc_5'),
        __('blog_import.doc_6'),
        __('blog_import.doc_7'),
    ];

    $temperatures = [
        [
            'product' => __('blog_import.temp_1_product'),
            'degree'  => __('blog_import.temp_1_degree'),
            'note'    => __('blog_import.temp_1_note'),
        ],
        [
            'product' => __('blog_import.temp_2_product'),
            'degree'  => __('blog_import.temp_2_degree'),
            'note'    => __('blog_import.temp_2_note'),
        ],
        [
            'product' => __('blog_import.temp_3_product'),
            'degree'  => __('blog_import.temp_3_degree'),
            'note'    => __('blog_import.temp_3_note'),
        ],
        [
            'product' => __('blog_import.temp_4_product'),
            'degree'  => __('blog_import.temp_4_degree'),
            'note'    => __('blog_import.temp_4_note'),
        ],
        [
            'product' => __('blog_import.temp_5_product'),
            'degree'  => __('blog_import.temp_5_degree'),
            'note'    => __('blog_import.temp_5_note'),
        ],
    ];

    $transportTips = [
        __('blog_import.transport_tip_1'),
        __('blog_import.transport_tip_2'),
        __('blog_import.transport_tip_3'),
        __('blog_import.transport_tip_4'),
        __('blog_import.transport_tip_5'),
    ];

    $commonMistakes = [
        __('blog_import.mistake_1'),
        __('blog_import.mistake_2'),
        __('blog_import.mistake_3'),
        __('blog_import.mistake_4'),
        __('blog_import.mistake_5'),
    ];

    $faqs = [
        ['q' => __('blog_import.faq_q1'), 'a' => __('blog_import.faq_a1')],
        ['q' => __('blog_import.faq_q2'), 'a' => __('blog_import.faq_a2')],
        ['q' => __('blog_import.faq_q3'), 'a' => __('blog_import.faq_a3')],
    ];
@endphp

@section('content')
    {{-- ===== لایه جدید دو ستونی ===== --}}
    <div class="import-layout">

        {{-- ===== لوگوی ثابت سمت چپ ===== --}}
        <aside class="import-logo" aria-label="{{ __('blog_import.title') }}">
            {{-- مسیر تصویر لوگو را جایگزین کنید --}}
            <img src="{{ asset('img/markets/Duck-ai-image-2026-10-06-15-41.webp') }}"
                 alt="{{ __('blog_import.title') }}">
        </aside>

        {{-- ===== محتوای اصلی صفحه (بدون تغییر) ===== --}}
        <div class="export-blog-page blog-import-page">

            {{-- Hero --}}
            <section class="export-blog-hero">
                <div class="container">
                    <div class="export-blog-hero-inner">
                        <span class="export-blog-label">{{ __('blog_import.hero_label') }}</span>
                        <h1>{{ __('blog_import.title') }}</h1>
                        <p class="export-blog-hero-desc">{{ __('blog_import.hero_description') }}</p>

                        <ul class="export-blog-meta">
                            <li>
                                <i class="fa fa-user"></i>
                                {{ __('blog_import.author') }}
                            </li>
                            <li>
                                <i class="fa fa-clock-o"></i>
                                {{ __('blog_import.read_time') }}
                            </li>
                            <li>
                                <i class="fa fa-calendar"></i>
                                {{ __('blog_import.published') }}: {{ now()->format('Y/m/d') }}
                            </li>
                        </ul>
                    </div>
                </div>
            </section>

            {{-- Body --}}
            <section class="export-blog-body">
                <div class="container">
                    <div class="export-blog-grid">

                        {{-- Sidebar TOC --}}
                        <aside class="export-blog-sidebar">
                            <nav class="export-blog-toc" aria-label="{{ __('blog_import.toc') }}">
                                <strong class="export-blog-toc-title">
                                    <i class="fa fa-list-ul"></i>
                                    {{ __('blog_import.toc') }}
                                </strong>
                                <ol>
                                    <li><a href="#intro">{{ __('blog_import.toc_intro') }}</a></li>
                                    <li><a href="#key-points">{{ __('blog_import.toc_key_points') }}</a></li>
                                    <li><a href="#docs">{{ __('blog_import.toc_docs') }}</a></li>
                                    <li><a href="#cold-chain">{{ __('blog_import.toc_cold_chain') }}</a></li>
                                    <li><a href="#temperature">{{ __('blog_import.toc_temperature') }}</a></li>
                                    <li><a href="#transport">{{ __('blog_import.toc_transport') }}</a></li>
                                    <li><a href="#storage">{{ __('blog_import.toc_storage') }}</a></li>
                                    <li><a href="#risks">{{ __('blog_import.toc_risks') }}</a></li>
                                    <li><a href="#faq">{{ __('blog_import.toc_faq') }}</a></li>
                                </ol>
                            </nav>
                        </aside>

                        {{-- Article --}}
                        <article class="export-blog-article">

                            {{-- Intro --}}
                            <section id="intro" class="export-blog-section">
                                <h2>{{ __('blog_import.intro_title') }}</h2>
                                <p>{!! __('blog_import.intro_text') !!}</p>
                            </section>

                            {{-- Key Points --}}
                            <section id="key-points" class="export-blog-section">
                                <h2>{{ __('blog_import.key_points_title') }}</h2>

                                <div class="export-blog-steps">
                                    @foreach ($keyPoints as $index => $point)
                                        <div class="export-blog-step">
                                            <div class="export-blog-step-num">{{ $index + 1 }}</div>
                                            <div class="export-blog-step-body">
                                                <h3>{{ $point['title'] }}</h3>
                                                <p>{{ $point['desc'] }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="export-blog-note">
                                    <i class="fa fa-info-circle"></i>
                                    <span>{{ __('blog_import.key_points_note') }}</span>
                                </div>
                            </section>

                            {{-- Documents --}}
                            <section id="docs" class="export-blog-section">
                                <h2>{{ __('blog_import.docs_title') }}</h2>
                                <p>{{ __('blog_import.docs_intro') }}</p>
                                <ul class="export-blog-docs">
                                    @forelse ($documents as $doc)
                                        <li>
                                            <i class="fa fa-check-circle"></i>
                                            <span>{{ $doc }}</span>
                                        </li>
                                    @empty
                                        <li>{{ __('blog_import.docs_empty') }}</li>
                                    @endforelse
                                </ul>
                            </section>

                            {{-- Cold Chain --}}
                            <section id="cold-chain" class="export-blog-section">
                                <h2>{{ __('blog_import.cold_chain_title') }}</h2>
                                <p>{{ __('blog_import.cold_chain_text') }}</p>

                                <div class="export-blog-note">
                                    <i class="fa fa-exclamation-triangle"></i>
                                    <span>{{ __('blog_import.cold_chain_warning') }}</span>
                                </div>
                            </section>

                            {{-- Temperature --}}
                            <section id="temperature" class="export-blog-section">
                                <h2>{{ __('blog_import.temperature_title') }}</h2>
                                <p>{{ __('blog_import.temperature_intro') }}</p>

                                <div class="export-blog-table-wrap">
                                    <table class="export-blog-table">
                                        <thead>
                                        <tr>
                                            <th>{{ __('blog_import.temp_col_product') }}</th>
                                            <th>{{ __('blog_import.temp_col_degree') }}</th>
                                            <th>{{ __('blog_import.temp_col_note') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($temperatures as $row)
                                            <tr>
                                                <td data-label="{{ __('blog_import.temp_col_product') }}">{{ $row['product'] }}</td>
                                                <td data-label="{{ __('blog_import.temp_col_degree') }}">{{ $row['degree'] }}</td>
                                                <td data-label="{{ __('blog_import.temp_col_note') }}">{{ $row['note'] }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </section>

                            {{-- Transport --}}
                            <section id="transport" class="export-blog-section">
                                <h2>{{ __('blog_import.transport_title') }}</h2>
                                <ul class="export-blog-list">
                                    @foreach ($transportTips as $tip)
                                        <li>{{ $tip }}</li>
                                    @endforeach
                                </ul>
                            </section>

                            {{-- Storage --}}
                            <section id="storage" class="export-blog-section">
                                <h2>{{ __('blog_import.storage_title') }}</h2>
                                <p>{{ __('blog_import.storage_text') }}</p>
                            </section>

                            {{-- Common Mistakes --}}
                            <section id="risks" class="export-blog-section">
                                <h2>{{ __('blog_import.mistakes_title') }}</h2>
                                <ol class="export-blog-tips">
                                    @foreach ($commonMistakes as $mistake)
                                        <li>{{ $mistake }}</li>
                                    @endforeach
                                </ol>
                            </section>

                            {{-- FAQ --}}
                            <section id="faq" class="export-blog-section">
                                <h2>{{ __('blog_import.faq_title') }}</h2>

                                <div class="export-blog-faq">
                                    @foreach ($faqs as $faq)
                                        <details class="export-blog-faq-item">
                                            <summary>{{ $faq['q'] }}</summary>
                                            <p>{{ $faq['a'] }}</p>
                                        </details>
                                    @endforeach
                                </div>
                            </section>

                            {{-- Footer --}}
                            <footer class="export-blog-footer">
                                <a href="" class="export-blog-back">
                                    <i class="fa fa-arrow-left"></i>
                                    {{ __('blog_import.back_to_blog') }}
                                </a>
                            </footer>

                        </article>
                    </div>
                </div>
            </section>

        </div>
    </div>
@endsection

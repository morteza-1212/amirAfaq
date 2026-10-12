@extends('layouts.home')

@section('title', __('market.title'))

@section('meta')
    <meta name="description" content="{{ __('market.meta_description') }}">
    <meta name="keywords" content="{{ __('market.meta_keywords') }}">
    <meta property="og:title" content="{{ __('market.title') }}">
    <meta property="og:description" content="{{ __('market.meta_description') }}">
    <meta property="og:type" content="article">
@endsection

@push('styles')
    <style>
        /* =========================================================
           چیدمان پایه دو ستونی (دسکتاپ بزرگ ≥ 1400px)
           ========================================================= */
        .article-layout {
            display: flex;
            gap: 2rem;
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem 1rem 2rem 420px;
            direction: rtl;
            align-items: flex-start;
        }

        /* در حالت LTR (انگلیسی) آینه می‌شود */
        html[dir="ltr"] .article-layout {
            direction: ltr;
            padding: 2rem 420px 2rem 1rem;
        }
        html[dir="ltr"] .article {
            text-align: left;
        }
        html[dir="ltr"] .article h2 {
            border-right: none;
            border-left: 4px solid #d69e2e;
            padding-right: 0;
            padding-left: .75rem;
        }
        html[dir="ltr"] .logo-sidebar {
            left: auto;
            right: 200px;
        }

        /* =========================================================
           ستون مقاله
           ========================================================= */
        .article {
            order: 1;
            flex: 1 1 auto;
            max-width: 820px;
            line-height: 2;
            direction: rtl;
            text-align: right;
            min-width: 0;
        }

        /* =========================================================
           لوگو: تنظیمات پایه
           ========================================================= */
        .logo-sidebar {
            position: fixed;
            top: 120px;
            left: 200px;
            width: clamp(220px, 20vw, 300px);
            z-index: 50;
            margin-top: 5%;
        }

        .logo-sidebar img {
            width: 100%;
            height: auto;
            border-radius: .75rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .12);
            background: #fff;
            padding: .5rem;
            display: block;
        }

        /* =========================================================
           استایل‌های محتوای مقاله
           ========================================================= */
        .article h1 {
            font-size: clamp(1.5rem, 2.4vw, 2rem);
            margin-bottom: .5rem;
            line-height: 1.4;
        }
        .article h2 {
            margin-top: 2.5rem;
            font-size: clamp(1.15rem, 1.8vw, 1.4rem);
            border-right: 4px solid #d69e2e;
            padding-right: .75rem;
        }
        .article h3 {
            font-size: clamp(1rem, 1.5vw, 1.15rem);
            margin-top: 1.5rem;
        }
        .article .meta {
            color: #718096;
            font-size: .9rem;
            margin-bottom: 2rem;
        }
        .article .note {
            background: #fffff0;
            border: 1px solid #fefcbf;
            padding: 1rem;
            border-radius: .5rem;
            margin: 1.5rem 0;
        }
        .article .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
            gap: 1rem;
            margin: 1.5rem 0;
        }
        .article .card {
            border: 1px solid #e2e8f0;
            border-radius: .5rem;
            padding: 1rem;
            background: #fff;
        }
        .article .card h3 {
            margin-top: 0;
            font-size: 1.1rem;
        }
        .article table {
            width: 100%;
            border-collapse: collapse;
            margin: 1.5rem 0;
            font-size: clamp(.85rem, 1vw, 1rem);
        }
        .article th,
        .article td {
            border: 1px solid #e2e8f0;
            padding: .6rem;
            text-align: right;
        }
        html[dir="ltr"] .article th,
        html[dir="ltr"] .article td {
            text-align: left;
        }
        .article th {
            background: #f7fafc;
        }
        .toc {
            background: #f7fafc;
            padding: 1rem 1.5rem;
            border-radius: .5rem;
        }
        .toc ol {
            margin: 0;
            padding-right: 1.25rem;
        }
        html[dir="ltr"] .toc ol {
            padding-right: 0;
            padding-left: 1.25rem;
        }
        .toc a {
            color: #2b6cb0;
            text-decoration: none;
        }
        .toc a:hover {
            text-decoration: underline;
        }

        /* =========================================================
           دسکتاپ متوسط (۱۲۰۰px تا ۱۴۰۰px)
           ========================================================= */
        @media (max-width: 1400px) {
            .article-layout {
                padding-left: 340px;
            }
            html[dir="ltr"] .article-layout {
                padding-left: 1rem;
                padding-right: 340px;
            }
            .logo-sidebar {
                left: 150px;
                width: clamp(180px, 18vw, 250px);
            }
            html[dir="ltr"] .logo-sidebar {
                left: auto;
                right: 150px;
            }
        }

        /* =========================================================
           لپ‌تاپ (۱۰۰۰px تا ۱۲۰۰px)
           ========================================================= */
        @media (max-width: 1200px) {
            .article-layout {
                padding-left: 260px;
            }
            html[dir="ltr"] .article-layout {
                padding-left: 1rem;
                padding-right: 260px;
            }
            .logo-sidebar {
                left: 100px;
                width: clamp(150px, 16vw, 200px);
                top: 110px;
            }
            html[dir="ltr"] .logo-sidebar {
                left: auto;
                right: 100px;
            }
        }

        /* =========================================================
           تبلت افقی (۹۰۰px تا ۱۰۰۰px)
           ========================================================= */
        @media (max-width: 1000px) {
            .article-layout {
                padding-left: 200px;
            }
            html[dir="ltr"] .article-layout {
                padding-left: 1rem;
                padding-right: 200px;
            }
            .logo-sidebar {
                left: 30px;
                width: clamp(130px, 15vw, 160px);
                top: 100px;
            }
            html[dir="ltr"] .logo-sidebar {
                left: auto;
                right: 30px;
            }
            .logo-sidebar img {
                padding: .35rem;
            }
        }

        /* =========================================================
           تبلت عمودی (۷۶۸px تا ۹۰۰px)
           ========================================================= */
        @media (max-width: 900px) {
            .article-layout {
                padding-left: 160px;
            }
            html[dir="ltr"] .article-layout {
                padding-left: 1rem;
                padding-right: 160px;
            }
            .logo-sidebar {
                left: 20px;
                width: 130px;
            }
            html[dir="ltr"] .logo-sidebar {
                left: auto;
                right: 20px;
            }
        }

        /* =========================================================
           موبایل (کمتر از ۷۶۸px) — لوگو از حالت fixed خارج می‌شود
           ========================================================= */
        @media (max-width: 768px) {
            .article-layout,
            html[dir="ltr"] .article-layout {
                flex-direction: column;
                align-items: center;
                padding: 1rem;
                gap: 1rem;
            }
            .logo-sidebar,
            html[dir="ltr"] .logo-sidebar {
                position: static;
                top: auto;
                left: auto;
                right: auto;
                width: 100%;
                max-width: 180px;
                margin: 0 auto 1rem;
                order: 0;
            }
            .logo-sidebar img {
                padding: .4rem;
            }
            .article {
                order: 1;
                width: 100%;
                max-width: 100%;
            }
        }

        /* =========================================================
           موبایل کوچک (کمتر از ۴۸۰px)
           ========================================================= */
        @media (max-width: 480px) {
            .article-layout,
            html[dir="ltr"] .article-layout {
                padding: .75rem;
            }
            .logo-sidebar {
                max-width: 140px;
            }
            .logo-sidebar img {
                padding: .3rem;
                border-radius: .5rem;
            }
            .article h2 {
                margin-top: 1.75rem;
            }
            .article .cards {
                grid-template-columns: 1fr;
            }
            .article th,
            .article td {
                padding: .4rem;
                font-size: .82rem;
            }
        }

        /* =========================================================
           موبایل خیلی کوچک (کمتر از ۳۶۰px)
           ========================================================= */
        @media (max-width: 360px) {
            .logo-sidebar {
                max-width: 110px;
            }
            .article h1 {
                font-size: 1.25rem;
            }
            .article h2 {
                font-size: 1.05rem;
            }
            .toc {
                padding: .75rem 1rem;
            }
        }
    </style>
@endpush

@php
    $trends = [
        ['title' => __('market.trend_1_title'), 'desc' => __('market.trend_1_desc')],
        ['title' => __('market.trend_2_title'), 'desc' => __('market.trend_2_desc')],
        ['title' => __('market.trend_3_title'), 'desc' => __('market.trend_3_desc')],
        ['title' => __('market.trend_4_title'), 'desc' => __('market.trend_4_desc')],
        ['title' => __('market.trend_5_title'), 'desc' => __('market.trend_5_desc')],
    ];

    $opportunities = [
        ['group' => __('market.opp_1_group'), 'examples' => __('market.opp_1_examples'), 'note' => __('market.opp_1_note')],
        ['group' => __('market.opp_2_group'), 'examples' => __('market.opp_2_examples'), 'note' => __('market.opp_2_note')],
        ['group' => __('market.opp_3_group'), 'examples' => __('market.opp_3_examples'), 'note' => __('market.opp_3_note')],
        ['group' => __('market.opp_4_group'), 'examples' => __('market.opp_4_examples'), 'note' => __('market.opp_4_note')],
        ['group' => __('market.opp_5_group'), 'examples' => __('market.opp_5_examples'), 'note' => __('market.opp_5_note')],
    ];

    $markets = [
        ['title' => __('market.market_1_title'), 'desc' => __('market.market_1_desc')],
        ['title' => __('market.market_2_title'), 'desc' => __('market.market_2_desc')],
        ['title' => __('market.market_3_title'), 'desc' => __('market.market_3_desc')],
    ];

    $challenges = [
        __('market.challenge_1'),
        __('market.challenge_2'),
        __('market.challenge_3'),
        __('market.challenge_4'),
        __('market.challenge_5'),
    ];

    $strategies = [
        __('market.strategy_1'),
        __('market.strategy_2'),
        __('market.strategy_3'),
        __('market.strategy_4'),
        __('market.strategy_5'),
        __('market.strategy_6'),
    ];

    $faqs = [
        ['q' => __('market.faq_q1'), 'a' => __('market.faq_a1')],
        ['q' => __('market.faq_q2'), 'a' => __('market.faq_a2')],
        ['q' => __('market.faq_q3'), 'a' => __('market.faq_a3')],
    ];
@endphp

@section('content')
    <div class="article-layout">

        {{-- ===== ستون لوگو (fixed سمت چپ) ===== --}}
        <aside class="logo-sidebar" aria-label="{{ __('market.title') }}">
            <img src="{{ asset('img/markets/Duck-ai-image-2026-10-06-15-41.webp') }}"
                 alt="{{ __('market.title') }}">
        </aside>

        {{-- ===== ستون مقاله ===== --}}
        <article class="article">
            <header>
                <h1>{{ __('market.title') }}</h1>
                <p class="meta">
                    {{ __('market.author') }}
                    &middot;
                    {{ __('market.read_time') }}
                    &middot;
                    {{ __('market.published') }}: {{ now()->format('Y/m/d') }}
                </p>
            </header>

            <nav class="toc" aria-label="{{ __('market.toc') }}">
                <strong>{{ __('market.toc') }}</strong>
                <ol>
                    <li><a href="#intro">{{ __('market.toc_intro') }}</a></li>
                    <li><a href="#trends">{{ __('market.toc_trends') }}</a></li>
                    <li><a href="#supply-demand">{{ __('market.toc_supply_demand') }}</a></li>
                    <li><a href="#opportunities">{{ __('market.toc_opportunities') }}</a></li>
                    <li><a href="#markets">{{ __('market.toc_markets') }}</a></li>
                    <li><a href="#challenges">{{ __('market.toc_challenges') }}</a></li>
                    <li><a href="#strategies">{{ __('market.toc_strategies') }}</a></li>
                    <li><a href="#faq">{{ __('market.toc_faq') }}</a></li>
                </ol>
            </nav>

            <section id="intro">
                <h2>{{ __('market.intro_title') }}</h2>
                <p>{{ __('market.intro_text') }}</p>
                <div class="note">
                    {{ __('market.intro_note') }}
                </div>
            </section>

            <section id="trends">
                <h2>{{ __('market.trends_title') }}</h2>
                @foreach ($trends as $index => $trend)
                    <h3>{{ $index + 1 }}. {{ $trend['title'] }}</h3>
                    <p>{{ $trend['desc'] }}</p>
                @endforeach
            </section>

            <section id="supply-demand">
                <h2>{{ __('market.supply_demand_title') }}</h2>
                <p>{{ __('market.supply_demand_text') }}</p>
            </section>

            <section id="opportunities">
                <h2>{{ __('market.opportunities_title') }}</h2>
                <p>{{ __('market.opportunities_intro') }}</p>
                <table>
                    <thead>
                    <tr>
                        <th>{{ __('market.opp_col_group') }}</th>
                        <th>{{ __('market.opp_col_examples') }}</th>
                        <th>{{ __('market.opp_col_note') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($opportunities as $row)
                        <tr>
                            <td>{{ $row['group'] }}</td>
                            <td>{{ $row['examples'] }}</td>
                            <td>{{ $row['note'] }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <p>{{ __('market.opportunities_footer') }}</p>
            </section>

            <section id="markets">
                <h2>{{ __('market.markets_title') }}</h2>
                <div class="cards">
                    @foreach ($markets as $m)
                        <div class="card">
                            <h3>{{ $m['title'] }}</h3>
                            <p>{{ $m['desc'] }}</p>
                        </div>
                    @endforeach
                </div>
                <p>{{ __('market.markets_footer') }}</p>
            </section>

            <section id="challenges">
                <h2>{{ __('market.challenges_title') }}</h2>
                <ul>
                    @foreach ($challenges as $challenge)
                        <li>{{ $challenge }}</li>
                    @endforeach
                </ul>
            </section>

            <section id="strategies">
                <h2>{{ __('market.strategies_title') }}</h2>
                <ol>
                    @foreach ($strategies as $strategy)
                        <li>{{ $strategy }}</li>
                    @endforeach
                </ol>
            </section>

            <section id="faq">
                <h2>{{ __('market.faq_title') }}</h2>
                @foreach ($faqs as $faq)
                    <h3>{{ $faq['q'] }}</h3>
                    <p>{{ $faq['a'] }}</p>
                @endforeach
            </section>

            <footer style="margin-top:3rem;">
                <a href="{{ url('/' . app()->getLocale() . '/blog') }}">
                    &rarr; {{ __('market.back_to_blog') }}
                </a>
            </footer>
        </article>

    </div>
@endsection

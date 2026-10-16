@extends('layouts.home')

@section('title', __('about.meta.title'))

@section('styles')
    <style>
        /* =========================================================
           ABOUT PAGE - Amir Afaq Gostar Pars
           Modern, Elegant, Brand-Colored
        ========================================================= */

        :root {
            --about-primary: #173d29;
            --about-primary-2: #2b6041;
            --about-gold: #c4a04c;
            --about-gold-dark: #a78332;
            --about-soft: #f7f9f5;
            --about-border: #e6ebe6;
            --about-text: #4a554d;
            --about-muted: #7b857e;
            --about-white: #ffffff;
            --about-shadow: 0 20px 60px rgba(23, 61, 41, .08);
            --about-shadow-lg: 0 30px 80px rgba(23, 61, 41, .14);
        }

        .company-page {
            font-family: 'Vazirmatn', sans-serif;
            color: var(--about-text);
            background: var(--about-white);
            overflow-x: hidden;
        }

        html[dir="rtl"] .company-page { direction: rtl; }
        html[dir="ltr"] .company-page { direction: ltr; }

        .company-container {
            width: min(1200px, 92%);
            margin: 0 auto;
        }

        /* =========================================================
           HERO
        ========================================================= */

        .company-hero {
            position: relative;
            min-height: 560px;
            display: flex;
            align-items: center;
            overflow: hidden;
            background:
                linear-gradient(120deg,
                rgba(15, 45, 28, .96) 0%,
                rgba(23, 61, 41, .88) 40%,
                rgba(23, 61, 41, .55) 75%,
                rgba(23, 61, 41, .25) 100%
                ),
                url('{{ asset('img/imageheader/Aboute.webp') }}')
                center/cover no-repeat;
            isolation: isolate;
        }

        .company-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 15% 30%, rgba(196, 160, 76, .18), transparent 45%),
                radial-gradient(circle at 85% 75%, rgba(196, 160, 76, .10), transparent 50%);
            pointer-events: none;
            z-index: 1;
        }

        .company-hero::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            right: 0;
            height: 100px;
            background: linear-gradient(to top, var(--about-white), transparent);
            pointer-events: none;
            z-index: 2;
        }

        .company-hero-content {
            position: relative;
            z-index: 3;
            max-width: 780px;
            color: var(--about-white);
            padding: 100px 0 130px;
            animation: heroFadeUp 1s ease-out both;
        }

        html[dir="rtl"] .company-hero-content { text-align: right; }
        html[dir="ltr"] .company-hero-content { text-align: left; }

        @keyframes heroFadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .company-hero-label {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 22px;
            border: 1px solid rgba(196, 160, 76, .55);
            border-radius: 50px;
            background: rgba(196, 160, 76, .12);
            backdrop-filter: blur(6px);
            color: var(--about-gold);
            font-size: 14px;
            font-weight: 600;
            letter-spacing: .5px;
            margin-bottom: 25px;
            animation: heroFadeUp 1s ease-out .1s both;
        }

        .company-hero-label::before {
            content: '';
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--about-gold);
            box-shadow: 0 0 0 4px rgba(196, 160, 76, .25);
            animation: labelPulse 2s ease-in-out infinite;
        }

        @keyframes labelPulse {
            0%, 100% { box-shadow: 0 0 0 4px rgba(196, 160, 76, .25); }
            50%      { box-shadow: 0 0 0 8px rgba(196, 160, 76, .05); }
        }

        .company-hero h1 {
            margin: 0 0 22px;
            font-size: clamp(36px, 5.5vw, 64px);
            line-height: 1.25;
            font-weight: 800;
            letter-spacing: -.5px;
            background: linear-gradient(135deg, #ffffff 0%, #f4e6c0 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: heroFadeUp 1s ease-out .2s both;
        }

        .company-hero p {
            margin: 0;
            max-width: 640px;
            font-size: 18px;
            line-height: 2.1;
            color: rgba(255, 255, 255, .88);
            animation: heroFadeUp 1s ease-out .3s both;
        }

        html[dir="rtl"] .company-hero p { margin-right: 0; margin-left: auto; }

        /* Decorative line under hero */
        .hero-decoration {
            position: absolute;
            bottom: 60px;
            left: 0;
            right: 0;
            z-index: 3;
            display: flex;
            justify-content: center;
            gap: 6px;
        }

        .hero-decoration span {
            width: 40px;
            height: 3px;
            border-radius: 3px;
            background: var(--about-gold);
            opacity: .4;
        }

        .hero-decoration span:nth-child(2) { width: 80px; opacity: 1; }
        .hero-decoration span:nth-child(3) { width: 40px; opacity: .4; }

        /* =========================================================
           SECTION BASE
        ========================================================= */

        .company-section {
            position: relative;
            padding: 100px 0;
        }

        .company-section:nth-child(even) {
            background: linear-gradient(180deg, #f7f9f5 0%, #eef3ee 100%);
        }

        .company-section .company-container {
            position: relative;
            z-index: 1;
        }

        .section-heading {
            max-width: 780px;
            margin: 0 auto 65px;
            text-align: center;
        }

        .section-heading .eyebrow {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 50px;
            background: rgba(196, 160, 76, .12);
            color: var(--about-gold-dark);
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 1px;
            margin-bottom: 18px;
            text-transform: uppercase;
        }

        .section-heading h2 {
            margin: 0 0 18px;
            color: var(--about-primary);
            font-size: clamp(28px, 4.2vw, 42px);
            font-weight: 800;
            line-height: 1.3;
            letter-spacing: -.5px;
        }

        .section-heading h2::after {
            content: '';
            display: block;
            width: 60px;
            height: 4px;
            border-radius: 4px;
            background: linear-gradient(90deg, var(--about-gold), var(--about-gold-dark));
            margin: 20px auto 0;
        }

        .section-heading p {
            margin: 0;
            color: var(--about-muted);
            font-size: 16px;
            line-height: 2.1;
        }

        /* =========================================================
           ABOUT
        ========================================================= */

        .about-grid {
            display: grid;
            grid-template-columns: 1fr 1.15fr;
            gap: 70px;
            align-items: center;
        }

        .about-image {
            position: relative;
            padding: 20px;
        }

        .about-image::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 75%;
            height: 75%;
            border: 2px solid var(--about-gold);
            border-radius: 28px;
            opacity: .35;
            z-index: 0;
        }

        .about-image img {
            position: relative;
            width: 100%;
            height: 480px;
            object-fit: cover;
            border-radius: 24px;
            display: block;
            box-shadow: var(--about-shadow-lg);
            z-index: 1;
            transition: transform .6s ease;
        }

        .about-image:hover img {
            transform: scale(1.02);
        }

        .about-image-badge {
            position: absolute;
            bottom: 40px;
            padding: 22px 26px;
            border-radius: 20px;
            background: linear-gradient(135deg, var(--about-primary), var(--about-primary-2));
            box-shadow: var(--about-shadow-lg);
            z-index: 2;
            min-width: 200px;
            color: #fff;
            text-align: center;
            animation: floatBadge 3s ease-in-out infinite;
        }

        html[dir="rtl"] .about-image-badge { left: -20px; }
        html[dir="ltr"] .about-image-badge { right: -20px; }

        @keyframes floatBadge {
            0%, 100% { transform: translateY(0); }
            50%      { transform: translateY(-10px); }
        }

        .about-image-badge strong {
            display: block;
            color: var(--about-gold);
            font-size: 32px;
            font-weight: 800;
            letter-spacing: 2px;
            margin-bottom: 6px;
        }

        .about-image-badge span {
            color: rgba(255, 255, 255, .85);
            font-size: 12px;
            letter-spacing: .5px;
        }

        .about-content h3 {
            margin: 0 0 25px;
            color: var(--about-primary);
            font-size: clamp(24px, 3vw, 32px);
            font-weight: 800;
            line-height: 1.4;
            position: relative;
            padding-bottom: 20px;
        }

        .about-content h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            width: 60px;
            height: 4px;
            border-radius: 4px;
            background: var(--about-gold);
        }

        html[dir="rtl"] .about-content h3::after { right: 0; }
        html[dir="ltr"] .about-content h3::after { left: 0; }

        .about-content p {
            color: var(--about-text);
            line-height: 2.2;
            font-size: 15.5px;
            margin: 0 0 18px;
        }

        /* =========================================================
           HISTORY - Timeline
        ========================================================= */

        .history-wrapper {
            position: relative;
            max-width: 950px;
            margin: auto;
            padding: 20px 0;
        }

        .history-wrapper::before {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            right: 50%;
            width: 3px;
            background: linear-gradient(to bottom,
            transparent 0%,
            var(--about-gold) 15%,
            var(--about-gold) 85%,
            transparent 100%
            );
            transform: translateX(50%);
            border-radius: 3px;
        }

        .history-item {
            position: relative;
            width: 50%;
            padding: 0 45px 55px;
            transition: transform .3s ease;
        }

        .history-item:hover {
            transform: translateY(-4px);
        }

        html[dir="rtl"] .history-item:nth-child(odd) { margin-right: 50%; padding-left: 45px; padding-right: 45px; }
        html[dir="rtl"] .history-item:nth-child(even) { text-align: left; }

        html[dir="ltr"] .history-item:nth-child(odd) { margin-left: 50%; padding-right: 45px; padding-left: 45px; }
        html[dir="ltr"] .history-item:nth-child(even) { text-align: right; }

        .history-dot {
            position: absolute;
            top: 12px;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: var(--about-gold);
            border: 5px solid #fff;
            box-shadow:
                0 0 0 3px var(--about-gold),
                0 8px 20px rgba(196, 160, 76, .4);
            z-index: 2;
            transition: transform .3s ease;
        }

        html[dir="rtl"] .history-dot { right: -11px; }
        html[dir="ltr"] .history-dot { left: -11px; }

        html[dir="rtl"] .history-item:nth-child(even) .history-dot { right: auto; left: -11px; }
        html[dir="ltr"] .history-item:nth-child(even) .history-dot { left: auto; right: -11px; }

        .history-item:hover .history-dot {
            transform: scale(1.3);
        }

        .history-year {
            display: inline-block;
            padding: 6px 18px;
            border-radius: 50px;
            background: rgba(196, 160, 76, .12);
            color: var(--about-gold-dark);
            font-weight: 800;
            font-size: 15px;
            margin-bottom: 14px;
            letter-spacing: .5px;
        }

        .history-item h3 {
            color: var(--about-primary);
            margin: 0 0 10px;
            font-size: 21px;
            font-weight: 700;
        }

        .history-item p {
            margin: 0;
            color: var(--about-muted);
            line-height: 2;
            font-size: 14.5px;
        }

        /* =========================================================
           CARDS - Mission/Vision/Values
        ========================================================= */

        .three-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        .info-card {
            position: relative;
            height: 100%;
            padding: 45px 30px;
            background: #fff;
            border: 1px solid var(--about-border);
            border-radius: 24px;
            text-align: center;
            overflow: hidden;
            transition: all .45s cubic-bezier(.25, .8, .25, 1);
        }

        .info-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--about-gold), var(--about-gold-dark));
            transform: scaleX(0);
            transform-origin: center;
            transition: transform .45s ease;
        }

        .info-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--about-shadow-lg);
            border-color: transparent;
        }

        .info-card:hover::before {
            transform: scaleX(1);
        }

        .info-icon {
            position: relative;
            width: 78px;
            height: 78px;
            margin: 0 auto 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 22px;
            background: linear-gradient(135deg, #edf4ed, #d8e5d9);
            color: var(--about-gold-dark);
            font-size: 30px;
            transition: all .45s ease;
        }

        .info-card:hover .info-icon {
            background: linear-gradient(135deg, var(--about-primary), var(--about-primary-2));
            color: var(--about-gold);
            transform: rotateY(360deg);
        }

        .info-card h3 {
            margin: 0 0 14px;
            color: var(--about-primary);
            font-size: 21px;
            font-weight: 700;
        }

        .info-card p {
            margin: 0;
            color: var(--about-muted);
            font-size: 14.5px;
            line-height: 2.1;
        }

        /* =========================================================
           ACTIVITY CARDS
        ========================================================= */

        .activity-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
        }

        .activity-card {
            position: relative;
            min-height: 220px;
            padding: 35px 30px;
            border-radius: 22px;
            background: linear-gradient(145deg, var(--about-primary) 0%, var(--about-primary-2) 100%);
            color: #fff;
            overflow: hidden;
            transition: all .45s cubic-bezier(.25, .8, .25, 1);
            cursor: pointer;
        }

        .activity-card::before {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(196, 160, 76, .18), transparent 70%);
            top: -80px;
            right: -80px;
            transition: all .6s ease;
        }

        .activity-card::after {
            content: '';
            position: absolute;
            width: 140px;
            height: 140px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .04);
            left: -50px;
            bottom: -60px;
            transition: all .6s ease;
        }

        .activity-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 60px rgba(23, 61, 41, .28);
        }

        .activity-card:hover::before {
            transform: scale(1.4);
        }

        .activity-card:hover::after {
            transform: scale(1.3);
            background: rgba(196, 160, 76, .10);
        }

        .activity-number {
            position: relative;
            z-index: 1;
            display: inline-block;
            color: var(--about-gold);
            font-size: 15px;
            font-weight: 800;
            letter-spacing: 2px;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 2px solid rgba(196, 160, 76, .3);
        }

        .activity-card h3 {
            position: relative;
            z-index: 1;
            margin: 0 0 14px;
            font-size: 20px;
            font-weight: 700;
        }

        .activity-card p {
            position: relative;
            z-index: 1;
            margin: 0;
            color: rgba(255, 255, 255, .8);
            font-size: 13.5px;
            line-height: 2;
        }

        /* =========================================================
           MANAGEMENT
        ========================================================= */

        .management-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
        }

        .manager-card {
            position: relative;
            padding: 38px 22px;
            background: #fff;
            border: 1px solid var(--about-border);
            border-radius: 22px;
            text-align: center;
            transition: all .4s ease;
            overflow: hidden;
        }

        .manager-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 100%;
            background: linear-gradient(180deg, rgba(196, 160, 76, .06), transparent 60%);
            opacity: 0;
            transition: opacity .4s ease;
            pointer-events: none;
        }

        .manager-card:hover {
            transform: translateY(-8px);
            border-color: var(--about-gold);
            box-shadow: var(--about-shadow);
        }

        .manager-card:hover::before {
            opacity: 1;
        }

        .manager-avatar {
            position: relative;
            width: 90px;
            height: 90px;
            margin: 0 auto 22px;
            border-radius: 50%;
            background: linear-gradient(135deg, #edf4ed, #d8e5d9);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--about-primary);
            font-size: 34px;
            transition: all .45s ease;
        }

        .manager-avatar::after {
            content: '';
            position: absolute;
            inset: -6px;
            border-radius: 50%;
            border: 2px dashed rgba(196, 160, 76, .4);
            opacity: 0;
            transition: opacity .4s ease;
        }

        .manager-card:hover .manager-avatar {
            background: linear-gradient(135deg, var(--about-primary), var(--about-primary-2));
            color: var(--about-gold);
        }

        .manager-card:hover .manager-avatar::after {
            opacity: 1;
            animation: rotate 12s linear infinite;
        }

        @keyframes rotate {
            to { transform: rotate(360deg); }
        }

        .manager-card h3 {
            position: relative;
            margin: 0 0 8px;
            color: var(--about-primary);
            font-size: 18px;
            font-weight: 700;
        }

        .manager-card span {
            position: relative;
            color: var(--about-muted);
            font-size: 13px;
            line-height: 1.8;
        }

        /* =========================================================
           INFRASTRUCTURE
        ========================================================= */

        .infrastructure-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
        }

        .infra-card {
            position: relative;
            padding: 35px 25px;
            border-radius: 20px;
            background: #fff;
            border: 1px solid var(--about-border);
            text-align: center;
            transition: all .4s ease;
            overflow: hidden;
        }

        .infra-card::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--about-gold), var(--about-gold-dark));
            transform: scaleX(0);
            transition: transform .4s ease;
        }

        .infra-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--about-shadow);
        }

        .infra-card:hover::before {
            transform: scaleX(1);
        }

        .infra-card strong {
            display: block;
            color: var(--about-primary);
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 14px;
            padding-bottom: 14px;
            border-bottom: 1px solid var(--about-border);
        }

        .infra-card span {
            color: var(--about-muted);
            font-size: 13.5px;
            line-height: 1.9;
        }

        /* =========================================================
           NETWORK / PARTNERS
        ========================================================= */

        .network-box {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        .network-card {
            position: relative;
            padding: 45px 40px;
            border-radius: 24px;
            background: #fff;
            border: 1px solid var(--about-border);
            transition: all .4s ease;
            overflow: hidden;
        }

        .network-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            background: linear-gradient(to bottom, var(--about-gold), var(--about-gold-dark));
            transform: scaleY(0);
            transform-origin: top;
            transition: transform .5s ease;
        }

        .network-card:hover {
            box-shadow: var(--about-shadow-lg);
        }

        .network-card:hover::before {
            transform: scaleY(1);
        }

        .network-card h3 {
            margin: 0 0 25px;
            color: var(--about-primary);
            font-size: 22px;
            font-weight: 700;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--about-border);
        }

        .network-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .network-list li {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 0;
            border-bottom: 1px dashed var(--about-border);
            color: var(--about-text);
            font-size: 15px;
            transition: all .3s ease;
        }

        .network-list li:last-child {
            border-bottom: 0;
        }

        .network-list li:hover {
            color: var(--about-primary);
            padding-inline-start: 8px;
        }

        .network-list i {
            color: var(--about-gold);
            font-size: 16px;
            transition: transform .3s ease;
        }

        .network-list li:hover i {
            transform: scale(1.2);
        }

        /* =========================================================
           COUNTRIES
        ========================================================= */

        .countries {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 14px;
            max-width: 950px;
            margin: auto;
        }

        .country {
            position: relative;
            padding: 13px 26px;
            border-radius: 50px;
            background: #fff;
            border: 1.5px solid var(--about-border);
            color: var(--about-primary);
            font-size: 14.5px;
            font-weight: 600;
            transition: all .35s cubic-bezier(.25, .8, .25, 1);
            cursor: default;
            overflow: hidden;
        }

        .country::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, var(--about-primary), var(--about-primary-2));
            transform: scaleY(0);
            transform-origin: bottom;
            transition: transform .35s ease;
            z-index: -1;
        }

        .country:hover {
            color: #fff;
            border-color: var(--about-primary);
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(23, 61, 41, .2);
        }

        .country:hover::before {
            transform: scaleY(1);
        }

        /* =========================================================
           CAPACITY
        ========================================================= */

        .capacity-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        .capacity-card {
            position: relative;
            padding: 50px 35px;
            border-radius: 24px;
            background: linear-gradient(145deg, var(--about-primary), var(--about-primary-2));
            color: #fff;
            overflow: hidden;
            transition: all .45s ease;
        }

        .capacity-card::before {
            content: '';
            position: absolute;
            top: -60px;
            right: -60px;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(196, 160, 76, .25), transparent 65%);
            transition: transform .6s ease;
        }

        .capacity-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 30px 70px rgba(23, 61, 41, .35);
        }

        .capacity-card:hover::before {
            transform: scale(1.5);
        }

        .capacity-card .capacity-icon {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 70px;
            height: 70px;
            border-radius: 20px;
            background: rgba(196, 160, 76, .15);
            color: var(--about-gold);
            font-size: 28px;
            margin-bottom: 25px;
            transition: all .45s ease;
        }

        .capacity-card:hover .capacity-icon {
            background: var(--about-gold);
            color: var(--about-primary);
            transform: rotateY(360deg);
        }

        .capacity-card h3 {
            position: relative;
            margin: 0 0 14px;
            font-size: 22px;
            font-weight: 700;
        }

        .capacity-card p {
            position: relative;
            margin: 0;
            color: rgba(255, 255, 255, .8);
            line-height: 2.1;
            font-size: 14.5px;
        }

        /* =========================================================
           CTA
        ========================================================= */

        .company-cta {
            position: relative;
            padding: 100px 20px;
            background:
                linear-gradient(135deg, rgba(23, 61, 41, .95), rgba(43, 96, 65, .95)),
                url('{{ asset('img/imageheader/Aboute.webp') }}')
                center/cover no-repeat;
            color: #fff;
            text-align: center;
            overflow: hidden;
        }

        .company-cta::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 20% 30%, rgba(196, 160, 76, .15), transparent 45%),
                radial-gradient(circle at 80% 70%, rgba(196, 160, 76, .10), transparent 45%);
            pointer-events: none;
        }

        .company-cta .company-container {
            position: relative;
            z-index: 1;
        }

        .company-cta h2 {
            margin: 0 0 20px;
            font-size: clamp(28px, 4.5vw, 44px);
            font-weight: 800;
            letter-spacing: -.5px;
        }

        .company-cta p {
            max-width: 700px;
            margin: 0 auto 35px;
            color: rgba(255, 255, 255, .85);
            line-height: 2.1;
            font-size: 16px;
        }

        .company-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 16px 40px;
            border-radius: 50px;
            background: linear-gradient(135deg, var(--about-gold), var(--about-gold-dark));
            color: #fff;
            text-decoration: none;
            font-size: 15px;
            font-weight: 700;
            letter-spacing: .5px;
            box-shadow: 0 15px 40px rgba(196, 160, 76, .4);
            transition: all .4s cubic-bezier(.25, .8, .25, 1);
            position: relative;
            overflow: hidden;
        }

        .company-btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, .25);
            transform: translate(-50%, -50%);
            transition: width .5s ease, height .5s ease;
        }

        .company-btn:hover::before {
            width: 400px;
            height: 400px;
        }

        .company-btn span,
        .company-btn i {
            position: relative;
            z-index: 1;
        }

        .company-btn:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 50px rgba(196, 160, 76, .55);
            color: #fff;
        }

        .company-btn i {
            transition: transform .4s ease;
        }

        html[dir="rtl"] .company-btn:hover i { transform: translateX(-5px); }
        html[dir="ltr"] .company-btn:hover i { transform: translateX(5px); }

        /* =========================================================
           ANIMATIONS on scroll
        ========================================================= */

        .reveal {
            opacity: 0;
            transform: translateY(40px);
            transition: opacity .8s ease, transform .8s ease;
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 1199px) {
            .company-hero {
                min-height: 500px;
            }
            .about-image img {
                height: 420px;
            }
        }

        @media (max-width: 992px) {
            .company-section {
                padding: 80px 0;
            }

            .about-grid,
            .network-box {
                grid-template-columns: 1fr;
                gap: 45px;
            }

            .about-image {
                padding: 15px;
            }

            .about-image-badge {
                position: relative;
                left: auto !important;
                right: auto !important;
                bottom: auto;
                margin-top: 20px;
                display: inline-block;
            }

            .three-grid,
            .activity-grid,
            .capacity-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .management-grid,
            .infrastructure-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .company-section {
                padding: 65px 0;
            }

            .section-heading {
                margin-bottom: 45px;
            }

            .company-hero {
                min-height: 460px;
            }

            .company-hero-content {
                padding: 70px 0 100px;
            }

            /* Timeline - تبدیل به حالت تک‌ستونی */
            .history-wrapper::before {
                right: 20px;
                transform: none;
            }

            html[dir="ltr"] .history-wrapper::before {
                left: 20px;
                right: auto;
            }

            .history-item,
            .history-item:nth-child(odd),
            .history-item:nth-child(even) {
                width: 100%;
                margin-right: 0 !important;
                margin-left: 0 !important;
                padding-right: 55px;
                padding-left: 0;
                text-align: right;
            }

            html[dir="ltr"] .history-item,
            html[dir="ltr"] .history-item:nth-child(odd),
            html[dir="ltr"] .history-item:nth-child(even) {
                padding-left: 55px;
                padding-right: 0;
                text-align: left;
            }

            .history-dot,
            .history-item:nth-child(even) .history-dot {
                right: 9px;
                left: auto;
            }

            html[dir="ltr"] .history-dot,
            html[dir="ltr"] .history-item:nth-child(even) .history-dot {
                left: 9px;
                right: auto;
            }

            .three-grid,
            .activity-grid,
            .capacity-grid,
            .management-grid,
            .infrastructure-grid {
                grid-template-columns: 1fr;
            }

            .about-image img {
                height: 350px;
            }

            .country {
                padding: 11px 20px;
                font-size: 13.5px;
            }
        }

        @media (max-width: 480px) {
            .company-container {
                width: 92%;
            }

            .company-hero h1 {
                font-size: 30px;
            }

            .company-hero p {
                font-size: 15px;
            }

            .company-hero-label {
                font-size: 12px;
                padding: 8px 16px;
            }

            .section-heading h2 {
                font-size: 26px;
            }

            .info-card,
            .manager-card,
            .activity-card,
            .capacity-card,
            .network-card {
                padding: 30px 22px;
            }

            .about-image-badge {
                padding: 16px 20px;
                min-width: 160px;
            }

            .about-image-badge strong {
                font-size: 26px;
            }

            .company-cta {
                padding: 70px 20px;
            }

            .company-btn {
                padding: 14px 30px;
                font-size: 14px;
            }
        }

        /* =========================================================
           SCROLL REVEAL ANIMATION
        ========================================================= */
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

    <div class="company-page">

        {{-- =====================================================
             HERO
        ====================================================== --}}
{{--        <section class="company-hero">--}}
{{--            <div class="company-container">--}}
{{--                <div class="company-hero-content">--}}
{{--                <span class="company-hero-label">--}}
{{--                    {{ __('about.hero.label') }}--}}
{{--                </span>--}}
{{--                    <h1>{{ __('about.hero.title') }}</h1>--}}
{{--                    <p>{{ __('about.hero.subtitle') }}</p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="hero-decoration">--}}
{{--                <span></span><span></span><span></span>--}}
{{--            </div>--}}
{{--        </section>--}}


        {{-- =====================================================
             INTRO
        ====================================================== --}}
        <section class="company-section">
            <div class="company-container">
                <div class="about-grid reveal">

                    <div class="about-image">
                        <img src="{{ asset('img/imageheader/Aboute.webp') }}"
                             alt="{{ __('about.intro.image_alt') }}">
                        <div class="about-image-badge">
                            <strong>AGP</strong>
                            <span>Amir Afaq Gostar Pars</span>
                        </div>
                    </div>

                    <div class="about-content">
                        <h3>{{ __('about.intro.title') }}</h3>
                        <p>{{ __('about.intro.paragraph1') }}</p>
                        <p>{{ __('about.intro.paragraph2') }}</p>
                        <p>{{ __('about.intro.paragraph3') }}</p>
                    </div>

                </div>
            </div>
        </section>


        {{-- =====================================================
             HISTORY
        ====================================================== --}}
        <section class="company-section">
            <div class="company-container">

                <div class="section-heading reveal">
                    <span class="eyebrow">{{ __('about.history.eyebrow') }}</span>
                    <h2>{{ __('about.history.title') }}</h2>
                    <p>{{ __('about.history.description') }}</p>
                </div>

                <div class="history-wrapper">
                    @for ($i = 1; $i <= 4; $i++)
                        <div class="history-item reveal">
                            <span class="history-dot"></span>
                            <div class="history-year">{{ __('about.history.items.item' . $i . '.year') }}</div>
                            <h3>{{ __('about.history.items.item' . $i . '.title') }}</h3>
                            <p>{{ __('about.history.items.item' . $i . '.text') }}</p>
                        </div>
                    @endfor
                </div>

            </div>
        </section>


        {{-- =====================================================
             MISSION / VISION / VALUES
        ====================================================== --}}
        <section class="company-section">
            <div class="company-container">

                <div class="section-heading reveal">
                    <span class="eyebrow">{{ __('about.identity.eyebrow') }}</span>
                    <h2>{{ __('about.identity.title') }}</h2>
                </div>

                <div class="three-grid">
                    @php
                        $identity = [
                            ['icon' => 'fa-bullseye', 'key' => 'mission'],
                            ['icon' => 'fa-eye',      'key' => 'vision'],
                            ['icon' => 'fa-gem',      'key' => 'values'],
                        ];
                    @endphp

                    @foreach ($identity as $item)
                        <div class="info-card reveal">
                            <div class="info-icon">
                                <i class="fas {{ $item['icon'] }}"></i>
                            </div>
                            <h3>{{ __('about.identity.items.' . $item['key'] . '.title') }}</h3>
                            <p>{{ __('about.identity.items.' . $item['key'] . '.text') }}</p>
                        </div>
                    @endforeach
                </div>

            </div>
        </section>


        {{-- =====================================================
             ACTIVITIES
        ====================================================== --}}
        <section class="company-section">
            <div class="company-container">

                <div class="section-heading reveal">
                    <span class="eyebrow">{{ __('about.activities.eyebrow') }}</span>
                    <h2>{{ __('about.activities.title') }}</h2>
                    <p>{{ __('about.activities.description') }}</p>
                </div>

                <div class="activity-grid">
                    @for ($i = 1; $i <= 6; $i++)
                        <div class="activity-card reveal">
                            <div class="activity-number">0{{ $i }}</div>
                            <h3>{{ __('about.activities.items.item' . $i . '.title') }}</h3>
                            <p>{{ __('about.activities.items.item' . $i . '.text') }}</p>
                        </div>
                    @endfor
                </div>

            </div>
        </section>


        {{-- =====================================================
             MANAGEMENT
        ====================================================== --}}
        <section class="company-section">
            <div class="company-container">

                <div class="section-heading reveal">
                    <span class="eyebrow">{{ __('about.management.eyebrow') }}</span>
                    <h2>{{ __('about.management.title') }}</h2>
                    <p>{{ __('about.management.description') }}</p>
                </div>

                <div class="management-grid">
                    @php
                        $managers = [
                            ['icon' => 'fa-user-tie',   'key' => 'ceo'],
                            ['icon' => 'fa-chart-line', 'key' => 'commercial'],
                            ['icon' => 'fa-globe',      'key' => 'export'],
                            ['icon' => 'fa-truck',      'key' => 'logistics'],
                        ];
                    @endphp

                    @foreach ($managers as $m)
                        <div class="manager-card reveal">
                            <div class="manager-avatar">
                                <i class="fas {{ $m['icon'] }}"></i>
                            </div>
                            <h3>{{ __('about.management.items.' . $m['key'] . '.title') }}</h3>
                            <span>{{ __('about.management.items.' . $m['key'] . '.text') }}</span>
                        </div>
                    @endforeach
                </div>

            </div>
        </section>


        {{-- =====================================================
             INFRASTRUCTURE
        ====================================================== --}}
        <section class="company-section">
            <div class="company-container">

                <div class="section-heading reveal">
                    <span class="eyebrow">{{ __('about.infrastructure.eyebrow') }}</span>
                    <h2>{{ __('about.infrastructure.title') }}</h2>
                    <p>{{ __('about.infrastructure.description') }}</p>
                </div>

                <div class="infrastructure-grid">
                    @for ($i = 1; $i <= 4; $i++)
                        <div class="infra-card reveal">
                            <strong>{{ __('about.infrastructure.items.item' . $i . '.title') }}</strong>
                            <span>{{ __('about.infrastructure.items.item' . $i . '.text') }}</span>
                        </div>
                    @endfor
                </div>

            </div>
        </section>


        {{-- =====================================================
             WAREHOUSES
        ====================================================== --}}
        <section class="company-section">
            <div class="company-container">

                <div class="section-heading reveal">
                    <span class="eyebrow">{{ __('about.warehouses.eyebrow') }}</span>
                    <h2>{{ __('about.warehouses.title') }}</h2>
                    <p>{{ __('about.warehouses.description') }}</p>
                </div>

                <div class="three-grid">
                    @php
                        $warehouses = [
                            ['icon' => 'fa-warehouse',      'key' => 'storage'],
                            ['icon' => 'fa-boxes-stacked',  'key' => 'inventory'],
                            ['icon' => 'fa-box-open',       'key' => 'preparation'],
                        ];
                    @endphp

                    @foreach ($warehouses as $w)
                        <div class="info-card reveal">
                            <div class="info-icon">
                                <i class="fas {{ $w['icon'] }}"></i>
                            </div>
                            <h3>{{ __('about.warehouses.items.' . $w['key'] . '.title') }}</h3>
                            <p>{{ __('about.warehouses.items.' . $w['key'] . '.text') }}</p>
                        </div>
                    @endforeach
                </div>

            </div>
        </section>


        {{-- =====================================================
             NETWORK
        ====================================================== --}}
        <section class="company-section">
            <div class="company-container">

                <div class="section-heading reveal">
                    <span class="eyebrow">{{ __('about.network.eyebrow') }}</span>
                    <h2>{{ __('about.network.title') }}</h2>
                    <p>{{ __('about.network.description') }}</p>
                </div>

                <div class="network-box">

                    <div class="network-card reveal">
                        <h3>{{ __('about.network.suppliers.title') }}</h3>
                        <ul class="network-list">
                            @for ($i = 1; $i <= 4; $i++)
                                <li>
                                    <i class="fas fa-check-circle"></i>
                                    {{ __('about.network.suppliers.items.item' . $i) }}
                                </li>
                            @endfor
                        </ul>
                    </div>

                    <div class="network-card reveal">
                        <h3>{{ __('about.network.partners.title') }}</h3>
                        <ul class="network-list">
                            @for ($i = 1; $i <= 4; $i++)
                                <li>
                                    <i class="fas fa-check-circle"></i>
                                    {{ __('about.network.partners.items.item' . $i) }}
                                </li>
                            @endfor
                        </ul>
                    </div>

                </div>

            </div>
        </section>


        {{-- =====================================================
             COUNTRIES
        ====================================================== --}}
        <section class="company-section">
            <div class="company-container">

                <div class="section-heading reveal">
                    <span class="eyebrow">{{ __('about.countries.eyebrow') }}</span>
                    <h2>{{ __('about.countries.title') }}</h2>
                    <p>{{ __('about.countries.description') }}</p>
                </div>

{{--                <div class="countries reveal">--}}
{{--                    @foreach (__('about.countries.items') as $country)--}}
{{--                        <span class="country">{{ $country }}</span>--}}
{{--                    @endforeach--}}
{{--                </div>--}}

            </div>
        </section>


        {{-- =====================================================
             CAPACITY
        ====================================================== --}}
        <section class="company-section">
            <div class="company-container">

                <div class="section-heading reveal">
                    <span class="eyebrow">{{ __('about.capacity.eyebrow') }}</span>
                    <h2>{{ __('about.capacity.title') }}</h2>
                    <p>{{ __('about.capacity.description') }}</p>
                </div>

                <div class="capacity-grid">
                    @php
                        $capacity = [
                            ['icon' => 'fa-arrow-up-right-from-square', 'key' => 'export'],
                            ['icon' => 'fa-ship',                       'key' => 'import'],
                            ['icon' => 'fa-handshake',                  'key' => 'cooperation'],
                        ];
                    @endphp

                    @foreach ($capacity as $c)
                        <div class="capacity-card reveal">
                            <div class="capacity-icon">
                                <i class="fas {{ $c['icon'] }}"></i>
                            </div>
                            <h3>{{ __('about.capacity.items.' . $c['key'] . '.title') }}</h3>
                            <p>{{ __('about.capacity.items.' . $c['key'] . '.text') }}</p>
                        </div>
                    @endforeach
                </div>

            </div>
        </section>


        {{-- =====================================================
             CTA
        ====================================================== --}}
        <section class="company-cta">
            <div class="company-container">
                <h2>{{ __('about.cta.title') }}</h2>
                <p>{{ __('about.cta.text') }}</p>
                <a href="{{ url(app()->getLocale() . '/contact') }}" class="company-btn">
                    <span>{{ __('about.cta.button') }}</span>
                    <i class="fas fa-arrow-left"></i>
                </a>
            </div>
        </section>

    </div>

    {{-- Scroll reveal --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const reveals = document.querySelectorAll('.reveal');
            const io = new IntersectionObserver((entries) => {
                entries.forEach((entry, i) => {
                    if (entry.isIntersecting) {
                        setTimeout(() => entry.target.classList.add('visible'), i * 80);
                        io.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.12 });

            reveals.forEach(el => io.observe(el));
        });
    </script>

@endsection

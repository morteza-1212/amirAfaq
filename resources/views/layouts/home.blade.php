@php
    /*
    |--------------------------------------------------------------------------
    | Locale
    |--------------------------------------------------------------------------
    */
    $locale    = app()->getLocale();
    $isRtl     = in_array($locale, ['fa', 'ar'], true);
    $direction = $isRtl ? 'rtl' : 'ltr';

    /*
    |--------------------------------------------------------------------------
    | Localized URLs — ساختار جدید مخصوص بالن
    |--------------------------------------------------------------------------
    */
    $homeUrl           = url($locale);
    $aboutUrl          = url($locale . '/about');
    $projectsUrl       = url($locale . '/projects');
    $productsUrl       = url($locale . '/products');
    $defenseUrl        = url($locale . '/defense-balloons');     // بالون‌های نظامی
    $advertisingUrl    = url($locale . '/advertising-balloons'); // بالون‌های تبلیغاتی
    $researchUrl       = url($locale . '/research-balloons');    // بالون‌های پژوهشی
    $suppliersUrl      = url($locale . '/suppliers');
    $logisticsUrl      = url($locale . '/logistics');
    $teamUrl           = url($locale . '/team');
    $contactUrl        = url($locale . '/contact');
    $catalogsUrl       = url($locale . '/catalogs');
    $galleryUrl        = url($locale . '/gallery');
    $buyerUrl          = url($locale . '/buyer');

    /*
    |--------------------------------------------------------------------------
    | Languages
    |--------------------------------------------------------------------------
    */
    $languageNames = [
        'fa' => 'فارسی',
        'en' => 'English',
        'ar' => 'العربية',
    ];
    $currentLanguage = $languageNames[$locale] ?? 'فارسی';

    /*
    |--------------------------------------------------------------------------
    | Google Map Language
    |--------------------------------------------------------------------------
    */
    $googleMapLanguage = match ($locale) {
        'en' => 'en',
        'ar' => 'ar',
        default => 'fa',
    };
@endphp

    <!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $direction }}">
<head>
    {{-- Meta --}}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="{{ __('home.meta.description') }}">
    <meta name="keywords" content="{{ __('home.meta.keywords') }}">
    <meta name="language" content="{{ $locale }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', __('home.meta.title'))</title>

    {{-- Local Fonts --}}
    <link rel="stylesheet" href="{{ asset('fonts/vazirmatn/vazirmatn.css') }}">

    {{-- Neshan --}}
    <link rel="stylesheet" href="{{ asset('vendor/neshan/index.css') }}">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css') }}">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.min.css') }}">

    {{-- Leaflet --}}
    <link rel="stylesheet" href="{{ asset('vendor/leaflet/leaflet.css') }}">

    {{-- Local CSS --}}
    <link rel="stylesheet" href="{{ asset('lib/animate/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lib/lightbox/css/lightbox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    {{-- Local JS --}}
    <script src="{{ asset('vendor/neshan/index.js') }}" defer></script>
    <script src="{{ asset('vendor/leaflet/leaflet.js') }}" defer></script>

    <style>
        /* =========================================================
           ROOT — هویت رنگی شرکت بالن
        ========================================================= */
        :root {
            --site-primary: #0A1F44;         /* سرمه‌ای نظامی/پژوهشی */
            --site-primary-dark: #071633;
            --site-secondary: #F26B21;       /* نارنجی ایمنی */
            --site-light: #F5F7FA;
            --site-text: #1E2A38;
            --site-muted: #6c757d;
            --site-border: rgba(10, 31, 68, .12);
            --site-radius: 12px;
            --site-radius-lg: 18px;
            --site-shadow: 0 8px 30px rgba(0, 0, 0, .06);
            --site-transition: all .25s ease;

            /* رنگ‌های سه بخش */
            --defense-primary: #0A1F44;
            --defense-accent: #C9A227;
            --advertising-primary: #F26B21;
            --advertising-accent: #F7B32B;
            --research-primary: #1E6FA8;
            --research-accent: #2AB7A9;
        }

        /* =========================================================
           RESET
        ========================================================= */
        *, *::before, *::after { box-sizing: border-box; }

        html {
            width: 100%;
            min-height: 100%;
            scroll-behavior: smooth;
            overflow-x: hidden;
        }

        body {
            width: 100%;
            min-height: 100vh;
            margin: 0;
            padding: 0;
            font-family: 'Vazirmatn', Tahoma, Arial, sans-serif;
            color: var(--site-text);
            background: #fff;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            text-rendering: optimizeLegibility;
        }

        img { max-width: 100%; height: auto; vertical-align: middle; }
        a { text-decoration: none; }
        button, input, textarea, select { font-family: 'Vazirmatn', Tahoma, Arial, sans-serif; }

        html[dir="rtl"] body { direction: rtl; text-align: right; }
        html[dir="ltr"] body { direction: ltr; text-align: left; }

        .container { width: 100%; }
        @media (min-width: 1200px) { .container { max-width: 1180px; } }
        @media (min-width: 1400px) { .container { max-width: 1240px; } }

        /* =========================================================
           TOPBAR
        ========================================================= */
        .topbar {
            position: relative;
            z-index: 1030;
            background: var(--site-light);
            border-bottom: 1px solid var(--site-border);
        }
        .topbar a { transition: var(--site-transition); color: #555; }
        .topbar a:hover { color: var(--site-primary) !important; }
        .topbar .text-primary { color: var(--site-primary) !important; }
        .topbar .text-secondary { color: var(--site-secondary) !important; }
        .topbar .border-start { border-color: var(--site-border) !important; }
        .topbar .small { line-height: 1.8; }

        /* =========================================================
           LANGUAGE SWITCHER
        ========================================================= */
        .language-dropdown { position: relative; }
        .language-dropdown > a {
            display: inline-flex;
            align-items: center;
            min-height: 34px;
            white-space: nowrap;
            cursor: pointer;
        }
        .language-dropdown .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            min-width: 160px;
            margin-top: 8px;
            padding: 7px;
            border: 0;
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 12px 35px rgba(0, 0, 0, .12);
            z-index: 1055;
        }
        .language-dropdown .dropdown-menu.show { display: block; }
        [dir="rtl"] .language-dropdown .dropdown-menu { right: 0; left: auto; }
        [dir="ltr"] .language-dropdown .dropdown-menu { left: 0; right: auto; }
        .language-dropdown .dropdown-item {
            display: block;
            padding: 9px 12px;
            border-radius: 8px;
            font-size: 14px;
            color: var(--site-text);
            transition: var(--site-transition);
        }
        .language-dropdown .dropdown-item:hover,
        .language-dropdown .dropdown-item.active {
            color: #fff;
            background: var(--site-primary);
        }

        /* =========================================================
           NAVBAR
        ========================================================= */
        .nav-bar {
            position: relative;
            z-index: 1020;
            background: var(--site-primary);
            border-bottom: 1px solid rgba(0, 0, 0, .04);
        }
        .navbar {
            min-height: 82px;
            padding-top: 8px;
            padding-bottom: 8px;
        }
        .navbar-brand {
            display: flex;
            align-items: center;
            flex-shrink: 0;
            margin: 0;
        }
        .navbar-brand img {
            display: block;
            width: auto;
            max-width: 185px;
            height: auto;
            max-height: 68px;
            object-fit: contain;
        }
        .navbar-nav { align-items: center; gap: 2px; }
        .navbar-nav .nav-link {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 44px;
            padding: 9px 14px !important;
            color: #1E2A38 !important;
            font-size: 14px;
            font-weight: 600;
            white-space: nowrap;
            border-radius: 8px;
            transition: var(--site-transition);
        }
        .navbar-nav .nav-link:hover {
            color: var(--site-primary) !important;
            background: rgba(10, 31, 68, .05);
        }
        .navbar-nav .nav-link.active { color: var(--site-primary) !important; }
        .navbar-nav .nav-link.active::after {
            content: '';
            position: absolute;
            left: 14px; right: 14px;
            bottom: 2px;
            height: 2px;
            border-radius: 20px;
            background: var(--site-secondary);
        }
        .navbar .dropdown-menu {
            min-width: 230px;
            margin-top: 8px;
            padding: 8px;
            border: 0;
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 15px 45px rgba(0, 0, 0, .12);
        }
        .navbar .dropdown-item {
            padding: 10px 13px;
            color: #1E2A38;
            font-size: 14px;
            font-weight: 500;
            border-radius: 8px;
            transition: var(--site-transition);
        }
        .navbar .dropdown-item:hover { color: #fff; background: var(--site-primary); }
        .navbar .dropdown-item .fa-shield-alt { color: var(--defense-accent); }
        .navbar .dropdown-item .fa-bullhorn  { color: var(--advertising-primary); }
        .navbar .dropdown-item .fa-flask     { color: var(--research-primary); }

        .nav-btn { display: flex; align-items: center; }
        .nav-btn .btn {
            min-width: 145px;
            border-radius: 9px;
            font-size: 14px;
            font-weight: 600;
            white-space: nowrap;
            background: var(--site-secondary);
            color: #fff;
            border: none;
        }
        .nav-btn .btn:hover {
            background: #D85A15;
            color: #fff;
            transform: translateY(-2px);
        }
        .nav-bar .btn-light {
            width: 54px;
            height: 54px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(10, 31, 68, .08);
            box-shadow: 0 5px 18px rgba(0, 0, 0, .05);
            color: var(--site-primary);
        }
        .nav-bar .btn-light:hover { transform: translateY(-2px); color: var(--site-secondary); }
        .navbar-toggler {
            width: 48px;
            height: 44px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--site-secondary);
            border-radius: 9px;
            color: var(--site-secondary);
            background: #fff;
            box-shadow: none !important;
        }
        .navbar-toggler:focus { box-shadow: 0 0 0 3px rgba(242, 107, 33, .15) !important; }

        main { width: 100%; min-height: 300px; overflow: hidden; }

        /* =========================================================
           FOOTER
        ========================================================= */
        .footer {
            position: relative;
            background: linear-gradient(135deg, #0A1F44 0%, #0D2650 55%, #071633 100%);
            color: rgba(255, 255, 255, .82);
        }
        .footer::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--site-secondary), var(--site-primary), var(--site-secondary));
        }
        .footer-item h3 { margin-bottom: 18px; font-size: 21px; font-weight: 700; color: #fff; }
        .footer-item h4 { font-size: 17px; font-weight: 700; color: #fff; }
        .footer-item p { line-height: 2; }
        .footer-item > a:not(.p-0) {
            display: block;
            margin-bottom: 8px;
            color: rgba(255, 255, 255, .72);
            transition: var(--site-transition);
        }
        .footer-item > a:hover { color: #fff; transform: translateX(-3px); }
        [dir="ltr"] .footer-item > a:hover { transform: translateX(3px); }
        .footer-btn {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
        }
        .footer-btn .btn-md-square {
            width: 42px;
            height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 0 !important;
            color: #fff;
            border: 1px solid rgba(255, 255, 255, .15);
            transition: var(--site-transition);
        }
        .footer-btn .btn-md-square:hover {
            color: #fff;
            background: var(--site-secondary);
            border-color: var(--site-secondary);
            transform: translateY(-3px);
        }
        .footer-instagram {
            position: relative;
            width: 100%;
            aspect-ratio: 1 / 1;
            overflow: hidden;
            background: rgba(255, 255, 255, .06);
        }
        .footer-instagram img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .4s ease;
        }
        .footer-instagram:hover img { transform: scale(1.07); }
        .footer-search-icon {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            background: rgba(10, 31, 68, .7);
            transition: var(--site-transition);
        }
        .footer-instagram:hover .footer-search-icon { opacity: 1; }
        .footer-search-icon a {
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: var(--site-secondary);
        }
        .footer .btn-xl-square {
            width: 65px;
            height: 65px;
            min-width: 65px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .footer a { color: rgba(255, 255, 255, .82); }
        .footer a:hover { color: #fff; }
        .footer form { max-width: 100%; }
        .footer form .form-control {
            min-height: 52px;
            padding-left: 20px;
            padding-right: 20px;
            border: 0;
            font-size: 13px;
            box-shadow: none;
        }
        [dir="rtl"] .footer form .form-control { padding-left: 100px; padding-right: 20px; }
        [dir="ltr"] .footer form .form-control { padding-right: 100px; padding-left: 20px; }
        .footer form .btn { min-width: 82px; font-size: 12px; font-weight: 600; }

        /* Footer — elements از style.css */
        .footer-heading {
            position: relative;
            display: inline-block;
            color: #fff;
            font-size: 18px;
            font-weight: 700;
            line-height: 1.8;
            margin-bottom: 24px;
            padding-bottom: 10px;
        }
        .footer-heading::after {
            content: "";
            position: absolute;
            bottom: 0;
            right: 0;
            width: 42px;
            height: 3px;
            border-radius: 5px;
            background: var(--site-secondary);
        }
        [dir="ltr"] .footer-heading::after { left: 0; right: auto; }

        .footer-brand { gap: 12px; }
        .footer-brand-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 45px;
            height: 45px;
            flex-shrink: 0;
            border-radius: 14px;
            background: rgba(242, 107, 33, .15);
            color: var(--site-secondary);
            font-size: 23px;
        }
        .footer-brand h3 { font-size: 21px; font-weight: 800; line-height: 1.8; }
        .footer-description { color: #B8C6D6; font-size: 14px; line-height: 2.1; }

        .footer-social { display: flex; flex-wrap: wrap; gap: 10px; }
        .footer-social-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            border: 1px solid rgba(255, 255, 255, 0.14);
            border-radius: 50%;
            color: #fff;
            background: rgba(255, 255, 255, 0.05);
            font-size: 17px;
        }
        .footer-social-link:hover {
            color: #fff;
            background: var(--site-secondary);
            border-color: var(--site-secondary);
            transform: translateY(-3px);
        }

        .footer-links { display: flex; flex-direction: column; gap: 12px; }
        .footer-links a {
            display: flex;
            align-items: flex-start;
            gap: 9px;
            color: #B8C6D6;
            line-height: 1.9;
        }
        .footer-links a i { color: var(--site-secondary); margin-top: 5px; flex-shrink: 0; }
        .footer-links a:hover { color: #fff; transform: translateX(-3px); }

        .footer-auth-box {
            padding: 22px 18px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.045);
        }
        .footer-auth-description { color: #B8C6D6; font-size: 13px; line-height: 2; margin-bottom: 18px; }
        .footer-auth-actions { display: flex; flex-direction: column; gap: 10px; }
        .footer-auth-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            min-height: 45px;
            padding: 10px 15px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
        }
        .footer-login-btn {
            color: #fff;
            background: var(--research-primary);
            border: 1px solid var(--research-accent);
        }
        .footer-login-btn:hover {
            color: #fff;
            background: var(--research-accent);
            border-color: var(--research-accent);
            transform: translateY(-2px);
        }
        .footer-register-btn {
            color: #fff;
            background: var(--site-secondary);
            border: 1px solid var(--site-secondary);
        }
        .footer-register-btn:hover {
            color: #fff;
            background: var(--advertising-accent);
            border-color: var(--advertising-accent);
            transform: translateY(-2px);
        }
        .footer-auth-note {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            margin-top: 17px;
            color: #9FB2C4;
            font-size: 12px;
            line-height: 1.9;
        }
        .footer-auth-note i { margin-top: 4px; color: var(--site-secondary); flex-shrink: 0; }

        .footer-gallery-item {
            position: relative;
            overflow: hidden;
            aspect-ratio: 1 / 1;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.07);
        }
        .footer-gallery-item a { display: block; width: 100%; height: 100%; }
        .footer-gallery-item img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.35s ease;
        }
        .footer-gallery-overlay {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            background: rgba(10, 31, 68, 0.72);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .footer-gallery-item:hover img { transform: scale(1.1); }
        .footer-gallery-item:hover .footer-gallery-overlay { opacity: 1; }

        .footer-divider {
            width: 100%;
            height: 1px;
            margin: 42px 0 30px;
            background: rgba(255, 255, 255, 0.12);
        }

        .footer-contact-item {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            height: 100%;
            padding: 17px 14px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 13px;
            background: rgba(255, 255, 255, 0.035);
        }
        .footer-contact-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 43px;
            height: 43px;
            flex-shrink: 0;
            border-radius: 12px;
            color: var(--site-secondary);
            background: rgba(242, 107, 33, 0.12);
            font-size: 18px;
        }
        .footer-contact-content { min-width: 0; }
        .footer-contact-content h5 { margin-bottom: 8px; color: #fff; font-size: 15px; font-weight: 700; }
        .footer-contact-content p,
        .footer-contact-content a {
            margin-bottom: 0;
            color: #B8C6D6;
            font-size: 13px;
            line-height: 2;
            overflow-wrap: anywhere;
        }
        .footer-contact-content a:hover { color: var(--site-secondary); }

        .footer-enamad-box {
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100%;
            min-height: 190px;
            padding: 18px;
            border: 1px solid rgba(255, 255, 255, 0.13);
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.045);
            text-align: center;
        }
        .footer-enamad-title { margin-bottom: 15px; color: #fff; font-size: 15px; font-weight: 700; }
        .footer-enamad-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            max-width: 150px;
            min-height: 95px;
            border: 2px dashed rgba(242, 107, 33, 0.5);
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.035);
        }
        .footer-enamad-description { margin: 12px 0 0; color: #9FB2C4; font-size: 11px; line-height: 1.9; }

        .footer-copyright {
            margin-top: 30px;
            padding-top: 22px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }
        .footer-copyright p { color: #9FB2C4; font-size: 12px; line-height: 2; }
        .footer-copyright-name { color: var(--site-secondary); font-weight: 700; }

        /* Copyright Bar */
        .copyright {
            background: #071633;
            border-top: 1px solid rgba(255, 255, 255, .08);
            color: rgba(255, 255, 255, .7);
            font-size: 0.85rem;
        }
        .copyright span, .copyright div { font-size: 13px; line-height: 2; }
        .copyright a { color: var(--site-secondary); }
        .copyright a:hover { color: #fff !important; }

        .back-to-top {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: fixed;
            right: 22px;
            bottom: 22px;
            z-index: 1000;
            opacity: .9;
            background: var(--site-primary);
            color: #fff;
            border: none;
            box-shadow: 0 8px 25px rgba(10, 31, 68, .25);
            transition: var(--site-transition);
        }
        .back-to-top:hover {
            opacity: 1;
            background: var(--site-secondary);
            color: #fff;
            transform: translateY(-4px);
        }
        [dir="rtl"] .back-to-top { right: auto; left: 22px; }

        #spinner {
            z-index: 99999;
            transition: opacity .3s ease, visibility .3s ease;
        }
        #spinner:not(.show) {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }

        /* =========================================================
           CHAT WIDGET
        ========================================================= */
        .jr-chat-launcher {
            position: fixed;
            bottom: 22px;
            left: 22px;
            z-index: 1040;
            width: 60px;
            height: 60px;
            border: none;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--site-primary) 0%, var(--site-primary-dark) 100%);
            color: #fff;
            font-size: 26px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 6px 24px rgba(10, 31, 68, .35);
            transition: transform .25s ease, box-shadow .25s ease;
        }
        [dir="rtl"] .jr-chat-launcher { left: auto; right: 22px; }
        .jr-chat-launcher:hover {
            transform: translateY(-4px) scale(1.04);
            background: linear-gradient(135deg, var(--site-secondary) 0%, #D85A15 100%);
            box-shadow: 0 10px 32px rgba(242, 107, 33, .45);
        }
        .jr-chat-launcher:active { transform: scale(.96); }
        .jr-chat-launcher .jr-badge {
            position: absolute;
            top: -4px; right: -4px;
            min-width: 22px;
            height: 22px;
            padding: 0 6px;
            border-radius: 11px;
            background: #e74c3c;
            color: #fff;
            font-size: 12px;
            font-weight: 700;
            line-height: 22px;
            text-align: center;
            box-shadow: 0 2px 6px rgba(231, 76, 60, .4);
            display: none;
        }
        [dir="rtl"] .jr-chat-launcher .jr-badge { right: auto; left: -4px; }

        .jr-chat-panel {
            position: fixed;
            bottom: 96px;
            left: 22px;
            z-index: 1050;
            width: 360px;
            max-width: calc(100vw - 44px);
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, .18), 0 0 0 1px var(--site-border);
            display: none;
            flex-direction: column;
            overflow: hidden;
            transform-origin: bottom left;
            animation: jrSlideUp .3s ease forwards;
        }
        [dir="rtl"] .jr-chat-panel {
            left: auto; right: 22px;
            transform-origin: bottom right;
        }
        .jr-chat-panel.jr-open { display: flex; }

        @keyframes jrSlideUp {
            from { opacity: 0; transform: translateY(16px) scale(.96); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        .jr-chat-header {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px 18px;
            background: linear-gradient(135deg, var(--site-primary) 0%, var(--site-primary-dark) 100%);
            color: #fff;
        }
        .jr-avatar {
            width: 42px; height: 42px;
            border-radius: 50%;
            background: rgba(242, 107, 33, .25);
            color: var(--site-secondary);
            display: flex; align-items: center; justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }
        .jr-titles { flex: 1; min-width: 0; }
        .jr-titles h6 {
            margin: 0 0 3px;
            font-size: 15px;
            font-weight: 700;
            color: #fff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .jr-status {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            color: rgba(255, 255, 255, .8);
        }
        .jr-dot {
            width: 8px; height: 8px;
            border-radius: 50%;
            background: #2ecc71;
            box-shadow: 0 0 0 2px rgba(46, 204, 113, .3);
            animation: jrPulse 1.8s infinite;
        }
        @keyframes jrPulse {
            0%, 100% { box-shadow: 0 0 0 2px rgba(46, 204, 113, .3); }
            50%      { box-shadow: 0 0 0 6px rgba(46, 204, 113, .05); }
        }
        .jr-chat-close {
            width: 32px; height: 32px;
            border: none;
            border-radius: 50%;
            background: rgba(255, 255, 255, .12);
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            transition: background .2s ease;
            flex-shrink: 0;
        }
        .jr-chat-close:hover { background: rgba(242, 107, 33, .35); }

        .jr-chat-body {
            flex: 1;
            min-height: 280px;
            max-height: 380px;
            padding: 18px;
            overflow-y: auto;
            background: var(--site-light);
            display: flex;
            flex-direction: column;
            gap: 10px;
            scroll-behavior: smooth;
        }
        .jr-chat-body::-webkit-scrollbar { width: 6px; }
        .jr-chat-body::-webkit-scrollbar-thumb {
            background: rgba(10, 31, 68, .2);
            border-radius: 3px;
        }

        .jr-placeholder {
            text-align: center;
            color: var(--site-muted);
            font-size: 14px;
            line-height: 2;
            padding: 30px 10px;
        }
        .jr-placeholder i {
            font-size: 36px;
            color: var(--site-secondary);
            opacity: .8;
            margin-bottom: 10px;
            display: block;
        }

        .jr-msg {
            max-width: 82%;
            padding: 10px 14px;
            border-radius: 14px;
            font-size: 14px;
            line-height: 1.7;
            word-wrap: break-word;
            animation: jrMsgIn .25s ease;
        }
        @keyframes jrMsgIn {
            from { opacity: 0; transform: translateY(8px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .jr-msg-bot {
            align-self: flex-start;
            background: #fff;
            color: var(--site-text);
            border-bottom-left-radius: 4px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .06);
        }
        [dir="rtl"] .jr-msg-bot {
            border-bottom-left-radius: 14px;
            border-bottom-right-radius: 4px;
        }
        .jr-msg-user {
            align-self: flex-end;
            background: var(--site-primary);
            color: #fff;
            border-bottom-right-radius: 4px;
        }
        [dir="rtl"] .jr-msg-user {
            border-bottom-right-radius: 14px;
            border-bottom-left-radius: 4px;
        }
        .jr-msg-time {
            display: block;
            margin-top: 4px;
            font-size: 10px;
            opacity: .6;
        }

        .jr-chat-input {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 14px;
            background: #fff;
            border-top: 1px solid var(--site-border);
        }
        .jr-chat-input input {
            flex: 1;
            min-width: 0;
            height: 44px;
            padding: 0 16px;
            border: 1px solid var(--site-border);
            border-radius: 22px;
            font-size: 14px;
            color: var(--site-text);
            background: var(--site-light);
            outline: none;
            transition: border-color .2s ease, box-shadow .2s ease;
        }
        .jr-chat-input input:focus {
            border-color: var(--site-secondary);
            box-shadow: 0 0 0 3px rgba(242, 107, 33, .12);
            background: #fff;
        }
        .jr-chat-input input::placeholder { color: #a0a8a2; }
        .jr-chat-input button {
            width: 44px; height: 44px;
            border: none;
            border-radius: 50%;
            background: var(--site-secondary);
            color: #fff;
            font-size: 18px;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            transition: background .2s ease, transform .15s ease;
        }
        .jr-chat-input button:hover {
            background: #D85A15;
            transform: scale(1.06);
        }
        .jr-chat-input button:active { transform: scale(.94); }

        .jr-typing {
            display: flex;
            align-items: center;
            gap: 4px;
            padding: 12px 16px;
            background: #fff;
            border-radius: 14px;
            border-bottom-left-radius: 4px;
            align-self: flex-start;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .06);
        }
        [dir="rtl"] .jr-typing {
            border-bottom-left-radius: 14px;
            border-bottom-right-radius: 4px;
        }
        .jr-typing span {
            width: 7px; height: 7px;
            border-radius: 50%;
            background: var(--site-muted);
            animation: jrBounce 1.4s infinite both;
        }
        .jr-typing span:nth-child(2) { animation-delay: .2s; }
        .jr-typing span:nth-child(3) { animation-delay: .4s; }
        @keyframes jrBounce {
            0%, 80%, 100% { transform: scale(.6); opacity: .4; }
            40%           { transform: scale(1); opacity: 1; }
        }

        /* =========================================================
           FLOATING CALL BUTTON
        ========================================================= */
        .floating-call-button {
            position: fixed;
            right: 22px;
            bottom: 92px;
            width: 58px;
            height: 58px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0A1F44 0%, #071633 100%);
            color: #fff;
            font-size: 23px;
            border: 2px solid rgba(242, 107, 33, 0.85);
            border-radius: 50%;
            box-shadow: 0 6px 22px rgba(10, 31, 68, 0.3);
            text-decoration: none;
            z-index: 1035;
            transition: transform 0.25s ease, box-shadow 0.25s ease, background 0.25s ease;
        }
        .floating-call-button:hover {
            color: #fff;
            background: var(--site-secondary);
            transform: translateY(-4px) scale(1.05);
            box-shadow: 0 10px 28px rgba(10, 31, 68, 0.4);
        }
        .floating-call-button:active { transform: scale(0.95); }
        [dir="rtl"] .floating-call-button { right: auto; left: 22px; }

        /* =========================================================
           RESPONSIVE
        ========================================================= */
        @media (max-width: 1199.98px) {
            .navbar { min-height: 76px; }
            .navbar-brand img { max-width: 160px; max-height: 60px; }
            .navbar-nav .nav-link {
                padding-left: 10px !important;
                padding-right: 10px !important;
                font-size: 13px;
            }
            .nav-btn { padding-left: 8px !important; padding-right: 8px !important; }
            .nav-btn .btn { min-width: 120px; padding-left: 14px; padding-right: 14px; }
        }

        @media (max-width: 991.98px) {
            .topbar { padding-top: 8px !important; padding-bottom: 8px !important; }
            .topbar .row { row-gap: 5px; }
            .navbar {
                min-height: 70px;
                padding-top: 7px;
                padding-bottom: 7px;
            }
            .navbar-brand img { max-width: 145px; max-height: 55px; }
            .navbar-collapse {
                width: 100%;
                margin-top: 12px;
                padding: 10px;
                background: #fff;
                border: 1px solid var(--site-border);
                border-radius: 12px;
                box-shadow: 0 12px 30px rgba(0, 0, 0, .07);
            }
            .navbar-nav { width: 100%; align-items: stretch; gap: 3px; }
            .navbar-nav .nav-link {
                width: 100%;
                min-height: 44px;
                justify-content: flex-start;
                padding: 10px 13px !important;
                border-radius: 8px;
                color: #1E2A38 !important;
            }
            [dir="rtl"] .navbar-nav .nav-link { text-align: right; }
            [dir="ltr"] .navbar-nav .nav-link { text-align: left; }
            .navbar-nav .nav-link.active::after { display: none; }
            .navbar-nav .nav-link.active { background: rgba(10, 31, 68, .06); }
            .navbar .dropdown-menu {
                width: 100%;
                min-width: 0;
                margin-top: 3px;
                padding: 5px;
                box-shadow: none;
                border: 1px solid var(--site-border);
                background: #FAFBFD;
            }
            .navbar .dropdown-item { padding: 9px 12px; color: #1E2A38; }
            .nav-btn { width: 100%; padding: 8px 0 2px !important; }
            .nav-btn .btn { width: 100%; margin: 0 !important; }
            .topbar .border-end { border-right: 0 !important; border-left: 0 !important; }
            main { min-height: 250px; }

            .floating-call-button {
                width: 52px;
                height: 52px;
                bottom: 84px;
                font-size: 21px;
            }
        }

        @media (max-width: 767.98px) {
            .topbar { font-size: 12px; }
            .topbar .d-flex { gap: 4px; }
            .topbar .ps-3, .topbar .pe-3 { padding-left: 5px !important; padding-right: 5px !important; }
            .topbar .me-3 { margin-right: 10px !important; }
            .topbar .ms-3 { margin-left: 10px !important; }
            .navbar-brand img { max-width: 130px; max-height: 50px; }
            .navbar-toggler { width: 44px; height: 42px; }
            .footer { padding-top: 45px !important; padding-bottom: 35px !important; }
            .footer .container { padding-left: 18px; padding-right: 18px; }
            .footer .row.g-5 { --bs-gutter-y: 2.3rem; }
            .footer .row.g-4 { --bs-gutter-y: 1.5rem; }
            .footer-item h3 { font-size: 19px; }
            .footer-item h4 { font-size: 16px; }
            .footer .btn-xl-square { width: 55px; height: 55px; min-width: 55px; padding: 12px !important; }
            .copyright { padding-top: 18px !important; padding-bottom: 18px !important; }
            .copyright .row { row-gap: 5px; }
            .back-to-top { width: 43px; height: 43px; right: 15px; bottom: 15px; }
            [dir="rtl"] .back-to-top { right: auto; left: 15px; }

            .jr-chat-panel {
                width: calc(100vw - 32px);
                bottom: 88px;
                left: 16px;
            }
            [dir="rtl"] .jr-chat-panel { left: auto; right: 16px; }
            .jr-chat-launcher {
                width: 54px; height: 54px;
                font-size: 22px;
                bottom: 18px; left: 18px;
            }
            [dir="rtl"] .jr-chat-launcher { left: auto; right: 18px; }
            .jr-chat-body { min-height: 220px; max-height: 300px; }

            .floating-call-button {
                width: 52px;
                height: 52px;
                right: 16px;
                bottom: 84px;
                font-size: 21px;
            }
            [dir="rtl"] .floating-call-button { right: auto; left: 16px; }
        }

        @media (max-width: 575.98px) {
            .topbar { padding-top: 7px !important; padding-bottom: 7px !important; }
            .topbar .col-12 { width: 100%; }
            .topbar .small { font-size: 11px; }
            .topbar .fa-map-marker-alt,
            .topbar .fa-envelope,
            .topbar .fa-phone {
                margin-right: 3px !important;
                margin-left: 3px !important;
            }
            .topbar .d-flex { justify-content: center !important; }
            .navbar { min-height: 64px; }
            .navbar-brand img { max-width: 118px; max-height: 46px; }
            .navbar-collapse { margin-top: 8px; padding: 7px; }
            .navbar-nav .nav-link { min-height: 42px; font-size: 13px; }
            .footer-instagram { border-radius: 8px; }
            .footer-search-icon a { width: 35px; height: 35px; }
            .footer .d-flex { flex-wrap: wrap; }
            .footer form .btn { min-width: 76px; }
            [dir="rtl"] .footer form .form-control { padding-left: 88px; }
            [dir="ltr"] .footer form .form-control { padding-right: 88px; }

            .jr-chat-panel {
                width: calc(100vw - 24px);
                left: 12px;
                bottom: 82px;
                border-radius: 14px;
            }
            [dir="rtl"] .jr-chat-panel { left: auto; right: 12px; }
            .jr-chat-body { min-height: 200px; max-height: 260px; padding: 14px; }
            .jr-chat-header { padding: 12px 14px; }
            .jr-avatar { width: 36px; height: 36px; font-size: 18px; }
            .jr-titles h6 { font-size: 14px; }
            .jr-chat-input { padding: 10px 12px; }
            .jr-chat-input input { height: 40px; font-size: 13px; }
            .jr-chat-input button { width: 40px; height: 40px; font-size: 16px; }

            .floating-call-button {
                width: 48px;
                height: 48px;
                bottom: 80px;
                font-size: 19px;
            }
        }

        @media (max-width: 380px) {
            .navbar-brand img { max-width: 105px; }
            .topbar .small { font-size: 10px; }
            .footer .btn-md-square { width: 38px !important; height: 38px !important; }
            .footer form .form-control { min-height: 48px; }
            .jr-chat-panel {
                width: calc(100vw - 16px);
                left: 8px;
                bottom: 78px;
            }
            [dir="rtl"] .jr-chat-panel { left: auto; right: 8px; }
        }

        @media (prefers-reduced-motion: reduce) {
            html { scroll-behavior: auto; }
            *, *::before, *::after {
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: .01ms !important;
            }
        }

        @media (prefers-reduced-motion: no-preference) {
            .floating-call-button { animation: floatingCallPulse 2.5s infinite; }
        }

        @keyframes floatingCallPulse {
            0%, 100% { box-shadow: 0 6px 22px rgba(10, 31, 68, 0.3); }
            50%      { box-shadow: 0 6px 28px rgba(242, 107, 33, 0.45); }
        }
    </style>

    @yield('styles')
    @stack('styles')
</head>

<body>

{{-- SPINNER --}}
<div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center" aria-hidden="false">
    <div class="spinner-border text-primary" style="width:3rem;height:3rem;" role="status">
        <span class="visually-hidden">{{ __('home.loading') }}</span>
    </div>
</div>

{{-- TOPBAR --}}
<div class="container-fluid topbar px-0">
    <div class="container">
        <div class="row gx-0 align-items-center py-2">
            <div class="col-lg-8 col-md-7 col-12">
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-start">
                    <div class="pe-3">
                        <a href="{{ $contactUrl }}" class="small">
                            <i class="fas fa-map-marker-alt text-primary me-1"></i>
                            {{ __('home.topbar.address') }}
                        </a>
                    </div>
                    <div class="ps-3 pe-3 border-start">
                        <a href="mailto:info@amirafaq.ir" class="small">
                            <i class="fas fa-envelope text-primary me-1"></i>
                            info@amirafaq.ir
                        </a>
                    </div>
                    <div class="ps-3">
                        <a href="tel:+982188776655" class="small" dir="ltr">
                            <i class="fas fa-phone text-primary me-1"></i>
                            {{ __('home.topbar.phone') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-5 col-12 mt-2 mt-md-0">
                <div class="d-flex align-items-center justify-content-center justify-content-md-end">
                    <div class="d-flex align-items-center me-2">
                        <a class="btn p-0 text-primary me-3" href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a class="btn p-0 text-primary me-3" href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                        <a class="btn p-0 text-primary me-3" href="#" aria-label="Telegram"><i class="fab fa-telegram"></i></a>
                        <a class="btn p-0 text-primary" href="#" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                    </div>
                    <div class="language-dropdown" id="languageDropdownWrapper">
                        <a href="javascript:void(0)" class="dropdown-toggle d-inline-flex align-items-center" id="languageDropdown" role="button" aria-haspopup="true" aria-expanded="false" style="color: #1E2A38; font-weight: 600;">
                            <i class="fa-solid fa-globe me-1"></i>
                            {{ $currentLanguage }}
                        </a>
                        <div class="dropdown-menu language-menu" aria-labelledby="languageDropdown">
                            <a href="{{ route('locale.switch', 'fa') }}" class="dropdown-item {{ $locale === 'fa' ? 'active' : '' }}">
                                <span>🇮🇷</span> فارسی
                            </a>
                            <a href="{{ route('locale.switch', 'en') }}" class="dropdown-item {{ $locale === 'en' ? 'active' : '' }}">
                                <span>🇬🇧</span> English
                            </a>
                            <a href="{{ route('locale.switch', 'ar') }}" class="dropdown-item {{ $locale === 'ar' ? 'active' : '' }}">
                                <span>🇸🇦</span> العربية
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- NAVBAR --}}
<div class="container-fluid nav-bar px-0">
    <div class="container">
        <nav class="navbar navbar-expand-lg">

            {{-- لوگو --}}
            <a href="{{ $homeUrl }}" class="navbar-brand">
                <img
                    src="{{ asset('img/logo2/logo.jpg') }}"
                    alt="{{ __('home.navbar.logo_alt') }}"
                    width="180"
                    height="70"
                    loading="eager"
                    decoding="async"
                >
            </a>

            {{-- دکمه منوی موبایل --}}
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarCollapse"
                aria-controls="navbarCollapse"
                aria-expanded="false"
                aria-label="{{ __('home.navbar.toggle_menu') }}"
            >
                <span class="fa fa-bars"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarCollapse">

                <div class="navbar-nav mx-0 mx-lg-auto">

                    {{-- صفحه اصلی --}}
                    <a href="{{ $homeUrl }}"
                       class="nav-item nav-link {{ request()->is($locale) || request()->is($locale . '/') ? 'active' : '' }}">
                        {{ __('home.navbar.home') }}
                    </a>

                    {{-- درباره ما --}}
                    <a href="{{ $aboutUrl }}"
                       class="nav-item nav-link {{ request()->is($locale . '/about') ? 'active' : '' }}">
                        {{ __('home.navbar.about') }}
                    </a>

                    {{-- پروژه‌ها --}}
                    <a href="{{ $projectsUrl }}"
                       class="nav-item nav-link {{ request()->is($locale . '/project*') ? 'active' : '' }}">
                        {{ __('home.navbar.projects') }}
                    </a>

                    {{-- بخش‌های تخصصی --}}
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" id="sectionsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ __('home.navbar.sections') }}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="sectionsDropdown">

                            {{-- سه بخش اصلی --}}
                            <a href="{{ $defenseUrl }}" class="dropdown-item">
                                <i class="fas fa-shield-alt me-2"></i>
                                {{ __('home.navbar.defense_balloons') }}
                            </a>
                            <a href="{{ $advertisingUrl }}" class="dropdown-item">
                                <i class="fas fa-bullhorn me-2"></i>
                                {{ __('home.navbar.advertising_balloons') }}
                            </a>
                            <a href="{{ $researchUrl }}" class="dropdown-item">
                                <i class="fas fa-flask me-2"></i>
                                {{ __('home.navbar.research_balloons') }}
                            </a>

                            <div class="dropdown-divider"></div>

                            <a href="{{ $productsUrl }}" class="dropdown-item">
                                <i class="fas fa-boxes me-2"></i>
                                {{ __('home.navbar.products') }}
                            </a>
                            <a href="{{ $catalogsUrl }}" class="dropdown-item">
                                <i class="fas fa-file-pdf me-2"></i>
                                {{ __('home.navbar.catalogs') }}
                            </a>
                            <a href="{{ $suppliersUrl }}" class="dropdown-item">
                                <i class="fas fa-handshake me-2"></i>
                                {{ __('home.navbar.suppliers') }}
                            </a>
                            <a href="{{ $logisticsUrl }}" class="dropdown-item">
                                <i class="fas fa-truck me-2"></i>
                                {{ __('home.navbar.logistics') }}
                            </a>
                            <a href="{{ $teamUrl }}" class="dropdown-item">
                                <i class="fas fa-users-cog me-2"></i>
                                {{ __('home.navbar.team') }}
                            </a>
                            <a href="{{ $galleryUrl }}" class="dropdown-item">
                                <i class="fas fa-images me-2"></i>
                                {{ __('home.navbar.gallery') }}
                            </a>
                            <a href="{{ $buyerUrl }}" class="dropdown-item">
                                <i class="fas fa-user-check me-2"></i>
                                {{ __('home.navbar.buyer') }}
                            </a>
                        </div>
                    </div>

                    {{-- تماس با ما --}}
                    <a href="{{ $contactUrl }}"
                       class="nav-item nav-link {{ request()->is($locale . '/contact') ? 'active' : '' }}">
                        {{ __('home.navbar.contact') }}
                    </a>

                    {{-- درخواست مشاوره --}}
                    <div class="nav-btn px-2">
                        <a href="{{ $contactUrl }}" class="btn py-2 px-4">
                            <i class="fas fa-paper-plane me-1"></i>
                            {{ __('home.navbar.cooperation') }}
                        </a>
                    </div>

                    {{-- ======================================== --}}
                    {{-- منوی مدیریت مخصوص ادمین --}}
                    {{-- ======================================== --}}
                    @auth
                        @if (auth()->user()->role === 'admin')
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle text-primary fw-bold" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user-shield me-1"></i>
                                    مدیریت سایت
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="adminDropdown">

                                    <a href="{{ route('view.panel') }}" class="dropdown-item">
                                        <i class="fas fa-tachometer-alt me-2"></i>
                                        داشبورد مدیریت
                                    </a>

                                    <div class="dropdown-divider"></div>

                                    <a href="{{ route('admin.productGroup.index') }}" class="dropdown-item">
                                        <i class="fas fa-layer-group me-2"></i>
                                        گروه‌های محصولات
                                    </a>
                                    <a href="{{ route('admin.category.index') }}" class="dropdown-item">
                                        <i class="fas fa-list me-2"></i>
                                        دسته‌بندی‌ها
                                    </a>
                                    <a href="{{ route('admin.product.index') }}" class="dropdown-item">
                                        <i class="fas fa-boxes me-2"></i>
                                        محصولات
                                    </a>
                                    <a href="{{ route('admin.catalog.index') }}" class="dropdown-item">
                                        <i class="fas fa-file-pdf me-2"></i>
                                        کاتالوگ‌ها
                                    </a>
                                    <a href="{{ route('admin.gallery.index') }}" class="dropdown-item">
                                        <i class="fas fa-images me-2"></i>
                                        گالری تصاویر
                                    </a>
                                    <a href="{{ route('admin.trade-transaction.index') }}" class="dropdown-item">
                                        <i class="fas fa-handshake me-2"></i>
                                        معاملات انجام‌شده
                                    </a>
                                    <a href="{{ route('admin.buyer.index') }}" class="dropdown-item">
                                        <i class="fas fa-users me-2"></i>
                                        خریداران
                                    </a>
                                    <a href="{{ route('admin.contact.index') }}" class="dropdown-item">
                                        <i class="fas fa-envelope me-2"></i>
                                        پیام‌های تماس
                                    </a>

                                    <div class="dropdown-divider"></div>

                                    <a href="{{ route('admin.chatbot.faqs.index') }}" class="dropdown-item">
                                        <i class="fas fa-question-circle me-2"></i>
                                        مدیریت سوالات متداول
                                    </a>
                                    <a href="{{ route('admin.support.index') }}" class="dropdown-item">
                                        <i class="fas fa-headset me-2"></i>
                                        پشتیبانی کاربران
                                    </a>
                                </div>
                            </div>

                            <div class="nav-item px-2 d-flex align-items-center">
                                <form action="{{ route('logout', ['locale' => app()->getLocale()]) }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger py-2 px-3">
                                        <i class="fas fa-sign-out-alt me-1"></i>
                                        خروج
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endauth

                </div>
            </div>

            {{-- اطلاعات تماس --}}
            <div class="d-none d-xl-flex flex-shrink-0 ps-3">
                <a href="tel:+982188776655" class="btn btn-light btn-lg-square rounded-circle position-relative" aria-label="{{ __('home.navbar.call') }}">
                    <i class="fa fa-phone-alt fa-lg"></i>
                    <span class="position-absolute" style="top:3px;right:8px;">
                        <i class="fa fa-comment-dots text-secondary"></i>
                    </span>
                </a>
                <div class="d-flex flex-column ms-3">
                    <span class="small">{{ __('home.navbar.experts') }}</span>
                    <a href="tel:+982188776655" dir="ltr">
                        <span class="fw-semibold">{{ __('home.topbar.phone') }}</span>
                    </a>
                </div>
            </div>

        </nav>
    </div>
</div>

{{-- MAIN --}}
<main>
    @yield('content')
</main>

{{-- FLOATING CALL BUTTON --}}
@if ($locale === 'fa')
    <a href="tel:+982188776655"
       class="floating-call-button"
       aria-label="تماس با شرکت امیر آفاق گستر"
       title="تماس با ما"
       dir="ltr">
        <i class="fas fa-phone-alt"></i>
    </a>
@endif

{{-- FOOTER --}}
<footer class="container-fluid footer py-5">
    <div class="container py-3 py-lg-4">

        {{-- بخش اصلی فوتر --}}
        <div class="row g-4 g-xl-5">

            {{-- معرفی شرکت --}}
            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="footer-item footer-company">
                    <a href="{{ $homeUrl }}" class="footer-brand d-inline-flex align-items-center mb-3">
                        <span class="footer-brand-icon">
                            <i class="fas fa-parachute-box"></i>
                        </span>
                        <h3 class="text-white mb-0">
                            {{ __('home.footer.company_name') }}
                        </h3>
                    </a>
                    <p class="footer-description text-white mb-4">
                        {{ __('home.footer.description') }}
                    </p>

                    <div class="footer-social">
                        <a class="footer-social-link" href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a class="footer-social-link" href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                        <a class="footer-social-link" href="#" aria-label="Telegram"><i class="fab fa-telegram-plane"></i></a>
                        <a class="footer-social-link" href="#" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
            </div>

            {{-- لینک‌های سریع --}}
            <div class="col-xl-2 col-lg-6 col-md-6">
                <div class="footer-item">
                    <h4 class="footer-heading">
                        {{ __('home.footer.quick_links_title') }}
                    </h4>
                    <nav class="footer-links" aria-label="{{ __('home.footer.quick_links_title') }}">

                        <a href="{{ $aboutUrl }}">
                            <i class="fas fa-angle-left"></i>
                            <span>{{ __('home.footer.links.about') }}</span>
                        </a>
                        <a href="{{ $defenseUrl }}">
                            <i class="fas fa-angle-left"></i>
                            <span>{{ __('home.footer.links.defense_balloons') }}</span>
                        </a>
                        <a href="{{ $advertisingUrl }}">
                            <i class="fas fa-angle-left"></i>
                            <span>{{ __('home.footer.links.advertising_balloons') }}</span>
                        </a>
                        <a href="{{ $researchUrl }}">
                            <i class="fas fa-angle-left"></i>
                            <span>{{ __('home.footer.links.research_balloons') }}</span>
                        </a>
                        <a href="{{ $projectsUrl }}">
                            <i class="fas fa-angle-left"></i>
                            <span>{{ __('home.footer.links.projects') }}</span>
                        </a>
                        <a href="{{ $contactUrl }}">
                            <i class="fas fa-angle-left"></i>
                            <span>{{ __('home.footer.links.contact') }}</span>
                        </a>
                    </nav>
                </div>
            </div>

            {{-- ورود و ثبت‌نام --}}
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="footer-item footer-auth-box">
                    <h4 class="footer-heading">
                        {{ __('home.footer.account_title') }}
                    </h4>
                    <p class="footer-auth-description">
                        {{ __('home.footer.account_description') }}
                    </p>
                    <div class="footer-auth-actions">
                        <a href="{{ route('login', ['locale' => app()->getLocale()]) }}" class="footer-auth-btn footer-login-btn">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>{{ __('home.footer.login') }}</span>
                        </a>
                        <a href="{{ route('register', ['locale' => app()->getLocale()]) }}" class="footer-auth-btn footer-register-btn">
                            <i class="fas fa-user-plus"></i>
                            <span>{{ __('home.footer.register') }}</span>
                        </a>
                    </div>
                    <div class="footer-auth-note">
                        <i class="fas fa-shield-alt"></i>
                        <span>{{ __('home.footer.account_note') }}</span>
                    </div>
                </div>
            </div>

            {{-- گالری --}}
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="footer-item">
                    <h4 class="footer-heading">
                        {{ __('home.footer.gallery_title') }}
                    </h4>
                    <div class="row g-2 footer-gallery">
                        @for ($n = 1; $n <= 6; $n++)
                            @php $galleryImage = asset("img/instagram-footer-$n.jpg"); @endphp
                            <div class="col-4">
                                <div class="footer-gallery-item">
                                    <a href="{{ $galleryImage }}" data-lightbox="footerGallery" aria-label="{{ __('home.footer.view_image') }}">
                                        <img src="{{ $galleryImage }}" class="img-fluid" loading="lazy" decoding="async" width="120" height="120" alt="{{ __('home.footer.gallery_image_alt', ['number' => $n]) }}">
                                        <span class="footer-gallery-overlay">
                                            <i class="fas fa-search-plus"></i>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>

        </div>

        {{-- خط جداکننده --}}
        <div class="footer-divider"></div>

        {{-- اطلاعات تماس و اینماد --}}
        <div class="row g-4 align-items-stretch">

            <div class="col-lg-3 col-md-6">
                <div class="footer-contact-item">
                    <div class="footer-contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="footer-contact-content">
                        <h5>{{ __('home.footer.address_title') }}</h5>
                        <p>{{ __('home.footer.address') }}</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="footer-contact-item">
                    <div class="footer-contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="footer-contact-content">
                        <h5>{{ __('home.footer.email_title') }}</h5>
                        <a href="mailto:info@amirafaq.ir" dir="ltr">info@amirafaq.ir</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="footer-contact-item">
                    <div class="footer-contact-icon">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <div class="footer-contact-content">
                        <h5>{{ __('home.footer.phone_title') }}</h5>
                        <a href="tel:+982188776655" dir="ltr">{{ __('home.footer.phone') }}</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="footer-enamad-box">
                    <h5 class="footer-enamad-title">{{ __('home.footer.enamad_title') }}</h5>
                    <div class="footer-enamad-placeholder" aria-label="{{ __('home.footer.enamad_placeholder') }}">
                        {{-- تصویر اینماد --}}
                    </div>
                    <p class="footer-enamad-description">{{ __('home.footer.enamad_description') }}</p>
                </div>
            </div>

        </div>

        {{-- کپی‌رایت --}}
        <div class="footer-copyright">
            <p class="mb-0">
                &copy; {{ date('Y') }}
                <span class="footer-copyright-name">{{ __('home.footer.company_name') }}</span>
                <span>{{ __('home.footer.copyright') }}</span>
            </p>
        </div>

    </div>
</footer>

{{-- COPYRIGHT BAR --}}
<div class="container-fluid copyright py-3">
    <div class="container">
        <div class="row align-items-center g-2">
            <div class="col-md-6 text-center text-md-end">
                <span>
                    <a href="{{ $homeUrl }}">
                        <i class="fas fa-copyright me-1"></i>
                        {{ __('home.footer.company_name') }}
                    </a>
                    ، {{ __('home.footer.copyright') }}
                </span>
            </div>
            <div class="col-md-6 text-center text-md-start">
                {{ __('home.footer.designed_by') }}
                <a href="https://takhticompany.com" target="_blank" rel="noopener noreferrer">
                    {{ __('home.footer.designer') }}
                </a>
            </div>
        </div>
    </div>
</div>

{{-- BACK TO TOP --}}
<a href="#" class="btn btn-primary btn-lg-square rounded-circle back-to-top" aria-label="{{ __('home.back_to_top') }}">
    <i class="fa fa-arrow-up"></i>
</a>

{{-- CHAT WIDGET --}}
<button type="button" id="jrChatLauncher" class="jr-chat-launcher" aria-label="Open chat" aria-expanded="false">
    <i class="fas fa-comments"></i>
    <span class="jr-badge" id="jrChatBadge">1</span>
</button>

<div id="jrChatPanel" class="jr-chat-panel" role="dialog" aria-label="Chat with support">
    <div class="jr-chat-header">
        <div class="jr-avatar">
            <i class="fas fa-headset"></i>
        </div>
        <div class="jr-titles">
            <h6>مشاوره تخصصی بالن</h6>
            <div class="jr-status">
                <span class="jr-dot"></span>
                <span id="jrStatusText">آنلاین — کارشناس فنی آماده پاسخ است</span>
            </div>
        </div>
        <button type="button" class="jr-chat-close" id="jrChatClose" aria-label="Close chat">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <div class="jr-chat-body" id="jrChatBody">
        <div class="jr-placeholder" id="jrPlaceholder">
            <i class="fas fa-comments"></i>
            سلام! 👋<br>
            به دنبال چه نوع بالونی هستید؟<br>
            <strong>نظامی / تبلیغاتی / پژوهشی</strong>
        </div>
    </div>

    <div class="jr-chat-input">
        <input type="text" id="jrMessageInput" placeholder="پیام خود را بنویسید..." autocomplete="off" maxlength="500" aria-label="Message">
        <button type="button" id="jrSendButton" aria-label="Send message">
            <i class="fas fa-paper-plane"></i>
        </button>
    </div>
</div>

{{-- JAVASCRIPT --}}
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('lib/wow/wow.min.js') }}"></script>
<script src="{{ asset('lib/easing/easing.min.js') }}"></script>
<script src="{{ asset('lib/waypoints/waypoints.min.js') }}"></script>
<script src="{{ asset('lib/counterup/counterup.min.js') }}"></script>
<script src="{{ asset('lib/lightbox/js/lightbox.min.js') }}"></script>
<script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>

{{-- LANGUAGE DROPDOWN --}}
<script>
    (function () {
        'use strict';
        var wrapper = document.getElementById('languageDropdownWrapper');
        var toggle  = document.getElementById('languageDropdown');
        if (!wrapper || !toggle) return;
        var menu = wrapper.querySelector('.dropdown-menu');
        if (!menu) return;

        function openMenu()  { menu.classList.add('show');    toggle.setAttribute('aria-expanded', 'true');  }
        function closeMenu() { menu.classList.remove('show'); toggle.setAttribute('aria-expanded', 'false'); }
        function isOpen()    { return menu.classList.contains('show'); }

        toggle.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            isOpen() ? closeMenu() : openMenu();
        });
        menu.addEventListener('click', function (e) { e.stopPropagation(); });
        document.addEventListener('click', function (e) {
            if (!wrapper.contains(e.target)) closeMenu();
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && isOpen()) closeMenu();
        });
        document.querySelectorAll('[data-bs-toggle="dropdown"]').forEach(function (el) {
            el.addEventListener('click', closeMenu);
        });
    })();
</script>

{{-- SPINNER --}}
<script>
    (function () {
        'use strict';
        function hideSpinner() {
            var spinner = document.getElementById('spinner');
            if (!spinner) return;
            spinner.classList.remove('show');
            spinner.setAttribute('aria-hidden', 'true');
            setTimeout(function () { spinner.style.display = 'none'; }, 300);
        }
        document.addEventListener('DOMContentLoaded', function () { setTimeout(hideSpinner, 250); }, { once: true });
        window.addEventListener('load', hideSpinner, { once: true });
        setTimeout(hideSpinner, 2500);
    })();
</script>

{{-- CHAT WIDGET LOGIC — بدون دوبار ارسال --}}
<script>
    (function () {
        'use strict';

        var launcher    = document.getElementById('jrChatLauncher');
        var panel       = document.getElementById('jrChatPanel');
        var closeBtn    = document.getElementById('jrChatClose');
        var body        = document.getElementById('jrChatBody');
        var input       = document.getElementById('jrMessageInput');
        var sendBtn     = document.getElementById('jrSendButton');
        var placeholder = document.getElementById('jrPlaceholder');
        var badge       = document.getElementById('jrChatBadge');

        if (!launcher || !panel || !body || !input || !sendBtn) return;

        var csrfElement = document.querySelector('meta[name="csrf-token"]');
        var CSRF        = csrfElement ? csrfElement.getAttribute('content') : '';

        var SEND_URL = @json(route('chatbot.send', ['locale' => app()->getLocale()]));
        var POLL_URL = @json(route('chatbot.messages', ['locale' => app()->getLocale()]));

        var isOpen             = false;
        var placeholderRemoved = false;
        var lastMessageId      = 0;
        var pollingTimer       = null;
        var isSending          = false;
        var renderedIds        = {};

        function openChat() {
            panel.classList.add('jr-open');
            isOpen = true;
            launcher.setAttribute('aria-expanded', 'true');
            if (badge) badge.style.display = 'none';
            input.focus();
            scrollToBottom();
            pollMessages();
        }

        function closeChat() {
            panel.classList.remove('jr-open');
            isOpen = false;
            launcher.setAttribute('aria-expanded', 'false');
        }

        launcher.addEventListener('click', function () {
            isOpen ? closeChat() : openChat();
        });

        closeBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            closeChat();
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && isOpen) closeChat();
        });

        function scrollToBottom() {
            requestAnimationFrame(function () {
                body.scrollTop = body.scrollHeight;
            });
        }

        function formatTime(dateString) {
            var d = dateString ? new Date(dateString) : new Date();
            if (isNaN(d.getTime())) d = new Date();
            var h = d.getHours(), m = d.getMinutes();
            return (h < 10 ? '0' + h : h) + ':' + (m < 10 ? '0' + m : m);
        }

        function removePlaceholder() {
            if (placeholderRemoved) return;
            if (placeholder && placeholder.parentNode) placeholder.remove();
            placeholderRemoved = true;
        }

        function updateStatusText(text) {
            var el = document.getElementById('jrStatusText');
            if (el) el.textContent = text;
        }

        function addMessage(text, type, time) {
            removePlaceholder();
            var cssType = (type === 'user' || type === 'visitor') ? 'user' : 'bot';
            var div = document.createElement('div');
            div.className = 'jr-msg jr-msg-' + cssType;
            var span = document.createElement('span');
            span.textContent = text;
            div.appendChild(span);
            var t = document.createElement('span');
            t.className = 'jr-msg-time';
            t.textContent = time || formatTime();
            div.appendChild(t);
            body.appendChild(div);
            scrollToBottom();
        }

        function showTyping() {
            if (document.getElementById('jrTypingIndicator')) return;
            removePlaceholder();
            var div = document.createElement('div');
            div.className = 'jr-typing';
            div.id = 'jrTypingIndicator';
            for (var i = 0; i < 3; i++) div.appendChild(document.createElement('span'));
            body.appendChild(div);
            scrollToBottom();
        }

        function hideTyping() {
            var el = document.getElementById('jrTypingIndicator');
            if (el) el.remove();
        }

        function renderServerMessages(messages) {
            if (!Array.isArray(messages) || !messages.length) return 0;
            var added = 0;
            messages.forEach(function (msg) {
                var id = Number(msg.id);
                if (!id) return;
                if (renderedIds[id]) {
                    if (id > lastMessageId) lastMessageId = id;
                    return;
                }
                renderedIds[id] = true;
                if (id > lastMessageId) lastMessageId = id;
                addMessage(msg.content, msg.sender_type, formatTime(msg.created_at));
                added++;
            });
            return added;
        }

        function updateStatusFromState(status) {
            if (status === 'waiting_for_agent') {
                updateStatusText('در انتظار پاسخ کارشناس...');
            } else if (status === 'assigned') {
                updateStatusText('کارشناس متصل شد');
            } else if (status === 'bot') {
                updateStatusText('آنلاین — آماده پاسخگویی');
            } else if (status === 'closed') {
                updateStatusText('این گفتگو بسته شده است');
            }
        }

        function sendMessage() {
            var text = input.value.trim();
            if (!text || isSending) return;
            isSending = true;
            sendBtn.disabled = true;
            input.value = '';
            input.focus();
            showTyping();

            fetch(SEND_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin',
                body: JSON.stringify({ content: text })
            })
                .then(function (res) {
                    if (!res.ok) throw new Error('HTTP ' + res.status);
                    return res.json();
                })
                .then(function (data) {
                    hideTyping();
                    if (data && Array.isArray(data.messages)) {
                        renderServerMessages(data.messages);
                    }
                    updateStatusFromState(data && data.status);
                })
                .catch(function (err) {
                    console.error('[chat] send error:', err);
                    hideTyping();
                    input.value = text;
                    var errorId = Date.now();
                    renderedIds[errorId] = true;
                    addMessage('خطا در ارسال پیام. لطفاً دوباره تلاش کنید.', 'bot');
                })
                .finally(function () {
                    isSending = false;
                    sendBtn.disabled = false;
                });
        }

        sendBtn.addEventListener('click', sendMessage);

        input.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendMessage();
            }
        });

        function pollMessages() {
            fetch(POLL_URL + '?after_id=' + lastMessageId, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            })
                .then(function (res) { return res.ok ? res.json() : null; })
                .then(function (data) {
                    if (!data) return;
                    var newCount = 0;
                    if (Array.isArray(data.messages) && data.messages.length) {
                        newCount = renderServerMessages(data.messages);
                    }
                    if (!isOpen && newCount > 0 && badge) {
                        var current = parseInt(badge.textContent || '0', 10) || 0;
                        badge.style.display = 'block';
                        badge.textContent = String(current + newCount);
                    }
                    updateStatusFromState(data.status);
                })
                .catch(function () { /* silent */ });
        }

        function startPolling() {
            if (pollingTimer) return;
            pollingTimer = setInterval(pollMessages, 3000);
        }

        (function initialLoad() {
            fetch(POLL_URL + '?after_id=0', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            })
                .then(function (res) { return res.ok ? res.json() : null; })
                .then(function (data) {
                    if (data && Array.isArray(data.messages)) {
                        renderServerMessages(data.messages);
                    }
                    if (data) updateStatusFromState(data.status);
                })
                .catch(function () { /* silent */ });
        })();

        startPolling();

        document.addEventListener('visibilitychange', function () {
            if (document.hidden) {
                if (pollingTimer) { clearInterval(pollingTimer); pollingTimer = null; }
                pollingTimer = setInterval(pollMessages, 10000);
            } else {
                if (pollingTimer) clearInterval(pollingTimer);
                pollingTimer = null;
                pollMessages();
                startPolling();
            }
        });

    })();
</script>
@yield('scripts')

</body>
</html>

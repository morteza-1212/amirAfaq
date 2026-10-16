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
    | Localized URLs
    |--------------------------------------------------------------------------
    */
    $homeUrl       = url($locale);
    $aboutUrl      = url($locale . '/about');
    $blogExportUrl = url($locale . '/blog/export');
    $servicesUrl   = url($locale . '/services');
    $productsUrl   = url($locale . '/product-export');
    $exportUrl     = url($locale . '/export');
    $importUrl     = url($locale . '/import');
    $logisticsUrl  = url($locale . '/logistics');
    $teamUrl       = url($locale . '/team');
    $contactUrl    = url($locale . '/contact');
    $suppliersUrl  = url($locale . '/suppliers');
    $marketsUrl    = url($locale . '/markets');
    $catalogs      = url($locale . '/catalogs');
    $contact       = url($locale . '/contact');
    $buyer         = url($locale . '/buyer');
    $gallery       = url($locale . '/gallery');
    $projectsUrl   = url($locale . '/projects');

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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://static.neshan.org/sdk/mapboxgl/v1.13.2/neshan-sdk/v1.1.3/index.css" />
    <script src="https://static.neshan.org/sdk/mapboxgl/v1.13.2/neshan-sdk/v1.1.3/index.js" defer></script>
    <meta name="description" content="{{ __('home.meta.description') }}">
    <meta name="keywords" content="{{ __('home.meta.keywords') }}">
    <meta name="language" content="{{ $locale }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', __('home.meta.title'))</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('lib/animate/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lib/lightbox/css/lightbox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <style>
        /* =========================================================
           ROOT
        ========================================================= */
        :root {
            --site-primary: #1b361e;
            --site-primary-dark: #132b17;
            --site-secondary: #d6a84f;
            --site-light: #f7f8f4;
            --site-text: #26352a;
            --site-muted: #6c757d;
            --site-border: rgba(27, 54, 30, .12);
            --site-radius: 12px;
            --site-radius-lg: 18px;
            --site-shadow: 0 8px 30px rgba(0, 0, 0, .06);
            --site-transition: all .25s ease;
        }

        /* =========================================================
           RESET
        ========================================================= */
        *,
        *::before,
        *::after { box-sizing: border-box; }

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

        /* =========================================================
           DIRECTION
        ========================================================= */
        html[dir="rtl"] body { direction: rtl; text-align: right; }
        html[dir="ltr"] body { direction: ltr; text-align: left; }

        /* =========================================================
           CONTAINER
        ========================================================= */
        .container { width: 100%; }
        @media (min-width: 1200px) { .container { max-width: 1180px; } }
        @media (min-width: 1400px) { .container { max-width: 1240px; } }

        /* =========================================================
           TOPBAR
        ========================================================= */
        .topbar {
            position: relative;
            z-index: 1030;
            border-bottom: 1px solid rgba(27, 54, 30, .06);
        }
        .topbar a { transition: var(--site-transition); }
        .topbar a:hover { color: var(--site-primary) !important; }
        .topbar .border-primary { border-color: rgba(27, 54, 30, .18) !important; }
        .topbar .text-primary { color: var(--site-primary) !important; }
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
            background: #0F1C05;
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
            color: #26352a !important;
            font-size: 14px;
            font-weight: 600;
            white-space: nowrap;
            border-radius: 8px;
            transition: var(--site-transition);
        }
        .navbar-nav .nav-link:hover {
            color: var(--site-primary) !important;
            background: rgba(27, 54, 30, .05);
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
            min-width: 210px;
            margin-top: 8px;
            padding: 8px;
            border: 0;
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 15px 45px rgba(0, 0, 0, .12);
        }
        .navbar .dropdown-item {
            padding: 10px 13px;
            color: #26352a;
            font-size: 14px;
            font-weight: 500;
            border-radius: 8px;
            transition: var(--site-transition);
        }
        .navbar .dropdown-item:hover { color: #fff; background: var(--site-primary); }
        .nav-btn { display: flex; align-items: center; }
        .nav-btn .btn {
            min-width: 125px;
            border-radius: 9px;
            font-size: 14px;
            font-weight: 600;
            white-space: nowrap;
        }
        .nav-bar .btn-light {
            width: 54px;
            height: 54px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(27, 54, 30, .08);
            box-shadow: 0 5px 18px rgba(0, 0, 0, .05);
        }
        .nav-bar .btn-light:hover { transform: translateY(-2px); }
        .navbar-toggler {
            width: 48px;
            height: 44px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(27, 54, 30, .15);
            border-radius: 9px;
            color: var(--site-primary);
            background: #fff;
            box-shadow: none !important;
        }
        .navbar-toggler:focus { box-shadow: 0 0 0 3px rgba(27, 54, 30, .1) !important; }

        main { width: 100%; min-height: 300px; overflow: hidden; }

        /* =========================================================
           FOOTER
        ========================================================= */
        .footer {
            position: relative;
            background: #162d19;
            color: rgba(255, 255, 255, .78);
        }
        .footer::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--site-primary), var(--site-secondary), var(--site-primary));
        }
        .footer-item h3 { margin-bottom: 18px; font-size: 21px; font-weight: 700; }
        .footer-item h4 { font-size: 17px; font-weight: 700; }
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
            background: rgba(27, 54, 30, .65);
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
        .copyright { background: #102313; border-top: 1px solid rgba(255, 255, 255, .06); }
        .copyright span, .copyright div { font-size: 13px; line-height: 2; }
        .copyright a { color: #fff; }
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
            box-shadow: 0 8px 25px rgba(0, 0, 0, .15);
            transition: var(--site-transition);
        }
        .back-to-top:hover { opacity: 1; transform: translateY(-4px); }
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
            box-shadow: 0 6px 24px rgba(27, 54, 30, .35);
            transition: transform .25s ease, box-shadow .25s ease;
        }
        [dir="rtl"] .jr-chat-launcher { left: auto; right: 22px; }
        .jr-chat-launcher:hover {
            transform: translateY(-4px) scale(1.04);
            box-shadow: 0 10px 32px rgba(27, 54, 30, .45);
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
            box-shadow: 0 20px 60px rgba(0, 0, 0, .18), 0 0 0 1px rgba(27, 54, 30, .06);
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
            background: rgba(255, 255, 255, .15);
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
        .jr-chat-close:hover { background: rgba(255, 255, 255, .25); }

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
            background: rgba(27, 54, 30, .2);
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
            color: var(--site-primary);
            opacity: .5;
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
            border-color: var(--site-primary);
            box-shadow: 0 0 0 3px rgba(27, 54, 30, .1);
            background: #fff;
        }
        .jr-chat-input input::placeholder { color: #a0a8a2; }
        .jr-chat-input button {
            width: 44px; height: 44px;
            border: none;
            border-radius: 50%;
            background: var(--site-primary);
            color: #fff;
            font-size: 18px;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            transition: background .2s ease, transform .15s ease;
        }
        .jr-chat-input button:hover {
            background: var(--site-primary-dark);
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
            .nav-btn .btn { min-width: 105px; padding-left: 14px; padding-right: 14px; }
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
                border: 1px solid rgba(27, 54, 30, .08);
                border-radius: 12px;
                box-shadow: 0 12px 30px rgba(0, 0, 0, .07);
            }
            .navbar-nav {
                width: 100%;
                align-items: stretch;
                gap: 3px;
            }
            .navbar-nav .nav-link {
                width: 100%;
                min-height: 44px;
                justify-content: flex-start;
                padding: 10px 13px !important;
                border-radius: 8px;
                color: #26352a !important;
            }
            [dir="rtl"] .navbar-nav .nav-link { text-align: right; }
            [dir="ltr"] .navbar-nav .nav-link { text-align: left; }
            .navbar-nav .nav-link.active::after { display: none; }
            .navbar-nav .nav-link.active { background: rgba(27, 54, 30, .06); }
            .navbar .dropdown-menu {
                width: 100%;
                min-width: 0;
                margin-top: 3px;
                padding: 5px;
                box-shadow: none;
                border: 1px solid rgba(27, 54, 30, .07);
                background: #fafbf8;
            }
            .navbar .dropdown-item { padding: 9px 12px; color: #26352a; }
            .nav-btn { width: 100%; padding: 8px 0 2px !important; }
            .nav-btn .btn { width: 100%; margin: 0 !important; }
            .topbar .border-end { border-right: 0 !important; border-left: 0 !important; }
            main { min-height: 250px; }
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
        /* =========================================================
   FLOATING CALL BUTTON — ONLY PERSIAN
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

            background: linear-gradient(
                135deg,
                #1b361e 0%,
                #132b17 100%
            );

            color: #fff;
            font-size: 23px;

            border: 2px solid rgba(214, 168, 79, 0.8);
            border-radius: 50%;

            box-shadow: 0 6px 22px rgba(27, 54, 30, 0.3);

            text-decoration: none;
            z-index: 1035;

            transition:
                transform 0.25s ease,
                box-shadow 0.25s ease,
                background 0.25s ease;
        }

        /* Hover */
        .floating-call-button:hover {
            color: #fff;
            background: #d6a84f;
            transform: translateY(-4px) scale(1.05);
            box-shadow: 0 10px 28px rgba(27, 54, 30, 0.4);
        }

        /* Click */
        .floating-call-button:active {
            transform: scale(0.95);
        }

        /* موقعیت در موبایل */
        @media (max-width: 767.98px) {
            .floating-call-button {
                width: 52px;
                height: 52px;
                right: 16px;
                bottom: 84px;
                font-size: 21px;
            }
        }

        /* صفحه‌نمایش کوچک */
        @media (max-width: 380px) {
            .floating-call-button {
                width: 48px;
                height: 48px;
                right: 12px;
                bottom: 80px;
                font-size: 19px;
            }
        }

        /* انیمیشن ملایم */
        @media (prefers-reduced-motion: no-preference) {
            .floating-call-button {
                animation: floatingCallPulse 2.5s infinite;
            }
        }

        @keyframes floatingCallPulse {
            0%, 100% {
                box-shadow: 0 6px 22px rgba(27, 54, 30, 0.3);
            }

            50% {
                box-shadow: 0 6px 28px rgba(214, 168, 79, 0.45);
            }
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
<div class="container-fluid topbar px-0 bg-light">
    <div class="container">
        <div class="row gx-0 align-items-center py-2">
            <div class="col-lg-8 col-md-7 col-12">
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-start">
                    <div class="pe-3">
                        <a href="{{ $contactUrl }}" class="text-muted small">
                            <i class="fas fa-map-marker-alt text-primary me-1"></i>
                            {{ __('home.topbar.address') }}
                        </a>
                    </div>
                    <div class="ps-3 pe-3 border-start">
                        <a href="mailto:info@keshtavaran.ir" class="text-muted small">
                            <i class="fas fa-envelope text-primary me-1"></i>
                            info@keshtavaran.ir
                        </a>
                    </div>
                    <div class="ps-3">
                        <a href="tel:+989150398636" class="text-muted small" dir="ltr">
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
                        <a href="javascript:void(0)" class="dropdown-toggle d-inline-flex align-items-center" id="languageDropdown" role="button" aria-haspopup="true" aria-expanded="false" style="color: #26352a; font-weight: 600;">
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
                    <a
                        href="{{ $homeUrl }}"
                        class="nav-item nav-link {{ request()->is($locale) || request()->is($locale . '/') ? 'active' : '' }}"
                    >
                        {{ __('home.navbar.home') }}
                    </a>

                    {{-- درباره ما --}}
                    <a
                        href="{{ $aboutUrl }}"
                        class="nav-item nav-link {{ request()->is($locale . '/about') ? 'active' : '' }}"
                    >
                        {{ __('home.navbar.about') }}
                    </a>

                    {{-- پروژه‌ها --}}
                    <a
                        href="{{ $projectsUrl }}"
                        class="nav-item nav-link {{ request()->is($locale . '/project*') ? 'active' : '' }}"
                    >
                        {{ __('home.navbar.projects') }}
                    </a>

                    {{-- بخش‌های سایت --}}
                    <div class="nav-item dropdown">

                        <a
                            href="#"
                            class="nav-link dropdown-toggle"
                            id="sectionsDropdown"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                        >
                            {{ __('home.navbar.sections') }}
                        </a>

                        <div
                            class="dropdown-menu"
                            aria-labelledby="sectionsDropdown"
                        >
                            <a href="{{ $productsUrl }}" class="dropdown-item">
                                {{ __('home.navbar.export_products') }}
                            </a>

                            <a href="{{ $exportUrl }}" class="dropdown-item">
                                {{ __('home.navbar.export') }}
                            </a>

                            <a href="{{ $importUrl }}" class="dropdown-item">
                                {{ __('home.navbar.import') }}
                            </a>

                            <a href="{{ $marketsUrl }}" class="dropdown-item">
                                {{ __('home.navbar.markets') }}
                            </a>

                            <a href="{{ $suppliersUrl }}" class="dropdown-item">
                                {{ __('home.navbar.suppliers') }}
                            </a>

                            <a href="{{ $logisticsUrl }}" class="dropdown-item">
                                {{ __('home.navbar.logistics') }}
                            </a>

                            <a href="{{ $homeUrl }}#team" class="dropdown-item">
                                {{ __('home.navbar.team') }}
                            </a>

                            <a href="{{ $catalogs }}" class="dropdown-item">
                                {{ __('home.navbar.catalogs') }}
                            </a>

                            <a href="{{ $buyer }}" class="dropdown-item">
                                {{ __('home.navbar.buyer') }}
                            </a>

                            <a href="{{ $gallery }}" class="dropdown-item">
                                {{ __('home.navbar.gallery') }}
                            </a>
                        </div>
                    </div>

                    {{-- تماس با ما --}}
                    <a
                        href="{{ $contact }}"
                        class="nav-item nav-link {{ request()->is($locale . '/contact') ? 'active' : '' }}"
                    >
                        {{ __('home.navbar.contact') }}
                    </a>

                    {{-- همکاری تجاری --}}
                    <div class="nav-btn px-2">
                        <a
                            href="{{ $contactUrl }}"
                            class="btn btn-primary py-2 px-4"
                        >
                            {{ __('home.navbar.cooperation') }}
                        </a>
                    </div>

                    {{-- ======================================== --}}
                    {{-- منوی مدیریت مخصوص ادمین --}}
                    {{-- ======================================== --}}

                    @auth
                        @if (auth()->user()->role === 'admin')

                            <div class="nav-item dropdown">

                                <a
                                    href="#"
                                    class="nav-link dropdown-toggle text-primary fw-bold"
                                    id="adminDropdown"
                                    role="button"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false"
                                >
                                    <i class="fas fa-user-shield me-1"></i>
                                    مدیریت سایت
                                </a>

                                <div
                                    class="dropdown-menu dropdown-menu-end"
                                    aria-labelledby="adminDropdown"
                                >

                                    {{-- داشبورد مدیریت --}}
                                    <a
                                        href="{{ route('view.panel') }}"
                                        class="dropdown-item"
                                    >
                                        <i class="fas fa-tachometer-alt me-2"></i>
                                        داشبورد مدیریت
                                    </a>

                                    <div class="dropdown-divider"></div>

                                    {{-- گروه محصولات --}}
                                    <a
                                        href="{{ route('admin.productGroup.index') }}"
                                        class="dropdown-item"
                                    >
                                        <i class="fas fa-layer-group me-2"></i>
                                        گروه‌های محصولات
                                    </a>

                                    {{-- دسته‌بندی‌ها --}}
                                    <a
                                        href="{{ route('admin.category.index') }}"
                                        class="dropdown-item"
                                    >
                                        <i class="fas fa-list me-2"></i>
                                        دسته‌بندی‌ها
                                    </a>

                                    {{-- محصولات --}}
                                    <a
                                        href="{{ route('admin.product.index') }}"
                                        class="dropdown-item"
                                    >
                                        <i class="fas fa-boxes me-2"></i>
                                        محصولات
                                    </a>

                                    {{-- کاتالوگ‌ها --}}
                                    <a
                                        href="{{ route('admin.catalog.index') }}"
                                        class="dropdown-item"
                                    >
                                        <i class="fas fa-file-pdf me-2"></i>
                                        کاتالوگ‌ها
                                    </a>

                                    {{-- گالری تصاویر --}}
                                    <a
                                        href="{{ route('admin.gallery.index') }}"
                                        class="dropdown-item"
                                    >
                                        <i class="fas fa-images me-2"></i>
                                        گالری تصاویر
                                    </a>

                                    {{-- معاملات --}}
                                    <a
                                        href="{{ route('admin.trade-transaction.index') }}"
                                        class="dropdown-item"
                                    >
                                        <i class="fas fa-handshake me-2"></i>
                                        معاملات انجام‌شده
                                    </a>

                                    {{-- خریداران --}}
                                    <a
                                        href="{{ route('admin.buyer.index') }}"
                                        class="dropdown-item"
                                    >
                                        <i class="fas fa-users me-2"></i>
                                        خریداران
                                    </a>

                                    {{-- پیام‌های تماس --}}
                                    <a
                                        href="{{ route('admin.contact.index') }}"
                                        class="dropdown-item"
                                    >
                                        <i class="fas fa-envelope me-2"></i>
                                        پیام‌های تماس
                                    </a>

                                    <div class="dropdown-divider"></div>

                                    {{-- مدیریت سوالات متداول --}}
                                    <a
                                        href="{{ route('admin.chatbot.faqs.index') }}"
                                        class="dropdown-item"
                                    >
                                        <i class="fas fa-question-circle me-2"></i>
                                        مدیریت سوالات متداول
                                    </a>

                                    {{-- پشتیبانی کاربران --}}
                                    <a
                                        href="{{ route('admin.support.index') }}"
                                        class="dropdown-item"
                                    >
                                        <i class="fas fa-headset me-2"></i>
                                        پشتیبانی کاربران
                                    </a>

                                </div>
                            </div>

                            {{-- ======================================== --}}
                            {{-- دکمه خروج از حساب ادمین --}}
                            {{-- ======================================== --}}

                            <div class="nav-item px-2 d-flex align-items-center">

                                <form
                                    action="{{ route('logout') }}"
                                    method="POST"
                                    class="m-0"
                                >
                                    @csrf

                                    <button
                                        type="submit"
                                        class="btn btn-outline-danger py-2 px-3"
                                    >
                                        <i class="fas fa-sign-out-alt me-1"></i>
                                        خروج از پنل
                                    </button>
                                </form>

                            </div>

                        @endif
                    @endauth

                </div>
            </div>

            {{-- اطلاعات تماس --}}
            <div class="d-none d-xl-flex flex-shrink-0 ps-3">

                <a
                    href="tel:+982188776655"
                    class="btn btn-light btn-lg-square rounded-circle position-relative"
                    aria-label="{{ __('home.navbar.call') }}"
                >
                    <i class="fa fa-phone-alt fa-lg"></i>

                    <span
                        class="position-absolute"
                        style="top:3px;right:8px;"
                    >
                        <i class="fa fa-comment-dots text-secondary"></i>
                    </span>
                </a>

                <div class="d-flex flex-column ms-3">

                    <span class="small">
                        {{ __('home.navbar.experts') }}
                    </span>

                    <a href="tel:+982188776655" dir="ltr">
                        <span class="fw-semibold">
                            {{ __('home.topbar.phone') }}
                        </span>
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
{{-- FLOATING CALL BUTTON: فقط زبان فارسی --}}
@if ($locale === 'fa')
    <a
        href="tel:+989150398636"
        class="floating-call-button"
        aria-label="تماس با شرکت امیر آفاق گستر"
        title="تماس با ما"
        dir="ltr"
    >
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

                    <a href="{{ $homeUrl }}"
                       class="footer-brand d-inline-flex align-items-center mb-3">

                        <span class="footer-brand-icon">
                            <i class="fas fa-seedling"></i>
                        </span>

                        <h3 class="text-white mb-0">
                            {{ __('home.footer.company_name') }}
                        </h3>
                    </a>

                    <p class="footer-description text-white mb-4">
                        {{ __('home.footer.description') }}
                    </p>

                    {{-- شبکه‌های اجتماعی --}}
                    <div class="footer-social">

                        <a class="footer-social-link"
                           href="#"
                           aria-label="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>

                        <a class="footer-social-link"
                           href="#"
                           aria-label="LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>

                        <a class="footer-social-link"
                           href="#"
                           aria-label="Telegram">
                            <i class="fab fa-telegram-plane"></i>
                        </a>

                        <a class="footer-social-link"
                           href="#"
                           aria-label="WhatsApp">
                            <i class="fab fa-whatsapp"></i>
                        </a>

                    </div>
                </div>
            </div>


            {{-- لینک‌های سریع --}}
            <div class="col-xl-2 col-lg-6 col-md-6">
                <div class="footer-item">

                    <h4 class="footer-heading">
                        {{ __('home.footer.quick_links_title') }}
                    </h4>

                    <nav class="footer-links"
                         aria-label="{{ __('home.footer.quick_links_title') }}">

                        <a href="{{ $aboutUrl }}">
                            <i class="fas fa-angle-left"></i>
                            <span>{{ __('home.footer.links.about') }}</span>
                        </a>

                        <a href="{{ $productsUrl }}">
                            <i class="fas fa-angle-left"></i>
                            <span>
                                {{ __('home.footer.links.agricultural_products') }}
                            </span>
                        </a>

                        <a href="{{ $productsUrl }}">
                            <i class="fas fa-angle-left"></i>
                            <span>
                                {{ __('home.footer.links.dairy_products') }}
                            </span>
                        </a>

                        <a href="{{ $exportUrl }}">
                            <i class="fas fa-angle-left"></i>
                            <span>{{ __('home.footer.links.export') }}</span>
                        </a>

                        <a href="{{ $importUrl }}">
                            <i class="fas fa-angle-left"></i>
                            <span>{{ __('home.footer.links.import') }}</span>
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

                        <a href="{{ route('login', ['locale' => app()->getLocale()]) }}"
                           class="footer-auth-btn footer-login-btn">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>{{ __('home.footer.login') }}</span>
                        </a>

                        <a href="{{ route('register', ['locale' => app()->getLocale()]) }}"
                           class="footer-auth-btn footer-register-btn">
                            <i class="fas fa-user-plus"></i>
                            <span>{{ __('home.footer.register') }}</span>
                        </a>

                    </div>

                    <div class="footer-auth-note">
                        <i class="fas fa-shield-alt"></i>

                        <span>
                            {{ __('home.footer.account_note') }}
                        </span>
                    </div>

                </div>
            </div>


            {{-- گالری تصاویر --}}
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="footer-item">

                    <h4 class="footer-heading">
                        {{ __('home.footer.gallery_title') }}
                    </h4>

                    <div class="row g-2 footer-gallery">

                        @for ($n = 1; $n <= 6; $n++)

                            @php
                                $galleryImage = asset("img/instagram-footer-$n.jpg");
                            @endphp

                            <div class="col-4">

                                <div class="footer-gallery-item">

                                    <a href="{{ $galleryImage }}"
                                       data-lightbox="footerGallery"
                                       aria-label="{{ __('home.footer.view_image') }}">

                                        <img
                                            src="{{ $galleryImage }}"
                                            class="img-fluid"
                                            loading="lazy"
                                            decoding="async"
                                            width="120"
                                            height="120"
                                            alt="{{ __('home.footer.gallery_image_alt', ['number' => $n]) }}"
                                        >

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

            {{-- آدرس --}}
            <div class="col-lg-3 col-md-6">
                <div class="footer-contact-item">

                    <div class="footer-contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>

                    <div class="footer-contact-content">

                        <h5>
                            {{ __('home.footer.address_title') }}
                        </h5>

                        <p>
                            {{ __('home.footer.address') }}
                        </p>

                    </div>

                </div>
            </div>


            {{-- ایمیل --}}
            <div class="col-lg-3 col-md-6">
                <div class="footer-contact-item">

                    <div class="footer-contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>

                    <div class="footer-contact-content">

                        <h5>
                            {{ __('home.footer.email_title') }}
                        </h5>

                        <a href="mailto:info@keshtavaran.ir"
                           dir="ltr">

                            info@keshtavaran.ir

                        </a>

                    </div>

                </div>
            </div>


            {{-- تلفن --}}
            <div class="col-lg-3 col-md-6">
                <div class="footer-contact-item">

                    <div class="footer-contact-icon">
                        <i class="fas fa-phone-alt"></i>
                    </div>

                    <div class="footer-contact-content">

                        <h5>
                            {{ __('home.footer.phone_title') }}
                        </h5>

                        <a href="tel:+982188776655"
                           dir="ltr">

                            {{ __('home.footer.phone') }}

                        </a>

                    </div>

                </div>
            </div>


            {{-- محل قرارگیری اینماد --}}
            <div class="col-lg-3 col-md-6">

                <div class="footer-enamad-box">

                    <h5 class="footer-enamad-title">
                        {{ __('home.footer.enamad_title') }}
                    </h5>

                    <div class="footer-enamad-placeholder"
                         aria-label="{{ __('home.footer.enamad_placeholder') }}">

                        {{-- تصویر یا کد رسمی اینماد را بعداً اینجا قرار دهید --}}

                    </div>

                    <p class="footer-enamad-description">
                        {{ __('home.footer.enamad_description') }}
                    </p>

                </div>

            </div>

        </div>


        {{-- کپی‌رایت --}}
        <div class="footer-copyright">

            <p class="mb-0">
                &copy; {{ date('Y') }}

                <span class="footer-copyright-name">
                    {{ __('home.footer.company_name') }}
                </span>

                <span>
                    {{ __('home.footer.copyright') }}
                </span>
            </p>

        </div>

    </div>
</footer>

{{-- COPYRIGHT --}}
<div class="container-fluid copyright py-3">
    <div class="container">
        <div class="row align-items-center g-2">
            <div class="col-md-6 text-center text-md-end">
                <span class="text-body">
                    <a href="{{ $homeUrl }}" class="border-bottom text-white">
                        <i class="fas fa-copyright text-light me-1"></i>
                        {{ __('home.footer.company_name') }}
                    </a>
                    ،
                    {{ __('home.footer.copyright') }}
                </span>
            </div>
            <div class="col-md-6 text-center text-md-start">
                {{ __('home.footer.designed_by') }}
                <a class="border-bottom text-white" href="https://takhticompany.com" target="_blank" rel="noopener noreferrer">
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

{{-- =========================================================
     CHAT WIDGET
========================================================== --}}
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
            <h6>پشتیبانی آنلاین</h6>
            <div class="jr-status">
                <span class="jr-dot"></span>
                <span id="jrStatusText">آنلاین — آماده پاسخگویی</span>
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
            چطور می‌توانم به شما کمک کنم؟
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
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

{{-- =========================================================
     CHAT WIDGET LOGIC — بدون دوبار ارسال
========================================================== --}}
<script>
    (function () {
        'use strict';

        /* =====================================================
           ELEMENTS
        ===================================================== */
        var launcher    = document.getElementById('jrChatLauncher');
        var panel       = document.getElementById('jrChatPanel');
        var closeBtn    = document.getElementById('jrChatClose');
        var body        = document.getElementById('jrChatBody');
        var input       = document.getElementById('jrMessageInput');
        var sendBtn     = document.getElementById('jrSendButton');
        var placeholder = document.getElementById('jrPlaceholder');
        var badge       = document.getElementById('jrChatBadge');

        if (!launcher || !panel || !body || !input || !sendBtn) return;

        /* =====================================================
           CONFIG
        ===================================================== */
        var CSRF     = document.querySelector('meta[name="csrf-token"]').content;
        var SEND_URL = '{{ route("chatbot.send") }}';
        var POLL_URL = '{{ route("chatbot.messages") }}';

        /* =====================================================
           STATE
        ===================================================== */
        var isOpen             = false;
        var placeholderRemoved = false;
        var lastMessageId      = 0;
        var pollingTimer       = null;
        var isSending          = false;
        var renderedIds        = {};   // برای جلوگیری از نمایش تکراری در UI

        /* =====================================================
           OPEN / CLOSE
        ===================================================== */
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

        /* =====================================================
           HELPERS
        ===================================================== */
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

        /**
         * افزودن پیام به UI
         */
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

        /* =====================================================
           TYPING INDICATOR
        ===================================================== */
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

        /* =====================================================
           RENDER SERVER MESSAGES (بدون تکرار)
        ===================================================== */
        function renderServerMessages(messages) {
            if (!Array.isArray(messages) || !messages.length) return 0;

            var added = 0;

            messages.forEach(function (msg) {
                var id = Number(msg.id);
                if (!id) return;

                // اگر قبلاً رندر شده، رد کن
                if (renderedIds[id]) {
                    if (id > lastMessageId) lastMessageId = id;
                    return;
                }

                renderedIds[id] = true;
                if (id > lastMessageId) lastMessageId = id;

                addMessage(
                    msg.content,
                    msg.sender_type,
                    formatTime(msg.created_at)
                );
                added++;
            });

            return added;
        }

        /* =====================================================
           STATUS
        ===================================================== */
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

        /* =====================================================
           SEND MESSAGE — بدون دوبار نمایش
        ===================================================== */
        function sendMessage() {
            var text = input.value.trim();
            if (!text || isSending) return;

            isSending = true;
            sendBtn.disabled = true;

            // پاک کردن input فوراً
            input.value = '';
            input.focus();

            // فقط typing نشان بده (پیام را فوری نمایش نده)
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

                    // نمایش پیام‌ها از پاسخ سرور (شامل پیام کاربر + پیام bot)
                    if (data && Array.isArray(data.messages)) {
                        renderServerMessages(data.messages);
                    }

                    updateStatusFromState(data && data.status);
                })
                .catch(function (err) {
                    console.error('[chat] send error:', err);
                    hideTyping();

                    // در صورت خطا، متن را برگردان به input
                    input.value = text;

                    // پیام خطا به‌عنوان bot نمایش بده
                    var errorId = Date.now();
                    renderedIds[errorId] = true;
                    addMessage(
                        'خطا در ارسال پیام. لطفاً دوباره تلاش کنید.',
                        'bot'
                    );
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

        /* =====================================================
           POLLING — دریافت پیام‌های جدید (کارشناس / bot)
        ===================================================== */
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

                    // اگر چت بسته است و پیام جدید آمده، badge نشان بده
                    if (!isOpen && newCount > 0 && badge) {
                        var current = parseInt(badge.textContent || '0', 10) || 0;
                        badge.style.display = 'block';
                        badge.textContent = String(current + newCount);
                    }

                    updateStatusFromState(data.status);
                })
                .catch(function () {
                    /* silent */
                });
        }

        function startPolling() {
            if (pollingTimer) return;
            pollingTimer = setInterval(pollMessages, 3000);
        }

        /* =====================================================
           START
        ===================================================== */
        // بارگذاری اولیه: همه پیام‌های قبلی را از سرور بگیر
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

        // Polling را همیشه فعال نگه دار (حتی اگر چت بسته باشد)
        startPolling();

        // وقتی تب مخفی شد، polling را کندتر کن
        document.addEventListener('visibilitychange', function () {
            if (document.hidden) {
                if (pollingTimer) {
                    clearInterval(pollingTimer);
                    pollingTimer = null;
                }
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

</body>
</html>

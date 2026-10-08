@php
    /*
    |--------------------------------------------------------------------------
    | Locale
    |--------------------------------------------------------------------------
    */

    $locale = app()->getLocale();

    $isRtl = in_array($locale, ['fa', 'ar'], true);

    $direction = $isRtl ? 'rtl' : 'ltr';


    /*
    |--------------------------------------------------------------------------
    | Localized URLs
    |--------------------------------------------------------------------------
    */

    $homeUrl     = url($locale);
    $aboutUrl    = url($locale . '/about');
    $servicesUrl = url($locale . '/services');
    $productsUrl = url($locale . '/products');
    $exportUrl   = url($locale . '/export');
    $importUrl   = url($locale . '/import');
    $logisticsUrl= url($locale . '/logistics');
    $teamUrl     = url($locale . '/team');
    $contactUrl  = url($locale . '/contact');
    $suppliersUrl = url($locale . '/suppliers');
    $marketsUrl = url($locale  . '/markets');


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

<html
    lang="{{ $locale }}"
    dir="{{ $direction }}"
>

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >
    <!-- در بخش head قالب -->
    <link rel="stylesheet" href="https://static.neshan.org/sdk/mapboxgl/v1.13.2/neshan-sdk/v1.1.3/index.css" />
    <script src="https://static.neshan.org/sdk/mapboxgl/v1.13.2/neshan-sdk/v1.1.3/index.js" defer></script>

    <meta
        name="description"
        content="{{ __('home.meta.description') }}"
    >

    <meta
        name="keywords"
        content="{{ __('home.meta.keywords') }}"
    >

    <meta
        name="language"
        content="{{ $locale }}"
    >

    <title>
        @yield('title', __('home.meta.title'))
    </title>


    {{-- =========================================================
         PRECONNECT
    ========================================================== --}}

    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >


    {{-- =========================================================
         FONT AWESOME
    ========================================================== --}}

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    >


    {{-- =========================================================
         VAZIRMATN
    ========================================================== --}}

    <link
        href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >


    {{-- =========================================================
         BOOTSTRAP ICONS
    ========================================================== --}}

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"
        rel="stylesheet"
    >


    {{-- =========================================================
         LIBRARIES
    ========================================================== --}}

    <link
        rel="stylesheet"
        href="{{ asset('lib/animate/animate.min.css') }}"
    >

    <link
        rel="stylesheet"
        href="{{ asset('lib/lightbox/css/lightbox.min.css') }}"
    >

    <link
        rel="stylesheet"
        href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}"
    >


    {{-- =========================================================
         BOOTSTRAP
    ========================================================== --}}

    <link
        rel="stylesheet"
        href="{{ asset('css/bootstrap.min.css') }}"
    >


    {{-- =========================================================
         MAIN CSS
    ========================================================== --}}

    <link
        rel="stylesheet"
        href="{{ asset('css/style.css') }}"
    >


    {{-- =========================================================
         GLOBAL STYLE
    ========================================================== --}}

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

            --site-shadow:
                0 8px 30px rgba(0, 0, 0, .06);

            --site-transition:
                all .25s ease;

        }


        /* =========================================================
           RESET
        ========================================================= */

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }


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

            font-family:
                'Vazirmatn',
                Tahoma,
                Arial,
                sans-serif;

            color: var(--site-text);

            background: #fff;

            overflow-x: hidden;

            -webkit-font-smoothing: antialiased;

            text-rendering: optimizeLegibility;

        }


        img {

            max-width: 100%;

            height: auto;

            vertical-align: middle;

        }


        a {

            text-decoration: none;

        }


        button,
        input,
        textarea,
        select {

            font-family:
                'Vazirmatn',
                Tahoma,
                Arial,
                sans-serif;

        }


        /* =========================================================
           DIRECTION
        ========================================================= */

        html[dir="rtl"] body {

            direction: rtl;

            text-align: right;

        }


        html[dir="ltr"] body {

            direction: ltr;

            text-align: left;

        }


        /* =========================================================
           CONTAINER
        ========================================================= */

        .container {

            width: 100%;

        }


        @media (min-width: 1200px) {

            .container {

                max-width: 1180px;

            }

        }


        @media (min-width: 1400px) {

            .container {

                max-width: 1240px;

            }

        }


        /* =========================================================
           TOPBAR
        ========================================================= */

        .topbar {

            position: relative;

            z-index: 1030;

            border-bottom:
                1px solid
                rgba(27, 54, 30, .06);

        }


        .topbar a {

            transition:
                var(--site-transition);

        }


        .topbar a:hover {

            color: var(--site-primary) !important;

        }


        .topbar .border-primary {

            border-color:
                rgba(27, 54, 30, .18) !important;

        }


        .topbar .text-primary {

            color:
                var(--site-primary) !important;

        }


        .topbar .small {

            line-height: 1.8;

        }


        /* =========================================================
           LANGUAGE SWITCHER
        ========================================================= */

        .language-switcher {

            position: relative;

        }


        .language-switcher > a {

            display: inline-flex;

            align-items: center;

            min-height: 34px;

            white-space: nowrap;

        }


        .language-switcher .dropdown-menu {

            min-width: 145px;

            margin-top: 8px;

            padding: 7px;

            border: 0;

            border-radius: 12px;

            box-shadow:
                0 12px 35px rgba(0, 0, 0, .12);

        }


        .language-switcher .dropdown-item {

            padding:
                9px 12px;

            border-radius: 8px;

            font-size: 14px;

            transition:
                var(--site-transition);

        }


        .language-switcher .dropdown-item:hover,
        .language-switcher .dropdown-item.active {

            color: #fff;

            background:
                var(--site-primary);

        }


        /* =========================================================
           NAVBAR
        ========================================================= */

        .nav-bar {

            position: relative;

            z-index: 1020;

            background: #fff;

            border-bottom:
                1px solid
                rgba(0, 0, 0, .04);

        }


        .navbar {

            min-height: 82px;

            padding-top: 8px;

            padding-bottom: 8px;

        }


        /* =========================================================
           LOGO
        ========================================================= */

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


        /* =========================================================
           NAVIGATION
        ========================================================= */

        .navbar-nav {

            align-items: center;

            gap: 2px;

        }


        .navbar-nav .nav-link {

            position: relative;

            display: inline-flex;

            align-items: center;

            justify-content: center;

            min-height: 44px;

            padding:
                9px 14px !important;

            color:
                #26352a !important;

            font-size: 14px;

            font-weight: 600;

            white-space: nowrap;

            border-radius: 8px;

            transition:
                var(--site-transition);

        }


        .navbar-nav .nav-link:hover {

            color:
                var(--site-primary) !important;

            background:
                rgba(27, 54, 30, .05);

        }


        .navbar-nav .nav-link.active {

            color:
                var(--site-primary) !important;

        }


        .navbar-nav .nav-link.active::after {

            content: '';

            position: absolute;

            left: 14px;

            right: 14px;

            bottom: 2px;

            height: 2px;

            border-radius: 20px;

            background:
                var(--site-secondary);

        }


        /* =========================================================
           DROPDOWN
        ========================================================= */

        .navbar .dropdown-menu {

            min-width: 210px;

            margin-top: 8px;

            padding: 8px;

            border: 0;

            border-radius: 12px;

            background: #fff;

            box-shadow:
                0 15px 45px rgba(0, 0, 0, .12);

        }


        .navbar .dropdown-item {

            padding:
                10px 13px;

            color:
                #26352a;

            font-size: 14px;

            font-weight: 500;

            border-radius: 8px;

            transition:
                var(--site-transition);

        }


        .navbar .dropdown-item:hover {

            color: #fff;

            background:
                var(--site-primary);

        }


        /* =========================================================
           NAV BUTTON
        ========================================================= */

        .nav-btn {

            display: flex;

            align-items: center;

        }


        .nav-btn .btn {

            min-width: 125px;

            border-radius: 9px;

            font-size: 14px;

            font-weight: 600;

            white-space: nowrap;

        }


        /* =========================================================
           NAV PHONE
        ========================================================= */

        .nav-bar .btn-light {

            width: 54px;

            height: 54px;

            display: flex;

            align-items: center;

            justify-content: center;

            border: 1px solid
            rgba(27, 54, 30, .08);

            box-shadow:
                0 5px 18px rgba(0, 0, 0, .05);

        }


        .nav-bar .btn-light:hover {

            transform: translateY(-2px);

        }


        /* =========================================================
           MOBILE NAVBAR BUTTON
        ========================================================= */

        .navbar-toggler {

            width: 48px;

            height: 44px;

            padding: 0;

            display: flex;

            align-items: center;

            justify-content: center;

            border:
                1px solid
                rgba(27, 54, 30, .15);

            border-radius: 9px;

            color:
                var(--site-primary);

            background: #fff;

            box-shadow: none !important;

        }


        .navbar-toggler:focus {

            box-shadow:
                0 0 0 3px
                rgba(27, 54, 30, .1) !important;

        }


        /* =========================================================
           MAIN
        ========================================================= */

        main {

            width: 100%;

            min-height: 300px;

            overflow: hidden;

        }


        /* =========================================================
           FOOTER
        ========================================================= */

        .footer {

            position: relative;

            background:
                #162d19;

            color: rgba(255, 255, 255, .78);

        }


        .footer::before {

            content: '';

            position: absolute;

            top: 0;

            left: 0;

            right: 0;

            height: 3px;

            background:
                linear-gradient(
                    90deg,
                    var(--site-primary),
                    var(--site-secondary),
                    var(--site-primary)
                );

        }


        .footer-item h3 {

            margin-bottom: 18px;

            font-size: 21px;

            font-weight: 700;

        }


        .footer-item h4 {

            font-size: 17px;

            font-weight: 700;

        }


        .footer-item p {

            line-height: 2;

        }


        .footer-item > a:not(.p-0) {

            display: block;

            margin-bottom: 8px;

            color:
                rgba(255, 255, 255, .72);

            transition:
                var(--site-transition);

        }


        .footer-item > a:hover {

            color: #fff;

            transform: translateX(-3px);

        }


        [dir="ltr"] .footer-item > a:hover {

            transform: translateX(3px);

        }


        /* =========================================================
           FOOTER SOCIAL
        ========================================================= */

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

            border:
                1px solid
                rgba(255, 255, 255, .15);

            transition:
                var(--site-transition);

        }


        .footer-btn .btn-md-square:hover {

            color: #fff;

            background:
                var(--site-secondary);

            border-color:
                var(--site-secondary);

            transform: translateY(-3px);

        }


        /* =========================================================
           FOOTER GALLERY
        ========================================================= */

        .footer-instagram {

            position: relative;

            width: 100%;

            aspect-ratio: 1 / 1;

            overflow: hidden;

            background:
                rgba(255, 255, 255, .06);

        }


        .footer-instagram img {

            width: 100%;

            height: 100%;

            object-fit: cover;

            transition:
                transform .4s ease;

        }


        .footer-instagram:hover img {

            transform: scale(1.07);

        }


        .footer-search-icon {

            position: absolute;

            inset: 0;

            display: flex;

            align-items: center;

            justify-content: center;

            opacity: 0;

            background:
                rgba(27, 54, 30, .65);

            transition:
                var(--site-transition);

        }


        .footer-instagram:hover
        .footer-search-icon {

            opacity: 1;

        }


        .footer-search-icon a {

            width: 42px;

            height: 42px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 50%;

            background:
                var(--site-secondary);

        }


        /* =========================================================
           FOOTER CONTACT
        ========================================================= */

        .footer .btn-xl-square {

            width: 65px;

            height: 65px;

            min-width: 65px;

            display: flex;

            align-items: center;

            justify-content: center;

        }


        .footer a {

            color:
                rgba(255, 255, 255, .82);

        }


        .footer a:hover {

            color: #fff;

        }


        /* =========================================================
           NEWSLETTER
        ========================================================= */

        .footer form {

            max-width: 100%;

        }


        .footer form .form-control {

            min-height: 52px;

            padding-left: 20px;

            padding-right: 20px;

            border: 0;

            font-size: 13px;

            box-shadow: none;

        }


        [dir="rtl"] .footer form .form-control {

            padding-left: 100px;

            padding-right: 20px;

        }


        [dir="ltr"] .footer form .form-control {

            padding-right: 100px;

            padding-left: 20px;

        }


        .footer form .btn {

            min-width: 82px;

            font-size: 12px;

            font-weight: 600;

        }


        /* =========================================================
           COPYRIGHT
        ========================================================= */

        .copyright {

            background:
                #102313;

            border-top:
                1px solid
                rgba(255, 255, 255, .06);

        }


        .copyright span,
        .copyright div {

            font-size: 13px;

            line-height: 2;

        }


        .copyright a {

            color: #fff;

        }


        /* =========================================================
           BACK TO TOP
        ========================================================= */

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

            box-shadow:
                0 8px 25px rgba(0, 0, 0, .15);

            transition:
                var(--site-transition);

        }


        .back-to-top:hover {

            opacity: 1;

            transform:
                translateY(-4px);

        }


        [dir="rtl"] .back-to-top {

            right: auto;

            left: 22px;

        }


        /* =========================================================
           SPINNER
        ========================================================= */

        #spinner {

            z-index: 99999;

            transition:
                opacity .3s ease,
                visibility .3s ease;

        }


        #spinner:not(.show) {

            opacity: 0;

            visibility: hidden;

            pointer-events: none;

        }


        /* =========================================================
           TABLET
        ========================================================= */

        @media (max-width: 1199.98px) {

            .navbar {

                min-height: 76px;

            }


            .navbar-brand img {

                max-width: 160px;

                max-height: 60px;

            }


            .navbar-nav .nav-link {

                padding-left: 10px !important;

                padding-right: 10px !important;

                font-size: 13px;

            }


            .nav-btn {

                padding-left: 8px !important;

                padding-right: 8px !important;

            }


            .nav-btn .btn {

                min-width: 105px;

                padding-left: 14px;

                padding-right: 14px;

            }

        }


        /* =========================================================
           MOBILE NAV
        ========================================================== */

        @media (max-width: 991.98px) {

            .topbar {

                padding-top: 8px !important;

                padding-bottom: 8px !important;

            }


            .topbar .row {

                row-gap: 5px;

            }


            .navbar {

                min-height: 70px;

                padding-top: 7px;

                padding-bottom: 7px;

            }


            .navbar-brand img {

                max-width: 145px;

                max-height: 55px;

            }


            .navbar-collapse {

                width: 100%;

                margin-top: 12px;

                padding: 10px;

                background: #fff;

                border:
                    1px solid
                    rgba(27, 54, 30, .08);

                border-radius: 12px;

                box-shadow:
                    0 12px 30px
                    rgba(0, 0, 0, .07);

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

                padding:
                    10px 13px !important;

                border-radius: 8px;

            }


            [dir="rtl"]
            .navbar-nav .nav-link {

                justify-content: flex-start;

                text-align: right;

            }


            [dir="ltr"]
            .navbar-nav .nav-link {

                justify-content: flex-start;

                text-align: left;

            }


            .navbar-nav
            .nav-link.active::after {

                display: none;

            }


            .navbar-nav
            .nav-link.active {

                background:
                    rgba(27, 54, 30, .06);

            }


            .navbar .dropdown-menu {

                width: 100%;

                min-width: 0;

                margin-top: 3px;

                padding: 5px;

                box-shadow: none;

                border:
                    1px solid
                    rgba(27, 54, 30, .07);

                background:
                    #fafbf8;

            }


            .navbar .dropdown-item {

                padding:
                    9px 12px;

            }


            .nav-btn {

                width: 100%;

                padding:
                    8px 0 2px !important;

            }


            .nav-btn .btn {

                width: 100%;

                margin: 0 !important;

            }


            .topbar .border-end {

                border-right: 0 !important;

            }


            .topbar .border-end {

                border-left: 0 !important;

            }


            main {

                min-height: 250px;

            }

        }


        /* =========================================================
           MOBILE
        ========================================================== */

        @media (max-width: 767.98px) {

            .topbar {

                font-size: 12px;

            }


            .topbar .d-flex {

                gap: 4px;

            }


            .topbar .ps-3,
            .topbar .pe-3 {

                padding-left: 5px !important;

                padding-right: 5px !important;

            }


            .topbar .me-3 {

                margin-right: 10px !important;

            }


            .topbar .ms-3 {

                margin-left: 10px !important;

            }


            .navbar-brand img {

                max-width: 130px;

                max-height: 50px;

            }


            .navbar-toggler {

                width: 44px;

                height: 42px;

            }


            .footer {

                padding-top: 45px !important;

                padding-bottom: 35px !important;

            }


            .footer .container {

                padding-left: 18px;

                padding-right: 18px;

            }


            .footer .row.g-5 {

                --bs-gutter-y: 2.3rem;

            }


            .footer .row.g-4 {

                --bs-gutter-y: 1.5rem;

            }


            .footer-item h3 {

                font-size: 19px;

            }


            .footer-item h4 {

                font-size: 16px;

            }


            .footer .btn-xl-square {

                width: 55px;

                height: 55px;

                min-width: 55px;

                padding: 12px !important;

            }


            .copyright {

                padding-top: 18px !important;

                padding-bottom: 18px !important;

            }


            .copyright .row {

                row-gap: 5px;

            }


            .back-to-top {

                width: 43px;

                height: 43px;

                right: 15px;

                bottom: 15px;

            }


            [dir="rtl"] .back-to-top {

                right: auto;

                left: 15px;

            }

        }


        /* =========================================================
           SMALL MOBILE
        ========================================================== */

        @media (max-width: 575.98px) {

            .topbar {

                padding-top: 7px !important;

                padding-bottom: 7px !important;

            }


            .topbar .col-12 {

                width: 100%;

            }


            .topbar .small {

                font-size: 11px;

            }


            .topbar .fa-map-marker-alt,
            .topbar .fa-envelope,
            .topbar .fa-phone {

                margin-right: 3px !important;

                margin-left: 3px !important;

            }


            .topbar .d-flex {

                justify-content: center !important;

            }


            .navbar {

                min-height: 64px;

            }


            .navbar-brand img {

                max-width: 118px;

                max-height: 46px;

            }


            .navbar-collapse {

                margin-top: 8px;

                padding: 7px;

            }


            .navbar-nav .nav-link {

                min-height: 42px;

                font-size: 13px;

            }


            .language-switcher .dropdown-menu {

                position: absolute;

            }


            .footer-instagram {

                border-radius: 8px;

            }


            .footer-search-icon a {

                width: 35px;

                height: 35px;

            }


            .footer .d-flex {

                flex-wrap: wrap;

            }


            .footer form .btn {

                min-width: 76px;

            }


            [dir="rtl"] .footer form .form-control {

                padding-left: 88px;

            }


            [dir="ltr"] .footer form .form-control {

                padding-right: 88px;

            }

        }


        /* =========================================================
           VERY SMALL DEVICES
        ========================================================== */

        @media (max-width: 380px) {

            .navbar-brand img {

                max-width: 105px;

            }


            .topbar .small {

                font-size: 10px;

            }


            .footer .btn-md-square {

                width: 38px !important;

                height: 38px !important;

            }


            .footer form .form-control {

                min-height: 48px;

            }

        }


        /* =========================================================
           REDUCE MOTION
        ========================================================== */

        @media (prefers-reduced-motion: reduce) {

            html {

                scroll-behavior: auto;

            }


            *,
            *::before,
            *::after {

                animation-duration: .01ms !important;

                animation-iteration-count: 1 !important;

                transition-duration: .01ms !important;

            }

        }

    </style>


    {{-- =========================================================
         PAGE STYLES
    ========================================================== --}}

    @yield('styles')

    @stack('styles')

</head>


<body>


{{-- =========================================================
     SPINNER
========================================================== --}}

<div
    id="spinner"
    class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center"
    aria-hidden="false"
>

    <div
        class="spinner-border text-primary"
        style="width:3rem;height:3rem;"
        role="status"
    >

        <span class="visually-hidden">
            {{ __('home.loading') }}
        </span>

    </div>

</div>


{{-- =========================================================
     TOPBAR
========================================================== --}}

<div class="container-fluid topbar px-0 bg-light">

    <div class="container">

        <div class="row gx-0 align-items-center py-2">


            {{-- Contact Information --}}
            <div class="col-lg-8 col-md-7 col-12">

                <div
                    class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-start"
                >

                    {{-- Address --}}
                    <div class="pe-3">

                        <a
                            href="{{ $contactUrl }}"
                            class="text-muted small"
                        >

                            <i class="fas fa-map-marker-alt text-primary me-1"></i>

                            {{ __('home.topbar.address') }}

                        </a>

                    </div>


                    {{-- Email --}}
                    <div class="ps-3 pe-3 border-start">

                        <a
                            href="mailto:info@keshtavaran.ir"
                            class="text-muted small"
                        >

                            <i class="fas fa-envelope text-primary me-1"></i>

                            info@keshtavaran.ir

                        </a>

                    </div>


                    {{-- Phone --}}
                    <div class="ps-3">

                        <a
                            href="tel:+982188776655"
                            class="text-muted small"
                            dir="ltr"
                        >

                            <i class="fas fa-phone text-primary me-1"></i>

                            {{ __('home.topbar.phone') }}

                        </a>

                    </div>

                </div>

            </div>


            {{-- Social + Language --}}
            <div class="col-lg-4 col-md-5 col-12 mt-2 mt-md-0">

                <div
                    class="d-flex align-items-center justify-content-center justify-content-md-end"
                >

                    <div class="d-flex align-items-center me-2">

                        <a
                            class="btn p-0 text-primary me-3"
                            href="#"
                            aria-label="Instagram"
                        >
                            <i class="fab fa-instagram"></i>
                        </a>

                        <a
                            class="btn p-0 text-primary me-3"
                            href="#"
                            aria-label="LinkedIn"
                        >
                            <i class="fab fa-linkedin-in"></i>
                        </a>

                        <a
                            class="btn p-0 text-primary me-3"
                            href="#"
                            aria-label="Telegram"
                        >
                            <i class="fab fa-telegram"></i>
                        </a>

                        <a
                            class="btn p-0 text-primary"
                            href="#"
                            aria-label="WhatsApp"
                        >
                            <i class="fab fa-whatsapp"></i>
                        </a>

                    </div>



                    <li class="nav-item dropdown language-dropdown">

                        <a
                            href="#"
                            class="nav-link dropdown-toggle"
                            id="languageDropdown"
                            role="button"
                            aria-expanded="false"
                        >
                            <i class="fa-solid fa-globe me-1"></i>
                            {{ $currentLanguage }}
                        </a>

                        <div
                            class="dropdown-menu dropdown-menu-end language-menu"
                            aria-labelledby="languageDropdown"
                        >

                            <a
                                href="{{ route('locale.switch', 'fa') }}"
                                class="dropdown-item {{ $locale === 'fa' ? 'active' : '' }}"
                            >
                                <span>🇮🇷</span>
                                فارسی
                            </a>

                            <a
                                href="{{ route('locale.switch', 'en') }}"
                                class="dropdown-item {{ $locale === 'en' ? 'active' : '' }}"
                            >
                                <span>🇬🇧</span>
                                English
                            </a>

                            <a
                                href="{{ route('locale.switch', 'ar') }}"
                                class="dropdown-item {{ $locale === 'ar' ? 'active' : '' }}"
                            >
                                <span>🇸🇦</span>
                                العربية
                            </a>

                        </div>

                    </li>
                </div>

            </div>

        </div>

    </div>

</div>


{{-- =========================================================
     NAVBAR
========================================================== --}}

<div class="container-fluid nav-bar px-0">

    <div class="container">

        <nav class="navbar navbar-expand-lg navbar-light">


            {{-- Logo --}}
            <a
                href="{{ $homeUrl }}"
                class="navbar-brand"
            >

                <img
                    src="{{ asset('img/logo/Duck-ai-image-2026-09-27-13-54.jpeg') }}"
                    alt="{{ __('home.navbar.logo_alt') }}"
                    width="180"
                    height="70"
                    loading="eager"
                    decoding="async"
                >

            </a>


            {{-- Mobile Button --}}
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


            {{-- Menu --}}
            <div
                class="collapse navbar-collapse"
                id="navbarCollapse"
            >

                <div class="navbar-nav mx-0 mx-lg-auto">


                    {{-- Home --}}
                    <a
                        href="{{ $homeUrl }}"
                        class="nav-item nav-link {{ request()->is($locale) || request()->is($locale . '/') ? 'active' : '' }}"
                    >
                        {{ __('home.navbar.home') }}
                    </a>


                    {{-- About --}}
                    <a
                        href="{{ $aboutUrl }}"
                        class="nav-item nav-link {{ request()->is($locale . '/about') ? 'active' : '' }}"
                    >
                        {{ __('home.navbar.about') }}
                    </a>


                    {{-- Services --}}
                    <a
                        href="{{ $servicesUrl }}"
                        class="nav-item nav-link {{ request()->is($locale . '/services') ? 'active' : '' }}"
                    >
                        {{ __('home.navbar.services') }}
                    </a>


                    {{-- Sections --}}
                    <div class="nav-item dropdown" style="color: black">

                        <a
                            href="#"
                            class="nav-link dropdown-toggle"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                            style="color: black"
                        >
                            {{ __('home.navbar.sections') }}
                        </a>


                        <div class="dropdown-menu" >

                            <a
                                href="{{ $productsUrl }}"
                                class="dropdown-item"
                            >
                                {{ __('home.navbar.export_products') }}
                            </a>

                            <a
                                href="{{ $exportUrl }}"
                                class="dropdown-item"
                            >
                                {{ __('home.navbar.export') }}
                            </a>

                            <a
                                href="{{ $importUrl }}"
                                class="dropdown-item"
                            >
                                {{ __('home.navbar.import') }}
                            </a>
                            <a
                                href="{{ $marketsUrl }}"
                                class="dropdown-item"
                            >
                                {{ __('home.navbar.markets') }}
                            </a>
                            <a
                                href="{{ $suppliersUrl }}"
                                class="dropdown-item"
                            >
                                {{ __('home.navbar.suppliers') }}
                            </a>

                            <a
                                href="{{ $logisticsUrl }}"
                                class="dropdown-item"
                            >
                                {{ __('home.navbar.logistics') }}
                            </a>

                            <a
                                href="{{ $teamUrl }}"
                                class="dropdown-item"
                            >
                                {{ __('home.navbar.team') }}
                            </a>

                        </div>

                    </div>


                    {{-- Contact --}}
                    <a
                        href="{{ $contactUrl }}"
                        class="nav-item nav-link {{ request()->is($locale . '/contact') ? 'active' : '' }}"
                    >
                        {{ __('home.navbar.contact') }}
                    </a>


                    {{-- Cooperation --}}
                    <div class="nav-btn px-2">

                        <a
                            href="{{ $contactUrl }}"
                            class="btn btn-primary py-2 px-4"
                        >
                            {{ __('home.navbar.cooperation') }}
                        </a>

                    </div>

                </div>

            </div>


            {{-- Phone --}}
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

                    <a
                        href="tel:+982188776655"
                        dir="ltr"
                    >

                        <span class="text-dark fw-semibold">
                            {{ __('home.topbar.phone') }}
                        </span>

                    </a>

                </div>

            </div>

        </nav>

    </div>

</div>


{{-- =========================================================
     MAIN
========================================================== --}}

<main>

    @yield('content')

</main>


{{-- =========================================================
     FOOTER
========================================================== --}}

<footer
    class="container-fluid footer py-5"
>

    <div class="container py-3 py-lg-4">

        <div class="row g-5">


            {{-- Company --}}
            <div class="col-xl-5 col-lg-6">

                <div class="footer-item">

                    <a
                        href="{{ $homeUrl }}"
                        class="d-inline-block mb-3"
                    >

                        <h3 class="text-white mb-0">

                            <i class="fas fa-seedling me-2"></i>

                            {{ __('home.footer.company_name') }}

                        </h3>

                    </a>


                    <p class="text-white mb-4">

                        {{ __('home.footer.description') }}

                    </p>


                    <div class="footer-btn">

                        <a
                            class="btn btn-md-square rounded-circle"
                            href="#"
                            aria-label="Instagram"
                        >
                            <i class="fab fa-instagram"></i>
                        </a>

                        <a
                            class="btn btn-md-square rounded-circle"
                            href="#"
                            aria-label="LinkedIn"
                        >
                            <i class="fab fa-linkedin-in"></i>
                        </a>

                        <a
                            class="btn btn-md-square rounded-circle"
                            href="#"
                            aria-label="Telegram"
                        >
                            <i class="fab fa-telegram"></i>
                        </a>

                        <a
                            class="btn btn-md-square rounded-circle"
                            href="#"
                            aria-label="WhatsApp"
                        >
                            <i class="fab fa-whatsapp"></i>
                        </a>

                    </div>

                </div>

            </div>


            {{-- Quick Links --}}
            <div class="col-xl-3 col-lg-6 col-md-6">

                <div class="footer-item">

                    <h4 class="text-white mb-4">
                        {{ __('home.footer.quick_links_title') }}
                    </h4>


                    <a href="{{ $aboutUrl }}">
                        <i class="fas fa-angle-left me-2"></i>
                        {{ __('home.footer.links.about') }}
                    </a>


                    <a href="{{ $productsUrl }}">
                        <i class="fas fa-angle-left me-2"></i>
                        {{ __('home.footer.links.agricultural_products') }}
                    </a>


                    <a href="{{ $productsUrl }}">
                        <i class="fas fa-angle-left me-2"></i>
                        {{ __('home.footer.links.dairy_products') }}
                    </a>


                    <a href="{{ $exportUrl }}">
                        <i class="fas fa-angle-left me-2"></i>
                        {{ __('home.footer.links.export') }}
                    </a>


                    <a href="{{ $importUrl }}">
                        <i class="fas fa-angle-left me-2"></i>
                        {{ __('home.footer.links.import') }}
                    </a>


                    <a href="{{ $contactUrl }}">
                        <i class="fas fa-angle-left me-2"></i>
                        {{ __('home.footer.links.contact') }}
                    </a>

                </div>

            </div>


            {{-- Gallery --}}
            <div class="col-xl-4 col-lg-6 col-md-6">

                <div class="footer-item">

                    <h4 class="mb-4 text-white">
                        {{ __('home.footer.gallery_title') }}
                    </h4>


                    <div class="row g-2">

                        @for ($n = 1; $n <= 6; $n++)

                            @php
                                $galleryImage =
                                    asset("img/instagram-footer-$n.jpg");
                            @endphp

                            <div class="col-4">

                                <div class="footer-instagram rounded">

                                    <img
                                        src="{{ $galleryImage }}"
                                        class="img-fluid w-100"
                                        loading="lazy"
                                        decoding="async"
                                        width="120"
                                        height="120"
                                        alt="{{ __('home.footer.gallery_image_alt', ['number' => $n]) }}"
                                    >


                                    <div class="footer-search-icon">

                                        <a
                                            href="{{ $galleryImage }}"
                                            data-lightbox="footerGallery"
                                            aria-label="{{ __('home.footer.view_image') }}"
                                        >

                                            <i class="fas fa-link text-white"></i>

                                        </a>

                                    </div>

                                </div>

                            </div>

                        @endfor

                    </div>

                </div>

            </div>


            {{-- Contact Information --}}
            <div class="col-12">

                <div
                    class="pt-4 pt-lg-5 mt-2"
                    style="
                        border-top:
                        1px solid
                        rgba(255,255,255,.08);
                    "
                >

                    <div class="row g-4">


                        {{-- Address --}}
                        <div class="col-lg-4 col-md-6">

                            <div class="d-flex align-items-start">

                                <div
                                    class="btn-xl-square bg-primary text-white rounded p-3 me-3 flex-shrink-0"
                                >

                                    <i class="fas fa-map-marker-alt fa-lg"></i>

                                </div>

                                <div>

                                    <h4 class="text-white mb-2">
                                        {{ __('home.footer.address_title') }}
                                    </h4>

                                    <p class="mb-0">
                                        {{ __('home.footer.address') }}
                                    </p>

                                </div>

                            </div>

                        </div>


                        {{-- Email --}}
                        <div class="col-lg-4 col-md-6">

                            <div class="d-flex align-items-start">

                                <div
                                    class="btn-xl-square bg-primary text-white rounded p-3 me-3 flex-shrink-0"
                                >

                                    <i class="fas fa-envelope fa-lg"></i>

                                </div>

                                <div>

                                    <h4 class="text-white mb-2">
                                        {{ __('home.footer.email_title') }}
                                    </h4>

                                    <a
                                        href="mailto:info@keshtavaran.ir"
                                        dir="ltr"
                                        class="d-inline-block"
                                    >
                                        info@keshtavaran.ir
                                    </a>

                                </div>

                            </div>

                        </div>


                        {{-- Phone --}}
                        <div class="col-lg-4 col-md-6">

                            <div class="d-flex align-items-start">

                                <div
                                    class="btn-xl-square bg-primary text-white rounded p-3 me-3 flex-shrink-0"
                                >

                                    <i class="fas fa-phone-alt fa-lg"></i>

                                </div>

                                <div>

                                    <h4 class="text-white mb-2">
                                        {{ __('home.footer.phone_title') }}
                                    </h4>

                                    <a
                                        href="tel:+982188776655"
                                        dir="ltr"
                                    >
                                        {{ __('home.footer.phone') }}
                                    </a>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Newsletter --}}
            <div class="col-xl-4 col-lg-6">

                <div class="footer-item">

                    <h4 class="text-white mb-3">
                        {{ __('home.footer.newsletter_title') }}
                    </h4>


                    <p class="text-white mb-3">

                        {{ __('home.footer.newsletter_text') }}

                    </p>


                    <form
                        action="{{ url($locale . '/newsletter') }}"
                        method="POST"
                        class="position-relative rounded-pill mb-4"
                    >

                        @csrf

                        <input
                            class="form-control rounded-pill w-100"
                            type="email"
                            name="email"
                            placeholder="{{ __('home.footer.newsletter_placeholder') }}"
                            required
                            autocomplete="email"
                            aria-label="{{ __('home.footer.newsletter_email') }}"
                        >


                        <button
                            type="submit"
                            class="btn btn-primary rounded-pill position-absolute top-50 translate-middle-y end-0 me-1"
                        >
                            {{ __('home.footer.newsletter_button') }}
                        </button>

                    </form>


                    <div class="d-flex align-items-center">

                        <a
                            href="tel:+982188776655"
                            class="btn btn-lg-square rounded-circle me-3"
                            aria-label="{{ __('home.navbar.call') }}"
                        >

                            <i class="fa fa-phone-alt"></i>

                        </a>


                        <div class="d-flex flex-column">

                            <span>
                                {{ __('home.navbar.experts') }}
                            </span>

                            <a
                                href="tel:+982188776655"
                                dir="ltr"
                            >

                                <span class="text-white fw-semibold">
                                    {{ __('home.topbar.phone') }}
                                </span>

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</footer>


{{-- =========================================================
     COPYRIGHT
========================================================== --}}

<div class="container-fluid copyright py-3">

    <div class="container">

        <div class="row align-items-center g-2">


            <div class="col-md-6 text-center text-md-end">

                <span class="text-body">

                    <a
                        href="{{ $homeUrl }}"
                        class="border-bottom text-white"
                    >

                        <i class="fas fa-copyright text-light me-1"></i>

                        {{ __('home.footer.company_name') }}

                    </a>

                    ،

                    {{ __('home.footer.copyright') }}

                </span>

            </div>


            <div class="col-md-6 text-center text-md-start">

                {{ __('home.footer.designed_by') }}

                <a
                    class="border-bottom text-white"
                    href="https://htmlcodex.com"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    {{ __('home.footer.designer') }}
                </a>

            </div>

        </div>

    </div>

</div>


{{-- =========================================================
     BACK TO TOP
========================================================== --}}

<a
    href="#"
    class="btn btn-primary btn-lg-square rounded-circle back-to-top"
    aria-label="{{ __('home.back_to_top') }}"
>
    <i class="fa fa-arrow-up"></i>
</a>


{{-- =========================================================
     JAVASCRIPT
========================================================== --}}

<script
    src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"
    defer
></script>


<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"
    defer
></script>


<script
    src="{{ asset('lib/wow/wow.min.js') }}"
    defer
></script>


<script
    src="{{ asset('lib/easing/easing.min.js') }}"
    defer
></script>


<script
    src="{{ asset('lib/waypoints/waypoints.min.js') }}"
    defer
></script>


<script
    src="{{ asset('lib/counterup/counterup.min.js') }}"
    defer
></script>


<script
    src="{{ asset('lib/lightbox/js/lightbox.min.js') }}"
    defer
></script>


<script
    src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"
    defer
></script>


<script
    src="{{ asset('js/main.js') }}"
    defer
></script>


{{-- =========================================================
     SPINNER FALLBACK
========================================================== --}}

<script>

    (function () {

        'use strict';


        function hideSpinner() {

            const spinner =
                document.getElementById('spinner');


            if (!spinner) {
                return;
            }


            spinner.classList.remove('show');

            spinner.setAttribute(
                'aria-hidden',
                'true'
            );


            setTimeout(function () {

                spinner.style.display = 'none';

            }, 300);

        }


        document.addEventListener(
            'DOMContentLoaded',
            function () {

                setTimeout(
                    hideSpinner,
                    250
                );

            },
            {
                once: true
            }
        );


        window.addEventListener(
            'load',
            hideSpinner,
            {
                once: true
            }
        );


        /*
        |--------------------------------------------------------------------------
        | Emergency fallback
        |--------------------------------------------------------------------------
        */

        setTimeout(
            hideSpinner,
            2500
        );


    })();

</script>


{{-- =========================================================
     PAGE SCRIPTS
========================================================== --}}

@stack('scripts')


</body>

</html>

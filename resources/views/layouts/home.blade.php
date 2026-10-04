@php
    $locale = app()->getLocale();

    /*
    |--------------------------------------------------------------------------
    | Locale Settings
    |--------------------------------------------------------------------------
    */
    $isRtl = in_array($locale, ['fa', 'ar']);

    $direction = $isRtl ? 'rtl' : 'ltr';

    /*
    |--------------------------------------------------------------------------
    | Localized URLs
    |--------------------------------------------------------------------------
    */
    $homeUrl = url($locale);
    $aboutUrl = url($locale . '/about');
    $servicesUrl = url($locale . '/services');
    $productsUrl = url($locale . '/products');
    $exportUrl = url($locale . '/export');
    $importUrl = url($locale . '/import');
    $blogUrl = url($locale . '/blog');
    $teamUrl = url($locale . '/team');
    $contactUrl = url($locale . '/contact');

    /*
    |--------------------------------------------------------------------------
    | Language Names
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
    | Google Maps Language
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

    <title>{{ __('home.meta.title') }}</title>

    <meta
        content="width=device-width, initial-scale=1.0"
        name="viewport"
    >

    <meta
        name="description"
        content="{{ __('home.meta.description') }}"
    >

    <meta
        name="keywords"
        content="{{ __('home.meta.keywords') }}"
    >

    <meta name="language" content="{{ $locale }}">

    <!-- =========================================================
         Google Web Fonts
    ========================================================== -->

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@100..900&display=swap"
        rel="stylesheet"
    >

    <!-- =========================================================
         Icon Font Stylesheet
    ========================================================== -->

    <link
        rel="stylesheet"
        href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
    >

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"
        rel="stylesheet"
    >

    <!-- =========================================================
         Libraries Stylesheet
    ========================================================== -->

    <link
        rel="stylesheet"
        href="{{ asset('lib/animate/animate.min.css') }}"
    >

    <link
        href="{{ asset('lib/lightbox/css/lightbox.min.css') }}"
        rel="stylesheet"
    >

    <link
        href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}"
        rel="stylesheet"
    >

    <!-- =========================================================
         Bootstrap
    ========================================================== -->

    <link
        href="{{ asset('css/bootstrap.min.css') }}"
        rel="stylesheet"
    >

    <!-- =========================================================
         Template Stylesheet
    ========================================================== -->

    <link
        href="{{ asset('css/style.css') }}"
        rel="stylesheet"
    >

    <style>
        body,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .btn,
        .nav-link,
        input,
        textarea,
        select {
            font-family: 'Vazirmatn', Tahoma, sans-serif;
        }

        html[dir="ltr"] body {
            direction: ltr;
        }

        html[dir="rtl"] body {
            direction: rtl;
        }

        /*
        |--------------------------------------------------------------------------
        | Navbar Direction
        |--------------------------------------------------------------------------
        */

        [dir="rtl"] .navbar-nav {
            direction: rtl;
        }

        [dir="ltr"] .navbar-nav {
            direction: ltr;
        }

        /*
        |--------------------------------------------------------------------------
        | Footer
        |--------------------------------------------------------------------------
        */

        [dir="rtl"] .footer-item a i {
            margin-left: .5rem;
            margin-right: 0 !important;
        }

        /*
        |--------------------------------------------------------------------------
        | Language Dropdown
        |--------------------------------------------------------------------------
        */

        .language-switcher .dropdown-menu {
            min-width: 140px;
        }

        /*
        |--------------------------------------------------------------------------
        | Google Map
        |--------------------------------------------------------------------------
        */

        #map {
            width: 100%;
            min-height: 450px;
        }
    </style>

    @stack('styles')

</head>

<body>

<!-- =========================================================
     Spinner Start
========================================================== -->

<div
    id="spinner"
    class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center"
>

    <div
        class="spinner-border text-primary"
        style="width: 3rem; height: 3rem;"
        role="status"
    >
        <span class="visually-hidden">
            {{ __('home.loading') }}
        </span>
    </div>

</div>

<!-- =========================================================
     Spinner End
========================================================== -->


<!-- =========================================================
     Topbar Start
========================================================== -->

<div class="container-fluid topbar px-0 bg-light py-2">

    <div class="container">

        <div class="row gx-0 align-items-center">

            <!-- Contact Information -->
            <div class="col-lg-8 col-md-7 col-12">

                <div class="d-flex flex-wrap justify-content-center justify-content-md-start">

                    <!-- Address -->
                    <div class="border-end border-primary pe-3 mb-2 mb-md-0">

                        <a
                            href="{{ $contactUrl }}"
                            class="text-muted small"
                        >

                            <i class="fas fa-map-marker-alt text-primary me-2"></i>

                            {{ __('home.topbar.address') }}

                        </a>

                    </div>

                    <!-- Email -->
                    <div class="ps-3 mb-2 mb-md-0">

                        <a
                            href="mailto:info@keshtavaran.ir"
                            class="text-muted small"
                        >

                            <i class="fas fa-envelope text-primary me-2"></i>

                            info@keshtavaran.ir

                        </a>

                    </div>

                    <!-- Phone -->
                    <div class="ps-md-3">

                        <a
                            href="tel:+982188776655"
                            class="text-muted small"
                            dir="ltr"
                        >

                            <i class="fas fa-phone text-primary me-2"></i>

                            {{ __('home.topbar.phone') }}

                        </a>

                    </div>

                </div>

            </div>


            <!-- Social + Language -->
            <div class="col-lg-4 col-md-5 col-12 mt-2 mt-md-0">

                <div class="d-flex justify-content-center justify-content-md-end align-items-center">

                    <!-- Social -->
                    <div class="d-flex border-end border-primary pe-3">

                        <a
                            class="btn p-0 text-primary me-3"
                            href="#"
                            title="Instagram"
                            aria-label="Instagram"
                        >
                            <i class="fab fa-instagram"></i>
                        </a>

                        <a
                            class="btn p-0 text-primary me-3"
                            href="#"
                            title="LinkedIn"
                            aria-label="LinkedIn"
                        >
                            <i class="fab fa-linkedin-in"></i>
                        </a>

                        <a
                            class="btn p-0 text-primary me-3"
                            href="#"
                            title="Telegram"
                            aria-label="Telegram"
                        >
                            <i class="fab fa-telegram"></i>
                        </a>

                        <a
                            class="btn p-0 text-primary"
                            href="#"
                            title="WhatsApp"
                            aria-label="WhatsApp"
                        >
                            <i class="fab fa-whatsapp"></i>
                        </a>

                    </div>


                    <!-- Language -->
                    <div class="dropdown ms-3 language-switcher">

                        <a
                            href="#"
                            class="dropdown-toggle text-dark"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                        >

                            <small>

                                <i class="fas fa-globe text-primary me-2"></i>

                                {{ $currentLanguage }}

                            </small>

                        </a>

                        <div class="dropdown-menu rounded shadow">

                            <a
                                href="{{ url('fa') }}"
                                class="dropdown-item {{ $locale === 'fa' ? 'active' : '' }}"
                            >
                                فارسی
                            </a>

                            <a
                                href="{{ url('en') }}"
                                class="dropdown-item {{ $locale === 'en' ? 'active' : '' }}"
                            >
                                English
                            </a>

                            <a
                                href="{{ url('ar') }}"
                                class="dropdown-item {{ $locale === 'ar' ? 'active' : '' }}"
                            >
                                العربية
                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- =========================================================
     Topbar End
========================================================== -->


<!-- =========================================================
     Navbar Start
========================================================== -->

<div class="container-fluid nav-bar px-0 px-lg-4 py-lg-0">

    <div class="container">

        <nav class="navbar navbar-expand-lg navbar-light">

            <!-- Logo -->
            <a
                href="{{ $homeUrl }}"
                class="navbar-brand p-0"
            >

                <img
                    src="{{ asset('img/logo/Duck-ai-image-2026-09-27-13-54.jpeg') }}"
                    alt="{{ __('home.navbar.logo_alt') }}"
                >

            </a>


            <!-- Mobile Toggle -->
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarCollapse"
                aria-label="{{ __('home.navbar.toggle_menu') }}"
            >

                <span class="fa fa-bars"></span>

            </button>


            <!-- Navbar -->
            <div
                class="collapse navbar-collapse"
                id="navbarCollapse"
            >

                <div class="navbar-nav mx-0 mx-lg-auto">

                    <!-- Home -->
                    <a
                        href="{{ $homeUrl }}"
                        class="nav-item nav-link active"
                    >
                        {{ __('home.navbar.home') }}
                    </a>

                    <!-- About -->
                    <a
                        href="{{ $aboutUrl }}"
                        class="nav-item nav-link"
                    >
                        {{ __('home.navbar.about') }}
                    </a>

                    <!-- Services -->
                    <a
                        href="{{ $servicesUrl }}"
                        class="nav-item nav-link"
                    >
                        {{ __('home.navbar.services') }}
                    </a>


                    <!-- Sections Dropdown -->
                    <div class="nav-item dropdown">

                        <a
                            href="#"
                            class="nav-link"
                            data-bs-toggle="dropdown"
                        >

                            <span class="dropdown-toggle">
                                {{ __('home.navbar.sections') }}
                            </span>

                        </a>

                        <div class="dropdown-menu">

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
                                href="{{ $blogUrl }}"
                                class="dropdown-item"
                            >
                                {{ __('home.navbar.blog') }}
                            </a>

                            <a
                                href="{{ $teamUrl }}"
                                class="dropdown-item"
                            >
                                {{ __('home.navbar.team') }}
                            </a>

                        </div>

                    </div>


                    <!-- Contact -->
                    <a
                        href="{{ $contactUrl }}"
                        class="nav-item nav-link"
                    >
                        {{ __('home.navbar.contact') }}
                    </a>


                    <!-- Cooperation -->
                    <div class="nav-btn px-3">

                        <a
                            href="{{ $contactUrl }}"
                            class="btn btn-primary py-2 px-4 ms-3 flex-shrink-0"
                        >
                            {{ __('home.navbar.cooperation') }}
                        </a>

                    </div>

                </div>

            </div>


            <!-- Phone -->
            <div class="d-none d-xl-flex flex-shrink-0 ps-4">

                <a
                    href="tel:+982188776655"
                    class="btn btn-light btn-lg-square rounded-circle position-relative wow tada"
                    data-wow-delay=".9s"
                    aria-label="{{ __('home.navbar.call') }}"
                >

                    <i class="fa fa-phone-alt fa-2x"></i>

                    <div
                        class="position-absolute"
                        style="top:7px; right:12px;"
                    >

                        <span>
                            <i class="fa fa-comment-dots text-secondary"></i>
                        </span>

                    </div>

                </a>


                <div class="d-flex flex-column ms-3">

                    <span>
                        {{ __('home.navbar.experts') }}
                    </span>

                    <a
                        href="tel:+982188776655"
                        dir="ltr"
                    >

                        <span class="text-dark">
                            {{ __('home.topbar.phone') }}
                        </span>

                    </a>

                </div>

            </div>

        </nav>

    </div>

</div>

<!-- =========================================================
     Navbar End
========================================================== -->


<!-- =========================================================
     Main Content
========================================================== -->

@yield('content')

<!-- =========================================================
     Main Content End
========================================================== -->


<!-- =========================================================
     Footer Start
========================================================== -->

<div
    class="container-fluid footer py-5 wow fadeIn"
    data-wow-delay="0.2s"
>

    <div class="container py-5">

        <div class="row g-5">

            <!-- Main Footer -->
            <div class="col-xl-9">

                <div class="mb-5">

                    <div class="row g-4">

                        <!-- Company -->
                        <div class="col-md-6 col-lg-6 col-xl-5">

                            <div class="footer-item">

                                <a
                                    href="{{ $homeUrl }}"
                                    class="p-0"
                                >

                                    <h3 class="text-white">

                                        <i class="fas fa-seedling me-3"></i>

                                        {{ __('home.footer.company_name') }}

                                    </h3>

                                </a>


                                <p class="text-white mb-4">

                                    {{ __('home.footer.description') }}

                                </p>


                                <!-- Social -->
                                <div class="footer-btn d-flex">

                                    <a
                                        class="btn btn-md-square rounded-circle me-3"
                                        href="#"
                                        aria-label="Instagram"
                                    >
                                        <i class="fab fa-instagram"></i>
                                    </a>

                                    <a
                                        class="btn btn-md-square rounded-circle me-3"
                                        href="#"
                                        aria-label="LinkedIn"
                                    >
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>

                                    <a
                                        class="btn btn-md-square rounded-circle me-3"
                                        href="#"
                                        aria-label="Telegram"
                                    >
                                        <i class="fab fa-telegram"></i>
                                    </a>

                                    <a
                                        class="btn btn-md-square rounded-circle me-0"
                                        href="#"
                                        aria-label="WhatsApp"
                                    >
                                        <i class="fab fa-whatsapp"></i>
                                    </a>

                                </div>

                            </div>

                        </div>


                        <!-- Quick Links -->
                        <div class="col-md-6 col-lg-6 col-xl-3">

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


                        <!-- Gallery -->
                        <div class="col-md-6 col-lg-6 col-xl-4">

                            <div class="footer-item">

                                <h4 class="mb-4 text-white">
                                    {{ __('home.footer.gallery_title') }}
                                </h4>

                                <div class="row g-3">

                                    @for ($n = 1; $n <= 6; $n++)

                                        <div class="col-4">

                                            <div class="footer-instagram rounded">

                                                <img
                                                    src="{{ asset("img/instagram-footer-$n.jpg") }}"
                                                    class="img-fluid w-100"
                                                    loading="lazy"
                                                    alt="{{ __('home.footer.gallery_image_alt', ['number' => $n]) }}"
                                                >

                                                <div class="footer-search-icon">

                                                    <a
                                                        href="{{ asset("img/instagram-footer-$n.jpg") }}"
                                                        data-lightbox="footerGallery"
                                                        class="my-auto"
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

                    </div>

                </div>


                <!-- Contact Information -->
                <div
                    class="pt-5"
                    style="border-top: 1px solid rgba(255, 255, 255, 0.08);"
                >

                    <div class="row g-4">

                        <!-- Address -->
                        <div class="col-lg-6 col-xl-4">

                            <div class="d-flex">

                                <div class="btn-xl-square bg-primary text-white rounded p-4 me-4">

                                    <i class="fas fa-map-marker-alt fa-2x"></i>

                                </div>

                                <div>

                                    <h4 class="text-white">
                                        {{ __('home.footer.address_title') }}
                                    </h4>

                                    <p class="mb-0">
                                        {{ __('home.footer.address') }}
                                    </p>

                                </div>

                            </div>

                        </div>


                        <!-- Email -->
                        <div class="col-lg-6 col-xl-4">

                            <div class="d-flex">

                                <div class="btn-xl-square bg-primary text-white rounded p-4 me-4">

                                    <i class="fas fa-envelope fa-2x"></i>

                                </div>

                                <div>

                                    <h4 class="text-white">
                                        {{ __('home.footer.email_title') }}
                                    </h4>

                                    <p class="mb-0">

                                        <a href="mailto:info@keshtavaran.ir">
                                            info@keshtavaran.ir
                                        </a>

                                    </p>

                                </div>

                            </div>

                        </div>


                        <!-- Phone -->
                        <div class="col-lg-6 col-xl-4">

                            <div class="d-flex">

                                <div class="btn-xl-square bg-primary text-white rounded p-4 me-4">

                                    <i class="fa fa-phone-alt fa-2x"></i>

                                </div>

                                <div>

                                    <h4 class="text-white">
                                        {{ __('home.footer.phone_title') }}
                                    </h4>

                                    <p class="mb-0">

                                        <a
                                            href="tel:+982188776655"
                                            dir="ltr"
                                        >
                                            {{ __('home.footer.phone') }}
                                        </a>

                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <!-- Newsletter -->
            <div class="col-xl-3">

                <div class="footer-item">

                    <h4 class="text-white mb-4">
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
                            class="form-control rounded-pill w-100 py-3 ps-4 pe-5"
                            type="email"
                            name="email"
                            placeholder="{{ __('home.footer.newsletter_placeholder') }}"
                            required
                            aria-label="{{ __('home.footer.newsletter_email') }}"
                        >

                        <button
                            type="submit"
                            class="btn btn-primary rounded-pill position-absolute top-0 end-0 py-2 mt-2 me-2"
                        >
                            {{ __('home.footer.newsletter_button') }}
                        </button>

                    </form>


                    <!-- Expert Contact -->
                    <div class="d-flex flex-shrink-0">

                        <div class="footer-btn">

                            <a
                                href="tel:+982188776655"
                                class="btn btn-lg-square rounded-circle position-relative wow tada"
                                data-wow-delay=".9s"
                                aria-label="{{ __('home.navbar.call') }}"
                            >

                                <i class="fa fa-phone-alt fa-2x"></i>

                                <div
                                    class="position-absolute"
                                    style="top: 2px; right: 12px;"
                                >

                                    <span>
                                        <i class="fa fa-comment-dots text-secondary"></i>
                                    </span>

                                </div>

                            </a>

                        </div>


                        <div class="d-flex flex-column ms-3 flex-shrink-0">

                            <span>
                                {{ __('home.navbar.experts') }}
                            </span>

                            <a
                                href="tel:+982188776655"
                                dir="ltr"
                            >

                                <span class="text-white">
                                    {{ __('home.topbar.phone') }}
                                </span>

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- =========================================================
     Footer End
========================================================== -->


<!-- =========================================================
     Copyright Start
========================================================== -->

<div class="container-fluid copyright py-4">

    <div class="container">

        <div class="row g-4 align-items-center">

            <!-- Copyright -->
            <div class="col-md-6 text-center text-md-end mb-md-0">

                <span class="text-body">

                    <a
                        href="{{ $homeUrl }}"
                        class="border-bottom text-white"
                    >

                        <i class="fas fa-copyright text-light me-2"></i>

                        {{ __('home.footer.company_name') }}

                    </a>

                    ،

                    {{ __('home.footer.copyright') }}

                </span>

            </div>


            <!-- Designer -->
            <div class="col-md-6 text-center text-md-start text-body">

                {{ __('home.footer.designed_by') }}

                <a
                    class="border-bottom text-white"
                    href="https://htmlcodex.com"
                >
                    {{ __('home.footer.designer') }}
                </a>

            </div>

        </div>

    </div>

</div>

<!-- =========================================================
     Copyright End
========================================================== -->


<!-- =========================================================
     Back to Top
========================================================== -->

<a
    href="#"
    class="btn btn-primary btn-lg-square rounded-circle back-to-top"
    aria-label="{{ __('home.back_to_top') }}"
>
    <i class="fa fa-arrow-up"></i>
</a>


<!-- =========================================================
     JavaScript Libraries
========================================================== -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="{{ asset('lib/wow/wow.min.js') }}"></script>

<script src="{{ asset('lib/easing/easing.min.js') }}"></script>

<script src="{{ asset('lib/waypoints/waypoints.min.js') }}"></script>

<script src="{{ asset('lib/counterup/counterup.min.js') }}"></script>

<script src="{{ asset('lib/lightbox/js/lightbox.min.js') }}"></script>

<script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>

<script src="{{ asset('js/main.js') }}"></script>


<!-- =========================================================
     Google Maps
========================================================== -->

<script>

    const OFFICE_LOCATION = {
        lat: 35.7448,
        lng: 51.4075
    };

    let map;
    let directionsService;
    let directionsRenderer;

    let currentTravelMode = 'DRIVING';


    function initMap() {

        map = new google.maps.Map(
            document.getElementById('map'),
            {
                zoom: 13,

                center: OFFICE_LOCATION,

                mapTypeControl: true,

                streetViewControl: false,

                fullscreenControl: true,

                styles: [
                    {
                        featureType: 'poi.business',
                        stylers: [
                            {
                                visibility: 'off'
                            }
                        ]
                    }
                ]
            }
        );


        const marker = new google.maps.Marker({

            position: OFFICE_LOCATION,

            map: map,

            title: @json(__('home.map.company_name')),

            animation: google.maps.Animation.DROP,

        });


        const infoWindow = new google.maps.InfoWindow({

            content: `
                <div style="direction: {{ $direction }}; text-align: {{ $isRtl ? 'right' : 'left' }};">
                    <strong style="color:#1B361E;">
                        {{ __('home.map.company_name') }}
            </strong>
            <br>

{{ __('home.map.address') }}

            <br>

            <a
                href="tel:+982188776655"
                style="color:#1B361E;"
                dir="ltr"
            >
{{ __('home.topbar.phone') }}
            </a>
        </div>
`

        });


        marker.addListener(
            'click',
            () => infoWindow.open(map, marker)
        );


        directionsService = new google.maps.DirectionsService();


        directionsRenderer = new google.maps.DirectionsRenderer({

            draggable: false,

            panel: document.getElementById('directions-text'),

            map: map,

            polylineOptions: {

                strokeColor: '#1B361E',

                strokeWeight: 5,

                strokeOpacity: 0.8

            }

        });

    }


    function calculateRoute(originOverride) {

        if (!directionsService) {
            return;
        }


        const originElement = document.getElementById('origin-input');

        if (!originElement) {
            return;
        }


        const origin =
            originOverride ||
            originElement.value.trim();


        if (!origin) {

            alert(
                @json(__('home.map.messages.enter_origin'))
            );

            return;

        }


        directionsService.route({

            origin: origin,

            destination: OFFICE_LOCATION,

            travelMode:
                google.maps.TravelMode[currentTravelMode],

        }, (response, status) => {

            const summary =
                document.getElementById('route-summary');


            if (status === 'OK') {

                directionsRenderer.setDirections(response);


                const leg =
                    response.routes[0].legs[0];


                document.getElementById(
                    'route-distance'
                ).textContent =
                    leg.distance.text;


                document.getElementById(
                    'route-duration'
                ).textContent =
                    leg.duration.text;


                summary.classList.remove('d-none');

            } else {

                const msg =
                    status === 'ZERO_RESULTS'
                        ? @json(__('home.map.messages.zero_results'))

                        : status === 'NOT_FOUND'
                            ? @json(__('home.map.messages.not_found'))

                            : @json(__('home.map.messages.route_error'))
                            + ' ' + status;


                alert(msg);


                summary.classList.add('d-none');

            }

        });

    }


    function useMyLocation() {

        if (!navigator.geolocation) {

            alert(
                @json(__('home.map.messages.geolocation_unsupported'))
            );

            return;

        }


        navigator.geolocation.getCurrentPosition(

            pos => {

                const here = {

                    lat: pos.coords.latitude,

                    lng: pos.coords.longitude

                };


                document.getElementById(
                    'origin-input'
                ).value =
                @json(__('home.map.current_location'));


                calculateRoute(here);

            },

            () => {

                alert(
                    @json(__('home.map.messages.location_denied'))
                );

            }

        );

    }


    function setTravelMode(mode) {

        currentTravelMode = mode;


        const ids = {

            DRIVING: 'btn-driving',

            WALKING: 'btn-walking',

            BICYCLING: 'btn-bicycling'

        };


        Object.keys(ids).forEach(m => {

            const btn =
                document.getElementById(ids[m]);


            if (!btn) {
                return;
            }


            const active =
                m === mode;


            btn.classList.toggle(
                'btn-primary',
                active
            );


            btn.classList.toggle(
                'active',
                active
            );


            btn.classList.toggle(
                'btn-outline-primary',
                !active
            );

        });


        calculateRoute();

    }

</script>


<!-- =========================================================
     Google Maps API
========================================================== -->

<script
    src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&language={{ $googleMapLanguage }}&region=IR&callback=initMap"
    async
    defer
></script>


@stack('scripts')

</body>

</html>

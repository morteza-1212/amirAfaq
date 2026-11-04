@extends('layouts.home')
@section('content')

    <!-- Hero Carousel Start -->
    <div class="header-carousel owl-carousel" id="home">

        {{-- اسلاید اول — نظامی --}}
        <div class="header-carousel-item slide-defense"
             style="background-image: url('{{ asset('img/header/nezami.jpeg') }}');">
            <div class="carousel-caption">
                <div class="container">
                    <div class="row align-items-center justify-content-start">
                        <div class="col-xl-6 col-lg-7 col-md-9 col-12 animated fadeInLeft">
                            <div class="text-sm-center text-md-start">
                                <span class="sector-badge badge-defense">
                                    <i class="fas fa-shield-alt"></i>
                                    {{ __('home.carousel.slide1.badge') }}
                                </span>
                                <h1 class="display-1 text-white mb-4">
                                    {{ __('home.carousel.slide1.title_line1') }}
                                    <br>
                                    {{ __('home.carousel.slide1.title_line2') }}
                                </h1>
                                <p class="mb-5 fs-5 text-white">
                                    {{ __('home.carousel.slide1.description') }}
                                </p>
                                <div class="d-flex justify-content-center justify-content-md-start flex-shrink-0 mb-4">
                                    <a class="btn btn-light rounded-pill py-3 px-4 px-md-5 me-2" href="">
                                        <i class="fas fa-shield-alt me-2"></i>{{ __('home.carousel.slide1.btn_primary') }}
                                    </a>
                                    <a class="btn btn-secondary rounded-pill py-3 px-4 px-md-5 ms-2" href="{{ $contactUrl }}">
                                        {{ __('home.carousel.slide1.btn_secondary') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- اسلاید دوم — تبلیغاتی --}}
        <div class="header-carousel-item slide-advertising"
             style="background-image: url('{{ asset('img/header/tablighati2.jpeg') }}');">
            <div class="carousel-caption">
                <div class="container">
                    <div class="row align-items-center justify-content-end">
                        <div class="col-xl-6 col-lg-7 col-md-9 col-12 animated fadeInRight">
                            <div class="text-sm-center text-md-end">
                                <span class="sector-badge badge-advertising">
                                    <i class="fas fa-bullhorn"></i>
                                    {{ __('home.carousel.slide2.badge') }}
                                </span>
                                <h1 class="display-1 text-white mb-4">
                                    {{ __('home.carousel.slide2.title_line1') }}
                                    <br>
                                    {{ __('home.carousel.slide2.title_line2') }}
                                </h1>
                                <p class="mb-5 fs-5 text-white">
                                    {{ __('home.carousel.slide2.description') }}
                                </p>
                                <div class="d-flex justify-content-center justify-content-md-end flex-shrink-0 mb-4">
                                    <a class="btn btn-light rounded-pill py-3 px-4 px-md-5 me-2" href="">
                                        <i class="fas fa-bullhorn me-2"></i>{{ __('home.carousel.slide2.btn_primary') }}
                                    </a>
                                    <a class="btn btn-secondary rounded-pill py-3 px-4 px-md-5 ms-2" href="{{ $contactUrl }}">
                                        {{ __('home.carousel.slide2.btn_secondary') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- اسلاید سوم — پژوهشی --}}
        <div class="header-carousel-item slide-research"
             style="background-image: url('{{ asset('img/header/tahgig.jpeg') }}');">
            <div class="carousel-caption">
                <div class="container">
                    <div class="row align-items-center justify-content-start">
                        <div class="col-xl-6 col-lg-7 col-md-9 col-12 animated fadeInLeft">
                            <div class="text-sm-center text-md-start">
                                <span class="sector-badge badge-research">
                                    <i class="fas fa-flask"></i>
                                    {{ __('home.carousel.slide3.badge') }}
                                </span>
                                <h1 class="display-1 text-white mb-4">
                                    {{ __('home.carousel.slide3.title_line1') }}
                                    <br>
                                    {{ __('home.carousel.slide3.title_line2') }}
                                </h1>
                                <p class="mb-5 fs-5 text-white">
                                    {{ __('home.carousel.slide3.description') }}
                                </p>
                                <div class="d-flex justify-content-center justify-content-md-start flex-shrink-0 mb-4">
                                    <a class="btn btn-light rounded-pill py-3 px-4 px-md-5 me-2" href="">
                                        <i class="fas fa-flask me-2"></i>{{ __('home.carousel.slide3.btn_primary') }}
                                    </a>
                                    <a class="btn btn-secondary rounded-pill py-3 px-4 px-md-5 ms-2" href="{{ $contactUrl }}">
                                        {{ __('home.carousel.slide3.btn_secondary') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- Hero Carousel End -->


    <!-- Sector Cards Start — سه بخش تخصصی -->
    <div class="container-fluid py-5 bg-light">
        <div class="container py-4">
            <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                <h4 class="text-primary">{{ __('home.sectors.badge') }}</h4>
                <h1 class="display-4 mb-4">{{ __('home.sectors.title') }}</h1>
                <p class="mb-0">{{ __('home.sectors.description') }}</p>
            </div>

            <div class="row g-4">
                <div class="col-md-4 wow fadeInUp" data-wow-delay="0.2s">
                    <a href="" class="sector-card sector-card--defense">
                        <span class="sector-icon"><i class="fas fa-shield-alt"></i></span>
                        <h4 class="text-light">{{ __('home.sectors.defense.title') }}</h4>
                        <p>{{ __('home.sectors.defense.description') }}</p>
                    </a>
                </div>
                <div class="col-md-4 wow fadeInUp" data-wow-delay="0.4s">
                    <a href="" class="sector-card sector-card--advertising">
                        <span class="sector-icon"><i class="fas fa-bullhorn"></i></span>
                        <h4>{{ __('home.sectors.advertising.title') }}</h4>
                        <p>{{ __('home.sectors.advertising.description') }}</p>
                    </a>
                </div>
                <div class="col-md-4 wow fadeInUp" data-wow-delay="0.6s">
                    <a href="" class="sector-card sector-card--research">
                        <span class="sector-icon"><i class="fas fa-flask"></i></span>
                        <h4>{{ __('home.sectors.research.title') }}</h4>
                        <p>{{ __('home.sectors.research.description') }}</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Sector Cards End -->


    <!-- About Start -->
    <div class="container-fluid bg-light about py-5" id="about">
        <div class="container py-5">
            <div class="row g-5">

                <div class="col-xl-6 wow fadeInLeft" data-wow-delay="0.2s">
                    <div class="about-item-content bg-white rounded p-5 h-100">
                        <h4 class="text-primary">{{ __('home.about.badge') }}</h4>
                        <h1 class="display-4 mb-4">{{ __('home.about.title') }}</h1>

                        <p>{{ __('home.about.paragraph1') }}</p>
                        <p>{{ __('home.about.paragraph2') }}</p>

                        <p class="text-dark">
                            <i class="fa fa-check text-primary me-3"></i>{{ __('home.about.feature1') }}
                        </p>
                        <p class="text-dark">
                            <i class="fa fa-check text-primary me-3"></i>{{ __('home.about.feature2') }}
                        </p>
                        <p class="text-dark mb-4">
                            <i class="fa fa-check text-primary me-3"></i>{{ __('home.about.feature3') }}
                        </p>

                        <a class="btn btn-primary rounded-pill py-3 px-5" href="{{ $aboutUrl }}">
                            {{ __('home.about.learn_more') }}
                        </a>
                    </div>
                </div>

                <div class="col-xl-6 wow fadeInRight" data-wow-delay="0.2s">
                    <div class="bg-white rounded p-5 h-100">
                        <div class="row g-4 justify-content-center">

                            <div class="col-12">
                                <div class="rounded bg-light">
                                    <img src="{{ asset('img/AbouteUs/About.jpeg') }}"
                                         class="img-fluid rounded w-100" loading="lazy"
                                         alt="{{ __('home.about.image_alt') }}">
                                </div>
                            </div>

                            {{-- آمار و ارقام شهاب بالن --}}
                            <div class="col-12">
                                <div class="row g-3 stats-grid">

                                    {{-- بالون‌های تولیدشده --}}
                                    <div class="col-6 col-sm-6">
                                        <div class="stat-card stat-card--defense h-100">
                                            <div class="stat-icon">
                                                <i class="fas fa-parachute-box"></i>
                                            </div>
                                            <div class="stat-body">
                                                <div class="stat-number">
                                                    <span data-toggle="counter-up">1250</span>
                                                    <span class="stat-plus">+</span>
                                                </div>
                                                <h4 class="stat-label">{{ __('home.about.stats.balloons') }}</h4>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- پروژه‌های اجراشده --}}
                                    <div class="col-6 col-sm-6">
                                        <div class="stat-card stat-card--advertising h-100">
                                            <div class="stat-icon">
                                                <i class="fas fa-project-diagram"></i>
                                            </div>
                                            <div class="stat-body">
                                                <div class="stat-number">
                                                    <span data-toggle="counter-up">340</span>
                                                    <span class="stat-plus">+</span>
                                                </div>
                                                <h4 class="stat-label">{{ __('home.about.stats.projects') }}</h4>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- سال تجربه --}}
                                    <div class="col-6 col-sm-6">
                                        <div class="stat-card stat-card--research h-100">
                                            <div class="stat-icon">
                                                <i class="fas fa-award"></i>
                                            </div>
                                            <div class="stat-body">
                                                <div class="stat-number">
                                                    <span data-toggle="counter-up">14</span>
                                                    <span class="stat-plus">+</span>
                                                </div>
                                                <h4 class="stat-label">{{ __('home.about.stats.experience') }}</h4>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- مشتریان راضی --}}
                                    <div class="col-6 col-sm-6">
                                        <div class="stat-card stat-card--primary h-100">
                                            <div class="stat-icon">
                                                <i class="fas fa-users"></i>
                                            </div>
                                            <div class="stat-body">
                                                <div class="stat-number">
                                                    <span data-toggle="counter-up">580</span>
                                                    <span class="stat-plus">+</span>
                                                </div>
                                                <h4 class="stat-label">{{ __('home.about.stats.customers') }}</h4>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- About End -->


    <!-- Services Start -->
    <div class="container-fluid service py-5" id="products">
        <div class="container py-5">
            <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                <h4 class="text-primary">{{ __('home.services.badge') }}</h4>
                <h1 class="display-4 mb-4">{{ __('home.services.title') }}</h1>
                <p class="mb-0">{{ __('home.services.description') }}</p>
            </div>

            <div class="row g-4 justify-content-center">

                @php
                    $services = [
                        ['img' => 'service-1.png', 'icon' => 'fa-shield-alt', 'key' => 'defense'],
                        ['img' => 'service-2.png', 'icon' => 'fa-bullhorn',   'key' => 'advertising'],
                        ['img' => 'service-3.png', 'icon' => 'fa-flask',      'key' => 'research'],
                        ['img' => 'service-4.png', 'icon' => 'fa-tools',      'key' => 'support'],
                    ];
                @endphp

                @foreach ($services as $i => $s)
                    <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="{{ 0.2 * ($i + 1) }}s">
                        <div class="service-item">
                            <div class="service-img">
                                <img src="{{ asset('img/' . $s['img']) }}" class="img-fluid rounded-top w-100"
                                     loading="lazy" alt="{{ __('home.services.items.' . $s['key'] . '.title') }}">
                                <div class="service-icon p-3"><i class="fas {{ $s['icon'] }} fa-2x"></i></div>
                            </div>
                            <div class="service-content p-4">
                                <div class="service-content-inner">
                                    <a href="{{ $productsUrl }}" class="d-inline-block h4 mb-4">
                                        {{ __('home.services.items.' . $s['key'] . '.title') }}
                                    </a>
                                    <p class="mb-4">{{ __('home.services.items.' . $s['key'] . '.text') }}</p>
                                    <a class="btn btn-primary rounded-pill py-2 px-4" href="{{ $productsUrl }}">
                                        {{ __('home.common.learn_more') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="col-12 text-center wow fadeInUp" data-wow-delay="0.2s">
                    <a class="btn btn-primary rounded-pill py-3 px-5" href="{{ $productsUrl }}">
                        {{ __('home.services.view_all') }}
                    </a>
                </div>

            </div>
        </div>
    </div>
    <!-- Services End -->


    <!-- Blog Start -->
    <div class="container-fluid blog bg-light py-5">
        <div class="container py-5">
            <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                <h4 class="text-primary">{{ __('home.blog.badge') }}</h4>
                <h1 class="display-4 mb-4">{{ __('home.blog.title') }}</h1>
                <p class="mb-0">{{ __('home.blog.description') }}</p>
            </div>

            <div class="row g-4 justify-content-center">

                @php
                    $posts = [
                        ['img' => 'export.webp',  'cat_key' => 'defense',     'date_key' => 'post1', 'comments' => '6', 'key' => 'post1', 'route' => 'blog.defense'],
                        ['img' => 'hmport2.webp', 'cat_key' => 'advertising', 'date_key' => 'post2', 'comments' => '4', 'key' => 'post2', 'route' => 'blog.advertising'],
                        ['img' => 'market.webp',  'cat_key' => 'research',    'date_key' => 'post3', 'comments' => '8', 'key' => 'post3', 'route' => 'blog.research'],
                    ];
                @endphp

                @foreach ($posts as $i => $p)
                    <div class="col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="{{ 0.2 * ($i + 1) }}s">
                        <div class="blog-item">
                            <div class="blog-img">
                                <img src="{{ asset('/img/blog/' . $p['img']) }}" class="img-fluid rounded-top w-100"
                                     loading="lazy" alt="{{ __('home.blog.posts.' . $p['key'] . '.title') }}">
                                <div class="blog-categiry cat-{{ $p['cat_key'] }} py-2 px-4">
                                    <span>{{ __('home.blog.categories.' . $p['cat_key']) }}</span>
                                </div>
                            </div>
                            <div class="blog-content p-4">
                                <div class="blog-comment d-flex justify-content-between mb-3">
                                    <div class="small">
                                        <span class="fa fa-user text-primary"></span>
                                        {{ __('home.blog.author') }}
                                    </div>
                                    <div class="small">
                                        <span class="fa fa-calendar text-primary"></span>
                                        {{ __('home.blog.posts.' . $p['date_key'] . '.date') }}
                                    </div>
                                    <div class="small">
                                        <span class="fa fa-comment-alt text-primary"></span>
                                        {{ $p['comments'] }} {{ __('home.blog.comments') }}
                                    </div>
                                </div>

                                <a href=""
                                   class="h4 d-inline-block mb-3">
                                    {{ __('home.blog.posts.' . $p['key'] . '.title') }}
                                </a>

                                <p class="mb-3">{{ __('home.blog.posts.' . $p['key'] . '.text') }}</p>

                                <a href="" class="btn p-0">
                                    {{ __('home.blog.read_more') }}
                                    <i class="fa fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
    <!-- Blog End -->


    <!-- Team Start -->
    <div class="container-fluid team py-5" id="team">
        <div class="container py-5">
            <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                <h4 class="text-primary">{{ __('home.team.badge') }}</h4>
                <h1 class="display-4 mb-4">{{ __('home.team.title') }}</h1>
                <p class="mb-0">{{ __('home.team.description') }}</p>
            </div>

            <div class="row g-4">
                @php
                    $team = [
                        ['img' => 'team-1.jpg', 'key' => 'member1'],
                        ['img' => 'team-2.jpg', 'key' => 'member2'],
                        ['img' => 'team-3.jpg', 'key' => 'member3'],
                        ['img' => 'team-4.jpg', 'key' => 'member4'],
                    ];
                @endphp

                @foreach ($team as $i => $m)
                    <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="{{ 0.2 * ($i + 1) }}s">
                        <div class="team-item">
                            <div class="team-img">
                                <img src="{{ asset('img/' . $m['img']) }}" class="img-fluid rounded-top w-100"
                                     loading="lazy"
                                     alt="{{ __('home.team.members.' . $m['key'] . '.name') }} — {{ __('home.team.members.' . $m['key'] . '.role') }}">
                                <div class="team-icon">
                                    <a class="btn btn-primary btn-sm-square rounded-pill mb-2" href="#" aria-label="LinkedIn">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                    <a class="btn btn-primary btn-sm-square rounded-pill mb-2" href="#" aria-label="Instagram">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                    <a class="btn btn-primary btn-sm-square rounded-pill mb-0" href="#" aria-label="Telegram">
                                        <i class="fab fa-telegram"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="team-title p-4">
                                <h4 class="mb-0">{{ __('home.team.members.' . $m['key'] . '.name') }}</h4>
                                <p class="mb-0">{{ __('home.team.members.' . $m['key'] . '.role') }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Team End -->


    <!-- Map Start -->
{{--    <div class="container-fluid py-5" id="contact" style="background-color: #F5F7FA;">--}}
{{--        <div class="container py-5">--}}

{{--            <div class="text-center mx-auto pb-5" style="max-width: 800px;">--}}
{{--                <h4 class="text-primary">{{ __('home.map_section.badge') }}</h4>--}}
{{--                <h1 class="display-4 mb-4">{{ __('home.map_section.title') }}</h1>--}}
{{--                <p class="mb-0">{{ __('home.map_section.description') }}</p>--}}
{{--            </div>--}}

{{--            <div class="row g-4">--}}

{{--                --}}{{-- Map --}}
{{--                <div class="col-lg-8">--}}
{{--                    <div class="bg-white rounded p-3 shadow-sm">--}}
{{--                        <div id="company-map" style="width: 100%; height: 500px; border-radius: 8px;"></div>--}}

{{--                        <div class="d-flex flex-wrap gap-2 mt-3">--}}
{{--                            <a href="https://balad.ir/p/4t19XkOaUFLTdg"--}}
{{--                               target="_blank"--}}
{{--                               rel="noopener noreferrer"--}}
{{--                               class="btn btn-success rounded-pill">--}}
{{--                                <i class="fa fa-map-marker-alt me-1"></i>--}}
{{--                                {{ __('home.map_section.view_on_balad') }}--}}
{{--                            </a>--}}

{{--                            <a href="https://www.openstreetmap.org/"--}}
{{--                               target="_blank"--}}
{{--                               rel="noopener noreferrer"--}}
{{--                               class="btn btn-outline-primary rounded-pill">--}}
{{--                                <i class="fa fa-map me-1"></i>--}}
{{--                                {{ __('home.map_section.view_larger') }}--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                --}}{{-- Company Info --}}
{{--                <div class="col-lg-4">--}}
{{--                    <div class="bg-white rounded p-4 shadow-sm h-100">--}}
{{--                        <h5 class="mb-4 text-primary">--}}
{{--                            <i class="fa fa-building me-2"></i>--}}
{{--                            {{ __('home.map_section.company_info_title') }}--}}
{{--                        </h5>--}}

{{--                        <div class="mb-4">--}}
{{--                            <h6>--}}
{{--                                <i class="fa fa-map-marker-alt text-primary me-2"></i>--}}
{{--                                {{ __('home.map_section.address_label') }}--}}
{{--                            </h6>--}}
{{--                            <p class="text-muted">{{ __('home.map_section.address_value') }}</p>--}}
{{--                        </div>--}}

{{--                        <hr>--}}

{{--                        <div class="mb-4">--}}
{{--                            <h6>--}}
{{--                                <i class="fa fa-globe text-primary me-2"></i>--}}
{{--                                {{ __('home.map_section.company_label') }}--}}
{{--                            </h6>--}}
{{--                            <p class="text-muted">{{ __('home.map_section.company_value') }}</p>--}}
{{--                        </div>--}}

{{--                        <a href="https://balad.ir/p/4t19XkOaUFLTdg"--}}
{{--                           target="_blank"--}}
{{--                           rel="noopener noreferrer"--}}
{{--                           class="btn btn-primary w-100 rounded-pill py-2">--}}
{{--                            <i class="fa fa-directions me-2"></i>--}}
{{--                            {{ __('home.map_section.directions') }}--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
    <!-- Map End -->

@endsection

@section('scripts')
<<<<<<< HEAD
=======

>>>>>>> a96f8e3 (complateforCartshoping)
    <script src="{{ asset('vendor/leaflet/leaflet.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

<<<<<<< HEAD
            const companyLocation = { lat: 35.2383, lng: 58.4656 };
            const mapElement = document.getElementById('company-map');

            if (!mapElement || typeof L === 'undefined') {
                console.error('Leaflet or map element not loaded.');
                return;
            }

            const map = L.map('company-map', { zoomControl: true })
                .setView([companyLocation.lat, companyLocation.lng], 16);

            const I18N = {
                companyName: @json(__('home.map_section.company_value')),
                address:     @json(__('home.map_section.address_value')),
                viewBalad:   @json(__('home.map_section.view_on_balad')),
                popupTitle:  @json(__('home.map_section.popup_title')),
                offlineTitle: @json(__('home.map_section.offline_title')),
                offlineText:  @json(__('home.map_section.offline_text'))
            };

            const companyMarker = L.marker([companyLocation.lat, companyLocation.lng]).addTo(map);

            companyMarker.bindPopup(`
                <div style="direction:rtl;text-align:right">
                    <strong>${I18N.companyName}</strong>
                    <br>
                    ${I18N.address}
                    <br><br>
                    <a href="https://balad.ir/p/4t19XkOaUFLTdg"
                       target="_blank" rel="noopener noreferrer">
                       ${I18N.viewBalad}
                    </a>
                </div>
            `).openPopup();

            const offlineMessage = document.createElement('div');
            offlineMessage.style.cssText = `
                position:absolute; z-index:1000; top:50%; left:50%;
                transform:translate(-50%,-50%); background:white; padding:20px;
                border-radius:12px; box-shadow:0 2px 15px rgba(0,0,0,.15);
                text-align:center; width:85%; max-width:350px;
                direction:rtl; display:none;
            `;
=======
            const companyLocation = {
                lat: 35.2383,
                lng: 58.4656
            };

            const mapElement = document.getElementById('company-map');

            if (!mapElement || typeof L === 'undefined') {
                console.error('Leaflet یا عنصر نقشه بارگذاری نشده است.');
                return;
            }

            // ایجاد نقشه
            const map = L.map('company-map', {
                zoomControl: true
            }).setView(
                [companyLocation.lat, companyLocation.lng],
                16
            );

            // نشانگر شرکت
            const companyMarker = L.marker([
                companyLocation.lat,
                companyLocation.lng
            ]).addTo(map);

            companyMarker.bindPopup(`
                <div style="direction:rtl;text-align:right">
                    <strong>شرکت امیر آفاق گستر پارس</strong>
                    <br>
                    شرکت صادرات و واردات
                    <br>
                    کاشمر، خیابان سلمان فارسی
                    <br><br>
                    <a href="https://balad.ir/p/4t19XkOaUFLTdg"
                       target="_blank"
                       rel="noopener noreferrer">
                       مشاهده موقعیت در بلد
                    </a>
                </div>
            `).openPopup();

            // پیام وضعیت نقشه
            const offlineMessage = document.createElement('div');

            offlineMessage.style.cssText = `
                position:absolute;
                z-index:1000;
                top:50%;
                left:50%;
                transform:translate(-50%,-50%);
                background:white;
                padding:20px;
                border-radius:12px;
                box-shadow:0 2px 15px rgba(0,0,0,.15);
                text-align:center;
                width:85%;
                max-width:350px;
                direction:rtl;
                display:none;
            `;

            offlineMessage.innerHTML = `
                <i class="fa fa-map-marked-alt fa-2x text-success mb-3"></i>
                <h5>موقعیت شرکت</h5>
                <p class="mb-0">
                    برای نمایش تصاویر نقشه، اتصال به سرویس نقشه موردنیاز است.
                    موقعیت و اطلاعات شرکت در دسترس هستند.
                </p>
            `;

            mapElement.style.position = 'relative';
            mapElement.appendChild(offlineMessage);

            function showOfflineMessage() {
                offlineMessage.style.display = 'block';
            }

            function hideOfflineMessage() {
                offlineMessage.style.display = 'none';
            }

            let tileLoaded = false;

            // فقط در صورت وجود اینترنت، درخواست نقشه ارسال شود
            if (navigator.onLine) {

                const tiles = L.tileLayer(
                    'https://tile.openstreetmap.org/{z}/{x}/{y}.png',
                    {
                        maxZoom: 19,
                        attribution: '&copy; OpenStreetMap contributors'
                    }
                );

                tiles.on('tileload', function () {
                    tileLoaded = true;
                    hideOfflineMessage();
                });

                tiles.on('tileerror', function () {
                    if (!tileLoaded) {
                        showOfflineMessage();
                    }
                });

                tiles.addTo(map);

            } else {
                showOfflineMessage();
            }

            // بررسی اتصال مجدد اینترنت
            window.addEventListener('online', function () {
                hideOfflineMessage();
                map.eachLayer(function (layer) {
                    if (layer instanceof L.TileLayer) {
                        map.removeLayer(layer);
                    }
                });

                tileLoaded = false;

                L.tileLayer(
                    'https://tile.openstreetmap.org/{z}/{x}/{y}.png',
                    {
                        maxZoom: 19,
                        attribution: '&copy; OpenStreetMap contributors'
                    }
                ).on('tileload', function () {
                    tileLoaded = true;
                    hideOfflineMessage();
                }).on('tileerror', function () {
                    if (!tileLoaded) {
                        showOfflineMessage();
                    }
                }).addTo(map);
            });

            window.addEventListener('offline', function () {
                map.eachLayer(function (layer) {
                    if (layer instanceof L.TileLayer) {
                        map.removeLayer(layer);
                    }
                });

                showOfflineMessage();
            });

            setTimeout(function () {
                map.invalidateSize();
            }, 300);
>>>>>>> a96f8e3 (complateforCartshoping)

            offlineMessage.innerHTML = `
                <i class="fa fa-map-marked-alt fa-2x text-primary mb-3"></i>
                <h5>${I18N.offlineTitle}</h5>
                <p class="mb-0">${I18N.offlineText}</p>
            `;

            mapElement.style.position = 'relative';
            mapElement.appendChild(offlineMessage);

            const showOfflineMessage = () => { offlineMessage.style.display = 'block'; };
            const hideOfflineMessage = () => { offlineMessage.style.display = 'none'; };

            let tileLoaded = false;

            const addTiles = () => {
                tileLoaded = false;
                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; OpenStreetMap contributors'
                })
                    .on('tileload', () => { tileLoaded = true; hideOfflineMessage(); })
                    .on('tileerror', () => { if (!tileLoaded) showOfflineMessage(); })
                    .addTo(map);
            };

            if (navigator.onLine) {
                addTiles();
            } else {
                showOfflineMessage();
            }

            window.addEventListener('online', function () {
                hideOfflineMessage();
                map.eachLayer(function (layer) {
                    if (layer instanceof L.TileLayer) map.removeLayer(layer);
                });
                addTiles();
            });

            window.addEventListener('offline', function () {
                map.eachLayer(function (layer) {
                    if (layer instanceof L.TileLayer) map.removeLayer(layer);
                });
                showOfflineMessage();
            });

            setTimeout(() => map.invalidateSize(), 300);
        });
    </script>

@endsection

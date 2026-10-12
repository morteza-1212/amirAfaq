@extends('layouts.home')
@section('content')

    <!-- Hero Carousel Start -->
    <div class="header-carousel owl-carousel" id="home">

        {{-- اسلاید اول --}}
        <div class="header-carousel-item"
             style="background-image: url('{{ asset('img/header/Duck-ai-image-2026-09-27-14-24.jpeg') }}');">
            <div class="carousel-caption">
                <div class="container">
                    <div class="row align-items-center justify-content-start">
                        <div class="col-xl-6 col-lg-7 col-md-9 col-12 animated fadeInLeft">
                            <div class="text-sm-center text-md-start">
                                <h4 class="text-white text-uppercase fw-bold mb-4">
                                    {{ __('home.carousel.slide1.badge') }}
                                </h4>
                                <h1 class="display-1 text-white mb-4">
                                    {{ __('home.carousel.slide1.title_line1') }}
                                    <br>
                                    {{ __('home.carousel.slide1.title_line2') }}
                                </h1>
                                <p class="mb-5 fs-5 text-white">
                                    {{ __('home.carousel.slide1.description') }}
                                </p>
                                <div class="d-flex justify-content-center justify-content-md-start flex-shrink-0 mb-4">
                                    <a class="btn btn-light rounded-pill py-3 px-4 px-md-5 me-2" href="{{ $productsUrl }}">
                                        <i class="fas fa-box-open me-2"></i>{{ __('home.carousel.slide1.btn_primary') }}
                                    </a>
                                    <a class="btn btn-dark rounded-pill py-3 px-4 px-md-5 ms-2" href="{{ $contactUrl }}">
                                        {{ __('home.carousel.slide1.btn_secondary') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- اسلاید دوم --}}
        <div class="header-carousel-item"
             style="background-image: url('{{ asset('img/header/Duck-ai-image-2026-09-27-14-24(1).jpeg') }}');">
            <div class="carousel-caption">
                <div class="container">
                    <div class="row align-items-center justify-content-end">
                        <div class="col-xl-6 col-lg-7 col-md-9 col-12 animated fadeInRight">
                            <div class="text-sm-center text-md-end">
                                <h4 class="text-white text-uppercase fw-bold mb-4">
                                    {{ __('home.carousel.slide2.badge') }}
                                </h4>
                                <h1 class="display-1 text-white mb-4">
                                    {{ __('home.carousel.slide2.title_line1') }}
                                    <br>
                                    {{ __('home.carousel.slide2.title_line2') }}
                                </h1>
                                <p class="mb-5 fs-5 text-white">
                                    {{ __('home.carousel.slide2.description') }}
                                </p>
                                <div class="d-flex justify-content-center justify-content-md-end flex-shrink-0 mb-4">
                                    <a class="btn btn-light rounded-pill py-3 px-4 px-md-5 me-2" href="{{ $aboutUrl }}">
                                        <i class="fas fa-globe me-2"></i>{{ __('home.carousel.slide2.btn_primary') }}
                                    </a>
                                    <a class="btn btn-dark rounded-pill py-3 px-4 px-md-5 ms-2" href="{{ $contactUrl }}">
                                        {{ __('home.carousel.slide2.btn_secondary') }}
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


    <!-- About Start -->
    <div class="container-fluid bg-light about py-5" id="about">
        <div class="container py-5">
            <div class="row g-5">

                <div class="col-xl-6 wow fadeInLeft" data-wow-delay="0.2s">
                    <div class="about-item-content bg-white rounded p-5 h-100">
                        <h4 style="color: #1B361E">{{ __('home.about.badge') }}</h4>
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
                                    <img src="{{ asset('img/AbouteUs/Duck-ai-image-2026-09-27-14-57.jpeg') }}"
                                         class="img-fluid rounded w-100" loading="lazy"
                                         alt="{{ __('home.about.image_alt') }}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="counter-item bg-light rounded p-3 h-100">
                                    <div class="counter-counting">
                                        <span class="text-primary fs-2 fw-bold" data-toggle="counter-up">129</span>
                                        <span class="h1 fw-bold text-primary">+</span>
                                    </div>
                                    <h4 class="mb-0 text-dark">{{ __('home.about.stats.countries') }}</h4>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="counter-item bg-light rounded p-3 h-100">
                                    <div class="counter-counting">
                                        <span class="text-primary fs-2 fw-bold" data-toggle="counter-up">99</span>
                                        <span class="h1 fw-bold text-primary">+</span>
                                    </div>
                                    <h4 class="mb-0 text-dark">{{ __('home.about.stats.producers') }}</h4>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="counter-item bg-light rounded p-3 h-100">
                                    <div class="counter-counting">
                                        <span class="text-primary fs-2 fw-bold" data-toggle="counter-up">556</span>
                                        <span class="h1 fw-bold text-primary">+</span>
                                    </div>
                                    <h4 class="mb-0 text-dark">{{ __('home.about.stats.tons') }}</h4>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="counter-item bg-light rounded p-3 h-100">
                                    <div class="counter-counting">
                                        <span class="text-primary fs-2 fw-bold" data-toggle="counter-up">967</span>
                                        <span class="h1 fw-bold text-primary">+</span>
                                    </div>
                                    <h4 class="mb-0 text-dark">{{ __('home.about.stats.customers') }}</h4>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- About End -->


    <!-- Service Start -->
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
                        ['img' => 'service-1.png', 'icon' => 'fa-leaf',  'key' => 'agriculture'],
                        ['img' => 'service-2.png', 'icon' => 'fa-globe', 'key' => 'export'],
                        ['img' => 'service-3.png', 'icon' => 'fa-ship',  'key' => 'import'],
                        ['img' => 'service-4.png', 'icon' => 'fa-truck', 'key' => 'logistics'],
                    ];
                @endphp

                @foreach ($services as $i => $s)
                    <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="{{ 0.2 * ($i + 1) }}s">
                        <div class="service-item">
                            <div class="service-img">
                                <img src="{{ asset('img/' . $s['img']) }}" class="img-fluid rounded-top w-100"
                                     loading="lazy" alt="{{ __('home.services.items.' . $s['key'] . '.title') }}">
                                <div class="service-icon p-3"><i class="fa {{ $s['icon'] }} fa-2x"></i></div>
                            </div>
                            <div class="service-content p-4">
                                <div class="service-content-inner">
                                    <a href="{{ $servicesUrl }}" class="d-inline-block h4 mb-4">
                                        {{ __('home.services.items.' . $s['key'] . '.title') }}
                                    </a>
                                    <p class="mb-4">{{ __('home.services.items.' . $s['key'] . '.text') }}</p>
                                    <a class="btn btn-primary rounded-pill py-2 px-4" href="{{ $servicesUrl }}">
                                        {{ __('home.common.learn_more') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="col-12 text-center wow fadeInUp" data-wow-delay="0.2s">
                    <a class="btn btn-primary rounded-pill py-3 px-5" href="{{ $servicesUrl }}">
                        {{ __('home.services.view_all') }}
                    </a>
                </div>

            </div>
        </div>
    </div>
    <!-- Service End -->


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
                        ['img' => 'export.webp', 'cat_key' => 'export', 'date' => '۳۰ آذر ۱۴۰۴', 'comments' => '۶', 'key' => 'post1', 'route' => 'blog.export'],
                        ['img' => 'hmport2.webp', 'cat_key' => 'import', 'date' => '۲۵ آذر ۱۴۰۴', 'comments' => '۴', 'key' => 'post2', 'route' => 'blog.import'],
                        ['img' => 'market.webp', 'cat_key' => 'market', 'date' => '۲۰ آذر ۱۴۰۴', 'comments' => '۸', 'key' => 'post3', 'route' => 'blog.markets'],
                    ];
                @endphp

                @foreach ($posts as $i => $p)
                    <div class="col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="{{ 0.2 * ($i + 1) }}s">
                        <div class="blog-item">
                            <div class="blog-img">
                                <img src="{{ asset('/img/blog/' . $p['img']) }}" class="img-fluid rounded-top w-100"
                                     loading="lazy" alt="{{ __('home.blog.posts.' . $p['key'] . '.title') }}">
                                <div class="blog-categiry py-2 px-4">
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
                                        {{ $p['date'] }}
                                    </div>
                                    <div class="small">
                                        <span class="fa fa-comment-alt text-primary"></span>
                                        {{ $p['comments'] }} {{ __('home.blog.comments') }}
                                    </div>
                                </div>

                                <a href="{{ route($p['route'], ['locale' => app()->getLocale()]) }}"
                                   class="h4 d-inline-block mb-3">
                                    {{ __('home.blog.posts.' . $p['key'] . '.title') }}
                                </a>

                                <p class="mb-3">{{ __('home.blog.posts.' . $p['key'] . '.text') }}</p>

                                <a href="{{ route($p['route'], ['locale' => app()->getLocale()]) }}" class="btn p-0">
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
                                     alt="{{ __('home.team.members.' . $m['key'] . '.name') }}، {{ __('home.team.members.' . $m['key'] . '.role') }}">
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
    <div class="container-fluid py-5" id="contact" style="background-color: #f8f9fa;">
        <div class="container py-5">
            <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                <h4 style="color: #1B361E">{{ __('home.map_section.badge') }}</h4>
                <h1 class="display-4 mb-4">{{ __('home.map_section.title') }}</h1>
                <p class="mb-0">{{ __('home.map_section.description') }}</p>
            </div>

            <div class="row g-4 justify-content-center">

                <div class="col-lg-8 wow fadeInLeft" data-wow-delay="0.2s">
                    <div class="bg-white rounded p-3 h-100 shadow-sm">
                        <div id="map" style="width: 100%; height: 500px; border-radius: 8px;"></div>

                        <div class="d-flex justify-content-center gap-2 mt-3 flex-wrap">
                            <button type="button" id="btn-driving" class="btn btn-primary rounded-pill active" onclick="setTravelMode('DRIVING')">
                                <i class="fa fa-car me-1"></i> {{ __('home.map_section.travel_modes.driving') }}
                            </button>
                            <button type="button" id="btn-walking" class="btn btn-outline-primary rounded-pill" onclick="setTravelMode('WALKING')">
                                <i class="fa fa-walking me-1"></i> {{ __('home.map_section.travel_modes.walking') }}
                            </button>
                            <button type="button" id="btn-bicycling" class="btn btn-outline-primary rounded-pill" onclick="setTravelMode('BICYCLING')">
                                <i class="fa fa-bicycle me-1"></i> {{ __('home.map_section.travel_modes.bicycling') }}
                            </button>
                        </div>

                        <div id="route-summary" class="alert alert-success mt-3 mb-0 d-none">
                            <div class="d-flex justify-content-around text-center">
                                <div>
                                    <i class="fa fa-road text-primary fa-2x mb-2"></i>
                                    <div>
                                        <strong>{{ __('home.map_section.distance') }}:</strong>
                                        <span id="route-distance">-</span>
                                    </div>
                                </div>
                                <div>
                                    <i class="fa fa-clock text-primary fa-2x mb-2"></i>
                                    <div>
                                        <strong>{{ __('home.map_section.duration') }}:</strong>
                                        <span id="route-duration">-</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 wow fadeInRight" data-wow-delay="0.2s">
                    <div class="bg-white rounded p-4 h-100 shadow-sm">
                        <h5 class="mb-3 pb-2" style="color: #1B361E; border-bottom: 2px solid #1B361E;">
                            <i class="fa fa-route me-2"></i> {{ __('home.map_section.route_title') }}
                        </h5>

                        <div class="mb-3">
                            <label for="origin-input" class="form-label small text-muted">
                                {{ __('home.map_section.origin') }}
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="fa fa-map-marker-alt text-primary"></i>
                                </span>
                                <input type="text" id="origin-input" class="form-control"
                                       placeholder="{{ __('home.map_section.origin_placeholder') }}"
                                       value="{{ __('home.map_section.origin_default') }}">
                                <button type="button" class="btn btn-outline-primary" onclick="useMyLocation()"
                                        title="{{ __('home.map_section.my_location') }}">
                                    <i class="fa fa-crosshairs"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="destination-input" class="form-label small text-muted">
                                {{ __('home.map_section.destination') }}
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="fa fa-flag-checkered text-danger"></i>
                                </span>
                                <input type="text" id="destination-input" class="form-control"
                                       value="{{ __('home.map_section.destination_value') }}" readonly>
                            </div>
                        </div>

                        <button type="button" class="btn btn-primary w-100 rounded-pill py-2 mb-4" onclick="calculateRoute()">
                            <i class="fa fa-search-location me-2"></i>
                            {{ __('home.map_section.show_route') }}
                        </button>

                        <div id="directions-text" style="max-height: 320px; overflow-y: auto; font-size: 13px;"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Map End -->

@endsection

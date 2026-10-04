@extends('layouts.home')
@section('content')

    <!-- Navbar End -->

    <!-- Hero Carousel Start -->
    <div class="header-carousel owl-carousel" id="home">

        <!-- اسلاید اول -->
        <div class="header-carousel-item"
             style="background-image: url('{{ asset('img/header/Duck-ai-image-2026-09-27-14-24.jpeg') }}');">
            <div class="carousel-caption">
                <div class="container">
                    <div class="row align-items-center justify-content-start">
                        <div class="col-xl-6 col-lg-7 col-md-9 col-12 animated fadeInLeft">
                            <div class="text-sm-center text-md-start">
                                <h4 class="text-white text-uppercase fw-bold mb-4">صادرات محصولات ایرانی به جهان</h4>
                                <h1 class="display-1 text-white mb-4">
                                    پسته، کشمش و زعفران
                                    <br>
                                    با کیفیت جهانی
                                </h1>
                                <p class="mb-5 fs-5 text-white">
                                    تأمین و صادرات محصولات کشاورزی منتخب ایران
                                    با تمرکز بر کیفیت، بسته‌بندی استاندارد و
                                    ایجاد ارتباط تجاری با بازارهای بین‌المللی.
                                </p>
                                <div class="d-flex justify-content-center justify-content-md-start flex-shrink-0 mb-4">
                                    <a class="btn btn-light rounded-pill py-3 px-4 px-md-5 me-2" href="/products">
                                        <i class="fas fa-box-open me-2"></i>محصولات صادراتی
                                    </a>
                                    <a class="btn btn-dark rounded-pill py-3 px-4 px-md-5 ms-2" href="/contact">درخواست همکاری</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- اسلاید دوم -->
        <div class="header-carousel-item"
             style="background-image: url('{{ asset('img/header/Duck-ai-image-2026-09-27-14-24(1).jpeg') }}');">
            <div class="carousel-caption">
                <div class="container">
                    <div class="row align-items-center justify-content-end">
                        <div class="col-xl-6 col-lg-7 col-md-9 col-12 animated fadeInRight">
                            <div class="text-sm-center text-md-end">
                                <h4 class="text-white text-uppercase fw-bold mb-4">تجارت بین‌المللی و تأمین کالا</h4>
                                <h1 class="display-1 text-white mb-4">
                                    ارتباط مطمئن
                                    <br>
                                    با بازارهای جهانی
                                </h1>
                                <p class="mb-5 fs-5 text-white">
                                    فعالیت در زمینه صادرات محصولات کشاورزی،
                                    واردات کالاهای منتخب و ارائه خدمات تجاری
                                    با هدف توسعه همکاری‌های بین‌المللی.
                                </p>
                                <div class="d-flex justify-content-center justify-content-md-end flex-shrink-0 mb-4">
                                    <a class="btn btn-light rounded-pill py-3 px-4 px-md-5 me-2" href="#about">
                                        <i class="fas fa-globe me-2"></i>درباره شرکت
                                    </a>
                                    <a class="btn btn-dark rounded-pill py-3 px-4 px-md-5 ms-2" href="#contact">تماس با ما</a>
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
                        <h4 style="color: #1B361E">درباره شرکت</h4>
                        <h1 class="display-4 mb-4">صادرات و واردات محصولات کشاورزی و لبنی</h1>
                        <p>
                            شرکت امیر آفاق گستر پارس با سال‌ها تجربه در حوزه تأمین، بسته‌بندی و توزیع محصولات کشاورزی و لبنی،
                            فعالیت خود را در زمینه صادرات و واردات محصولات باکیفیت به بازارهای داخلی و بین‌المللی گسترش داده است.
                        </p>
                        <p>
                            ما با همکاری مستقیم با کشاورزان، دامداران و کارخانه‌های صنایع لبنی، زنجیره تأمین مطمئنی را فراهم
                            کرده‌ایم تا محصولات تازه و استاندارد به دست مشتریان برسد.
                        </p>
                        <p class="text-dark"><i class="fa fa-check text-primary me-3"></i>تأمین مستقیم از تولیدکنندگان معتبر</p>
                        <p class="text-dark"><i class="fa fa-check text-primary me-3"></i>بسته‌بندی و کنترل کیفیت استاندارد</p>
                        <p class="text-dark mb-4"><i class="fa fa-check text-primary me-3"></i>حمل‌ونقل بین‌المللی و زنجیره سرد</p>
                        <a class="btn btn-primary rounded-pill py-3 px-5" href="/about">بیشتر بدانید</a>
                    </div>
                </div>

                <div class="col-xl-6 wow fadeInRight" data-wow-delay="0.2s">
                    <div class="bg-white rounded p-5 h-100">
                        <div class="row g-4 justify-content-center">
                            <div class="col-12">
                                <div class="rounded bg-light">
                                    <img src="{{ asset('img/AbouteUs/Duck-ai-image-2026-09-27-14-57.jpeg') }}"
                                         class="img-fluid rounded w-100" loading="lazy"
                                         alt="صادرات محصولات کشاورزی و لبنی">
                                </div>
                            </div>

                            {{-- TODO: اعداد آمار نمونه هستند؛ با مقادیر واقعی جایگزین شوند --}}
                            <div class="col-sm-6">
                                <div class="counter-item bg-light rounded p-3 h-100">
                                    <div class="counter-counting">
                                        <span class="text-primary fs-2 fw-bold" data-toggle="counter-up">129</span>
                                        <span class="h1 fw-bold text-primary">+</span>
                                    </div>
                                    <h4 class="mb-0 text-dark">کشور مقصد صادرات</h4>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="counter-item bg-light rounded p-3 h-100">
                                    <div class="counter-counting">
                                        <span class="text-primary fs-2 fw-bold" data-toggle="counter-up">99</span>
                                        <span class="h1 fw-bold text-primary">+</span>
                                    </div>
                                    <h4 class="mb-0 text-dark">تولیدکننده همکار</h4>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="counter-item bg-light rounded p-3 h-100">
                                    <div class="counter-counting">
                                        <span class="text-primary fs-2 fw-bold" data-toggle="counter-up">556</span>
                                        <span class="h1 fw-bold text-primary">+</span>
                                    </div>
                                    <h4 class="mb-0 text-dark">تن محصول صادراتی سالانه</h4>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="counter-item bg-light rounded p-3 h-100">
                                    <div class="counter-counting">
                                        <span class="text-primary fs-2 fw-bold" data-toggle="counter-up">967</span>
                                        <span class="h1 fw-bold text-primary">+</span>
                                    </div>
                                    <h4 class="mb-0 text-dark">مشتری فعال داخلی و خارجی</h4>
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
                <h4 class="text-primary">خدمات ما</h4>
                <h1 class="display-4 mb-4">خدمات تخصصی صادرات و واردات محصولات کشاورزی</h1>
                <p class="mb-0">
                    شرکت امیر آفاق گستر پارس با ارائه خدمات تخصصی در زمینه
                    تأمین، صادرات و واردات محصولات کشاورزی، ارتباطی مطمئن میان
                    تولیدکنندگان ایرانی و بازارهای بین‌المللی ایجاد می‌کند.
                </p>
            </div>

            <div class="row g-4 justify-content-center">
                @php
                    $services = [
                        ['img' => 'service-1.png', 'icon' => 'fa-leaf',  'title' => 'تأمین محصولات کشاورزی',
                         'text' => 'تأمین انواع محصولات کشاورزی باکیفیت از تولیدکنندگان معتبر و بررسی دقیق کیفیت محصولات.'],
                        ['img' => 'service-2.png', 'icon' => 'fa-globe', 'title' => 'صادرات به بازارهای جهانی',
                         'text' => 'صادرات محصولات ایرانی به کشورهای مختلف با رعایت استانداردهای بین‌المللی و نیاز بازار مقصد.'],
                        ['img' => 'service-3.png', 'icon' => 'fa-ship',  'title' => 'واردات محصولات کشاورزی',
                         'text' => 'واردات محصولات مورد نیاز از تأمین‌کنندگان معتبر خارجی با مدیریت کامل فرآیند خرید و حمل‌ونقل.'],
                        ['img' => 'service-4.png', 'icon' => 'fa-truck', 'title' => 'حمل‌ونقل و لجستیک',
                         'text' => 'مدیریت حمل‌ونقل، بسته‌بندی، امور گمرکی و تحویل ایمن محصولات در کوتاه‌ترین زمان ممکن.'],
                    ];
                @endphp

                @foreach ($services as $i => $s)
                    <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="{{ 0.2 * ($i + 1) }}s">
                        <div class="service-item">
                            <div class="service-img">
                                {{-- TODO: تصاویر service-1..4 را در public/img قرار دهید (قبلاً از تصاویر بلاگ استفاده می‌شد) --}}
                                <img src="{{ asset('img/' . $s['img']) }}" class="img-fluid rounded-top w-100"
                                     loading="lazy" alt="{{ $s['title'] }}">
                                <div class="service-icon p-3"><i class="fa {{ $s['icon'] }} fa-2x"></i></div>
                            </div>
                            <div class="service-content p-4">
                                <div class="service-content-inner">
                                    <a href="/services" class="d-inline-block h4 mb-4">{{ $s['title'] }}</a>
                                    <p class="mb-4">{{ $s['text'] }}</p>
                                    <a class="btn btn-primary rounded-pill py-2 px-4" href="/services">بیشتر بدانید</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="col-12 text-center wow fadeInUp" data-wow-delay="0.2s">
                    <a class="btn btn-primary rounded-pill py-3 px-5" href="/services">مشاهده همه خدمات</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Service End -->

    <!-- Blog Start -->
    <div class="container-fluid blog bg-light py-5">
        <div class="container py-5">
            <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                <h4 class="text-primary">اخبار و مقالات</h4>
                <h1 class="display-4 mb-4">جدیدترین مطالب کشاورزی و لبنی</h1>
                <p class="mb-0">
                    با جدیدترین اخبار، تحلیل‌ها و مقالات تخصصی در حوزه صادرات و واردات محصولات کشاورزی و لبنی آشنا شوید.
                    از تغییرات بازارهای جهانی تا نکات کلیدی در بسته‌بندی، نگهداری و حمل‌ونقل محصولات.
                </p>
            </div>

            <div class="row g-4 justify-content-center">
                {{-- TODO: بهتر است از دیتابیس (@foreach $posts) خوانده شود؛ تاریخ‌ها نمونه‌اند --}}
                @php
                    $posts = [
                        ['img' => 'blog-1.png', 'cat' => 'صادرات', 'date' => '۳۰ آذر ۱۴۰۴', 'comments' => '۶',
                         'title' => 'راهنمای کامل صادرات محصولات کشاورزی به کشورهای همسایه',
                         'text' => 'از اخذ مجوزهای لازم تا بسته‌بندی استاندارد و حمل‌ونقل بین‌المللی؛ هر آنچه برای شروع صادرات موفق نیاز دارید.'],
                        ['img' => 'blog-2.png', 'cat' => 'واردات', 'date' => '۲۵ آذر ۱۴۰۴', 'comments' => '۴',
                         'title' => 'نکات کلیدی در واردات محصولات لبنی و نگهداری زنجیره سرد',
                         'text' => 'آشنایی با استانداردهای بهداشتی، شرایط نگهداری و حمل‌ونقل محصولات لبنی برای جلوگیری از افت کیفیت.'],
                        ['img' => 'blog-3.png', 'cat' => 'تحلیل بازار', 'date' => '۲۰ آذر ۱۴۰۴', 'comments' => '۸',
                         'title' => 'تحلیل بازار جهانی محصولات کشاورزی و فرصت‌های صادراتی',
                         'text' => 'بررسی روند قیمت‌ها، تقاضای جهانی و بازارهای هدف برای صادرات محصولات کشاورزی و لبنی در سال جاری.'],
                    ];
                @endphp

                @foreach ($posts as $i => $p)
                    <div class="col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="{{ 0.2 * ($i + 1) }}s">
                        <div class="blog-item">
                            <div class="blog-img">
                                <img src="{{ asset('img/' . $p['img']) }}" class="img-fluid rounded-top w-100"
                                     loading="lazy" alt="{{ $p['title'] }}">
                                <div class="blog-categiry py-2 px-4"><span>{{ $p['cat'] }}</span></div>
                            </div>
                            <div class="blog-content p-4">
                                <div class="blog-comment d-flex justify-content-between mb-3">
                                    <div class="small"><span class="fa fa-user text-primary"></span> تیم محتوا</div>
                                    <div class="small"><span class="fa fa-calendar text-primary"></span> {{ $p['date'] }}</div>
                                    <div class="small"><span class="fa fa-comment-alt text-primary"></span> {{ $p['comments'] }} دیدگاه</div>
                                </div>
                                <a href="/blog" class="h4 d-inline-block mb-3">{{ $p['title'] }}</a>
                                <p class="mb-3">{{ $p['text'] }}</p>
                                <a href="/blog" class="btn p-0">ادامه مطلب <i class="fa fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Blog End -->

    <!-- Team Start -->
    <div class="container-fluid team py-5">
        <div class="container py-5">
            <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                <h4 class="text-primary">تیم ما</h4>
                <h1 class="display-4 mb-4">با متخصصان ما آشنا شوید</h1>
                <p class="mb-0">
                    تیم ما متشکل از کارشناسان باتجربه در حوزه کشاورزی، دامداری، صنایع لبنی، بازاریابی بین‌الملل و لجستیک است
                    که با دانش تخصصی و شبکه گسترده جهانی، شما را در مسیر صادرات و واردات موفق همراهی می‌کنند.
                </p>
            </div>

            <div class="row g-4">
                {{-- TODO: نام‌ها و تصاویر نمونه هستند --}}
                @php
                    $team = [
                        ['img' => 'team-1.jpg', 'name' => 'علی رضایی',  'role' => 'مدیرعامل و بنیان‌گذار'],
                        ['img' => 'team-2.jpg', 'name' => 'مریم احمدی', 'role' => 'مدیر صادرات'],
                        ['img' => 'team-3.jpg', 'name' => 'حسین کریمی', 'role' => 'مدیر واردات'],
                        ['img' => 'team-4.jpg', 'name' => 'زهرا موسوی', 'role' => 'کارشناس کنترل کیفیت'],
                    ];
                @endphp

                @foreach ($team as $i => $m)
                    <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="{{ 0.2 * ($i + 1) }}s">
                        <div class="team-item">
                            <div class="team-img">
                                <img src="{{ asset('img/' . $m['img']) }}" class="img-fluid rounded-top w-100"
                                     loading="lazy" alt="{{ $m['name'] }}، {{ $m['role'] }}">
                                <div class="team-icon">
                                    <a class="btn btn-primary btn-sm-square rounded-pill mb-2" href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                                    <a class="btn btn-primary btn-sm-square rounded-pill mb-2" href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                                    <a class="btn btn-primary btn-sm-square rounded-pill mb-0" href="#" aria-label="Telegram"><i class="fab fa-telegram"></i></a>
                                </div>
                            </div>
                            <div class="team-title p-4">
                                <h4 class="mb-0">{{ $m['name'] }}</h4>
                                <p class="mb-0">{{ $m['role'] }}</p>
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
                <h4 style="color: #1B361E">موقعیت ما روی نقشه</h4>
                <h1 class="display-4 mb-4">دفتر مرکزی امیر آفاق گستر پارس</h1>
                <p class="mb-0">
                    برای مشاهده مسیر دسترسی به دفتر مرکزی، مبدأ خود را وارد کنید
                    یا از دکمه «موقعیت من» استفاده کنید.
                </p>
            </div>

            <div class="row g-4 justify-content-center">
                <div class="col-lg-8 wow fadeInLeft" data-wow-delay="0.2s">
                    <div class="bg-white rounded p-3 h-100 shadow-sm">
                        <div id="map" style="width: 100%; height: 500px; border-radius: 8px;"></div>

                        <div class="d-flex justify-content-center gap-2 mt-3 flex-wrap">
                            <button type="button" id="btn-driving" class="btn btn-primary rounded-pill active" onclick="setTravelMode('DRIVING')">
                                <i class="fa fa-car me-1"></i> خودرو
                            </button>
                            <button type="button" id="btn-walking" class="btn btn-outline-primary rounded-pill" onclick="setTravelMode('WALKING')">
                                <i class="fa fa-walking me-1"></i> پیاده
                            </button>
                            <button type="button" id="btn-bicycling" class="btn btn-outline-primary rounded-pill" onclick="setTravelMode('BICYCLING')">
                                <i class="fa fa-bicycle me-1"></i> دوچرخه
                            </button>
                        </div>

                        <div id="route-summary" class="alert alert-success mt-3 mb-0 d-none">
                            <div class="d-flex justify-content-around text-center">
                                <div>
                                    <i class="fa fa-road text-primary fa-2x mb-2"></i>
                                    <div><strong>مسافت:</strong> <span id="route-distance">-</span></div>
                                </div>
                                <div>
                                    <i class="fa fa-clock text-primary fa-2x mb-2"></i>
                                    <div><strong>زمان:</strong> <span id="route-duration">-</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 wow fadeInRight" data-wow-delay="0.2s">
                    <div class="bg-white rounded p-4 h-100 shadow-sm">
                        <h5 class="mb-3 pb-2" style="color: #1B361E; border-bottom: 2px solid #1B361E;">
                            <i class="fa fa-route me-2"></i> مسیر دسترسی
                        </h5>

                        <div class="mb-3">
                            <label for="origin-input" class="form-label small text-muted">مبدأ</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="fa fa-map-marker-alt text-primary"></i></span>
                                <input type="text" id="origin-input" class="form-control" placeholder="آدرس مبدأ را وارد کنید" value="تهران">
                                <button type="button" class="btn btn-outline-primary" onclick="useMyLocation()" title="موقعیت من">
                                    <i class="fa fa-crosshairs"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="destination-input" class="form-label small text-muted">مقصد</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="fa fa-flag-checkered text-danger"></i></span>
                                <input type="text" id="destination-input" class="form-control"
                                       value="تهران، خیابان ولیعصر، برج تجاری کشاورزی" readonly>
                            </div>
                        </div>

                        <button type="button" class="btn btn-primary w-100 rounded-pill py-2 mb-4" onclick="calculateRoute()">
                            <i class="fa fa-search-location me-2"></i> نمایش مسیر
                        </button>

                        <div id="directions-text" style="max-height: 320px; overflow-y: auto; font-size: 13px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Map End -->

    <!-- Footer Start -->



@endsection

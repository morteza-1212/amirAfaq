<!DOCTYPE html>
<html
lang="{{app()->getLocale()}}"
dir="{{app()->getLocale() == 'en' ? 'ltr':'rtl'}}">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>{{__('home.title')}}</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

<style>

:root{
  --navy-950:#0A1B33;
  --navy-800:#122A4D;
  --navy-700:#1B3A66;
  --gold-600:#B8863C;
  --gold-500:#C99B54;
  --gold-100:#F1E4CB;
  --paper:#FCFBF9;
  --ink-900:#1A1E27;
  --ink-500:#616B79;
  --line:#E3E0D8;
}

*{box-sizing:border-box;}

body{
  font-family:'Vazirmatn', tahoma, sans-serif;
  background:var(--paper);
  color:var(--ink-900);
  line-height:1.9;
}

h1,h2,h3,h4,h5{
  font-weight:800;
  letter-spacing:-.01em;
}

a{ text-decoration:none; }

.container{ max-width:1200px; }

/* ===== Navbar ===== */

.navbar{
  background:var(--paper) !important;
  border-bottom:1px solid var(--line);
  padding-top:18px;
  padding-bottom:18px;
}

.brand-mark{
  display:flex;
  align-items:center;
  gap:10px;
}

.brand-mark .mark{
  width:38px;
  height:38px;
  border:1.5px solid var(--navy-950);
  border-radius:3px;
  display:flex;
  align-items:center;
  justify-content:center;
  font-weight:900;
  font-size:15px;
  color:var(--navy-950);
}

.brand-mark .name{
  font-size:19px;
  font-weight:800;
  color:var(--navy-950);
  line-height:1.2;
}

.brand-mark .name small{
  display:block;
  font-size:11px;
  font-weight:500;
  color:var(--gold-600);
  letter-spacing:.03em;
}

.navbar-nav .nav-link{
  color:var(--ink-900);
  font-weight:600;
  margin:0 14px;
  position:relative;
}

.navbar-nav .nav-link:hover{
  color:var(--navy-950);
}

.btn-navy{
  background:var(--navy-950);
  color:#fff;
  border:1px solid var(--navy-950);
  font-weight:700;
  padding:10px 26px;
  border-radius:3px;
  transition:.25s;
}

.btn-navy:hover{
  background:transparent;
  color:var(--navy-950);
}

.btn-gold{
  background:var(--gold-600);
  color:#fff;
  border:1px solid var(--gold-600);
  font-weight:700;
  padding:12px 32px;
  border-radius:3px;
  transition:.25s;
}

.btn-gold:hover{
  background:transparent;
  color:var(--gold-600);
}

.btn-line-light{
  border:1px solid rgba(255,255,255,.55);
  color:#fff;
  font-weight:600;
  padding:12px 32px;
  border-radius:3px;
  transition:.25s;
}

.btn-line-light:hover{
  background:rgba(255,255,255,.1);
  border-color:#fff;
  color:#fff;
}

/* ===== Hero ===== */

.hero{
  min-height:720px;
  background:
    linear-gradient(100deg, rgba(10,27,51,.94) 0%, rgba(10,27,51,.78) 45%, rgba(10,27,51,.45) 100%),
    url('/images/hero-export.jpg');
  background-size:cover;
  background-position:center;
  display:flex;
  align-items:center;
  color:#fff;
  position:relative;
}

.hero .eyebrow-mark{
  display:inline-flex;
  align-items:center;
  gap:10px;
  color:var(--gold-500);
  font-weight:600;
  font-size:15px;
  margin-bottom:22px;
}

.hero .eyebrow-mark::before{
  content:'';
  width:34px;
  height:1px;
  background:var(--gold-500);
}

.hero h1{
  font-size:54px;
  font-weight:900;
  line-height:1.35;
  max-width:760px;
}

.hero p{
  font-size:19px;
  line-height:2;
  color:rgba(255,255,255,.82);
  max-width:600px;
  margin-top:22px;
}

.hero-manifest{
  border-top:1px solid rgba(255,255,255,.18);
  margin-top:60px;
  padding-top:28px;
  display:flex;
  gap:56px;
  flex-wrap:wrap;
}

.hero-manifest .item .num{
  font-size:26px;
  font-weight:800;
  color:#fff;
}

.hero-manifest .item .lbl{
  font-size:14px;
  color:rgba(255,255,255,.65);
  margin-top:2px;
}

/* ===== Section basics ===== */

.section-tag{
  color:var(--gold-600);
  font-weight:700;
  font-size:14px;
  margin-bottom:12px;
  display:block;
}

.section-title{
  font-size:34px;
  font-weight:800;
  color:var(--navy-950);
  margin-bottom:22px;
}

.section-title.center{
  text-align:center;
  max-width:640px;
  margin-left:auto;
  margin-right:auto;
}

.lede{
  color:var(--ink-500);
  font-size:17px;
  max-width:620px;
}

.lede.center{
  margin-left:auto;
  margin-right:auto;
  text-align:center;
}

/* ===== About ===== */

.about-figure{
  position:relative;
}

.about-figure img{
  border:1px solid var(--line);
  width:100%;
}

.about-figure .frame{
  position:absolute;
  top:-16px;
  right:-16px;
  bottom:16px;
  left:16px;
  border:1.5px solid var(--gold-600);
  z-index:-1;
}

.ledger{
  border-top:1px solid var(--line);
  margin-top:34px;
}

.ledger .row-item{
  display:flex;
  align-items:baseline;
  justify-content:space-between;
  padding:20px 0;
  border-bottom:1px solid var(--line);
}

.ledger .row-item .figure{
  font-size:30px;
  font-weight:800;
  color:var(--navy-950);
}

.ledger .row-item .cap{
  color:var(--ink-500);
  font-size:15px;
}

/* ===== Services ===== */

.svc{
  border:1px solid var(--line);
  padding:40px 32px;
  height:100%;
  background:#fff;
  transition:.25s;
}

.svc:hover{
  border-color:var(--gold-600);
}

.svc .icon-holder{
  width:56px;
  height:56px;
  border:1.5px solid var(--navy-950);
  border-radius:3px;
  display:flex;
  align-items:center;
  justify-content:center;
  margin-bottom:26px;
}

.svc .icon-holder i{
  font-size:24px;
  color:var(--navy-950);
}

.svc h4{
  font-size:20px;
  margin-bottom:12px;
  color:var(--navy-950);
}

.svc p{
  color:var(--ink-500);
  font-size:15.5px;
  margin:0;
}

/* ===== Products ===== */

.product-card{
  border:1px solid var(--line);
  background:#fff;
  overflow:hidden;
}

.product-card .img-wrap{
  overflow:hidden;
  height:230px;
}

.product-card img{
  width:100%;
  height:100%;
  object-fit:cover;
  transition:.4s;
}

.product-card:hover img{
  transform:scale(1.06);
}

.product-card .body{
  padding:26px;
  border-top:1px solid var(--line);
}

.product-card h5{
  color:var(--navy-950);
  font-size:18px;
  margin-bottom:8px;
}

.product-card p{
  color:var(--ink-500);
  font-size:15px;
  margin:0;
}

/* ===== Trade lanes / markets ===== */

.lane-strip{
  position:relative;
  padding-top:40px;
}

.lane-strip::before{
  content:'';
  position:absolute;
  top:10px;
  right:0;
  left:0;
  height:1px;
  background:var(--line);
}

.lane-strip .lane{
  position:relative;
  text-align:center;
  padding-top:10px;
}

.lane-strip .lane::before{
  content:'';
  position:absolute;
  top:-4px;
  right:calc(50% - 4px);
  width:9px;
  height:9px;
  border-radius:50%;
  background:var(--gold-600);
  border:2px solid var(--paper);
}

.lane-strip .lane .name{
  font-weight:700;
  color:var(--navy-950);
  font-size:16px;
}

/* ===== Quality ===== */

.badge-box{
  border:1px solid var(--line);
  background:#fff;
  padding:30px 10px;
  text-align:center;
  height:100%;
}

.badge-box .tag{
  font-weight:800;
  font-size:18px;
  color:var(--navy-950);
  letter-spacing:.02em;
}

.badge-box .desc{
  color:var(--ink-500);
  font-size:13.5px;
  margin-top:6px;
}

/* ===== CTA ===== */

.cta{
  background:var(--navy-950);
  color:#fff;
  padding:90px 0;
  position:relative;
  border-top:3px solid var(--gold-600);
}

.cta h2{
  font-size:32px;
  color:#fff;
  margin-bottom:14px;
}

.cta p{
  color:rgba(255,255,255,.72);
  font-size:17px;
}

/* ===== Footer ===== */

footer{
  background:var(--navy-950);
  color:rgba(255,255,255,.7);
  padding:60px 0 24px;
  border-top:1px solid rgba(255,255,255,.08);
}

footer h6{
  color:#fff;
  font-weight:700;
  margin-bottom:18px;
  font-size:15px;
}

footer a{
  color:rgba(255,255,255,.65);
  display:block;
  margin-bottom:10px;
  font-size:14.5px;
}

footer a:hover{
  color:var(--gold-500);
}

.footer-bottom{
  border-top:1px solid rgba(255,255,255,.1);
  margin-top:40px;
  padding-top:22px;
  font-size:13.5px;
  color:rgba(255,255,255,.45);
  display:flex;
  justify-content:space-between;
  flex-wrap:wrap;
  gap:10px;
}

@media(max-width:768px){
  .hero h1{ font-size:36px; }
  .hero p{ font-size:16px; }
  .section-title{ font-size:26px; }
  .hero-manifest{ gap:30px; }
}

</style>

</head>

<body>

<!-- Header -->
<nav class="navbar navbar-expand-lg">
  <div class="container">

    <a class="navbar-brand brand-mark" href="#">
      <span class="mark">GT</span>
      <span class="name">Global Trade
        <small>بازرگانی و صادرات بین‌المللی</small>
      </span>
    </a>

    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="nav">

      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="#">{{__('home.home')}}</a></li>
        <li class="nav-item"><a class="nav-link" href="#products">{{__('home.products')}}</a></li>
        <li class="nav-item"><a class="nav-link" href="#services">{{__('home.services')}}</a></li>
        <li class="nav-item"><a class="nav-link" href="#about">{{__('home.about')}}</a></li>
        <li class="nav-item"><a class="nav-link" href="#contact">{{__('home.contact')}}</a></li>
      </ul>

      <a class="btn btn-navy" href="#contact">{{__('home.quote')}}</a>

    </div>

  </div>
</nav>


<!-- Hero -->
<section class="hero">
  <div class="container">
    <div class="row">
      <div class="col-lg-9">

        <span class="eyebrow-mark">شبکه‌ای فعال در بیش از ۱۵ کشور</span>

        <h1>تأمین، صادرات و واردات محصولات با استانداردهای بین‌المللی</h1>

        <p>
          ما پل ارتباطی میان تولیدکنندگان ایرانی و بازارهای جهانی هستیم؛
          از تأمین محصولات کشاورزی و مواد غذایی تا مدیریت کامل فرآیند
          گمرکی، حمل و ترخیص کالا.
        </p>

        <div class="mt-5 d-flex gap-3 flex-wrap">
          <a class="btn btn-gold" href="#products">مشاهده محصولات</a>
          <a class="btn btn-line-light" href="#contact">درخواست همکاری</a>
        </div>

        <div class="hero-manifest">
          <div class="item">
            <div class="num">۱۵+</div>
            <div class="lbl">کشور مقصد</div>
          </div>
          <div class="item">
            <div class="num">۱۰۰+</div>
            <div class="lbl">محصول قابل تأمین</div>
          </div>
          <div class="item">
            <div class="num">ISO / HACCP</div>
            <div class="lbl">گواهی‌نامه‌های معتبر</div>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>


<!-- About -->
<section class="py-5" id="about" style="padding-top:110px !important; padding-bottom:110px !important;">
  <div class="container">
    <div class="row align-items-center g-5">

      <div class="col-lg-6">
        <div class="about-figure">
          <img src="/images/company.jpg" alt="درباره شرکت">
          <div class="frame"></div>
        </div>
      </div>

      <div class="col-lg-6">

        <span class="section-tag">درباره ما</span>
        <h2 class="section-title">شریک قابل اعتماد شما در تجارت جهانی</h2>

        <p class="lede">
          با ایجاد شبکه‌ای از تولیدکنندگان، تأمین‌کنندگان و شرکای حمل و نقل،
          محصولات باکیفیت را به بازارهای هدف صادر و نیازهای وارداتی مشتریان
          را با دقت و شفافیت تأمین می‌کنیم. هر سفارش از تأمین تا تحویل نهایی
          توسط یک تیم پیگیری می‌شود.
        </p>

        <div class="ledger">
          <div class="row-item">
            <span class="cap">کشورهای مقصد فعال در شبکه صادراتی</span>
            <span class="figure">۱۵+</span>
          </div>
          <div class="row-item">
            <span class="cap">دسته‌بندی محصول قابل تأمین و صادرات</span>
            <span class="figure">۱۰۰+</span>
          </div>
          <div class="row-item">
            <span class="cap">سال سابقه فعالیت در تجارت بین‌الملل</span>
            <span class="figure">۱۲</span>
          </div>
        </div>

      </div>

    </div>
  </div>
</section>


<!-- Services -->
<section class="py-5" id="services" style="background:#fff; padding-top:110px !important; padding-bottom:110px !important; border-top:1px solid var(--line); border-bottom:1px solid var(--line);">
  <div class="container">

    <span class="section-tag d-block text-center">خدمات ما</span>
    <h2 class="section-title center">از تأمین کالا تا تحویل در مقصد</h2>
    <p class="lede center mb-5">
      مدیریت یکپارچه فرآیند تجارت بین‌الملل، برای کاهش ریسک و زمان معامله شما.
    </p>

    <div class="row g-4 mt-3">

      <div class="col-md-4">
        <div class="svc">
          <div class="icon-holder"><i class="bi bi-globe2"></i></div>
          <h4>صادرات بین‌المللی</h4>
          <p>مدیریت کامل فرآیند صادرات کالا، از اسناد تجاری تا تشریفات گمرکی مبدأ و مقصد.</p>
        </div>
      </div>

      <div class="col-md-4">
        <div class="svc">
          <div class="icon-holder"><i class="bi bi-box-seam"></i></div>
          <h4>تأمین محصولات</h4>
          <p>تأمین مستقیم از تولیدکنندگان معتبر با کنترل کیفیت در تمام مراحل بسته‌بندی و بارگیری.</p>
        </div>
      </div>

      <div class="col-md-4">
        <div class="svc">
          <div class="icon-holder"><i class="bi bi-truck"></i></div>
          <h4>حمل و لجستیک</h4>
          <p>مدیریت حمل زمینی، دریایی و هوایی همراه با پیگیری لحظه‌ای وضعیت محموله.</p>
        </div>
      </div>

    </div>

  </div>
</section>


<!-- Products -->
<section class="py-5" id="products" style="padding-top:110px !important; padding-bottom:110px !important;">
  <div class="container">

    <span class="section-tag d-block text-center">محصولات</span>
    <h2 class="section-title center">محصولات اصلی</h2>
    <p class="lede center mb-5">
      منتخبی از دسته‌بندی‌های اصلی قابل تأمین و صادرات.
    </p>

    <div class="row g-4 mt-3">

      @foreach($products ?? [] as $product)

      <div class="col-md-4">
        <div class="product-card">
          <div class="img-wrap">
            <img src="{{asset($product->image)}}" alt="{{$product->name}}">
          </div>
          <div class="body">
            <h5>{{$product->name}}</h5>
            <p>{{$product->short_description}}</p>
          </div>
        </div>
      </div>

      @endforeach

    </div>

  </div>
</section>


<!-- Markets -->
<section class="py-5" style="background:#fff; padding-top:110px !important; padding-bottom:110px !important; border-top:1px solid var(--line); border-bottom:1px solid var(--line);">
  <div class="container">

    <span class="section-tag d-block text-center">بازارهای صادراتی</span>
    <h2 class="section-title center">حضور فعال در بازارهای جهانی</h2>

    <div class="row lane-strip mt-5">

      @foreach([
        'اروپا',
        'خاورمیانه',
        'آسیای مرکزی',
        'آفریقا',
        'کشورهای CIS'
      ] as $market)

      <div class="col-6 col-md-2 lane">
        <div class="name">{{$market}}</div>
      </div>

      @endforeach

    </div>

  </div>
</section>


<!-- Quality -->
<section class="py-5" style="padding-top:110px !important; padding-bottom:110px !important;">
  <div class="container">

    <span class="section-tag d-block text-center">کیفیت و اعتماد</span>
    <h2 class="section-title center">استانداردها و گواهی‌نامه‌ها</h2>

    <div class="row g-3 mt-4">

      <div class="col-6 col-md-3">
        <div class="badge-box">
          <div class="tag">ISO</div>
          <div class="desc">سامانه مدیریت کیفیت</div>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="badge-box">
          <div class="tag">HACCP</div>
          <div class="desc">کنترل ایمنی مواد غذایی</div>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="badge-box">
          <div class="tag">GLOBAL G.A.P</div>
          <div class="desc">استاندارد تولید محصول کشاورزی</div>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="badge-box">
          <div class="tag">Halal</div>
          <div class="desc">گواهی مطابقت شرعی</div>
        </div>
      </div>

    </div>

  </div>
</section>


<!-- CTA -->
<section class="cta" id="contact">
  <div class="container text-center">
    <h2>برای همکاری تجاری آماده‌ایم</h2>
    <p>کاتالوگ محصولات و شرایط همکاری را همین امروز دریافت کنید.</p>
    <a class="btn btn-gold mt-4" href="#">درخواست کاتالوگ و استعلام قیمت</a>
  </div>
</section>


<footer>
  <div class="container">
    <div class="row g-4">

      <div class="col-md-4">
        <div class="brand-mark mb-3">
          <span class="mark" style="border-color:#fff; color:#fff;">GT</span>
          <span class="name" style="color:#fff;">Global Trade
            <small style="color:var(--gold-500);">بازرگانی و صادرات بین‌المللی</small>
          </span>
        </div>
        <p style="color:rgba(255,255,255,.55); font-size:14.5px;">
          صادرات و واردات محصولات کشاورزی، مواد غذایی و محصولات کارخانه‌ای
          با استانداردهای بین‌المللی.
        </p>
      </div>

      <div class="col-md-4">
        <h6>دسترسی سریع</h6>
        <a href="#">{{__('home.home')}}</a>
        <a href="#products">{{__('home.products')}}</a>
        <a href="#services">{{__('home.services')}}</a>
        <a href="#about">{{__('home.about')}}</a>
      </div>

      <div class="col-md-4">
        <h6>اطلاعات تماس</h6>
        <a href="#"><i class="bi bi-telephone ms-1"></i> شماره تماس شرکت</a>
        <a href="#"><i class="bi bi-envelope ms-1"></i> آدرس ایمیل شرکت</a>
        <a href="#"><i class="bi bi-geo-alt ms-1"></i> آدرس دفتر مرکزی</a>
      </div>

    </div>

    <div class="footer-bottom">
      <span>© {{date('Y')}} Global Trade Company</span>
      <span>طراحی و توسعه با Laravel</span>
    </div>

  </div>
</footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
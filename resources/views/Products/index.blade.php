@extends('layouts.home')

@section('title', 'لیست محصولات')

@section('styles')
    <style>
        /* ========== اسکرول‌بار سفارشی ========== */
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        /* ========== انیمیشن ورود کارت‌ها ========== */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .product-card {
            animation: fadeInUp 0.45s ease-out backwards;
            will-change: transform, opacity;
        }

        /* ========== خط‌خوردگی ========== */
        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* ========== سایه نرم ========== */
        .soft-shadow {
            box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 1px 2px rgba(0,0,0,0.06);
        }
        .soft-shadow-hover {
            transition: box-shadow 0.3s ease, transform 0.3s ease;
        }
        .soft-shadow-hover:hover {
            box-shadow: 0 20px 30px -10px rgba(0,0,0,0.12), 0 10px 15px -5px rgba(0,0,0,0.05);
            transform: translateY(-2px);
        }

        /* ========== ابعاد تصویر محصول ========== */
        .product-image-wrapper {
            aspect-ratio: 1 / 1;
            position: relative;
            overflow: hidden;
            background-color: #f3f4f6;
            display: block;
        }
        .product-image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }
        .product-card:hover .product-image-wrapper img {
            transform: scale(1.08);
        }

        /* ========== Badge ناموجود ========== */
        .out-of-stock-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.65), rgba(0,0,0,0.35));
            backdrop-filter: blur(2px);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* ========== بدنه صفحه ========== */
        .products-page {
            min-height: 100vh;
            background: linear-gradient(to bottom, #f9fafb, #ffffff);
        }

        /* ========== استایل کارت محصول ========== */
        .product-card {
            display: flex;
            flex-direction: column;
            background: #fff;
            border-radius: 0.75rem;
            overflow: hidden;
            position: relative;
            color: inherit;
            text-decoration: none;
            height: 100%;
        }
        .product-card:hover { color: inherit; text-decoration: none; }
        .product-card .product-image-link {
            display: block;
            color: inherit;
            text-decoration: none;
        }

        /* ========== Badge مخصوص ========== */
        .badge-discount {
            position: absolute;
            top: 0.375rem;
            right: 0.375rem;
            z-index: 10;
            background: linear-gradient(to left, #ef4444, #dc2626);
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            padding: 0.125rem 0.625rem;
            border-radius: 9999px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
        }
        .badge-featured {
            position: absolute;
            top: 0.375rem;
            left: 0.375rem;
            z-index: 10;
            background: #facc15;
            color: #713f12;
            font-size: 10px;
            font-weight: 700;
            padding: 0.125rem 0.5rem;
            border-radius: 9999px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }
        .badge-stock {
            font-size: 9px;
            color: #ea580c;
            font-weight: 700;
            background: #fff7ed;
            padding: 0.125rem 0.375rem;
            border-radius: 0.25rem;
            flex-shrink: 0;
        }

        @media (min-width: 640px) {
            .badge-discount { font-size: 12px; padding: 0.25rem 0.625rem; top: 0.5rem; right: 0.5rem; }
            .badge-featured { font-size: 12px; padding: 0.25rem 0.5rem; top: 0.5rem; left: 0.5rem; }
            .badge-stock    { font-size: 10px; }
        }

        /* ========== دکمه محصولات ویژه ========== */
        .btn-featured {
            background: linear-gradient(to left, #facc15, #fb923c);
            color: #fff;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s ease;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }
        .btn-featured:hover {
            background: linear-gradient(to left, #eab308, #f97316);
            color: #fff;
        }

        /* ========== نوار مرتب‌سازی ========== */
        .sort-bar {
            background: #fff;
            border-radius: 0.75rem;
            padding: 0.75rem;
            margin-bottom: 1rem;
        }

        /* ========== انتخاب‌گر مرتب‌سازی ========== */
        .sort-select {
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            background: #fff;
            cursor: pointer;
            outline: none;
        }
        .sort-select:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59,130,246,0.15);
        }

        /* ========== نوار کناری ========== */
        .sidebar-sticky {
            position: sticky;
            top: 5rem;
            max-height: calc(100vh - 6rem);
            overflow-y: auto;
            padding-right: 0.25rem;
        }

        /* ========== هدر صفحه ========== */
        .page-header {
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
        }

        /* ========== اسکلت خالی ========== */
        .empty-state {
            background: #fff;
            border-radius: 0.75rem;
            padding: 2rem 1rem;
            text-align: center;
        }
        .empty-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 4rem;
            height: 4rem;
            border-radius: 50%;
            background: #f3f4f6;
            margin-bottom: 1rem;
        }

        @media (min-width: 640px) {
            .empty-state { padding: 3rem; }
            .empty-icon  { width: 5rem; height: 5rem; }
        }

        /* ========== Pagination ========== */
        .pagination-wrapper .pagination {
            justify-content: center;
            flex-wrap: wrap;
        }

        /* ========== Grid محصولات ========== */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.625rem;
        }

        @media (min-width: 640px) {
            .products-grid { gap: 0.75rem; }
        }
        @media (min-width: 992px) {
            .products-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 1rem; }
        }
        @media (min-width: 1400px) {
            .products-grid { grid-template-columns: repeat(4, minmax(0, 1fr)); }
        }

        /* ========== متن برند و نام محصول ========== */
        .product-brand {
            font-size: 10px;
            color: #9ca3af;
            margin-bottom: 0.125rem;
        }
        .product-name {
            font-size: 0.75rem;
            font-weight: 500;
            color: #111827;
            min-height: 2.25rem;
            margin-bottom: 0.375rem;
            transition: color 0.2s ease;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .product-card:hover .product-name {
            color: #2563eb;
        }

        @media (min-width: 640px) {
            .product-brand { font-size: 12px; }
            .product-name  { font-size: 0.875rem; min-height: 2.5rem; margin-bottom: 0.5rem; }
        }

        /* ========== قیمت ========== */
        .price-compare {
            font-size: 10px;
            color: #9ca3af;
            text-decoration: line-through;
        }
        .price-main {
            font-weight: 700;
            color: #111827;
            font-size: 0.75rem;
        }
        .price-currency {
            font-size: 10px;
            font-weight: 400;
            color: #6b7280;
        }
        @media (min-width: 640px) {
            .price-compare { font-size: 12px; }
            .price-main    { font-size: 0.875rem; }
            .price-currency{ font-size: 12px; }
        }
        @media (min-width: 768px) {
            .price-main    { font-size: 1rem; }
        }

        /* ========== باکس اطلاعات ========== */
        .product-card-info {
            padding: 0.625rem;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            justify-content: space-between;
        }
        @media (min-width: 640px) {
            .product-card-info { padding: 0.75rem; }
        }

        /* ========== دکمه افزودن به سبد خرید ========== */
        .btn-add-cart {
            width: 100%;
            margin-top: 0.5rem;
            background: #2563eb;
            color: #fff;
            border: none;
            border-radius: 0.5rem;
            padding: 0.4rem 0.5rem;
            font-size: 11px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.3rem;
            transition: background-color 0.2s ease, transform 0.1s ease;
            cursor: pointer;
        }
        .btn-add-cart:hover {
            background: #1d4ed8;
            color: #fff;
        }
        .btn-add-cart:active {
            transform: scale(0.97);
        }
        .btn-add-cart:disabled {
            background: #9ca3af;
            cursor: not-allowed;
            opacity: 0.7;
        }
        .btn-add-cart.loading {
            pointer-events: none;
            opacity: 0.8;
        }
        .btn-add-cart .cart-icon {
            width: 14px;
            height: 14px;
            flex-shrink: 0;
        }

        @media (min-width: 640px) {
            .btn-add-cart {
                font-size: 12px;
                padding: 0.5rem 0.75rem;
                margin-top: 0.625rem;
            }
            .btn-add-cart .cart-icon { width: 16px; height: 16px; }
        }
        @media (min-width: 768px) {
            .btn-add-cart { font-size: 13px; }
        }

        /* ========== فیلترها ========== */
        .filter-card {
            background: #fff;
            border-radius: 0.75rem;
            padding: 1rem;
            margin-bottom: 0.75rem;
        }
        .filter-card-title {
            font-size: 0.875rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
            user-select: none;
        }
        .filter-card-title .chevron {
            transition: transform 0.2s ease;
            color: #9ca3af;
        }
        .filter-card.collapsed .chevron {
            transform: rotate(-90deg);
        }
        .filter-card.collapsed .filter-card-body {
            display: none;
        }
        .filter-option {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.375rem 0.5rem;
            border-radius: 0.375rem;
            font-size: 0.8125rem;
            color: #374151;
            cursor: pointer;
            transition: background-color 0.15s ease;
        }
        .filter-option:hover { background-color: #f8fafc; }
        .filter-option input { accent-color: #2563eb; cursor: pointer; }
        .filter-option label { cursor: pointer; margin: 0; flex-grow: 1; }

        .filter-input {
            width: 100%;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 0.5rem 0.75rem;
            font-size: 0.8125rem;
            outline: none;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }
        .filter-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59,130,246,0.15);
        }

        .filter-btn-apply {
            width: 100%;
            background: #2563eb;
            color: #fff;
            border: none;
            border-radius: 0.5rem;
            padding: 0.6rem;
            font-size: 0.875rem;
            font-weight: 600;
            transition: background-color 0.2s ease;
            margin-top: 0.5rem;
        }
        .filter-btn-apply:hover { background: #1d4ed8; color: #fff; }

        .filter-btn-reset {
            width: 100%;
            background: #fff;
            color: #6b7280;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 0.5rem;
            font-size: 0.8125rem;
            font-weight: 500;
            transition: background-color 0.2s ease;
            margin-top: 0.5rem;
        }
        .filter-btn-reset:hover { background: #f9fafb; color: #374151; }

        .price-range-inputs {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }
        .price-range-inputs .filter-input { flex: 1; min-width: 0; }

        /* ========== Offcanvas فیلتر موبایل ========== */
        .offcanvas-filters {
            --bs-offcanvas-width: 320px;
        }
        @media (max-width: 380px) {
            .offcanvas-filters { --bs-offcanvas-width: 90vw; }
        }

        /* ========== Toast نوتیفیکیشن ========== */
        .toast-container {
            position: fixed;
            bottom: 1rem;
            left: 1rem;
            right: 1rem;
            z-index: 1090;
            pointer-events: none;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            align-items: flex-end;
        }
        @media (min-width: 576px) {
            .toast-container { left: auto; right: 1rem; }
        }
        .cart-toast {
            pointer-events: auto;
            background: #fff;
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            min-width: 220px;
            max-width: 340px;
            border-right: 4px solid #10b981;
            animation: slideInRight 0.3s ease-out;
        }
        .cart-toast.error { border-right-color: #ef4444; }
        .cart-toast.success { border-right-color: #10b981; }
        .cart-toast.hide { animation: slideOutRight 0.3s ease-in forwards; }

        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to   { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideOutRight {
            from { transform: translateX(0); opacity: 1; }
            to   { transform: translateX(100%); opacity: 0; }
        }

        /* ========== Spinner دکمه ========== */
        .spinner-btn {
            display: inline-block;
            width: 12px;
            height: 12px;
            border: 2px solid rgba(255,255,255,0.4);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* ========== دکمه فیلتر (موبایل) ========== */
        .filter-toggle-btn {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
            padding: 0.625rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            transition: background-color 0.2s ease;
        }
        .filter-toggle-btn:active { background: #f1f5f9; }
        .filter-badge-count {
            background: #2563eb;
            color: #fff;
            border-radius: 9999px;
            font-size: 11px;
            padding: 0.05rem 0.4rem;
            font-weight: 700;
        }

        /* ========== Focus ring ========== */
        .focus-ring:focus {
            outline: 2px solid #3b82f6;
            outline-offset: 2px;
        }

        /* ============================================================
           دکمه شناور سبد خرید (Floating Cart Button)
           ============================================================ */
        .floating-cart-btn {
            position: fixed;
            bottom: 1.25rem;
            left: 1.25rem;
            z-index: 1050;
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: #fff;
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 25px -5px rgba(37, 99, 235, 0.5),
            0 8px 10px -6px rgba(37, 99, 235, 0.3);
            cursor: pointer;
            transition: transform 0.25s ease, box-shadow 0.25s ease, background 0.25s ease;
            text-decoration: none;
            animation: floatIn 0.5s ease-out;
        }
        .floating-cart-btn:hover {
            color: #fff;
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 15px 30px -5px rgba(37, 99, 235, 0.6),
            0 10px 15px -6px rgba(37, 99, 235, 0.4);
        }
        .floating-cart-btn:active {
            transform: translateY(-1px) scale(1.02);
        }
        .floating-cart-btn svg {
            width: 26px;
            height: 26px;
            stroke: #fff;
        }

        /* Badge تعداد اقلام */
        .floating-cart-btn .cart-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            min-width: 22px;
            height: 22px;
            padding: 0 6px;
            background: #ef4444;
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            border-radius: 9999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #fff;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
            line-height: 1;
        }
        .floating-cart-btn .cart-badge.hidden {
            display: none;
        }

        /* Tooltip (متن راهنما) */
        .floating-cart-btn .cart-tooltip {
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%) translateX(8px);
            background: #111827;
            color: #fff;
            font-size: 12px;
            padding: 4px 10px;
            border-radius: 6px;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s ease, transform 0.2s ease;
        }
        .floating-cart-btn .cart-tooltip::before {
            content: '';
            position: absolute;
            right: 100%;
            top: 50%;
            transform: translateY(-50%);
            border: 5px solid transparent;
            border-left: none;
            border-right-color: #111827;
        }
        .floating-cart-btn:hover .cart-tooltip {
            opacity: 1;
            transform: translateY(-50%) translateX(4px);
        }

        /* انیمیشن ورود */
        @keyframes floatIn {
            from { opacity: 0; transform: translateY(20px) scale(0.8); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* انیمیشن bounce هنگام افزودن محصول */
        @keyframes cartBounce {
            0%, 100% { transform: scale(1); }
            30%      { transform: scale(1.2); }
            60%      { transform: scale(0.95); }
        }
        .floating-cart-btn.bounce {
            animation: cartBounce 0.5s ease-out;
        }

        /* در موبایل کوچک، اندازه کمی کوچک‌تر */
        @media (max-width: 380px) {
            .floating-cart-btn {
                width: 50px;
                height: 50px;
                bottom: 1rem;
                left: 1rem;
            }
            .floating-cart-btn svg { width: 22px; height: 22px; }
        }

        /* در دسکتاپ کمی بالاتر از پایین */
        @media (min-width: 992px) {
            .floating-cart-btn {
                bottom: 1.5rem;
                left: 1.5rem;
                width: 60px;
                height: 60px;
            }
            .floating-cart-btn svg { width: 28px; height: 28px; }
        }
    </style>
@endsection

@section('content')
    <div class="products-page">

        {{-- ============ Header صفحه ============ --}}
        <div class="page-header">
            <div class="container-xl py-3 py-sm-4">
                {{-- Breadcrumb --}}
                <nav class="text-muted small mb-2 d-flex align-items-center flex-wrap gap-1" aria-label="breadcrumb">
                    <a href="{{ url('/') }}" class="text-decoration-none text-muted">خانه</a>
                    <span class="text-secondary">/</span>
                    <a href="{{ route('products.index', ['locale' => app()->getLocale()]) }}"
                       class="text-decoration-none text-muted">محصولات</a>
                </nav>

                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
                    <div class="min-w-0">
                        <h1 class="h4 fw-bold text-dark mb-1 text-truncate">محصولات</h1>
                        <p class="text-muted small mb-0">
                            <span class="fw-bold text-primary">{{ number_format($products->total()) }}</span>
                            محصول یافت شد
                        </p>
                    </div>
                    <a href="{{ route('products.featured', ['locale' => app()->getLocale()]) }}"
                       class="btn btn-featured d-inline-flex align-items-center justify-content-center gap-2 flex-shrink-0 focus-ring">
                        ⭐ محصولات ویژه
                    </a>
                </div>
            </div>
        </div>

        {{-- ============ محتوای اصلی ============ --}}
        <div class="container-xl py-3 py-sm-4">

            {{-- ============ دکمه فیلتر موبایل ============ --}}
            <div class="d-lg-none mb-3">
                <button type="button"
                        class="filter-toggle-btn focus-ring"
                        data-bs-toggle="offcanvas"
                        data-bs-target="#mobileFiltersOffcanvas"
                        aria-controls="mobileFiltersOffcanvas">
                    <span class="d-flex align-items-center gap-2">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        <span>فیلترها</span>
                        @if(request()->hasAny(['q','category_id','brand','min_price','max_price','in_stock','is_featured']))
                            <span class="filter-badge-count">
                                {{ collect(['q','category_id','brand','min_price','max_price','in_stock','is_featured'])->filter(fn($k) => request()->filled($k))->count() }}
                            </span>
                        @endif
                    </span>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>

            <div class="row g-3 g-lg-4">

                {{-- ============ Sidebar فیلترها (دسکتاپ) ============ --}}
                <aside class="col-lg-3 d-none d-lg-block">
                    <div class="sidebar-sticky custom-scrollbar">
                        @include('Products.partials.filters', ['isMobile' => false])
                    </div>
                </aside>

                {{-- ============ Main محصولات ============ --}}
                <div class="col-lg-9 min-w-0">

                    {{-- نوار مرتب‌سازی --}}
                    <div class="sort-bar soft-shadow d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 gap-sm-3">
                        <div class="text-muted small text-center text-sm-end">
                            @if($products->total() > 0)
                                نمایش
                                <span class="fw-bold text-dark">{{ $products->firstItem() }}</span>
                                تا
                                <span class="fw-bold text-dark">{{ $products->lastItem() }}</span>
                                از
                                <span class="fw-bold text-dark">{{ number_format($products->total()) }}</span>
                                محصول
                            @else
                                هیچ محصولی یافت نشد
                            @endif
                        </div>

                        <div class="d-flex align-items-center justify-content-between justify-content-sm-end gap-2">
                            <label class="text-muted small text-nowrap mb-0" for="sortSelect">مرتب‌سازی:</label>
                            <select id="sortSelect" class="sort-select flex-grow-1 flex-sm-grow-0">
                                <option value="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}"
                                    @selected(request('sort', 'newest') === 'newest')>جدیدترین</option>
                                <option value="{{ request()->fullUrlWithQuery(['sort' => 'oldest']) }}"
                                    @selected(request('sort') === 'oldest')>قدیمی‌ترین</option>
                                <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}"
                                    @selected(request('sort') === 'price_asc')>ارزان‌ترین</option>
                                <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}"
                                    @selected(request('sort') === 'price_desc')>گران‌ترین</option>
                                <option value="{{ request()->fullUrlWithQuery(['sort' => 'popular']) }}"
                                    @selected(request('sort') === 'popular')>محبوب‌ترین</option>
                            </select>
                        </div>
                    </div>

                    {{-- ============ محصولات ============ --}}
                    @if($products->isEmpty())
                        <div class="empty-state soft-shadow">
                            <div class="empty-icon">
                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <h3 class="h5 fw-bold text-dark mb-2">محصولی یافت نشد</h3>
                            <p class="text-muted small mb-4">
                                با تغییر فیلترها یا جستجو، دوباره امتحان کنید.
                            </p>
                            <a href="{{ route('products.index', ['locale' => app()->getLocale()]) }}"
                               class="btn btn-primary btn-sm focus-ring">
                                نمایش همه محصولات
                            </a>
                        </div>
                    @else
                        <div class="products-grid">
                            @foreach($products as $index => $product)
                                <div class="product-card soft-shadow soft-shadow-hover"
                                     style="animation-delay: {{ min($index * 40, 400) }}ms">

                                    {{-- لینک تصویر و نام به صفحه محصول --}}
                                    <a href="{{ route('products.show', ['locale' => app()->getLocale(), 'slug' => $product->slug]) }}"
                                       class="product-image-link">

                                        {{-- Badge تخفیف --}}
                                        @if($product->discountPercent())
                                            <span class="badge-discount">{{ $product->discountPercent() }}٪</span>
                                        @endif

                                        {{-- Badge ویژه --}}
                                        @if($product->is_featured)
                                            <span class="badge-featured" title="محصول ویژه">⭐</span>
                                        @endif

                                        {{-- تصویر --}}
                                        <div class="product-image-wrapper">
                                            <img src="{{ $product->image_url ?? 'https://placehold.co/400x400?text=No+Image' }}"
                                                 alt="{{ $product->name }}"
                                                 loading="lazy">

                                            @if($product->isOutOfStock())
                                                <div class="out-of-stock-overlay">
                                                    <span class="bg-white text-danger fw-bold px-2 py-1 rounded-pill small shadow">
                                                        ناموجود
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                    </a>

                                    {{-- اطلاعات محصول --}}
                                    <div class="product-card-info">
                                        <a href="{{ route('products.show', ['locale' => app()->getLocale(), 'slug' => $product->slug]) }}"
                                           class="text-decoration-none text-reset flex-grow-0">
                                            {{-- برند --}}
                                            @if($product->brand)
                                                <p class="product-brand line-clamp-1 mb-0">{{ $product->brand }}</p>
                                            @endif

                                            {{-- نام --}}
                                            <h3 class="product-name">{{ $product->name }}</h3>
                                        </a>

                                        {{-- قیمت --}}
                                        <div class="d-flex align-items-end justify-content-between gap-1 mb-1">
                                            <div class="flex-grow-1 min-w-0">
                                                @if($product->compare_price && $product->compare_price > $product->price)
                                                    <div class="price-compare text-truncate">
                                                        {{ number_format($product->compare_price) }}
                                                    </div>
                                                @endif
                                                <div class="price-main text-truncate">
                                                    {{ number_format($product->price) }}
                                                    <span class="price-currency">تومان</span>
                                                </div>
                                            </div>

                                            @if($product->isLowStock() && !$product->isOutOfStock())
                                                <span class="badge-stock" title="موجودی محدود">
                                                    {{ $product->stock_quantity }}
                                                </span>
                                            @endif
                                        </div>

                                        {{-- دکمه افزودن به سبد خرید --}}
                                        <button type="button"
                                                class="btn-add-cart"
                                                data-product-id="{{ $product->id }}"
                                                data-add-to-cart-url="{{ route('cart.add', ['locale' => app()->getLocale(), 'product' => $product->id]) }}"
                                                @if($product->isOutOfStock()) disabled @endif>
                                            @if($product->isOutOfStock())
                                                <svg class="cart-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                                <span>ناموجود</span>
                                            @else
                                                <svg class="cart-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                </svg>
                                                <span>افزودن به سبد</span>
                                            @endif
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- صفحه‌بندی --}}
                        <div class="mt-4 mt-sm-5 pagination-wrapper">
                            {{ $products->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- ============ Offcanvas فیلتر موبایل ============ --}}
    <div class="offcanvas offcanvas-start offcanvas-filters" tabindex="-1"
         id="mobileFiltersOffcanvas" aria-labelledby="mobileFiltersOffcanvasLabel">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title fw-bold" id="mobileFiltersOffcanvasLabel">فیلترها</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="بستن"></button>
        </div>
        <div class="offcanvas-body custom-scrollbar">
            @include('Products.partials.filters', ['isMobile' => true])
        </div>
    </div>

    {{-- ============ دکمه شناور سبد خرید ============ --}}
    <a href="{{ route('cart.show', ['locale' => app()->getLocale()]) }}"
       class="floating-cart-btn"
       id="floatingCartBtn"
       aria-label="مشاهده سبد خرید"
       title="مشاهده سبد خرید" style="margin-bottom: 5%">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
             stroke-linecap="round" stroke-linejoin="round">
            <circle cx="9" cy="21" r="1"></circle>
            <circle cx="20" cy="21" r="1"></circle>
            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
        </svg>
        <span class="cart-badge {{ ($cartCount ?? session('cart_count', 0)) > 0 ? '' : 'hidden' }}"
              id="floatingCartCount">{{ $cartCount ?? session('cart_count', 0) }}</span>
        <span class="cart-tooltip">سبد خرید</span>
    </a>

    {{-- ============ Toast Container ============ --}}
    <div class="toast-container" id="toastContainer"></div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // ============ مرتب‌سازی ============
            const sortSelect = document.getElementById('sortSelect');
            if (sortSelect) {
                sortSelect.addEventListener('change', function () {
                    window.location = this.value;
                });
            }

            // ============ باز/بستن کارت‌های فیلتر ============
            document.querySelectorAll('.filter-card-title[data-toggle-collapse]').forEach(function (title) {
                title.addEventListener('click', function () {
                    const card = this.closest('.filter-card');
                    if (card) card.classList.toggle('collapsed');
                });
            });

            // ============ دکمه افزودن به سبد خرید (AJAX) ============
            document.querySelectorAll('.btn-add-cart').forEach(function (btn) {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();

                    if (btn.disabled || btn.classList.contains('loading')) return;

                    const url       = btn.dataset.addToCartUrl;
                    const productId = btn.dataset.productId;
                    const original  = btn.innerHTML;
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content
                        || '{{ csrf_token() }}';

                    // ✅ بررسی وجود productId
                    if (!productId) {
                        showToast('شناسه محصول یافت نشد.', 'error');
                        return;
                    }

                    btn.classList.add('loading');
                    btn.innerHTML = '<span class="spinner-btn"></span><span>در حال افزودن...</span>';

                    fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                        },
                        // ✅ ارسال product_id که کنترلر الزامی می‌داند
                        body: JSON.stringify({ product_id: productId, quantity: 1 }),
                    })
                        .then(async function (res) {
                            const data = await res.json().catch(function () { return {}; });

                            if (!res.ok) {
                                // ✅ پیام خطای واقعی از سرور (شامل خطاهای اعتبارسنجی 422)
                                const validationMsg = data.errors
                                    ? Object.values(data.errors).flat()[0]
                                    : null;
                                const msg = data.message
                                    || validationMsg
                                    || ('خطا: HTTP ' + res.status);
                                throw new Error(msg);
                            }

                            return data;
                        })
                        .then(function (data) {
                            showToast(data.message || 'محصول به سبد خرید اضافه شد', 'success');
                            // ✅ کنترلر items_count برمی‌گرداند نه cart_count
                            updateCartCount(data.items_count ?? data.cart_count);

                            btn.innerHTML = '<svg class="cart-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg><span>اضافه شد</span>';
                            setTimeout(function () {
                                btn.classList.remove('loading');
                                btn.innerHTML = original;
                            }, 1500);
                        })
                        .catch(function (err) {
                            console.error('Cart add error:', err);
                            // ✅ نمایش پیام خطای واقعی به کاربر
                            showToast(err.message || 'خطا در افزودن به سبد خرید. لطفاً دوباره تلاش کنید.', 'error');
                            btn.classList.remove('loading');
                            btn.innerHTML = original;
                        });
                });
            });

            // ============ Toast ============
            function showToast(message, type) {
                const container = document.getElementById('toastContainer');
                if (!container) return;

                const toast = document.createElement('div');
                toast.className = 'cart-toast ' + (type || 'success');

                const icon = type === 'error'
                    ? '<svg width="20" height="20" fill="none" stroke="#ef4444" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'
                    : '<svg width="20" height="20" fill="none" stroke="#10b981" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>';

                // ✅ ساخت امن DOM به‌جای innerHTML برای پیام (جلوگیری از XSS)
                const span = document.createElement('span');
                span.className = 'flex-grow-1';
                span.textContent = message;

                toast.innerHTML = icon;
                toast.appendChild(span);
                container.appendChild(toast);

                setTimeout(function () {
                    toast.classList.add('hide');
                    setTimeout(function () { toast.remove(); }, 300);
                }, 3500);
            }

            // ============ به‌روزرسانی تعداد سبد خرید ============
            function updateCartCount(count) {
                if (count === undefined || count === null) return;

                count = parseInt(count, 10) || 0;

                // آپدیت همه المان‌های دارای data-cart-count
                document.querySelectorAll('[data-cart-count]').forEach(function (el) {
                    el.textContent = count;
                });

                // آپدیت badge دکمه شناور
                const badge = document.getElementById('floatingCartCount');
                if (badge) {
                    badge.textContent = count;
                    if (count > 0) {
                        badge.classList.remove('hidden');
                    } else {
                        badge.classList.add('hidden');
                    }
                }

                // انیمیشن bounce روی دکمه شناور
                const floatBtn = document.getElementById('floatingCartBtn');
                if (floatBtn) {
                    floatBtn.classList.remove('bounce');
                    void floatBtn.offsetWidth; // force reflow
                    floatBtn.classList.add('bounce');
                    setTimeout(function () {
                        floatBtn.classList.remove('bounce');
                    }, 600);
                }
            }
        });
    </script>
@endsection

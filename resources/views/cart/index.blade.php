@extends('layouts.home')

@section('title', 'سبد خرید')

@section('styles')
    <style>
        /* ========== بدنه صفحه ========== */
        .cart-page {
            min-height: 100vh;
            background: linear-gradient(to bottom, #f9fafb, #ffffff);
        }

        /* ========== هدر ========== */
        .page-header {
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
        }

        /* ========== کارت ========== */
        .soft-shadow {
            box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 1px 2px rgba(0,0,0,0.06);
        }

        /* ========== آیتم سبد ========== */
        .cart-item {
            background: #fff;
            border-radius: 0.75rem;
            padding: 0.875rem;
            margin-bottom: 0.75rem;
            display: flex;
            gap: 0.75rem;
            align-items: stretch;
            transition: box-shadow 0.2s ease;
        }
        .cart-item:hover {
            box-shadow: 0 4px 12px -2px rgba(0,0,0,0.08);
        }
        .cart-item-image {
            width: 80px;
            height: 80px;
            border-radius: 0.5rem;
            overflow: hidden;
            background: #f3f4f6;
            flex-shrink: 0;
        }
        .cart-item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .cart-item-info {
            flex-grow: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .cart-item-name {
            font-size: 0.875rem;
            font-weight: 600;
            color: #111827;
            text-decoration: none;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.4;
            margin-bottom: 0.25rem;
        }
        .cart-item-name:hover { color: #2563eb; }

        @media (min-width: 640px) {
            .cart-item { padding: 1rem; gap: 1rem; }
            .cart-item-image { width: 100px; height: 100px; }
            .cart-item-name { font-size: 1rem; }
        }

        /* ========== کنترل تعداد ========== */
        .qty-control {
            display: inline-flex;
            align-items: center;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            overflow: hidden;
            background: #fff;
        }
        .qty-btn {
            width: 32px;
            height: 32px;
            border: none;
            background: #fff;
            color: #374151;
            font-size: 1rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background-color 0.15s ease;
        }
        .qty-btn:hover:not(:disabled) { background: #f3f4f6; }
        .qty-btn:disabled {
            color: #d1d5db;
            cursor: not-allowed;
        }
        .qty-input {
            width: 40px;
            height: 32px;
            border: none;
            border-left: 1px solid #e5e7eb;
            border-right: 1px solid #e5e7eb;
            text-align: center;
            font-size: 0.875rem;
            font-weight: 600;
            color: #111827;
            outline: none;
            -moz-appearance: textfield;
        }
        .qty-input::-webkit-inner-spin-button,
        .qty-input::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        @media (min-width: 640px) {
            .qty-btn { width: 36px; height: 36px; }
            .qty-input { width: 48px; height: 36px; font-size: 0.9375rem; }
        }

        /* ========== قیمت ========== */
        .price-main {
            font-weight: 700;
            color: #111827;
            font-size: 0.875rem;
        }
        .price-currency {
            font-size: 11px;
            font-weight: 400;
            color: #6b7280;
        }
        @media (min-width: 640px) {
            .price-main { font-size: 1rem; }
        }

        /* ========== دکمه حذف ========== */
        .btn-remove {
            background: transparent;
            border: none;
            color: #ef4444;
            padding: 0.25rem;
            border-radius: 0.375rem;
            cursor: pointer;
            transition: background-color 0.15s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .btn-remove:hover { background: #fef2f2; }

        /* ========== خلاصه سفارش ========== */
        .order-summary {
            background: #fff;
            border-radius: 0.75rem;
            padding: 1rem;
            position: sticky;
            top: 5rem;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
            font-size: 0.875rem;
            color: #4b5563;
        }
        .summary-row.total {
            border-top: 2px dashed #e5e7eb;
            margin-top: 0.5rem;
            padding-top: 0.75rem;
            font-size: 1rem;
            font-weight: 700;
            color: #111827;
        }
        .summary-row.total .value {
            color: #2563eb;
            font-size: 1.125rem;
        }

        /* ========== دکمه پرداخت ========== */
        .btn-checkout {
            width: 100%;
            background: linear-gradient(135deg, #10b981, #059669);
            color: #fff;
            border: none;
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            font-size: 0.9375rem;
            font-weight: 700;
            transition: all 0.2s ease;
            box-shadow: 0 4px 6px -1px rgba(16,185,129,0.3);
        }
        .btn-checkout:hover:not(:disabled) {
            background: linear-gradient(135deg, #059669, #047857);
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 8px 12px -2px rgba(16,185,129,0.4);
        }
        .btn-checkout:disabled {
            background: #9ca3af;
            cursor: not-allowed;
            box-shadow: none;
        }

        /* ========== فرم اطلاعات تماس ========== */
        .contact-form {
            background: #fff;
            border-radius: 0.75rem;
            padding: 1rem;
            margin-top: 0.75rem;
        }
        .contact-form-title {
            font-size: 0.9375rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .form-label-sm {
            font-size: 0.8125rem;
            color: #4b5563;
            margin-bottom: 0.25rem;
            font-weight: 500;
        }
        .form-control-sm {
            font-size: 0.875rem;
            padding: 0.5rem 0.75rem;
            border-radius: 0.5rem;
            border: 1px solid #e5e7eb;
        }
        .form-control-sm:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59,130,246,0.15);
        }

        /* ========== حالت خالی ========== */
        .empty-cart {
            background: #fff;
            border-radius: 0.75rem;
            padding: 3rem 1rem;
            text-align: center;
        }
        .empty-cart-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 6rem;
            height: 6rem;
            border-radius: 50%;
            background: #f3f4f6;
            margin-bottom: 1.25rem;
        }

        /* ========== اسکلت لودینگ ========== */
        .skeleton {
            background: linear-gradient(90deg, #f3f4f6 25%, #e5e7eb 50%, #f3f4f6 75%);
            background-size: 200% 100%;
            animation: skeleton-loading 1.5s infinite;
            border-radius: 0.375rem;
        }
        @keyframes skeleton-loading {
            from { background-position: 200% 0; }
            to   { background-position: -200% 0; }
        }

        /* ========== Toast ========== */
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
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
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

        /* ========== Spinner ========== */
        .spinner-btn {
            display: inline-block;
            width: 14px;
            height: 14px;
            border: 2px solid rgba(255,255,255,0.4);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* ========== دکمه شناور بازگشت ========== */
        .floating-back-btn {
            position: fixed;
            bottom: 1.25rem;
            left: 1.25rem;
            z-index: 1050;
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 25px -5px rgba(99,102,241,0.5);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            text-decoration: none;
        }
        .floating-back-btn:hover {
            color: #fff;
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 15px 30px -5px rgba(99,102,241,0.6);
        }
        .floating-back-btn svg { width: 26px; height: 26px; }

        @media (max-width: 380px) {
            .floating-back-btn { width: 50px; height: 50px; bottom: 1rem; left: 1rem; }
            .floating-back-btn svg { width: 22px; height: 22px; }
        }
        @media (min-width: 992px) {
            .floating-back-btn { bottom: 1.5rem; left: 1.5rem; width: 60px; height: 60px; }
            .floating-back-btn svg { width: 28px; height: 28px; }
        }
    </style>
@endsection

@section('content')
    <div class="cart-page">

        {{-- ============ Header ============ --}}
        <div class="page-header">
            <div class="container-xl py-3 py-sm-4">
                <nav class="text-muted small mb-2 d-flex align-items-center flex-wrap gap-1" aria-label="breadcrumb">
                    <a href="{{ url('/') }}" class="text-decoration-none text-muted">خانه</a>
                    <span class="text-secondary">/</span>
                    <a href="{{ route('products.index', ['locale' => app()->getLocale()]) }}"
                       class="text-decoration-none text-muted">محصولات</a>
                    <span class="text-secondary">/</span>
                    <span class="text-dark fw-medium">سبد خرید</span>
                </nav>

                <div class="d-flex justify-content-between align-items-center gap-3">
                    <div>
                        <h1 class="h4 fw-bold text-dark mb-1">🛒 سبد خرید</h1>
                        <p class="text-muted small mb-0" id="cartSummaryText">
                            در حال بارگذاری...
                        </p>
                    </div>
                    <button type="button"
                            class="btn btn-outline-danger btn-sm d-none"
                            id="clearCartBtn">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                             stroke-linecap="round" stroke-linejoin="round" style="vertical-align: -2px;">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6l-2 14a2 2 0 0 1-2 2H9a2 2 0 0 1-2-2L5 6"></path>
                        </svg>
                        خالی کردن سبد
                    </button>
                </div>
            </div>
        </div>

        {{-- ============ محتوای اصلی ============ --}}
        <div class="container-xl py-3 py-sm-4">

            {{-- حالت لودینگ اولیه --}}
            <div id="loadingState" class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">در حال بارگذاری...</span>
                </div>
                <p class="text-muted small mt-3">در حال بارگذاری سبد خرید...</p>
            </div>

            {{-- حالت خالی --}}
            <div id="emptyState" class="empty-cart soft-shadow d-none">
                <div class="empty-cart-icon">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="1.5"
                         stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                </div>
                <h3 class="h5 fw-bold text-dark mb-2">سبد خرید شما خالی است</h3>
                <p class="text-muted small mb-4">هنوز محصولی به سبد خرید اضافه نکرده‌اید.</p>
                <a href="{{ route('products.index', ['locale' => app()->getLocale()]) }}"
                   class="btn btn-primary focus-ring">
                    🛍️ مشاهده محصولات
                </a>
            </div>

            {{-- حالت اصلی --}}
            <div id="cartContent" class="d-none">
                <div class="row g-3 g-lg-4">

                    {{-- ستون چپ: آیتم‌ها --}}
                    <div class="col-lg-8">
                        <div id="cartItemsContainer"></div>

                        {{-- فرم اطلاعات تماس (مهمان) --}}
                        <div class="contact-form soft-shadow d-none" id="guestContactForm">
                            <div class="contact-form-title">
                                <svg width="20" height="20" fill="none" stroke="#2563eb" stroke-width="2" viewBox="0 0 24 24"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                اطلاعات تماس شما
                            </div>
                            <p class="text-muted small mb-3">
                                برای تکمیل سفارش، لطفاً اطلاعات زیر را وارد کنید.
                            </p>
                            <form id="contactForm">
                                <div class="row g-2">
                                    <div class="col-12 col-sm-6">
                                        <label class="form-label-sm d-block">نام و نام خانوادگی *</label>
                                        <input type="text" name="name" class="form-control form-control-sm"
                                               required maxlength="150" placeholder="مثال: علی رضایی">
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <label class="form-label-sm d-block">شماره موبایل *</label>
                                        <input type="tel" name="phone" class="form-control form-control-sm"
                                               required pattern="09\d{9}" maxlength="11"
                                               placeholder="09123456789">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label-sm d-block">ایمیل (اختیاری)</label>
                                        <input type="email" name="email" class="form-control form-control-sm"
                                               maxlength="150" placeholder="you@example.com">
                                    </div>
                                    <div class="col-12 mt-3">
                                        <button type="submit" class="btn btn-primary w-100">
                                            ذخیره اطلاعات
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- ستون راست: خلاصه سفارش --}}
                    <div class="col-lg-4">
                        <div class="order-summary soft-shadow">
                            <h5 class="fw-bold mb-3" style="font-size: 1rem;">خلاصه سفارش</h5>

                            <div class="summary-row">
                                <span>تعداد اقلام:</span>
                                <span class="fw-bold" id="summaryItemsCount">0</span>
                            </div>
                            <div class="summary-row">
                                <span>جمع کل:</span>
                                <span class="fw-bold" id="summarySubtotal">0</span>
                            </div>
                            <div class="summary-row">
                                <span>هزینه ارسال:</span>
                                <span class="text-success small">محاسبه در مرحله بعد</span>
                            </div>

                            <div class="summary-row total">
                                <span>مبلغ قابل پرداخت:</span>
                                <span class="value" id="summaryTotal">0</span>
                            </div>

                            <button type="button" class="btn-checkout mt-3" id="checkoutBtn">
                                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"
                                     viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"
                                     style="vertical-align: -3px;">
                                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                    <line x1="1" y1="10" x2="23" y2="10"></line>
                                </svg>
                                ادامه فرآیند خرید
                            </button>

                            <a href="{{ route('products.index', ['locale' => app()->getLocale()]) }}"
                               class="btn btn-outline-secondary w-100 mt-2 btn-sm">
                                ← بازگشت به فروشگاه
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ============ دکمه شناور بازگشت ============ --}}
    <a href="{{ route('products.index', ['locale' => app()->getLocale()]) }}"
       class="floating-back-btn"
       aria-label="بازگشت به فروشگاه"
       title="بازگشت به فروشگاه">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
             stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
    </a>

    {{-- ============ Toast Container ============ --}}
    <div class="toast-container" id="toastContainer"></div>
@endsection

@section('scripts')
    <script>
        // ============================================================
        // تنظیمات
        // ============================================================
        const CART_API = {
            index:           '{{ route("cart.show", ["locale" => app()->getLocale()]) }}',
            add:             '{{ route("cart.add", ["locale" => app()->getLocale()]) }}',
            update:   (id) => '{{ route("cart.update", ["locale" => app()->getLocale(), "itemId" => "__ID__"]) }}'.replace('__ID__', id),
            remove:   (id) => '{{ route("cart.remove", ["locale" => app()->getLocale(), "itemId" => "__ID__"]) }}'.replace('__ID__', id),
            clear:           '{{ route("cart.clear", ["locale" => app()->getLocale()]) }}',
            setGuestContact: '{{ route("cart.guest", ["locale" => app()->getLocale()]) }}', // ← اصلاح شد
            checkout:        '{{ route("checkout.index", ["locale" => app()->getLocale()]) }}',
        };

        const CSRF = document.querySelector('meta[name="csrf-token"]')?.content
            || '{{ csrf_token() }}';

        // ============================================================
        // ابزار کمکی
        // ============================================================
        function formatNumber(n) {
            return Number(n || 0).toLocaleString('fa-IR');
        }

        async function apiRequest(url, method = 'GET', body = null) {
            const options = {
                method: method,
                headers: {
                    'X-CSRF-TOKEN': CSRF,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
            };
            if (body) {
                options.headers['Content-Type'] = 'application/json';
                options.body = JSON.stringify(body);
            }
            const res = await fetch(url, options);
            const data = await res.json().catch(() => ({}));
            if (!res.ok) {
                throw new Error(data.message || 'خطا در ارتباط با سرور');
            }
            return data;
        }

        // ============================================================
        // نمایش Toast
        // ============================================================
        function showToast(message, type = 'success') {
            const container = document.getElementById('toastContainer');
            if (!container) return;

            const toast = document.createElement('div');
            toast.className = 'cart-toast ' + type;

            const icon = type === 'error'
                ? '<svg width="20" height="20" fill="none" stroke="#ef4444" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'
                : '<svg width="20" height="20" fill="none" stroke="#10b981" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>';

            toast.innerHTML = icon + '<span class="flex-grow-1">' + message + '</span>';
            container.appendChild(toast);

            setTimeout(() => {
                toast.classList.add('hide');
                setTimeout(() => toast.remove(), 300);
            }, 3500);
        }

        // ============================================================
        // رندر آیتم سبد
        // ============================================================
        function renderCartItem(item) {
            const fallbackImg = 'https://placehold.co/200x200?text=No+Image';
            const productUrl = `/{{ app()->getLocale() }}/products/${item.slug}`;

            return `
                <div class="cart-item" data-item-id="${item.id}">
                    <a href="${productUrl}" class="cart-item-image">
                        <img src="${item.image || fallbackImg}" alt="${item.name}" loading="lazy">
                    </a>
                    <div class="cart-item-info">
                        <div>
                            <a href="${productUrl}" class="cart-item-name">${item.name}</a>
                            <div class="text-muted small mt-1">
                                قیمت واحد: <span class="fw-bold">${formatNumber(item.unit_price)}</span> تومان
                            </div>
                        </div>
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mt-2">
                            <div class="qty-control">
                                <button type="button" class="qty-btn" data-action="decrease"
                                        data-item-id="${item.id}" ${item.quantity <= 1 ? 'disabled' : ''}>
                                    −
                                </button>
                                <input type="number" class="qty-input" value="${item.quantity}" min="1"
                                       data-item-id="${item.id}" readonly>
                                <button type="button" class="qty-btn" data-action="increase"
                                        data-item-id="${item.id}">+</button>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <div class="price-main">
                                    ${formatNumber(item.total_price)}
                                    <span class="price-currency">تومان</span>
                                </div>
                                <button type="button" class="btn-remove" data-action="remove"
                                        data-item-id="${item.id}" title="حذف از سبد">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"
                                         viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6l-2 14a2 2 0 0 1-2 2H9a2 2 0 0 1-2-2L5 6"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

        // ============================================================
        // رندر کل سبد
        // ============================================================
        function renderCart(cart) {
            const loadingState = document.getElementById('loadingState');
            const emptyState   = document.getElementById('emptyState');
            const cartContent  = document.getElementById('cartContent');
            const itemsContainer = document.getElementById('cartItemsContainer');
            const summaryText = document.getElementById('cartSummaryText');
            const clearBtn = document.getElementById('clearCartBtn');
            const guestContactForm = document.getElementById('guestContactForm');

            loadingState.classList.add('d-none');

            if (!cart.items || cart.items.length === 0) {
                emptyState.classList.remove('d-none');
                cartContent.classList.add('d-none');
                clearBtn.classList.add('d-none');
                summaryText.textContent = 'سبد خرید خالی است';
                return;
            }

            emptyState.classList.add('d-none');
            cartContent.classList.remove('d-none');
            clearBtn.classList.remove('d-none');

            // رندر آیتم‌ها
            itemsContainer.innerHTML = cart.items.map(renderCartItem).join('');

            // خلاصه سفارش
            document.getElementById('summaryItemsCount').textContent = formatNumber(cart.items_count);
            document.getElementById('summarySubtotal').textContent = formatNumber(cart.subtotal) + ' تومان';
            document.getElementById('summaryTotal').textContent = formatNumber(cart.subtotal) + ' تومان';
            summaryText.textContent = formatNumber(cart.items_count) + ' کالا در سبد خرید شما';

            // نمایش فرم تماس برای مهمان
            if (cart.is_guest) {
                guestContactForm.classList.remove('d-none');
                const form = document.getElementById('contactForm');
                if (cart.contact) {
                    if (cart.contact.name)  form.name.value  = cart.contact.name;
                    if (cart.contact.phone) form.phone.value = cart.contact.phone;
                    if (cart.contact.email) form.email.value = cart.contact.email;
                }
            } else {
                guestContactForm.classList.add('d-none');
            }

            // بایند رویدادها
            bindCartEvents();
        }

        // ============================================================
        // بارگذاری سبد از سرور
        // ============================================================
        async function loadCart(showLoading = true) {
            if (showLoading) {
                document.getElementById('loadingState').classList.remove('d-none');
                document.getElementById('cartContent').classList.add('d-none');
                document.getElementById('emptyState').classList.add('d-none');
            }

            try {
                const data = await apiRequest(CART_API.index);
                // API شما data را داخل data.data برمی‌گرداند
                const cart = data.data || data;
                renderCart(cart);
            } catch (err) {
                console.error(err);
                showToast('خطا در بارگذاری سبد خرید', 'error');
                document.getElementById('loadingState').classList.add('d-none');
                document.getElementById('emptyState').classList.remove('d-none');
            }
        }

        // ============================================================
        // بایند رویدادهای سبد
        // ============================================================
        function bindCartEvents() {
            // کم/زیاد کردن تعداد
            document.querySelectorAll('.qty-btn[data-action]').forEach(btn => {
                btn.addEventListener('click', async function () {
                    const action = this.dataset.action;
                    const itemId = this.dataset.itemId;
                    const input  = document.querySelector(`.qty-input[data-item-id="${itemId}"]`);
                    if (!input) return;

                    let qty = parseInt(input.value) || 1;
                    if (action === 'increase') qty++;
                    else if (action === 'decrease') qty = Math.max(1, qty - 1);
                    else return;

                    this.disabled = true;
                    try {
                        await updateItemQuantity(itemId, qty);
                    } catch (err) {
                        showToast(err.message, 'error');
                    } finally {
                        this.disabled = false;
                    }
                });
            });

            // حذف آیتم
            document.querySelectorAll('.btn-remove[data-action="remove"]').forEach(btn => {
                btn.addEventListener('click', async function () {
                    const itemId = this.dataset.itemId;
                    if (!confirm('آیا از حذف این محصول از سبد خرید مطمئن هستید؟')) return;

                    this.disabled = true;
                    try {
                        await removeItem(itemId);
                    } catch (err) {
                        showToast(err.message, 'error');
                    } finally {
                        this.disabled = false;
                    }
                });
            });
        }

        // ============================================================
        // عملیات‌های سبد
        // ============================================================
        async function updateItemQuantity(itemId, quantity) {
            await apiRequest(CART_API.update(itemId), 'PATCH', { quantity: quantity });
            showToast('تعداد بروزرسانی شد');
            await loadCart(false);
        }

        async function removeItem(itemId) {
            await apiRequest(CART_API.remove(itemId), 'DELETE');
            showToast('محصول از سبد خرید حذف شد');
            await loadCart(false);
        }

        async function clearCart() {
            if (!confirm('آیا از خالی کردن کل سبد خرید مطمئن هستید؟')) return;
            try {
                await apiRequest(CART_API.clear, 'DELETE');
                showToast('سبد خرید خالی شد');
                await loadCart(false);
            } catch (err) {
                showToast(err.message, 'error');
            }
        }

        // ============================================================
        // مقداردهی اولیه
        // ============================================================
        document.addEventListener('DOMContentLoaded', function () {

            // بارگذاری سبد
            loadCart();

            // خالی کردن سبد
            document.getElementById('clearCartBtn').addEventListener('click', clearCart);

            // ذخیره اطلاعات تماس
            document.getElementById('contactForm').addEventListener('submit', async function (e) {
                e.preventDefault();
                const formData = new FormData(this);
                const payload = {
                    name:  formData.get('name'),
                    phone: formData.get('phone'),
                    email: formData.get('email') || null,
                };

                const submitBtn = this.querySelector('button[type="submit"]');
                const original  = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-btn"></span> در حال ذخیره...';

                try {
                    await apiRequest(CART_API.setGuestContact, 'POST', payload);
                    showToast('اطلاعات تماس با موفقیت ذخیره شد');
                } catch (err) {
                    showToast(err.message, 'error');
                } finally {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = original;
                }
            });

            // ادامه فرآیند خرید
            document.getElementById('checkoutBtn').addEventListener('click', async function () {
                // اطمینان از پر بودن اطلاعات تماس برای مهمان
                const guestForm = document.getElementById('guestContactForm');
                const isGuestVisible = guestForm && !guestForm.classList.contains('d-none');

                if (isGuestVisible) {
                    const form = document.getElementById('contactForm');
                    const name  = form.name.value.trim();
                    const phone = form.phone.value.trim();

                    if (!name || !phone) {
                        showToast('لطفاً نام و شماره موبایل خود را وارد کنید.', 'error');
                        form.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        return;
                    }

                    // ذخیره خودکار اطلاعات تماس قبل از رفتن به checkout
                    try {
                        this.disabled = true;
                        await apiRequest(CART_API.setGuestContact, 'POST', {
                            name, phone, email: form.email.value.trim() || null,
                        });
                    } catch (err) {
                        showToast(err.message, 'error');
                        this.disabled = false;
                        return;
                    }
                }

                window.location.href = CART_API.checkout;
            });
        });
    </script>
@endsection

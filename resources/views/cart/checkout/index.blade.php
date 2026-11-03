@extends('layouts.home')

@section('title', 'تکمیل خرید')

@section('styles')
    <style>
        .checkout-page { min-height: 100vh; background: linear-gradient(to bottom, #f9fafb, #fff); }
        .page-header { background: #fff; border-bottom: 1px solid #e5e7eb; }
        .soft-shadow { box-shadow: 0 1px 3px rgba(0,0,0,.04), 0 1px 2px rgba(0,0,0,.06); }
        .checkout-card { background: #fff; border-radius: .75rem; padding: 1rem 1.25rem; margin-bottom: 1rem; }
        .checkout-card-title { font-weight: 700; font-size: .9375rem; color: #111827; margin-bottom: .75rem; display: flex; align-items: center; gap: .5rem; }
        .form-label-sm { font-size: .8125rem; color: #4b5563; margin-bottom: .25rem; font-weight: 500; }
        .form-control-sm { font-size: .875rem; padding: .5rem .75rem; border-radius: .5rem; border: 1px solid #e5e7eb; }
        .form-control-sm:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,.15); }
        .order-summary { background: #fff; border-radius: .75rem; padding: 1rem; position: sticky; top: 5rem; }
        .summary-row { display: flex; justify-content: space-between; padding: .5rem 0; font-size: .875rem; color: #4b5563; }
        .summary-row.total { border-top: 2px dashed #e5e7eb; margin-top: .5rem; padding-top: .75rem; font-size: 1rem; font-weight: 700; color: #111827; }
        .summary-row.total .value { color: #2563eb; font-size: 1.125rem; }
        .btn-checkout { width: 100%; background: linear-gradient(135deg,#10b981,#059669); color: #fff; border: none; border-radius: .5rem; padding: .75rem 1rem; font-weight: 700; box-shadow: 0 4px 6px -1px rgba(16,185,129,.3); }
        .btn-checkout:hover:not(:disabled) { background: linear-gradient(135deg,#059669,#047857); color: #fff; }
        .btn-checkout:disabled { background: #9ca3af; cursor: not-allowed; box-shadow: none; }
        .checkout-item { display: flex; gap: .75rem; align-items: center; padding: .75rem 0; border-bottom: 1px dashed #e5e7eb; }
        .checkout-item:last-child { border-bottom: none; }
        .checkout-item img { width: 60px; height: 60px; border-radius: .5rem; object-fit: cover; background: #f3f4f6; }
        .checkout-item-name { font-size: .875rem; font-weight: 600; color: #111827; }
        .checkout-item-meta { font-size: .75rem; color: #6b7280; }
        .payment-option { display: flex; align-items: center; gap: .5rem; padding: .5rem; border: 1px solid #e5e7eb; border-radius: .5rem; cursor: pointer; }
        .payment-option:has(input:checked) { border-color: #2563eb; background: #eff6ff; }
    </style>
@endsection

@section('content')
    <div class="checkout-page">
        <div class="page-header">
            <div class="container-xl py-3 py-sm-4">
                <nav class="text-muted small mb-2 d-flex align-items-center flex-wrap gap-1">
                    <a href="{{ url('/') }}" class="text-decoration-none text-muted">خانه</a>
                    <span>/</span>
                    <a href="{{ route('cart.show', ['locale' => app()->getLocale()]) }}" class="text-decoration-none text-muted">سبد خرید</a>
                    <span>/</span>
                    <span class="text-dark fw-medium">تکمیل خرید</span>
                </nav>
                <h1 class="h4 fw-bold text-dark mb-1">📦 تکمیل خرید</h1>
                <p class="text-muted small mb-0">اطلاعات ارسال و پرداخت را وارد کنید.</p>
            </div>
        </div>

        <div class="container-xl py-3 py-sm-4">
            <form method="POST" action="{{ route('checkout.store', ['locale' => app()->getLocale()]) }}" id="checkoutForm">
                @csrf
                <div class="row g-3 g-lg-4">
                    <div class="col-lg-8">

                        {{-- اطلاعات گیرنده --}}
                        <div class="checkout-card soft-shadow">
                            <div class="checkout-card-title">
                                <svg width="18" height="18" fill="none" stroke="#2563eb" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                اطلاعات گیرنده
                            </div>
                            <div class="row g-2">
                                <div class="col-12 col-sm-6">
                                    <label class="form-label-sm d-block">نام و نام خانوادگی *</label>
                                    <input type="text" name="recipient_name" class="form-control form-control-sm"
                                           required maxlength="150"
                                           value="{{ old('recipient_name', $cart->guest_name ?? auth()->user()?->name) }}">
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label class="form-label-sm d-block">شماره موبایل *</label>
                                    <input type="tel" name="shipping_phone" class="form-control form-control-sm"
                                           required pattern="09\d{9}" maxlength="11"
                                           value="{{ old('shipping_phone', $cart->guest_phone) }}">
                                </div>
                            </div>
                        </div>

                        {{-- آدرس ارسال --}}
                        <div class="checkout-card soft-shadow">
                            <div class="checkout-card-title">
                                <svg width="18" height="18" fill="none" stroke="#2563eb" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                آدرس ارسال
                            </div>
                            <div class="row g-2">
                                <div class="col-12 col-sm-6">
                                    <label class="form-label-sm d-block">استان *</label>
                                    <input type="text" name="shipping_province" class="form-control form-control-sm"
                                           required maxlength="100"
                                           value="{{ old('shipping_province', $address?->province) }}">
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label class="form-label-sm d-block">شهر *</label>
                                    <input type="text" name="shipping_city" class="form-control form-control-sm"
                                           required maxlength="100"
                                           value="{{ old('shipping_city', $address?->city) }}">
                                </div>
{{--                                <input--}}
{{--                                    type="text"--}}
{{--                                    name="shipping_province"--}}
{{--                                    class="form-control"--}}
{{--                                    required--}}
{{--                                >--}}
                                <div class="col-12 col-sm-6">
                                    <label class="form-label-sm d-block">کد پستی</label>
                                    <input type="text" name="shipping_postcode" class="form-control form-control-sm"
                                           maxlength="20"
                                           value="{{ old('shipping_postcode', $address?->postcode) }}">
                                </div>
                                <div class="col-12">
                                    <label class="form-label-sm d-block">آدرس کامل *</label>
                                    <textarea name="shipping_address" class="form-control form-control-sm"
                                              rows="2" required maxlength="500">{{ old('shipping_address', $address?->address) }}</textarea>
                                </div>
                                <div class="col-12">
                                    <label class="form-label-sm d-block">توضیحات (اختیاری)</label>
                                    <textarea name="notes" class="form-control form-control-sm"
                                              rows="2" maxlength="1000">{{ old('notes') }}</textarea>
                                </div>
                            </div>
                        </div>
                        {{-- روش پرداخت --}}
                        <div class="checkout-card soft-shadow">
                            <div class="checkout-card-title">
                                <svg width="18" height="18" fill="none" stroke="#2563eb" stroke-width="2" viewBox="0 0 24 24">
                                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                    <line x1="1" y1="10" x2="23" y2="10"></line>
                                </svg>
                                روش پرداخت
                            </div>
                            <div class="d-flex flex-column gap-2">
                                <label class="payment-option">
                                    <input type="radio" name="payment_method" value="online"
                                        {{ old('payment_method', 'online') === 'online' ? 'checked' : '' }}>
                                    <span class="fw-medium">پرداخت آنلاین (درگاه بانکی)</span>
                                </label>
                                <label class="payment-option">
                                    <input type="radio" name="payment_method" value="cod"
                                        {{ old('payment_method') === 'cod' ? 'checked' : '' }}>
                                    <span class="fw-medium">پرداخت در محل (هنگام تحویل)</span>
                                </label>
                            </div>
                            @error('payment_method')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- روش پرداخت --}}
{{--                        <div class="checkout-card soft-shadow">--}}
{{--                            <div class="checkout-card-title">--}}
{{--                                <svg width="18" height="18" fill="none" stroke="#2563eb" stroke-width="2" viewBox="0 0 24 24">--}}
{{--                                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>--}}
{{--                                    <line x1="1" y1="10" x2="23" y2="10"></line>--}}
{{--                                </svg>--}}
{{--                                روش پرداخت--}}
{{--                            </div>--}}
{{--                            <div class="d-flex flex-column gap-2">--}}
{{--                                <label class="payment-option">--}}
{{--                                    <input type="radio" name="payment_method" value="online" checked>--}}
{{--                                    <span class="fw-medium">پرداخت آنلاین</span>--}}
{{--                                </label>--}}
{{--                                <label class="payment-option">--}}
{{--                                    <input type="radio" name="payment_method" value="cod">--}}
{{--                                    <span class="fw-medium">پرداخت در محل (هنگام تحویل)</span>--}}
{{--                                </label>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>

                    {{-- خلاصه سفارش --}}
                    <div class="col-lg-4">
                        <div class="order-summary soft-shadow">
                            <h5 class="fw-bold mb-3" style="font-size: 1rem;">خلاصه سفارش</h5>

                            <div class="mb-2">
                                @foreach($cart->items as $item)
                                    <div class="checkout-item">
                                        <img src="{{ $item->product?->image ?? 'https://placehold.co/120x120?text=No+Image' }}"
                                             alt="{{ $item->product?->name }}">
                                        <div class="flex-grow-1 min-w-0">
                                            <div class="checkout-item-name text-truncate">
                                                {{ $item->product?->name ?? 'محصول حذف شده' }}
                                            </div>
                                            <div class="checkout-item-meta">
                                                {{ number_format($item->quantity) }} ×
                                                {{ number_format($item->unit_price) }} تومان
                                            </div>
                                        </div>
                                        <div class="fw-bold small text-nowrap">
                                            {{ number_format($item->total_price) }} تومان
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="summary-row">
                                <span>تعداد اقلام:</span>
                                <span class="fw-bold">{{ number_format($cart->items_count) }}</span>
                            </div>
                            <div class="summary-row">
                                <span>جمع کل:</span>
                                <span class="fw-bold">{{ number_format($cart->subtotal) }} تومان</span>
                            </div>
                            <div class="summary-row">
                                <span>هزینه ارسال:</span>
                                <span class="text-success small">در مرحله بعد</span>
                            </div>
                            <div class="summary-row total">
                                <span>مبلغ قابل پرداخت:</span>
                                <span class="value">{{ number_format($cart->subtotal) }} تومان</span>
                            </div>

                            <button type="submit" class="btn-checkout mt-3" id="submitOrderBtn">
                                ✅ ثبت سفارش
                            </button>

                            <a href="{{ route('cart.show', ['locale' => app()->getLocale()]) }}"
                               class="btn btn-outline-secondary w-100 mt-2 btn-sm">
                                ← بازگشت به سبد خرید
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('checkoutForm').addEventListener('submit', function () {
            const btn = document.getElementById('submitOrderBtn');
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> در حال ثبت سفارش...';
        });
    </script>
@endsection

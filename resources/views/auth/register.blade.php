@extends('layouts.home')

@section('title', 'ثبت نام | امیر آفاق گستر پارس')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/auth/auth.css') }}">

    <style>
        /* --- استایل‌های اختصاصی این صفحه --- */
        .required {
            color: #e53935;
            font-weight: bold;
        }

        .field-error {
            display: block;
            margin-top: 6px;
            color: #e74c3c;
            font-size: 13px;
            font-weight: 500;
            line-height: 1.6;
        }

        .field-error::before {
            content: '⚠ ';
        }

        .auth-alert {
            padding: 12px 16px;
            margin-bottom: 16px;
            border-radius: 8px;
            font-size: 14px;
            line-height: 1.7;
        }

        .auth-alert-success {
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid rgba(16, 185, 129, .2);
        }

        .auth-alert-danger {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid rgba(239, 68, 68, .2);
        }

        .auth-alert-danger ul {
            margin: 8px 0 0;
            padding-right: 20px;
        }

        .auth-alert-danger li {
            margin-bottom: 4px;
        }

        .form-group input.is-invalid {
            border-color: #e74c3c;
            background: #fff5f5;
        }

        /* --- گروه رمز عبور با دکمه نمایش --- */
        .password-group {
            position: relative;
        }

        .password-group input {
            padding-left: 46px; /* فضای دکمه در سمت چپ (RTL) */
        }

        .toggle-password {
            position: absolute;
            left: 10px;
            bottom: 10px;          /* هم‌تراز با input */
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            background: transparent;
            cursor: pointer;
            color: #6b7280;
            font-size: 18px;
            border-radius: 6px;
            transition: background .15s, color .15s;
            padding: 0;
            line-height: 1;
        }

        .toggle-password:hover {
            background: rgba(0, 0, 0, .06);
            color: #111827;
        }

        .toggle-password:focus-visible {
            outline: 2px solid #3b82f6;
            outline-offset: 1px;
        }

        .toggle-password svg {
            width: 20px;
            height: 20px;
            pointer-events: none;
        }

        /* آیکن چشم خط‌خورده به‌طور پیش‌فرض مخفی */
        .toggle-password .icon-eye-off { display: none; }
        .toggle-password.is-visible .icon-eye    { display: none; }
        .toggle-password.is-visible .icon-eye-off { display: block; }
    </style>
@endsection

@section('content')

    <div class="auth-page">

        <div class="auth-container">

            {{-- عنوان صفحه --}}
            <div class="auth-header">
                <h1>ایجاد حساب کاربری</h1>
                <p>شرکت صادرات و واردات امیر آفاق گستر پارس</p>
            </div>

            {{-- پیام موفقیت --}}
            @if(session('success'))
                <div class="auth-alert auth-alert-success">
                    ✅ {{ session('success') }}
                </div>
            @endif

            {{-- خطاهای کلی فرم --}}
            @if($errors->any())
                <div class="auth-alert auth-alert-danger">
                    <strong>لطفاً خطاهای زیر را برطرف کنید:</strong>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- فرم ثبت نام --}}
            <form action="{{ route('register.store') }}"
                  method="POST"
                  class="auth-form"
                  novalidate>

                @csrf

                {{-- نام کاربری --}}
                <div class="form-group">
                    <label for="name">نام کاربری <span class="required">*</span></label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="نام کاربری خود را وارد کنید"
                        autocomplete="username"
                        minlength="3"
                        maxlength="100"
                        required
                        autofocus
                        class="@error('name') is-invalid @enderror"
                    >

                    @error('name')
                    <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- نام و نام خانوادگی --}}
                <div class="form-group">
                    <label for="full_name">نام و نام خانوادگی <span class="required">*</span></label>

                    <input
                        type="text"
                        id="full_name"
                        name="full_name"
                        value="{{ old('full_name') }}"
                        placeholder="مثلاً: علی رضایی"
                        autocomplete="name"
                        minlength="3"
                        maxlength="150"
                        required
                        class="@error('full_name') is-invalid @enderror"
                    >

                    @error('full_name')
                    <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- شماره موبایل --}}
                <div class="form-group">
                    <label for="phone">شماره موبایل <span class="required">*</span></label>

                    <input
                        type="tel"
                        id="phone"
                        name="phone"
                        value="{{ old('phone') }}"
                        placeholder="09xxxxxxxxx"
                        autocomplete="tel"
                        inputmode="numeric"
                        pattern="09[0-9]{9}"
                        maxlength="11"
                        dir="ltr"
                        required
                        class="@error('phone') is-invalid @enderror"
                    >

                    @error('phone')
                    <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- ایمیل --}}
                <div class="form-group">
                    <label for="email">ایمیل (اختیاری)</label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="example@domain.com"
                        autocomplete="email"
                        maxlength="150"
                        dir="ltr"
                        class="@error('email') is-invalid @enderror"
                    >

                    @error('email')
                    <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- رمز عبور --}}
                <div class="form-group password-group">
                    <label for="password">رمز عبور <span class="required">*</span></label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="حداقل ۸ کاراکتر"
                        autocomplete="new-password"
                        minlength="8"
                        required
                        class="@error('password') is-invalid @enderror"
                    >

                    <button type="button"
                            class="toggle-password"
                            data-target="password"
                            aria-label="نمایش رمز عبور"
                            aria-pressed="false"
                            title="نمایش رمز عبور">
                        {{-- آیکن چشم باز --}}
                        <svg class="icon-eye" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                        {{-- آیکن چشم خط‌خورده --}}
                        <svg class="icon-eye-off" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M17.94 17.94A10.94 10.94 0 0 1 12 19c-6.5 0-10-7-10-7a19.8 19.8 0 0 1 5.06-5.94"/>
                            <path d="M9.9 4.24A9.6 9.6 0 0 1 12 4c6.5 0 10 7 10 7a19.9 19.9 0 0 1-3.16 4.19"/>
                            <path d="M1 1l22 22"/>
                            <path d="M14.12 14.12a3 3 0 0 1-4.24-4.24"/>
                        </svg>
                    </button>

                    @error('password')
                    <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- تکرار رمز عبور --}}
                <div class="form-group password-group">
                    <label for="password_confirmation">تکرار رمز عبور <span class="required">*</span></label>

                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="رمز عبور را دوباره وارد کنید"
                        autocomplete="new-password"
                        minlength="8"
                        required
                        class="@error('password_confirmation') is-invalid @enderror"
                    >

                    <button type="button"
                            class="toggle-password"
                            data-target="password_confirmation"
                            aria-label="نمایش تکرار رمز عبور"
                            aria-pressed="false"
                            title="نمایش تکرار رمز عبور">
                        <svg class="icon-eye" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                        <svg class="icon-eye-off" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M17.94 17.94A10.94 10.94 0 0 1 12 19c-6.5 0-10-7-10-7a19.8 19.8 0 0 1 5.06-5.94"/>
                            <path d="M9.9 4.24A9.6 9.6 0 0 1 12 4c6.5 0 10 7 10 7a19.9 19.9 0 0 1-3.16 4.19"/>
                            <path d="M1 1l22 22"/>
                            <path d="M14.12 14.12a3 3 0 0 1-4.24-4.24"/>
                        </svg>
                    </button>

                    @error('password_confirmation')
                    <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- دکمه ثبت نام --}}
                <button type="submit" class="auth-submit">
                    ثبت نام
                </button>

            </form>

            {{-- لینک ورود --}}
            <div class="auth-footer">
                <span>قبلاً حساب کاربری ایجاد کرده‌اید؟</span>

                <a href="{{ route('login') }}">
                    وارد شوید
                </a>
            </div>

        </div>

    </div>

@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.toggle-password').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var targetId = btn.getAttribute('data-target');
                    var input = document.getElementById(targetId);
                    if (!input) return;

                    var isVisible = input.type === 'text';
                    input.type = isVisible ? 'password' : 'text';

                    btn.classList.toggle('is-visible', !isVisible);
                    btn.setAttribute('aria-pressed', String(!isVisible));
                    btn.setAttribute('aria-label',
                        (!isVisible ? 'مخفی کردن' : 'نمایش') + ' رمز عبور');
                    btn.setAttribute('title',
                        (!isVisible ? 'مخفی کردن' : 'نمایش') + ' رمز عبور');

                    // حفظ فوکوس روی فیلد بعد از toggle (تجربه بهتر)
                    input.focus({ preventScroll: true });
                });
            });
        });
    </script>

@endsection

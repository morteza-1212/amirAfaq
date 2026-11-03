@extends('layouts.home')

@section('title', 'ورود به حساب کاربری | امیر آفاق گستر پارس')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/auth/auth.css') }}">

    <style>
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

        .remember-group {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
            font-size: 14px;
        }

        .remember-group input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .remember-group label {
            cursor: pointer;
            user-select: none;
            margin: 0;
        }

        /* --- گروه رمز عبور با دکمه نمایش --- */
        .password-group {
            position: relative;
        }

        .password-group input {
            padding-left: 46px;
        }

        .toggle-password {
            position: absolute;
            left: 10px;
            bottom: 10px;
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

        .toggle-password .icon-eye-off { display: none; }
        .toggle-password.is-visible .icon-eye     { display: none; }
        .toggle-password.is-visible .icon-eye-off { display: block; }
    </style>
@endsection

@section('content')

    <div class="auth-page">
        <div class="auth-container">

            {{-- عنوان صفحه --}}
            <div class="auth-header">
                <h1>ورود به حساب کاربری</h1>
                <p>شرکت صادرات و واردات امیر آفاق گستر پارس</p>
            </div>

            {{-- پیام موفقیت --}}
            @if(session('success'))
                <div class="auth-alert auth-alert-success">
                    ✅ {{ session('success') }}
                </div>
            @endif

            {{-- پیام خطای کلی --}}
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

            {{-- پیام خطای دستی (session error) --}}
            @if(session('error'))
                <div class="auth-alert auth-alert-danger">
                    ⚠ {{ session('error') }}
                </div>
            @endif

            {{-- فرم ورود --}}
            <form action="{{ route('login.store') }}"
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
                        required
                        autofocus
                        class="@error('name') is-invalid @enderror"
                    >

                    @error('name')
                    <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- رمز عبور با دکمه نمایش ---}}
                <div class="form-group password-group">
                    <label for="password">رمز عبور <span class="required">*</span></label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="رمز عبور خود را وارد کنید"
                        autocomplete="current-password"
                        required
                        class="@error('password') is-invalid @enderror"
                    >

                    <button type="button"
                            class="toggle-password"
                            data-target="password"
                            aria-label="نمایش رمز عبور"
                            aria-pressed="false"
                            title="نمایش رمز عبور">
                        {{-- چشم باز --}}
                        <svg class="icon-eye" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                        {{-- چشم خط‌خورده --}}
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

                {{-- مرا به خاطر بسپار --}}
                <div class="remember-group">
                    <input
                        type="checkbox"
                        id="remember"
                        name="remember"
                        value="1"
                        {{ old('remember') ? 'checked' : '' }}
                    >

                    <label for="remember">
                        مرا به خاطر بسپار
                    </label>
                </div>

                {{-- دکمه ورود --}}
                <button type="submit" class="auth-submit">
                    ورود به حساب کاربری
                </button>

            </form>

            {{-- لینک ثبت نام --}}
            <div class="auth-footer">
                <span>هنوز حساب کاربری ندارید؟</span>
                <a href="{{ route('register') }}">ثبت نام کنید</a>
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

                    input.focus({ preventScroll: true });
                });
            });
        });
    </script>

@endsection

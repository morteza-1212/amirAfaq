@extends('layouts.home')

@section('title', 'ورود به حساب کاربری | امیر آفاق گستر پارس')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/auth/auth.css') }}">

    <style>
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

            {{-- پیام خطای کلی (اگر خطاها را به صورت لیست می‌خواهید) --}}
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
                    <label for="name">نام کاربری</label>

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

                {{-- رمز عبور --}}
                <div class="form-group">
                    <label for="password">رمز عبور</label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="رمز عبور خود را وارد کنید"
                        autocomplete="current-password"
                        required
                        class="@error('password') is-invalid @enderror"
                    >

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

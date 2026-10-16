@extends('layouts.home')

@section('title', 'ثبت نام | امیر آفاق گستر پارس')

@section('styles')
    <link rel="stylesheet"
          href="{{ asset('css/auth/auth.css') }}">
@endsection

@section('content')

    <div class="auth-page">

        <div class="auth-container">

            {{-- عنوان صفحه --}}
            <div class="auth-header">
                <h1>ایجاد حساب کاربری</h1>

                <p>
                    شرکت صادرات و واردات امیر آفاق گستر پارس
                </p>
            </div>

            {{-- پیام موفقیت --}}
            @if(session('success'))
                <div class="auth-alert auth-alert-success">
                    {{ session('success') }}
                </div>
            @endif


            {{-- فرم ثبت نام --}}
            <form action="{{ route('register.store') }}"
                  method="POST"
                  class="auth-form">

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
                    >

                    @error('name')
                    <span class="field-error">
                        {{ $message }}
                    </span>
                    @enderror
                </div>

                {{-- رمز عبور --}}
                <div class="form-group">
                    <label for="password">رمز عبور</label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="حداقل ۸ کاراکتر"
                        autocomplete="new-password"
                        minlength="8"
                        required
                    >

                    @error('password')
                    <span class="field-error">
                        {{ $message }}
                    </span>
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

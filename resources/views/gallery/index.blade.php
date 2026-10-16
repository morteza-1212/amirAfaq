@extends('layouts.home')

@section('title', __('gallery.title'))

@section('styles')
    <link rel="stylesheet"
          href="{{ asset('css/gallery/gallery.css') }}?v=1"
          media="print"
          onload="this.media='all'">
@endsection

@section('content')
    @php

        // آیکون‌های نوع فعالیت
        $activityIcons = [
            'commerce'       => 'fa-shopping-cart',
            'logistics'      => 'fa-truck',
            'exhibition'     => 'fa-store',
            'exports'        => 'fa-ship',
            'imports'        => 'fa-plane-arrival',
            'global_markets' => 'fa-globe',
        ];
    @endphp

    <main class="gallery-page" dir="{{ $currentLocale === 'en' ? 'ltr' : 'rtl' }}">

        {{-- Hero --}}
        <section class="gallery-hero">
            <div class="container">

                {{-- Language Switcher --}}
{{--                <div class="gallery-lang-switcher">--}}
{{--                    @foreach($supportedLocales as $code => $label)--}}
{{--                        <a href="{{ route('gallery', ['locale' => $code]) }}"--}}
{{--                           class="gallery-lang-btn @if($currentLocale === $code) active @endif"--}}
{{--                           title="{{ $label }}">--}}
{{--                            {{ strtoupper($code) }}--}}
{{--                        </a>--}}
{{--                    @endforeach--}}
{{--                </div>--}}

                <div class="gallery-hero-content">
                    <span class="gallery-hero-label">
                        {{ __('gallery.eyebrow') }}
                    </span>

                    <h1>{{ __('gallery.title') }}</h1>

                    <p>{{ __('gallery.description') }}</p>
                </div>
            </div>
        </section>

        {{-- Gallery --}}
        <section class="gallery-section">
            <div class="container">

                <div class="gallery-heading">
                    <span class="gallery-section-label">
                        {{ __('gallery.section_eyebrow') }}
                    </span>
                    <h2>{{ __('gallery.section_title') }}</h2>
                    <p>{{ __('gallery.section_description') }}</p>
                </div>

                <div class="gallery-grid">

                    @forelse($galleries as $index => $gallery)
                        @php
                            $t = $gallery->translation($currentLocale);
                        @endphp

                        @if(!$t)
                            @continue
                        @endif

                        <a href="{{ $gallery->image_url }}"
                           class="gallery-item"
                           target="_blank"
                           rel="noopener">

                            <img src="{{ $gallery->image_url }}"
                                 alt="{{ $t->alt_text ?? $t->title }}"
                                 loading="lazy">

                            <div class="gallery-overlay">
                                <div class="gallery-overlay-content">

                                    <span class="gallery-category">
                                        <i class="fas {{ $activityIcons[$gallery->activity_type] ?? 'fa-tag' }} me-1"></i>
                                        {{ $gallery->activity_type_label }}
                                    </span>

                                    <h3>{{ $t->title }}</h3>

                                    @if($t->description)
                                        <p class="gallery-item-description">
                                            {{ \Illuminate\Support\Str::limit($t->description, 100) }}
                                        </p>
                                    @endif

                                    <span class="gallery-view">
                                        <i class="fas fa-expand"></i>
                                        {{ __('gallery.view_image') }}
                                    </span>

                                </div>
                            </div>
                        </a>

                    @empty
                        <div class="gallery-empty" style="grid-column: 1 / -1; text-align: center; padding: 80px 20px; color: #94a3b8;">
                            <i class="fas fa-images" style="font-size: 4rem; margin-bottom: 15px; display: block; opacity: 0.5;"></i>
                            <p>{{ __('gallery.empty') ?? 'هیچ تصویری یافت نشد.' }}</p>
                        </div>
                    @endforelse

                </div>
            </div>
        </section>

        {{-- CTA --}}
        <section class="gallery-cta">
            <div class="container">
                <div class="gallery-cta-box">
                    <div>
                        <span class="gallery-section-label">
                            {{ __('gallery.cta_eyebrow') }}
                        </span>
                        <h2>{{ __('gallery.cta_title') }}</h2>
                        <p>{{ __('gallery.cta_description') }}</p>
                    </div>

                    <a href="{{ route('contact', ['locale' => $currentLocale]) }}"
                       class="gallery-btn">
                        {{ __('gallery.contact_us') }}
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
            </div>
        </section>

    </main>
@endsection

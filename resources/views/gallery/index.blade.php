@extends('layouts.home')

@section('title', __('gallery.title'))

@section('styles')
    <link rel="stylesheet"
          href="{{ asset('css/gallery/gallery.css') }}?v=1"
          media="print"
          onload="this.media='all'">
@endsection

@section('content')

    <main class="gallery-page">

        {{-- Hero --}}
        <section class="gallery-hero">
            <div class="container">
                <div class="gallery-hero-content">

                <span class="gallery-hero-label">
                    {{ __('gallery.eyebrow') }}
                </span>

                    <h1>
                        {{ __('gallery.title') }}
                    </h1>

                    <p>
                        {{ __('gallery.description') }}
                    </p>

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

                    <h2>
                        {{ __('gallery.section_title') }}
                    </h2>

                    <p>
                        {{ __('gallery.section_description') }}
                    </p>

                </div>


                <div class="gallery-grid">

                    {{-- Item 1 --}}
                    <a href="{{ asset('img/gallery/gallery-1.webp') }}"
                       class="gallery-item"
                       target="_blank">

                        <img src="{{ asset('img/gallery/gallery-1.webp') }}"
                             alt="{{ __('gallery.items.item_1.title') }}"
                             loading="lazy">

                        <div class="gallery-overlay">

                            <div class="gallery-overlay-content">

                            <span class="gallery-category">
                                {{ __('gallery.items.item_1.category') }}
                            </span>

                                <h3>
                                    {{ __('gallery.items.item_1.title') }}
                                </h3>

                                <span class="gallery-view">
                                <i class="fas fa-expand"></i>
                                {{ __('gallery.view_image') }}
                            </span>

                            </div>

                        </div>

                    </a>


                    {{-- Item 2 --}}
                    <a href="{{ asset('img/gallery/gallery-2.webp') }}"
                       class="gallery-item"
                       target="_blank">

                        <img src="{{ asset('img/gallery/gallery-2.webp') }}"
                             alt="{{ __('gallery.items.item_2.title') }}"
                             loading="lazy">

                        <div class="gallery-overlay">

                            <div class="gallery-overlay-content">

                            <span class="gallery-category">
                                {{ __('gallery.items.item_2.category') }}
                            </span>

                                <h3>
                                    {{ __('gallery.items.item_2.title') }}
                                </h3>

                                <span class="gallery-view">
                                <i class="fas fa-expand"></i>
                                {{ __('gallery.view_image') }}
                            </span>

                            </div>

                        </div>

                    </a>


                    {{-- Item 3 --}}
                    <a href="{{ asset('img/gallery/gallery-3.webp') }}"
                       class="gallery-item"
                       target="_blank">

                        <img src="{{ asset('img/gallery/gallery-3.webp') }}"
                             alt="{{ __('gallery.items.item_3.title') }}"
                             loading="lazy">

                        <div class="gallery-overlay">

                            <div class="gallery-overlay-content">

                            <span class="gallery-category">
                                {{ __('gallery.items.item_3.category') }}
                            </span>

                                <h3>
                                    {{ __('gallery.items.item_3.title') }}
                                </h3>

                                <span class="gallery-view">
                                <i class="fas fa-expand"></i>
                                {{ __('gallery.view_image') }}
                            </span>

                            </div>

                        </div>

                    </a>


                    {{-- Item 4 --}}
                    <a href="{{ asset('img/gallery/gallery-4.webp') }}"
                       class="gallery-item"
                       target="_blank">

                        <img src="{{ asset('img/gallery/gallery-4.webp') }}"
                             alt="{{ __('gallery.items.item_4.title') }}"
                             loading="lazy">

                        <div class="gallery-overlay">

                            <div class="gallery-overlay-content">

                            <span class="gallery-category">
                                {{ __('gallery.items.item_4.category') }}
                            </span>

                                <h3>
                                    {{ __('gallery.items.item_4.title') }}
                                </h3>

                                <span class="gallery-view">
                                <i class="fas fa-expand"></i>
                                {{ __('gallery.view_image') }}
                            </span>

                            </div>

                        </div>

                    </a>


                    {{-- Item 5 --}}
                    <a href="{{ asset('img/gallery/gallery-5.webp') }}"
                       class="gallery-item"
                       target="_blank">

                        <img src="{{ asset('img/gallery/gallery-5.webp') }}"
                             alt="{{ __('gallery.items.item_5.title') }}"
                             loading="lazy">

                        <div class="gallery-overlay">

                            <div class="gallery-overlay-content">

                            <span class="gallery-category">
                                {{ __('gallery.items.item_5.category') }}
                            </span>

                                <h3>
                                    {{ __('gallery.items.item_5.title') }}
                                </h3>

                                <span class="gallery-view">
                                <i class="fas fa-expand"></i>
                                {{ __('gallery.view_image') }}
                            </span>

                            </div>

                        </div>

                    </a>


                    {{-- Item 6 --}}
                    <a href="{{ asset('img/gallery/gallery-6.webp') }}"
                       class="gallery-item"
                       target="_blank">

                        <img src="{{ asset('img/gallery/gallery-6.webp') }}"
                             alt="{{ __('gallery.items.item_6.title') }}"
                             loading="lazy">

                        <div class="gallery-overlay">

                            <div class="gallery-overlay-content">

                            <span class="gallery-category">
                                {{ __('gallery.items.item_6.category') }}
                            </span>

                                <h3>
                                    {{ __('gallery.items.item_6.title') }}
                                </h3>

                                <span class="gallery-view">
                                <i class="fas fa-expand"></i>
                                {{ __('gallery.view_image') }}
                            </span>

                            </div>

                        </div>

                    </a>

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

                        <h2>
                            {{ __('gallery.cta_title') }}
                        </h2>

                        <p>
                            {{ __('gallery.cta_description') }}
                        </p>
                    </div>

                    <a href=""
                       class="gallery-btn">

                        {{ __('gallery.contact_us') }}

                        <i class="fas fa-arrow-left"></i>

                    </a>

                </div>

            </div>

        </section>

    </main>

@endsection

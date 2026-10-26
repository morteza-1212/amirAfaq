@extends('layouts.home')

@section('title', __('export_products.title'))

@section('styles')
    <link rel="stylesheet"
          href="{{ asset('css/export/products.css') }}?v=1"
          media="print"
          onload="this.media='all'">
@endsection

@section('content')
    @php
        // زبان جاری
        $currentLocale = app()->getLocale();

        // زبان‌های پشتیبانی‌شده
        $supportedLocales = [
            'fa' => 'فارسی',
            'ar' => 'العربية',
            'en' => 'English',
        ];

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

    <main class="export-products-page">

        {{-- Hero Section --}}
        <section class="export-products-hero">

            <div class="container">

                <div class="export-products-hero-content">

                    <span class="export-products-eyebrow">
                        {{ __('export_products.eyebrow') }}
                    </span>

                    <h1>
                        {{ __('export_products.title') }}
                    </h1>

                    <p>
                        {{ __('export_products.description') }}
                    </p>

                </div>

            </div>

        </section>


        {{-- Products Section --}}
        <section class="export-products-section">
            <div class="container">

                {{-- Heading --}}
                <div class="section-heading">
            <span class="section-eyebrow">
                {{ __('export_products.products_eyebrow') }}
            </span>
                    <h2>{{ __('export_products.products_title') }}</h2>
                    <p>{{ __('export_products.products_description') }}</p>
                </div>

                {{-- Products Grid --}}
                <div class="export-products-grid">

                    @forelse($products as $product)
                        @php
                            // ترجمه زبان جاری با fallback
                            $t = $product->translation($currentLocale ?? app()->getLocale());
                        @endphp

                        @if(!$t)
                            @continue
                        @endif

                        <article class="export-product-card">

                            <div class="export-product-image">
                                @if($product->image)
                                    <img src="{{ $product->image_url }}"
                                         alt="{{ $t->name }}"
                                         loading="lazy">
                                @else
                                    <div class="no-image">
                                        <i class="fas fa-image"></i>
                                    </div>
                                @endif
                            </div>

                            <div class="export-product-content">

                                <h3>{{ $t->name }}</h3>

                                @if($t->short_description)
                                    <p>{{ \Illuminate\Support\Str::limit($t->short_description, 120) }}</p>
                                @endif

                                <a href="{{ route('productExport.show', ['locale' => $currentLocale, 'productExport' => $product->id]) }}"
                                   class="export-product-link">
                                    {{ __('export_products.view_product') }}
                                </a>
                            </div>

                        </article>

                    @empty
                        <div class="export-products-empty">
                            <i class="fas fa-box-open"></i>
                            <p>{{ __('export_products.empty') ?? 'هیچ محصولی یافت نشد.' }}</p>
                        </div>
                    @endforelse

                </div>

                {{-- Pagination --}}
                @if($products->hasPages())
                    <div class="export-products-pagination mt-4">
                        {{ $products->links() }}
                    </div>
                @endif

            </div>
        </section>

        {{-- Export CTA --}}
        <section class="export-products-cta">

            <div class="container">

                <div class="export-products-cta-content">

                    <h2>
                        {{ __('export_products.cta_title') }}
                    </h2>

                    <p>
                        {{ __('export_products.cta_description') }}
                    </p>

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

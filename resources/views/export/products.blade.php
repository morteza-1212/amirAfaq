@extends('layouts.home')

@section('title', __('export_products.title'))

@section('styles')
    <link rel="stylesheet"
          href="{{ asset('css/export/products.css') }}?v=1"
          media="print"
          onload="this.media='all'">
@endsection

@section('content')

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

                <div class="section-heading">

                    <span class="section-eyebrow">
                        {{ __('export_products.products_eyebrow') }}
                    </span>

                    <h2>
                        {{ __('export_products.products_title') }}
                    </h2>

                    <p>
                        {{ __('export_products.products_description') }}
                    </p>

                </div>


                <div class="export-products-grid">

                    {{-- Product 1 --}}
                    <article class="export-product-card">

                        <div class="export-product-image">
                            <img
                                src="{{ asset('images/export-products/product-1.jpg') }}"
                                alt="{{ __('export_products.product_1.title') }}"
                                loading="lazy"
                            >
                        </div>

                        <div class="export-product-content">

                            <h3>
                                {{ __('export_products.product_1.title') }}
                            </h3>

                            <p>
                                {{ __('export_products.product_1.description') }}
                            </p>

                            <a href="#"
                               class="export-product-link">
                                {{ __('export_products.view_product') }}
                            </a>

                        </div>

                    </article>


                    {{-- Product 2 --}}
                    <article class="export-product-card">

                        <div class="export-product-image">
                            <img
                                src="{{ asset('images/export-products/product-2.jpg') }}"
                                alt="{{ __('export_products.product_2.title') }}"
                                loading="lazy"
                            >
                        </div>

                        <div class="export-product-content">

                            <h3>
                                {{ __('export_products.product_2.title') }}
                            </h3>

                            <p>
                                {{ __('export_products.product_2.description') }}
                            </p>

                            <a href="#"
                               class="export-product-link">
                                {{ __('export_products.view_product') }}
                            </a>

                        </div>

                    </article>


                    {{-- Product 3 --}}
                    <article class="export-product-card">

                        <div class="export-product-image">
                            <img
                                src="{{ asset('images/export-products/product-3.jpg') }}"
                                alt="{{ __('export_products.product_3.title') }}"
                                loading="lazy"
                            >
                        </div>

                        <div class="export-product-content">

                            <h3>
                                {{ __('export_products.product_3.title') }}
                            </h3>

                            <p>
                                {{ __('export_products.product_3.description') }}
                            </p>

                            <a href="#"
                               class="export-product-link">
                                {{ __('export_products.view_product') }}
                            </a>

                        </div>

                    </article>


                    {{-- Product 4 --}}
                    <article class="export-product-card">

                        <div class="export-product-image">
                            <img
                                src="{{ asset('images/export-products/product-4.jpg') }}"
                                alt="{{ __('export_products.product_4.title') }}"
                                loading="lazy"
                            >
                        </div>

                        <div class="export-product-content">

                            <h3>
                                {{ __('export_products.product_4.title') }}
                            </h3>

                            <p>
                                {{ __('export_products.product_4.description') }}
                            </p>

                            <a href="#"
                               class="export-product-link">
                                {{ __('export_products.view_product') }}
                            </a>

                        </div>

                    </article>

                </div>

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

                    <a href=""
                       class="btn btn-primary">
                        {{ __('export_products.contact_us') }}
                    </a>

                </div>

            </div>

        </section>

    </main>

@endsection

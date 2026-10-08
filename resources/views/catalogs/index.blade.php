@extends('layouts.home')

@section('title', __('catalogs.page_title'))

@section('content')

    <div class="container py-5">

        {{-- Page Header --}}
        <div class="text-center mb-5">
            <h1 class="fw-bold">
                {{ __('catalogs.title') }}
            </h1>

            <p class="text-muted mt-3">
                {{ __('catalogs.description') }}
            </p>
        </div>


        {{-- Catalogs --}}
        <div class="row g-4">

            {{-- Company Profile --}}
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body text-center p-4">

                        <div class="mb-3">
                            <i class="bi bi-building fs-1"></i>
                        </div>

                        <h5 class="card-title">
                            {{ __('catalogs.company_profile') }}
                        </h5>

                        <p class="text-muted">
                            {{ __('catalogs.company_profile_description') }}
                        </p>

                        <a href="{{ asset('catalogs/company-profile.pdf') }}"
                           class="btn btn-primary"
                           target="_blank"
                           download>
                            <i class="bi bi-download me-1"></i>
                            {{ __('catalogs.download') }}
                        </a>

                    </div>
                </div>
            </div>


            {{-- Product Catalog --}}
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body text-center p-4">

                        <div class="mb-3">
                            <i class="bi bi-book fs-1"></i>
                        </div>

                        <h5 class="card-title">
                            {{ __('catalogs.product_catalog') }}
                        </h5>

                        <p class="text-muted">
                            {{ __('catalogs.product_catalog_description') }}
                        </p>

                        <a href="{{ asset('catalogs/product-catalog.pdf') }}"
                           class="btn btn-primary"
                           target="_blank"
                           download>
                            <i class="bi bi-download me-1"></i>
                            {{ __('catalogs.download') }}
                        </a>

                    </div>
                </div>
            </div>


            {{-- Agricultural Products --}}
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body text-center p-4">

                        <div class="mb-3">
                            <i class="bi bi-flower1 fs-1"></i>
                        </div>

                        <h5 class="card-title">
                            {{ __('catalogs.agricultural_catalog') }}
                        </h5>

                        <p class="text-muted">
                            {{ __('catalogs.agricultural_catalog_description') }}
                        </p>

                        <a href="{{ asset('catalogs/agricultural-products.pdf') }}"
                           class="btn btn-primary"
                           target="_blank"
                           download>
                            <i class="bi bi-download me-1"></i>
                            {{ __('catalogs.download') }}
                        </a>

                    </div>
                </div>
            </div>


            {{-- Industrial Products --}}
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body text-center p-4">

                        <div class="mb-3">
                            <i class="bi bi-gear-wide-connected fs-1"></i>
                        </div>

                        <h5 class="card-title">
                            {{ __('catalogs.industrial_catalog') }}
                        </h5>

                        <p class="text-muted">
                            {{ __('catalogs.industrial_catalog_description') }}
                        </p>

                        <a href="{{ asset('catalogs/industrial-products.pdf') }}"
                           class="btn btn-primary"
                           target="_blank"
                           download>
                            <i class="bi bi-download me-1"></i>
                            {{ __('catalogs.download') }}
                        </a>

                    </div>
                </div>
            </div>


            {{-- Export Catalog --}}
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body text-center p-4">

                        <div class="mb-3">
                            <i class="bi bi-globe2 fs-1"></i>
                        </div>

                        <h5 class="card-title">
                            {{ __('catalogs.export_catalog') }}
                        </h5>

                        <p class="text-muted">
                            {{ __('catalogs.export_catalog_description') }}
                        </p>

                        <a href="{{ asset('catalogs/export-catalog.pdf') }}"
                           class="btn btn-primary"
                           target="_blank"
                           download>
                            <i class="bi bi-download me-1"></i>
                            {{ __('catalogs.download') }}
                        </a>

                    </div>
                </div>
            </div>


            {{-- Certificates --}}
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body text-center p-4">

                        <div class="mb-3">
                            <i class="bi bi-patch-check fs-1"></i>
                        </div>

                        <h5 class="card-title">
                            {{ __('catalogs.certificates') }}
                        </h5>

                        <p class="text-muted">
                            {{ __('catalogs.certificates_description') }}
                        </p>

                        <a href="{{ asset('catalogs/certificates.pdf') }}"
                           class="btn btn-primary"
                           target="_blank"
                           download>
                            <i class="bi bi-download me-1"></i>
                            {{ __('catalogs.download') }}
                        </a>

                    </div>
                </div>
            </div>

        </div>


        {{-- Request Catalog Section --}}
        <div class="row justify-content-center mt-5">

            <div class="col-lg-8">

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4 p-lg-5 text-center">

                        <div class="mb-3">
                            <i class="bi bi-envelope-paper fs-1"></i>
                        </div>

                        <h3 class="fw-bold mb-3">
                            {{ __('catalogs.request_title') }}
                        </h3>

                        <p class="text-muted mb-4">
                            {{ __('catalogs.request_description') }}
                        </p>

                        <a href=""
                           class="btn btn-primary px-4">
                            <i class="bi bi-send me-1"></i>
                            {{ __('catalogs.request_button') }}
                        </a>

                    </div>
                </div>

            </div>

        </div>

    </div>

@endsection

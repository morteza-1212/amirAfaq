@extends('layouts.home')

@section('title', __('import_export_services.title'))

@section('styles')
    <link rel="stylesheet"
          href="{{ asset('css/services/services.css') }}?v=1"
          media="print"
          onload="this.media='all'">
@endsection

@section('content')

    <main class="import-export-page">

        {{-- =====================================================
             HERO
        ====================================================== --}}
        <section class="import-export-hero">

            <div class="container">

                <div class="import-export-hero-content">

                <span class="import-export-hero-label">
                    {{ __('import_export_services.eyebrow') }}
                </span>

                    <h1>
                        {{ __('import_export_services.title') }}
                    </h1>

                    <p>
                        {{ __('import_export_services.description') }}
                    </p>

                    <div class="import-export-hero-actions">

                        <a href="#services" class="import-export-btn">
                            {{ __('import_export_services.view_services') }}

                            <i class="fas fa-arrow-down"></i>
                        </a>

                        <a href=""
                           class="import-export-btn import-export-btn-outline">
                            {{ __('import_export_services.contact_us') }}
                        </a>

                    </div>

                </div>

            </div>

        </section>


        {{-- =====================================================
             INTRO
        ====================================================== --}}
        <section class="import-export-intro">

            <div class="container">

                <div class="import-export-intro-grid">

                    <div class="import-export-intro-content">

                    <span class="import-export-section-label">
                        {{ __('import_export_services.intro_eyebrow') }}
                    </span>

                        <h2>
                            {{ __('import_export_services.intro_title') }}
                        </h2>

                        <p>
                            {{ __('import_export_services.intro_description') }}
                        </p>

                    </div>


                    <div class="import-export-stat-box">

                        <div class="import-export-stat-icon">
                            <i class="fas fa-globe"></i>
                        </div>

                        <strong>
                            {{ __('import_export_services.stat_title') }}
                        </strong>

                        <span>
                        {{ __('import_export_services.stat_description') }}
                    </span>

                    </div>

                </div>

            </div>

        </section>


        {{-- =====================================================
             SERVICES
        ====================================================== --}}
        <section class="import-export-services" id="services">

            <div class="container">

                <div class="import-export-heading">

                <span class="import-export-section-label">
                    {{ __('import_export_services.services_eyebrow') }}
                </span>

                    <h2>
                        {{ __('import_export_services.services_title') }}
                    </h2>

                    <p>
                        {{ __('import_export_services.services_description') }}
                    </p>

                </div>


                <div class="import-export-grid">


                    {{-- Service 1 --}}
                    <article class="import-export-card">

                        <div class="import-export-card-top">

                        <span class="import-export-card-number">
                            01
                        </span>

                            <div class="import-export-card-icon">
                                <i class="fas fa-arrow-up-right-dots"></i>
                            </div>

                        </div>

                        <h3>
                            {{ __('import_export_services.export.title') }}
                        </h3>

                        <p>
                            {{ __('import_export_services.export.description') }}
                        </p>

                        <ul>

                            <li>
                                <i class="fas fa-check"></i>
                                {{ __('import_export_services.export.item_1') }}
                            </li>

                            <li>
                                <i class="fas fa-check"></i>
                                {{ __('import_export_services.export.item_2') }}
                            </li>

                            <li>
                                <i class="fas fa-check"></i>
                                {{ __('import_export_services.export.item_3') }}
                            </li>

                        </ul>

                    </article>


                    {{-- Service 2 --}}
                    <article class="import-export-card">

                        <div class="import-export-card-top">

                        <span class="import-export-card-number">
                            02
                        </span>

                            <div class="import-export-card-icon">
                                <i class="fas fa-arrow-down"></i>
                            </div>

                        </div>

                        <h3>
                            {{ __('import_export_services.import.title') }}
                        </h3>

                        <p>
                            {{ __('import_export_services.import.description') }}
                        </p>

                        <ul>

                            <li>
                                <i class="fas fa-check"></i>
                                {{ __('import_export_services.import.item_1') }}
                            </li>

                            <li>
                                <i class="fas fa-check"></i>
                                {{ __('import_export_services.import.item_2') }}
                            </li>

                            <li>
                                <i class="fas fa-check"></i>
                                {{ __('import_export_services.import.item_3') }}
                            </li>

                        </ul>

                    </article>


                    {{-- Service 3 --}}
                    <article class="import-export-card">

                        <div class="import-export-card-top">

                        <span class="import-export-card-number">
                            03
                        </span>

                            <div class="import-export-card-icon">
                                <i class="fas fa-file-signature"></i>
                            </div>

                        </div>

                        <h3>
                            {{ __('import_export_services.documentation.title') }}
                        </h3>

                        <p>
                            {{ __('import_export_services.documentation.description') }}
                        </p>

                        <ul>

                            <li>
                                <i class="fas fa-check"></i>
                                {{ __('import_export_services.documentation.item_1') }}
                            </li>

                            <li>
                                <i class="fas fa-check"></i>
                                {{ __('import_export_services.documentation.item_2') }}
                            </li>

                            <li>
                                <i class="fas fa-check"></i>
                                {{ __('import_export_services.documentation.item_3') }}
                            </li>

                        </ul>

                    </article>


                    {{-- Service 4 --}}
                    <article class="import-export-card">

                        <div class="import-export-card-top">

                        <span class="import-export-card-number">
                            04
                        </span>

                            <div class="import-export-card-icon">
                                <i class="fas fa-ship"></i>
                            </div>

                        </div>

                        <h3>
                            {{ __('import_export_services.logistics.title') }}
                        </h3>

                        <p>
                            {{ __('import_export_services.logistics.description') }}
                        </p>

                        <ul>

                            <li>
                                <i class="fas fa-check"></i>
                                {{ __('import_export_services.logistics.item_1') }}
                            </li>

                            <li>
                                <i class="fas fa-check"></i>
                                {{ __('import_export_services.logistics.item_2') }}
                            </li>

                            <li>
                                <i class="fas fa-check"></i>
                                {{ __('import_export_services.logistics.item_3') }}
                            </li>

                        </ul>

                    </article>


                    {{-- Service 5 --}}
                    <article class="import-export-card">

                        <div class="import-export-card-top">

                        <span class="import-export-card-number">
                            05
                        </span>

                            <div class="import-export-card-icon">
                                <i class="fas fa-handshake"></i>
                            </div>

                        </div>

                        <h3>
                            {{ __('import_export_services.sourcing.title') }}
                        </h3>

                        <p>
                            {{ __('import_export_services.sourcing.description') }}
                        </p>

                        <ul>

                            <li>
                                <i class="fas fa-check"></i>
                                {{ __('import_export_services.sourcing.item_1') }}
                            </li>

                            <li>
                                <i class="fas fa-check"></i>
                                {{ __('import_export_services.sourcing.item_2') }}
                            </li>

                            <li>
                                <i class="fas fa-check"></i>
                                {{ __('import_export_services.sourcing.item_3') }}
                            </li>

                        </ul>

                    </article>


                    {{-- Service 6 --}}
                    <article class="import-export-card">

                        <div class="import-export-card-top">

                        <span class="import-export-card-number">
                            06
                        </span>

                            <div class="import-export-card-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>

                        </div>

                        <h3>
                            {{ __('import_export_services.market.title') }}
                        </h3>

                        <p>
                            {{ __('import_export_services.market.description') }}
                        </p>

                        <ul>

                            <li>
                                <i class="fas fa-check"></i>
                                {{ __('import_export_services.market.item_1') }}
                            </li>

                            <li>
                                <i class="fas fa-check"></i>
                                {{ __('import_export_services.market.item_2') }}
                            </li>

                            <li>
                                <i class="fas fa-check"></i>
                                {{ __('import_export_services.market.item_3') }}
                            </li>

                        </ul>

                    </article>

                </div>

            </div>

        </section>


        {{-- =====================================================
             PROCESS
        ====================================================== --}}
        <section class="import-export-process">

            <div class="container">

                <div class="import-export-heading import-export-heading-light">

                <span class="import-export-section-label">
                    {{ __('import_export_services.process_eyebrow') }}
                </span>

                    <h2>
                        {{ __('import_export_services.process_title') }}
                    </h2>

                    <p>
                        {{ __('import_export_services.process_description') }}
                    </p>

                </div>


                <div class="import-export-process-grid">

                    <div class="import-export-process-item">

                        <span>01</span>

                        <div>
                            <i class="fas fa-magnifying-glass"></i>

                            <h3>
                                {{ __('import_export_services.process.step_1_title') }}
                            </h3>

                            <p>
                                {{ __('import_export_services.process.step_1_description') }}
                            </p>
                        </div>

                    </div>


                    <div class="import-export-process-item">

                        <span>02</span>

                        <div>
                            <i class="fas fa-file-circle-check"></i>

                            <h3>
                                {{ __('import_export_services.process.step_2_title') }}
                            </h3>

                            <p>
                                {{ __('import_export_services.process.step_2_description') }}
                            </p>
                        </div>

                    </div>


                    <div class="import-export-process-item">

                        <span>03</span>

                        <div>
                            <i class="fas fa-box-open"></i>

                            <h3>
                                {{ __('import_export_services.process.step_3_title') }}
                            </h3>

                            <p>
                                {{ __('import_export_services.process.step_3_description') }}
                            </p>
                        </div>

                    </div>


                    <div class="import-export-process-item">

                        <span>04</span>

                        <div>
                            <i class="fas fa-location-dot"></i>

                            <h3>
                                {{ __('import_export_services.process.step_4_title') }}
                            </h3>

                            <p>
                                {{ __('import_export_services.process.step_4_description') }}
                            </p>
                        </div>

                    </div>

                </div>

            </div>

        </section>


        {{-- =====================================================
             CTA
        ====================================================== --}}
        <section class="import-export-cta">

            <div class="container">

                <div class="import-export-cta-box">

                    <div>

                    <span class="import-export-section-label">
                        {{ __('import_export_services.cta_eyebrow') }}
                    </span>

                        <h2>
                            {{ __('import_export_services.cta_title') }}
                        </h2>

                        <p>
                            {{ __('import_export_services.cta_description') }}
                        </p>

                    </div>

                    <a href=""
                       class="import-export-btn">

                        {{ __('import_export_services.contact_us') }}

                        <i class="fas fa-arrow-left"></i>

                    </a>

                </div>

            </div>

        </section>

    </main>

@endsection

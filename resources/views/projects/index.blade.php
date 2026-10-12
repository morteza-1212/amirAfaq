@extends('layouts.home')

@section('title', __('projects.title'))

@section('styles')
    <link rel="stylesheet"
          href="{{ asset('css/projects/projects.css') }}?v=1"
          media="print"
          onload="this.media='all'">
@endsection

@section('content')

    <main class="projects-page">

        {{-- =====================================================
             HERO
        ====================================================== --}}
        <section class="projects-hero">

            <div class="container">

                <div class="projects-hero-content">

                <span class="projects-hero-label">
                    {{ __('projects.eyebrow') }}
                </span>

                    <h1>
                        {{ __('projects.title') }}
                    </h1>

                    <p>
                        {{ __('projects.description') }}
                    </p>

                </div>

            </div>

        </section>


        {{-- =====================================================
             INTRO
        ====================================================== --}}
        <section class="projects-intro">

            <div class="container">

                <div class="projects-intro-grid">

                    <div class="projects-intro-content">

                    <span class="projects-section-label">
                        {{ __('projects.intro_eyebrow') }}
                    </span>

                        <h2>
                            {{ __('projects.intro_title') }}
                        </h2>

                        <p>
                            {{ __('projects.intro_description') }}
                        </p>

                    </div>

                    <div class="projects-intro-badge">

                        <div class="projects-badge-icon">
                            <i class="fas fa-handshake"></i>
                        </div>

                        <strong>
                            {{ __('projects.trust_title') }}
                        </strong>

                        <span>
                        {{ __('projects.trust_description') }}
                    </span>

                    </div>

                </div>

            </div>

        </section>


        {{-- =====================================================
             PROJECTS
        ====================================================== --}}
        <section class="projects-section">

            <div class="container">

                <div class="projects-heading">

                <span class="projects-section-label">
                    {{ __('projects.projects_eyebrow') }}
                </span>

                    <h2>
                        {{ __('projects.projects_title') }}
                    </h2>

                    <p>
                        {{ __('projects.projects_description') }}
                    </p>

                </div>


                <div class="projects-grid">


                    {{-- Project 1 --}}
                    <article class="project-card">

                        <div class="project-card-top">

                            <div class="project-number">
                                01
                            </div>

                            <span class="project-status">
                            {{ __('projects.completed') }}
                        </span>

                        </div>


                        <div class="project-card-icon">
                            <i class="fas fa-boxes-stacked"></i>
                        </div>


                        <h3>
                            {{ __('projects.project_1.title') }}
                        </h3>


                        <div class="project-destination">
                            <i class="fas fa-location-dot"></i>

                            <span>
                            {{ __('projects.project_1.destination') }}
                        </span>
                        </div>


                        <div class="project-details">

                            <div class="project-detail">
                            <span>
                                <i class="fas fa-box"></i>
                                {{ __('projects.product') }}
                            </span>

                                <strong>
                                    {{ __('projects.project_1.product') }}
                                </strong>
                            </div>


                            <div class="project-detail">
                            <span>
                                <i class="fas fa-weight-hanging"></i>
                                {{ __('projects.quantity') }}
                            </span>

                                <strong>
                                    {{ __('projects.project_1.quantity') }}
                                </strong>
                            </div>


                            <div class="project-detail">
                            <span>
                                <i class="fas fa-cube"></i>
                                {{ __('projects.packaging') }}
                            </span>

                                <strong>
                                    {{ __('projects.project_1.packaging') }}
                                </strong>
                            </div>


                            <div class="project-detail">
                            <span>
                                <i class="fas fa-truck"></i>
                                {{ __('projects.transport') }}
                            </span>

                                <strong>
                                    {{ __('projects.project_1.transport') }}
                                </strong>
                            </div>


                            <div class="project-detail">
                            <span>
                                <i class="fas fa-clock"></i>
                                {{ __('projects.delivery_time') }}
                            </span>

                                <strong>
                                    {{ __('projects.project_1.delivery') }}
                                </strong>
                            </div>

                        </div>

                    </article>


                    {{-- Project 2 --}}
                    <article class="project-card">

                        <div class="project-card-top">

                            <div class="project-number">
                                02
                            </div>

                            <span class="project-status">
                            {{ __('projects.completed') }}
                        </span>

                        </div>


                        <div class="project-card-icon">
                            <i class="fas fa-seedling"></i>
                        </div>


                        <h3>
                            {{ __('projects.project_2.title') }}
                        </h3>


                        <div class="project-destination">
                            <i class="fas fa-location-dot"></i>

                            <span>
                            {{ __('projects.project_2.destination') }}
                        </span>
                        </div>


                        <div class="project-details">

                            <div class="project-detail">
                            <span>
                                <i class="fas fa-box"></i>
                                {{ __('projects.product') }}
                            </span>

                                <strong>
                                    {{ __('projects.project_2.product') }}
                                </strong>
                            </div>


                            <div class="project-detail">
                            <span>
                                <i class="fas fa-weight-hanging"></i>
                                {{ __('projects.quantity') }}
                            </span>

                                <strong>
                                    {{ __('projects.project_2.quantity') }}
                                </strong>
                            </div>


                            <div class="project-detail">
                            <span>
                                <i class="fas fa-cube"></i>
                                {{ __('projects.packaging') }}
                            </span>

                                <strong>
                                    {{ __('projects.project_2.packaging') }}
                                </strong>
                            </div>


                            <div class="project-detail">
                            <span>
                                <i class="fas fa-truck"></i>
                                {{ __('projects.transport') }}
                            </span>

                                <strong>
                                    {{ __('projects.project_2.transport') }}
                                </strong>
                            </div>


                            <div class="project-detail">
                            <span>
                                <i class="fas fa-clock"></i>
                                {{ __('projects.delivery_time') }}
                            </span>

                                <strong>
                                    {{ __('projects.project_2.delivery') }}
                                </strong>
                            </div>

                        </div>

                    </article>


                    {{-- Project 3 --}}
                    <article class="project-card">

                        <div class="project-card-top">

                            <div class="project-number">
                                03
                            </div>

                            <span class="project-status">
                            {{ __('projects.completed') }}
                        </span>

                        </div>


                        <div class="project-card-icon">
                            <i class="fas fa-lemon"></i>
                        </div>


                        <h3>
                            {{ __('projects.project_3.title') }}
                        </h3>


                        <div class="project-destination">
                            <i class="fas fa-location-dot"></i>

                            <span>
                            {{ __('projects.project_3.destination') }}
                        </span>
                        </div>


                        <div class="project-details">

                            <div class="project-detail">
                            <span>
                                <i class="fas fa-box"></i>
                                {{ __('projects.product') }}
                            </span>

                                <strong>
                                    {{ __('projects.project_3.product') }}
                                </strong>
                            </div>


                            <div class="project-detail">
                            <span>
                                <i class="fas fa-weight-hanging"></i>
                                {{ __('projects.quantity') }}
                            </span>

                                <strong>
                                    {{ __('projects.project_3.quantity') }}
                                </strong>
                            </div>


                            <div class="project-detail">
                            <span>
                                <i class="fas fa-cube"></i>
                                {{ __('projects.packaging') }}
                            </span>

                                <strong>
                                    {{ __('projects.project_3.packaging') }}
                                </strong>
                            </div>


                            <div class="project-detail">
                            <span>
                                <i class="fas fa-truck"></i>
                                {{ __('projects.transport') }}
                            </span>

                                <strong>
                                    {{ __('projects.project_3.transport') }}
                                </strong>
                            </div>


                            <div class="project-detail">
                            <span>
                                <i class="fas fa-clock"></i>
                                {{ __('projects.delivery_time') }}
                            </span>

                                <strong>
                                    {{ __('projects.project_3.delivery') }}
                                </strong>
                            </div>

                        </div>

                    </article>


                    {{-- Project 4 --}}
                    <article class="project-card">

                        <div class="project-card-top">

                            <div class="project-number">
                                04
                            </div>

                            <span class="project-status">
                            {{ __('projects.completed') }}
                        </span>

                        </div>


                        <div class="project-card-icon">
                            <i class="fas fa-globe"></i>
                        </div>


                        <h3>
                            {{ __('projects.project_4.title') }}
                        </h3>


                        <div class="project-destination">
                            <i class="fas fa-location-dot"></i>

                            <span>
                            {{ __('projects.project_4.destination') }}
                        </span>
                        </div>


                        <div class="project-details">

                            <div class="project-detail">
                            <span>
                                <i class="fas fa-box"></i>
                                {{ __('projects.product') }}
                            </span>

                                <strong>
                                    {{ __('projects.project_4.product') }}
                                </strong>
                            </div>


                            <div class="project-detail">
                            <span>
                                <i class="fas fa-weight-hanging"></i>
                                {{ __('projects.quantity') }}
                            </span>

                                <strong>
                                    {{ __('projects.project_4.quantity') }}
                                </strong>
                            </div>


                            <div class="project-detail">
                            <span>
                                <i class="fas fa-cube"></i>
                                {{ __('projects.packaging') }}
                            </span>

                                <strong>
                                    {{ __('projects.project_4.packaging') }}
                                </strong>
                            </div>


                            <div class="project-detail">
                            <span>
                                <i class="fas fa-truck"></i>
                                {{ __('projects.transport') }}
                            </span>

                                <strong>
                                    {{ __('projects.project_4.transport') }}
                                </strong>
                            </div>


                            <div class="project-detail">
                            <span>
                                <i class="fas fa-clock"></i>
                                {{ __('projects.delivery_time') }}
                            </span>

                                <strong>
                                    {{ __('projects.project_4.delivery') }}
                                </strong>
                            </div>

                        </div>

                    </article>


                </div>

            </div>

        </section>


        {{-- =====================================================
             CONFIDENTIALITY
        ====================================================== --}}
        <section class="projects-confidentiality">

            <div class="container">

                <div class="confidentiality-box">

                    <div class="confidentiality-icon">
                        <i class="fas fa-shield-halved"></i>
                    </div>

                    <div class="confidentiality-content">

                    <span class="projects-section-label">
                        {{ __('projects.confidentiality_eyebrow') }}
                    </span>

                        <h2>
                            {{ __('projects.confidentiality_title') }}
                        </h2>

                        <p>
                            {{ __('projects.confidentiality_description') }}
                        </p>

                    </div>

                </div>

            </div>

        </section>


        {{-- =====================================================
             CTA
        ====================================================== --}}
        <section class="projects-cta">

            <div class="container">

                <div class="projects-cta-box">

                    <div>

                    <span class="projects-section-label">
                        {{ __('projects.cta_eyebrow') }}
                    </span>

                        <h2>
                            {{ __('projects.cta_title') }}
                        </h2>

                        <p>
                            {{ __('projects.cta_description') }}
                        </p>

                    </div>

                    <a href=""
                       class="projects-btn">

                        {{ __('projects.contact_us') }}

                        <i class="fas fa-arrow-left"></i>

                    </a>

                </div>

            </div>

        </section>

    </main>

@endsection

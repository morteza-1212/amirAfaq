
@extends('panelAdmin.layouts.panel')

@section('title', 'مدیریت گروه‌های محصول')

@section('style')
    <style>
        /* =========================================================
           PRODUCT GROUPS ADMIN
           Responsive: 320px → 1920px+
        ========================================================= */

        :root {
            --pg-primary: #2563eb;
            --pg-primary-dark: #1d4ed8;
            --pg-primary-soft: #eff6ff;

            --pg-success: #16a34a;
            --pg-success-soft: #f0fdf4;

            --pg-danger: #dc2626;
            --pg-danger-soft: #fef2f2;

            --pg-warning: #d97706;
            --pg-warning-soft: #fffbeb;

            --pg-text: #111827;
            --pg-text-soft: #4b5563;
            --pg-muted: #6b7280;

            --pg-border: #e5e7eb;
            --pg-border-light: #f3f4f6;

            --pg-bg: #f8fafc;
            --pg-card: #ffffff;

            --pg-radius-sm: 8px;
            --pg-radius: 12px;
            --pg-radius-lg: 16px;

            --pg-shadow-sm:
                0 1px 2px rgba(15, 23, 42, .04);

            --pg-shadow:
                0 4px 12px rgba(15, 23, 42, .06);

            --pg-shadow-md:
                0 8px 24px rgba(15, 23, 42, .08);

            --pg-transition:
                180ms cubic-bezier(.4, 0, .2, 1);
        }

        /* =========================================================
           PAGE
        ========================================================= */

        .pg-page {
            min-height: 100vh;
            background:
                radial-gradient(
                    circle at top right,
                    rgba(37, 99, 235, .035),
                    transparent 30%
                ),
                linear-gradient(
                    180deg,
                    #f8fafc 0%,
                    #f1f5f9 100%
                );

            color: var(--pg-text);
        }

        .pg-container {
            width: min(100% - 24px, 1440px);
            margin-inline: auto;
            padding-block: 20px 32px;
        }

        /* =========================================================
           HEADER
        ========================================================= */

        .pg-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 22px;
        }

        .pg-title-wrapper {
            min-width: 0;
        }

        .pg-title {
            display: flex;
            align-items: center;
            gap: 12px;

            margin: 0;

            font-size: 1.5rem;
            font-weight: 800;
            line-height: 1.5;

            color: #111827;
        }

        .pg-title-icon {
            width: 44px;
            height: 44px;

            flex: 0 0 44px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border-radius: 12px;

            background:
                linear-gradient(
                    135deg,
                    #eff6ff,
                    #dbeafe
                );

            color: var(--pg-primary);

            box-shadow:
                inset 0 0 0 1px rgba(37, 99, 235, .08);

            transition: var(--pg-transition);
        }

        .pg-title:hover .pg-title-icon {
            transform: translateY(-2px) rotate(-2deg);
            box-shadow:
                0 8px 18px rgba(37, 99, 235, .12);
        }

        .pg-subtitle {
            margin: 5px 0 0;
            padding-right: 56px;

            color: var(--pg-muted);

            font-size: .875rem;
            line-height: 1.8;
        }

        /* =========================================================
           PRIMARY BUTTON
        ========================================================= */

        .pg-primary-btn {
            position: relative;
            overflow: hidden;

            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;

            min-height: 44px;

            padding: 0 18px;

            border-radius: 10px;

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #1d4ed8
                );

            color: #fff;

            font-size: .875rem;
            font-weight: 700;

            text-decoration: none;

            box-shadow:
                0 5px 14px rgba(37, 99, 235, .20);

            transition: var(--pg-transition);
        }

        .pg-primary-btn::before {
            content: "";

            position: absolute;
            inset: 0;

            background:
                linear-gradient(
                    110deg,
                    transparent 30%,
                    rgba(255,255,255,.25) 50%,
                    transparent 70%
                );

            transform: translateX(-120%);
            transition: transform .55s ease;
        }

        .pg-primary-btn:hover::before {
            transform: translateX(120%);
        }

        .pg-primary-btn:hover {
            transform: translateY(-2px);
            box-shadow:
                0 9px 22px rgba(37, 99, 235, .28);
        }

        .pg-primary-btn:active {
            transform: translateY(0);
        }

        /* =========================================================
           ALERT
        ========================================================= */

        .pg-alert {
            display: flex;
            align-items: flex-start;
            gap: 11px;

            padding: 13px 15px;

            margin-bottom: 18px;

            border-radius: var(--pg-radius);

            font-size: .875rem;
            line-height: 1.8;

            animation: pgAlert .35s ease both;
        }

        .pg-alert-success {
            color: #166534;
            background: var(--pg-success-soft);
            border: 1px solid #bbf7d0;
        }

        .pg-alert-error {
            color: #991b1b;
            background: var(--pg-danger-soft);
            border: 1px solid #fecaca;
        }

        .pg-alert svg {
            flex: 0 0 auto;
            margin-top: 2px;
        }

        @keyframes pgAlert {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* =========================================================
           FILTER CARD
        ========================================================= */

        .pg-filter-card {
            background: var(--pg-card);

            border: 1px solid var(--pg-border);

            border-radius: var(--pg-radius-lg);

            padding: 18px;

            margin-bottom: 20px;

            box-shadow: var(--pg-shadow-sm);
        }

        .pg-filter-grid {
            display: grid;

            grid-template-columns:
        minmax(220px, 1.5fr)
        minmax(150px, 1fr)
        minmax(150px, 1fr)
        auto;

            gap: 14px;

            align-items: end;
        }

        .pg-field {
            min-width: 0;
        }

        .pg-label {
            display: block;

            margin-bottom: 7px;

            color: #374151;

            font-size: .8rem;
            font-weight: 700;
        }

        .pg-input,
        .pg-select {
            width: 100%;

            min-height: 44px;

            padding: 0 12px;

            border: 1px solid #d1d5db;
            border-radius: 9px;

            background: #fff;

            color: #111827;

            font-family: inherit;
            font-size: .875rem;

            outline: none;

            transition: var(--pg-transition);
        }

        .pg-input::placeholder {
            color: #9ca3af;
        }

        .pg-input:hover,
        .pg-select:hover {
            border-color: #9ca3af;
        }

        .pg-input:focus,
        .pg-select:focus {
            border-color: var(--pg-primary);

            box-shadow:
                0 0 0 3px rgba(37, 99, 235, .10);
        }

        .pg-search-wrapper {
            position: relative;
        }

        .pg-search-wrapper .pg-input {
            padding-right: 40px;
        }

        .pg-search-icon {
            position: absolute;

            right: 13px;
            top: 50%;

            transform: translateY(-50%);

            color: #9ca3af;

            pointer-events: none;
        }

        .pg-select {
            appearance: none;

            padding-left: 38px;

            background-image:
                url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3E%3C/svg%3E");

            background-repeat: no-repeat;
            background-size: 18px;
            background-position: left 10px center;
        }

        /* =========================================================
           FILTER BUTTONS
        ========================================================= */

        .pg-filter-actions {
            display: flex;
            gap: 8px;
        }

        .pg-filter-btn,
        .pg-reset-btn {
            min-height: 44px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border-radius: 9px;

            cursor: pointer;

            font-family: inherit;
            font-size: .875rem;
            font-weight: 700;

            transition: var(--pg-transition);
        }

        .pg-filter-btn {
            gap: 8px;

            min-width: 110px;

            padding: 0 16px;

            border: 0;

            background: #1f2937;
            color: #fff;

            box-shadow: var(--pg-shadow-sm);
        }

        .pg-filter-btn:hover {
            background: #111827;
            transform: translateY(-1px);
            box-shadow: var(--pg-shadow);
        }

        .pg-reset-btn {
            width: 44px;

            border: 1px solid var(--pg-border);

            background: #f9fafb;
            color: #4b5563;

            text-decoration: none;
        }

        .pg-reset-btn:hover {
            background: #f3f4f6;
            color: #111827;

            transform: rotate(-45deg);
        }

        /* =========================================================
           TABLE CARD
        ========================================================= */

        .pg-table-card {
            overflow: hidden;

            background: #fff;

            border: 1px solid var(--pg-border);

            border-radius: var(--pg-radius-lg);

            box-shadow: var(--pg-shadow-sm);
        }

        .pg-table-scroll {
            width: 100%;

            overflow-x: auto;

            scrollbar-width: thin;
        }

        .pg-table {
            width: 100%;

            min-width: 850px;

            border-collapse: separate;
            border-spacing: 0;
        }

        .pg-table thead th {
            padding: 14px 16px;

            background:
                linear-gradient(
                    180deg,
                    #f8fafc,
                    #f1f5f9
                );

            border-bottom: 1px solid var(--pg-border);

            color: #475569;

            font-size: .75rem;
            font-weight: 800;

            white-space: nowrap;
        }

        .pg-table tbody td {
            padding: 13px 16px;

            border-bottom: 1px solid #f1f5f9;

            vertical-align: middle;

            font-size: .875rem;
        }

        .pg-table tbody tr:last-child td {
            border-bottom: 0;
        }

        .pg-table tbody tr {
            transition: background .15s ease;
        }

        .pg-table tbody tr:hover {
            background: #f8fbff;
        }

        /* =========================================================
           PRODUCT IMAGE
        ========================================================= */

        .pg-image {
            width: 44px;
            height: 44px;

            object-fit: cover;

            border-radius: 9px;

            border: 1px solid var(--pg-border);

            box-shadow: var(--pg-shadow-sm);

            transition: var(--pg-transition);
        }

        .pg-table tbody tr:hover .pg-image {
            transform: scale(1.06);
        }

        .pg-image-placeholder {
            width: 44px;
            height: 44px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 9px;

            border: 1px solid var(--pg-border);

            background:
                linear-gradient(
                    135deg,
                    #f3f4f6,
                    #e5e7eb
                );

            color: #9ca3af;
        }

        /* =========================================================
           TYPE BADGES
        ========================================================= */

        .pg-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            padding: 5px 9px;

            border-radius: 7px;

            border: 1px solid;

            font-size: .72rem;
            font-weight: 700;

            white-space: nowrap;
        }

        .pg-badge-green {
            background: #f0fdf4;
            color: #15803d;
            border-color: #bbf7d0;
        }

        .pg-badge-blue {
            background: #eff6ff;
            color: #1d4ed8;
            border-color: #bfdbfe;
        }

        .pg-badge-amber {
            background: #fffbeb;
            color: #b45309;
            border-color: #fde68a;
        }

        /* =========================================================
           STATUS
        ========================================================= */

        .pg-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;

            padding: 5px 9px;

            border-radius: 999px;

            font-size: .72rem;
            font-weight: 700;
        }

        .pg-status-dot {
            width: 6px;
            height: 6px;

            border-radius: 50%;
        }

        .pg-status-active {
            background: #f0fdf4;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        .pg-status-active .pg-status-dot {
            background: #22c55e;
        }

        .pg-status-inactive {
            background: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

        .pg-status-inactive .pg-status-dot {
            background: #ef4444;
        }

        /* =========================================================
           SORT
        ========================================================= */

        .pg-sort {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            min-width: 34px;

            padding: 4px 8px;

            border-radius: 7px;

            background: #f3f4f6;

            color: #4b5563;

            font-size: .75rem;
            font-weight: 700;
        }

        /* =========================================================
           FEATURED
        ========================================================= */

        .pg-featured {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            width: 32px;
            height: 32px;

            border-radius: 50%;

            background: #fffbeb;

            color: #eab308;

            transition: var(--pg-transition);
        }

        .pg-featured:hover {
            transform: scale(1.08);
        }

        /* =========================================================
           ACTIONS
        ========================================================= */

        .pg-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .pg-action {
            width: 36px;
            height: 36px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border-radius: 8px;

            border: 0;

            cursor: pointer;

            transition: var(--pg-transition);
        }

        .pg-action-edit {
            color: #2563eb;
            background: transparent;
        }

        .pg-action-edit:hover {
            background: #eff6ff;
            transform: translateY(-2px);
        }

        .pg-action-delete {
            color: #dc2626;
            background: transparent;
        }

        .pg-action-delete:hover {
            background: #fef2f2;
            transform: translateY(-2px);
        }

        /* =========================================================
           EMPTY
        ========================================================= */

        .pg-empty {
            padding: 65px 20px;

            text-align: center;

            color: #6b7280;
        }

        .pg-empty-icon {
            width: 72px;
            height: 72px;

            margin: 0 auto 14px;

            color: #d1d5db;

            animation: pgFloat 3s ease-in-out infinite;
        }

        .pg-empty-text {
            margin: 0 0 12px;

            font-size: .875rem;
        }

        .pg-empty-link {
            color: var(--pg-primary);

            font-size: .875rem;
            font-weight: 700;

            text-decoration: none;
        }

        .pg-empty-link:hover {
            color: var(--pg-primary-dark);
        }

        /* =========================================================
           MOBILE CARDS
        ========================================================= */

        .pg-mobile-list {
            display: none;

            gap: 12px;
        }

        .pg-mobile-card {
            overflow: hidden;

            background: #fff;

            border: 1px solid var(--pg-border);

            border-radius: var(--pg-radius-lg);

            box-shadow: var(--pg-shadow-sm);

            transition: var(--pg-transition);
        }

        .pg-mobile-card:hover {
            transform: translateY(-2px);

            border-color: #dbeafe;

            box-shadow: var(--pg-shadow-md);
        }

        .pg-mobile-main {
            display: flex;

            gap: 12px;

            padding: 15px;
        }

        .pg-mobile-image {
            flex: 0 0 auto;
        }

        .pg-mobile-content {
            min-width: 0;
            flex: 1;
        }

        .pg-mobile-title-row {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;

            gap: 8px;
        }

        .pg-mobile-code {
            min-width: 0;

            margin: 0;

            overflow: hidden;

            color: #111827;

            font-size: .9rem;
            font-weight: 800;

            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .pg-mobile-meta {
            display: flex;
            flex-wrap: wrap;

            gap: 6px;

            margin-top: 9px;
        }

        .pg-mobile-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;

            border-top: 1px solid #f1f5f9;
        }

        .pg-mobile-action {
            min-height: 46px;

            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;

            border: 0;

            background: transparent;

            font-family: inherit;

            font-size: .82rem;
            font-weight: 700;

            cursor: pointer;

            transition: var(--pg-transition);
        }

        .pg-mobile-action + .pg-mobile-action {
            border-right: 1px solid #f1f5f9;
        }

        .pg-mobile-edit {
            color: #2563eb;
        }

        .pg-mobile-edit:hover {
            background: #eff6ff;
        }

        .pg-mobile-delete {
            color: #dc2626;
        }

        .pg-mobile-delete:hover {
            background: #fef2f2;
        }

        /* =========================================================
           PAGINATION
        ========================================================= */

        .pg-pagination {
            padding: 14px 16px;

            border-top: 1px solid #f1f5f9;

            background: #fafafa;
        }

        .pg-pagination nav {
            display: flex;

            align-items: center;
            justify-content: center;

            flex-wrap: wrap;

            gap: 5px;
        }

        .pg-pagination a,
        .pg-pagination span {
            min-width: 36px;
            min-height: 36px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            padding: 0 8px;

            border-radius: 8px;

            border: 1px solid var(--pg-border);

            background: #fff;

            color: #475569;

            font-size: .78rem;
            font-weight: 600;

            text-decoration: none;

            transition: var(--pg-transition);
        }

        .pg-pagination a:hover {
            border-color: #93c5fd;

            background: #eff6ff;

            color: #2563eb;

            transform: translateY(-1px);
        }

        .pg-pagination span[aria-current="page"] {
            border-color: var(--pg-primary);

            background: var(--pg-primary);

            color: #fff;

            box-shadow:
                0 4px 10px rgba(37, 99, 235, .20);
        }

        /* =========================================================
           ANIMATION
        ========================================================= */

        @keyframes pgFloat {
            0%, 100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-7px);
            }
        }

        /* =========================================================
           1536+
        ========================================================= */

        @media (min-width: 1536px) {

            .pg-container {
                width: min(100% - 48px, 1540px);

                padding-top: 28px;
            }

            .pg-title {
                font-size: 1.65rem;
            }

            .pg-table tbody td,
            .pg-table thead th {
                padding-left: 18px;
                padding-right: 18px;
            }
        }

        /* =========================================================
           1280 - 1535
        ========================================================= */

        @media (min-width: 1280px) {

            .pg-container {
                width: min(100% - 40px, 1440px);
            }

            .pg-filter-card {
                padding: 20px;
            }
        }

        /* =========================================================
           1024 - 1279 : LAPTOP
        ========================================================= */

        @media (min-width: 1024px) and (max-width: 1279px) {

            .pg-container {
                width: calc(100% - 32px);
            }

            .pg-filter-grid {
                grid-template-columns:
            minmax(180px, 1.4fr)
            minmax(130px, 1fr)
            minmax(130px, 1fr)
            auto;
            }

            .pg-table {
                min-width: 820px;
            }

            .pg-table thead th,
            .pg-table tbody td {
                padding-left: 11px;
                padding-right: 11px;
            }
        }

        /* =========================================================
           768 - 1023 : TABLET
        ========================================================= */

        @media (min-width: 768px) and (max-width: 1023px) {

            .pg-container {
                width: calc(100% - 28px);

                padding-top: 18px;
            }

            .pg-header {
                align-items: flex-start;
            }

            .pg-title {
                font-size: 1.3rem;
            }

            .pg-title-icon {
                width: 40px;
                height: 40px;
                flex-basis: 40px;
            }

            .pg-filter-grid {
                grid-template-columns: 1fr 1fr;
            }

            .pg-filter-actions {
                grid-column: 1 / -1;
            }

            .pg-filter-btn {
                flex: 1;
            }

            .pg-table {
                min-width: 760px;
            }

            .pg-table thead th,
            .pg-table tbody td {
                padding: 10px 9px;
                font-size: .78rem;
            }

            .pg-image,
            .pg-image-placeholder {
                width: 40px;
                height: 40px;
            }
        }

        /* =========================================================
           767px ↓ : MOBILE
        ========================================================= */

        @media (max-width: 767px) {

            .pg-container {
                width: calc(100% - 20px);

                padding-top: 14px;
                padding-bottom: 24px;
            }

            .pg-header {
                display: block;

                margin-bottom: 18px;
            }

            .pg-title {
                font-size: 1.18rem;

                gap: 9px;
            }

            .pg-title-icon {
                width: 38px;
                height: 38px;

                flex-basis: 38px;

                border-radius: 10px;
            }

            .pg-title-icon svg {
                width: 18px;
                height: 18px;
            }

            .pg-subtitle {
                padding-right: 47px;

                margin-top: 3px;

                font-size: .75rem;
            }

            .pg-primary-btn {
                width: 100%;

                margin-top: 14px;

                min-height: 46px;
            }

            .pg-filter-card {
                padding: 14px;

                margin-bottom: 15px;

                border-radius: 14px;
            }

            .pg-filter-grid {
                grid-template-columns: 1fr;

                gap: 11px;
            }

            .pg-label {
                margin-bottom: 6px;

                font-size: .76rem;
            }

            .pg-input,
            .pg-select {
                min-height: 45px;

                font-size: .84rem;
            }

            .pg-filter-actions {
                display: grid;

                grid-template-columns: 1fr 46px;

                width: 100%;

                margin-top: 2px;
            }

            .pg-filter-btn {
                width: 100%;
            }

            .pg-reset-btn {
                width: 46px;
            }

            .pg-table-card {
                display: none;
            }

            .pg-mobile-list {
                display: grid;
            }

            .pg-mobile-card {
                border-radius: 14px;
            }

            .pg-mobile-main {
                padding: 13px;
            }

            .pg-mobile-image .pg-image,
            .pg-mobile-image .pg-image-placeholder {
                width: 58px;
                height: 58px;
            }

            .pg-mobile-code {
                font-size: .86rem;
            }

            .pg-mobile-meta {
                margin-top: 8px;
            }

            .pg-badge,
            .pg-status,
            .pg-sort {
                font-size: .68rem;
            }

            .pg-pagination {
                padding: 11px;
            }

            .pg-pagination a,
            .pg-pagination span {
                min-width: 34px;
                min-height: 34px;

                font-size: .73rem;
            }
        }

        /* =========================================================
           480px ↓
        ========================================================= */

        @media (max-width: 480px) {

            .pg-container {
                width: calc(100% - 16px);
            }

            .pg-title {
                font-size: 1.04rem;
            }

            .pg-title-icon {
                width: 35px;
                height: 35px;
                flex-basis: 35px;
            }

            .pg-subtitle {
                font-size: .7rem;
            }

            .pg-primary-btn {
                min-height: 44px;

                padding-inline: 12px;

                font-size: .8rem;
            }

            .pg-filter-card {
                padding: 12px;
            }

            .pg-mobile-main {
                gap: 10px;
                padding: 11px;
            }

            .pg-mobile-image .pg-image,
            .pg-mobile-image .pg-image-placeholder {
                width: 52px;
                height: 52px;
            }

            .pg-mobile-actions {
                grid-template-columns: 1fr 1fr;
            }

            .pg-mobile-action {
                min-height: 44px;

                font-size: .76rem;
            }

            .pg-pagination {
                overflow-x: auto;

                justify-content: flex-start;
            }

            .pg-pagination nav {
                min-width: max-content;
            }
        }

        /* =========================================================
           360px ↓
        ========================================================= */

        @media (max-width: 360px) {

            .pg-container {
                width: calc(100% - 12px);
            }

            .pg-title {
                font-size: .96rem;
            }

            .pg-title-icon {
                width: 33px;
                height: 33px;
                flex-basis: 33px;
            }

            .pg-subtitle {
                padding-right: 42px;

                font-size: .66rem;
            }

            .pg-mobile-image .pg-image,
            .pg-mobile-image .pg-image-placeholder {
                width: 48px;
                height: 48px;
            }

            .pg-mobile-code {
                font-size: .8rem;
            }

            .pg-mobile-meta {
                gap: 4px;
            }

            .pg-badge,
            .pg-status,
            .pg-sort {
                padding: 4px 6px;

                font-size: .63rem;
            }

            .pg-mobile-action {
                gap: 4px;

                font-size: .7rem;
            }
        }

        /* =========================================================
           REDUCED MOTION
        ========================================================= */

        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: .01ms !important;
            }
        }

        /* =========================================================
           FOCUS
        ========================================================= */

        .pg-page a:focus-visible,
        .pg-page button:focus-visible,
        .pg-page input:focus-visible,
        .pg-page select:focus-visible {
            outline: 2px solid var(--pg-primary);
            outline-offset: 2px;
        }

        /* =========================================================
           PRINT
        ========================================================= */

        @media print {

            .pg-page {
                background: #fff !important;
            }

            .pg-primary-btn,
            .pg-filter-card,
            .pg-actions,
            .pg-mobile-list,
            .pg-pagination {
                display: none !important;
            }

            .pg-table-card {
                border: 1px solid #ccc;

                box-shadow: none;
            }

            .pg-table {
                min-width: 0;
            }
        }
    </style>
@endsection


@section('content')

    <div class="pg-page" dir="rtl">

        <div class="pg-container">

            {{-- =====================================================
                 HEADER
            ====================================================== --}}

            <header class="pg-header">

                <div class="pg-title-wrapper">

                    <h1 class="pg-title">

                    <span class="pg-title-icon">

                        <svg
                            width="21"
                            height="21"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"
                            />
                        </svg>

                    </span>

                        مدیریت گروه‌های محصول

                    </h1>

                    <p class="pg-subtitle">
                        لیست تمام گروه‌های محصول ثبت‌شده در سیستم
                    </p>

                </div>

                <a href="{{route('admin.productGroup.create')}}"
                   class="pg-primary-btn">

                    <svg
                        width="19"
                        height="19"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 4v16m8-8H4"
                        />
                    </svg>

                    افزودن گروه جدید

                </a>

            </header>


            {{-- =====================================================
                 SUCCESS
            ====================================================== --}}

            @if (session('success'))

                <div class="pg-alert pg-alert-success"
                     role="alert">

                    <svg
                        width="20"
                        height="20"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                    </svg>

                    <span>
                    {{ session('success') }}
                </span>

                </div>

            @endif


            {{-- =====================================================
                 ERROR
            ====================================================== --}}

            @if (session('error'))

                <div class="pg-alert pg-alert-error"
                     role="alert">

                    <svg
                        width="20"
                        height="20"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                    </svg>

                    <span>
                    {{ session('error') }}
                </span>

                </div>

            @endif


            {{-- =====================================================
                 FILTER
            ====================================================== --}}

            <div class="pg-filter-card">

                <form method="GET"
                      action=""
                      class="pg-filter-grid">

                    {{-- Search --}}

                    <div class="pg-field">

                        <label
                            for="search"
                            class="pg-label"
                        >
                            جستجو
                        </label>

                        <div class="pg-search-wrapper">

                            <svg
                                class="pg-search-icon"
                                width="17"
                                height="17"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                />
                            </svg>

                            <input
                                type="text"
                                name="search"
                                id="search"
                                value="{{ request('search') }}"
                                placeholder="کد گروه را وارد کنید..."
                                class="pg-input"
                            >

                        </div>

                    </div>


                    {{-- Type --}}

                    <div class="pg-field">

                        <label
                            for="type"
                            class="pg-label"
                        >
                            نوع گروه
                        </label>

                        <select
                            name="type"
                            id="type"
                            class="pg-select"
                        >

                            <option value="">
                                همه
                            </option>

                            <option
                                value="agricultural"
                                @selected(request('type') === 'agricultural')
                            >
                                کشاورزی
                            </option>

                            <option
                                value="industrial"
                                @selected(request('type') === 'industrial')
                            >
                                صنعتی
                            </option>

                            <option
                                value="raw_material"
                                @selected(request('type') === 'raw_material')
                            >
                                مواد خام
                            </option>

                        </select>

                    </div>


                    {{-- Status --}}

                    <div class="pg-field">

                        <label
                            for="status"
                            class="pg-label"
                        >
                            وضعیت
                        </label>

                        <select
                            name="status"
                            id="status"
                            class="pg-select"
                        >

                            <option value="">
                                همه
                            </option>

                            <option
                                value="1"
                                @selected(request('status') === '1')
                            >
                                فعال
                            </option>

                            <option
                                value="0"
                                @selected(request('status') === '0')
                            >
                                غیرفعال
                            </option>

                        </select>

                    </div>


                    {{-- Actions --}}

                    <div class="pg-filter-actions">

                        <button
                            type="submit"
                            class="pg-filter-btn"
                        >

                            <svg
                                width="16"
                                height="16"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"
                                />
                            </svg>

                            اعمال فیلتر

                        </button>

                        <a
                            href=""
                            title="پاک کردن فیلترها"
                            class="pg-reset-btn"
                        >

                            <svg
                                width="17"
                                height="17"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
                                />
                            </svg>

                        </a>

                    </div>

                </form>

            </div>


            {{-- =====================================================
                 TYPE LABELS
            ====================================================== --}}

            @php

                $typeLabels = [

                    'agricultural' => [
                        'کشاورزی',
                        'pg-badge pg-badge-green'
                    ],

                    'industrial' => [
                        'صنعتی',
                        'pg-badge pg-badge-blue'
                    ],

                    'raw_material' => [
                        'مواد خام',
                        'pg-badge pg-badge-amber'
                    ],

                ];

            @endphp


            {{-- =====================================================
                 DESKTOP TABLE
            ====================================================== --}}

            <div class="pg-table-card">

                <div class="pg-table-scroll">

                    <table class="pg-table">

                        <thead>

                        <tr>

                            <th class="text-right">
                                #
                            </th>

                            <th class="text-right">
                                تصویر
                            </th>

                            <th class="text-right">
                                کد گروه
                            </th>

                            <th class="text-right">
                                نوع
                            </th>

                            <th class="text-center">
                                ترتیب
                            </th>

                            <th class="text-center">
                                وضعیت
                            </th>

                            <th class="text-center">
                                ویژه
                            </th>

                            <th class="text-center">
                                عملیات
                            </th>

                        </tr>

                        </thead>

                        <tbody>

                        @forelse ($productGroups as $group)

                            <tr>

                                {{-- Number --}}

                                <td>

                                    {{ $loop->iteration + ($productGroups->currentPage() - 1) * $productGroups->perPage() }}

                                </td>


                                {{-- Image --}}

                                <td>

                                    @if ($group->image)

                                        <img
                                            src="{{ asset('storage/' . $group->image) }}"
                                            alt="{{ $group->code }}"
                                            loading="lazy"
                                            class="pg-image"
                                        >

                                    @else

                                        <div class="pg-image-placeholder">

                                            @if ($group->icon)

                                                <i class="{{ $group->icon }}"></i>

                                            @else

                                                <svg
                                                    width="21"
                                                    height="21"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="1.5"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                                    />
                                                </svg>

                                            @endif

                                        </div>

                                    @endif

                                </td>


                                {{-- Code --}}

                                <td>

                                    <strong>
                                        {{ $group->code }}
                                    </strong>

                                </td>


                                {{-- Type --}}

                                <td>

                                    @php
                                        [$label, $badgeClass] =
                                            $typeLabels[$group->type]
                                            ?? ['—', 'pg-badge'];
                                    @endphp

                                    <span class="{{ $badgeClass }}">
                                    {{ $label }}
                                </span>

                                </td>


                                {{-- Sort --}}

                                <td class="text-center">

                                <span class="pg-sort">
                                    {{ $group->sort_order }}
                                </span>

                                </td>


                                {{-- Status --}}

                                <td class="text-center">

                                    @if ($group->status)

                                        <span class="pg-status pg-status-active">

                                        <span class="pg-status-dot"></span>

                                        فعال

                                    </span>

                                    @else

                                        <span class="pg-status pg-status-inactive">

                                        <span class="pg-status-dot"></span>

                                        غیرفعال

                                    </span>

                                    @endif

                                </td>


                                {{-- Featured --}}

                                <td class="text-center">

                                    @if ($group->is_featured)

                                        <span
                                            class="pg-featured"
                                            title="گروه ویژه"
                                        >

                                        <svg
                                            width="16"
                                            height="16"
                                            fill="currentColor"
                                            viewBox="0 0 20 20"
                                        >
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                                            />
                                        </svg>

                                    </span>

                                    @else

                                        <span class="text-gray-300">
                                        ☆
                                    </span>

                                    @endif

                                </td>


                                {{-- Actions --}}

                                <td>

                                    <div class="pg-actions">

                                        <a
                                            href="{{route('admin.productGroup.edit',$group->id)}}"
                                            title="ویرایش"
                                            class="pg-action pg-action-edit"
                                        >

                                            <svg
                                                width="17"
                                                height="17"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                                />
                                            </svg>

                                        </a>


                                        <form
                                            method="POST"
                                            action="{{route('admin.productGroup.delete',$group->id)}}"
                                            onsubmit="return confirm('آیا از حذف این گروه مطمئن هستید؟')"
                                        >

                                            @csrf

                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                title="حذف"
                                                class="pg-action pg-action-delete"
                                            >

                                                <svg
                                                    width="17"
                                                    height="17"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                                    />
                                                </svg>

                                            </button>

                                        </form>
                                        <a
                                            href="{{ route('admin.productGroup.translations.index', $group->id) }}"
                                            title="مدیریت ترجمه‌ها"
                                            class="pg-action"
                                            style="color:#7c3aed;"
                                        >
                                            <svg
                                                width="17"
                                                height="17"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M3 5h12M9 3v2m4 0a8 8 0 01-8 8m0 0H3m2 0a8 8 0 008 8M17 13l4 8m-2-4h-4"
                                                />
                                            </svg>
                                        </a>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="8">

                                    <div class="pg-empty">

                                        <svg
                                            class="pg-empty-icon"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="1.5"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"
                                            />
                                        </svg>

                                        <p class="pg-empty-text">
                                            هیچ گروه محصولی یافت نشد.
                                        </p>

                                        <a
                                            href=""
                                            class="pg-empty-link"
                                        >
                                            افزودن اولین گروه
                                        </a>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                        </tbody>

                    </table>

                </div>


                {{-- Pagination --}}

                @if ($productGroups->hasPages())

                    <div class="pg-pagination">

                        {{ $productGroups->withQueryString()->links() }}

                    </div>

                @endif

            </div>


            {{-- =====================================================
                 MOBILE
            ====================================================== --}}

            <div class="pg-mobile-list">

                @forelse ($productGroups as $group)

                    <article class="pg-mobile-card">

                        <div class="pg-mobile-main">

                            {{-- Image --}}

                            <div class="pg-mobile-image">

                                @if ($group->image)

                                    <img
                                        src="{{ asset('storage/' . $group->image) }}"
                                        alt="{{ $group->code }}"
                                        loading="lazy"
                                        class="pg-image"
                                    >

                                @else

                                    <div class="pg-image-placeholder">

                                        @if ($group->icon)

                                            <i class="{{ $group->icon }}"></i>

                                        @else

                                            <svg
                                                width="24"
                                                height="24"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.5"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                                />
                                            </svg>

                                        @endif

                                    </div>

                                @endif

                            </div>


                            {{-- Content --}}

                            <div class="pg-mobile-content">

                                <div class="pg-mobile-title-row">

                                    <h3 class="pg-mobile-code">
                                        {{ $group->code }}
                                    </h3>

                                    @if ($group->is_featured)

                                        <span
                                            class="pg-featured"
                                            title="گروه ویژه"
                                        >

                                        <svg
                                            width="15"
                                            height="15"
                                            fill="currentColor"
                                            viewBox="0 0 20 20"
                                        >
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                                            />
                                        </svg>

                                    </span>

                                    @endif

                                </div>


                                <div class="pg-mobile-meta">

                                    @php
                                        [$label, $badgeClass] =
                                            $typeLabels[$group->type]
                                            ?? ['—', 'pg-badge'];
                                    @endphp

                                    <span class="{{ $badgeClass }}">
                                    {{ $label }}
                                </span>


                                    @if ($group->status)

                                        <span class="pg-status pg-status-active">

                                        <span class="pg-status-dot"></span>

                                        فعال

                                    </span>

                                    @else

                                        <span class="pg-status pg-status-inactive">

                                        <span class="pg-status-dot"></span>

                                        غیرفعال

                                    </span>

                                    @endif


                                    <span class="pg-sort">
                                    ترتیب {{ $group->sort_order }}
                                </span>

                                </div>

                            </div>

                        </div>


                        {{-- Mobile actions --}}

                        <div class="pg-mobile-actions">

                            <a
                                href=""
                                class="pg-mobile-action pg-mobile-edit"
                            >

                                <svg
                                    width="16"
                                    height="16"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                    />
                                </svg>

                                ویرایش

                            </a>


                            <form
                                method="POST"
                                action=""
                                onsubmit="return confirm('آیا از حذف این گروه مطمئن هستید؟')"
                            >

                                @csrf

                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="pg-mobile-action pg-mobile-delete"
                                >

                                    <svg
                                        width="16"
                                        height="16"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                        />
                                    </svg>

                                    حذف

                                </button>

                            </form>

                        </div>

                    </article>

                @empty

                    <div class="pg-mobile-card">

                        <div class="pg-empty">

                            <svg
                                class="pg-empty-icon"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.5"
                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"
                                />
                            </svg>

                            <p class="pg-empty-text">
                                هیچ گروه محصولی یافت نشد.
                            </p>

                            <a
                                href=""
                                class="pg-empty-link"
                            >
                                افزودن اولین گروه
                            </a>

                        </div>

                    </div>

                @endforelse


                {{-- Mobile pagination --}}

                @if ($productGroups->hasPages())

                    <div class="pg-pagination">

                        {{ $productGroups->withQueryString()->links() }}

                    </div>

                @endif

            </div>

        </div>

    </div>

@endsection


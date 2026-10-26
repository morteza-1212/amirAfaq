<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'پنل مدیریت') | شرکت خدمات رایانه‌ای تختی</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
          crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    {{-- jQuery --}}
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    {{-- Persian Date --}}
    <script src="https://cdn.jsdelivr.net/npm/persian-date@1.1.0/dist/persian-date.min.js"></script>

    {{-- Persian Datepicker --}}
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/persian-datepicker@1.2.0/dist/css/persian-datepicker.min.css">
    <script src="https://cdn.jsdelivr.net/npm/persian-datepicker@1.2.0/dist/js/persian-datepicker.min.js"></script>

    {{-- استایل اختصاصی هر صفحه --}}
    @stack('styles')

    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --success-color: #27ae60;
            --warning-color: #f39c12;
            --danger-color: #e74c3c;
            --info-color: #00b894;
            --light-color: #ecf0f1;
            --dark-color: #2c3e50;
            --sidebar-width: 250px;
            --header-height: 70px;
            --border-radius: 8px;
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            overflow-x: hidden;
        }

        body {
            font-family: 'Vazirmatn', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f5f7fa;
            color: #333;
            direction: rtl;
        }

        /* ═══════════════════ Sidebar ═══════════════════ */
        .sidebar {
            position: fixed;
            top: 0;
            right: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, var(--primary-color), #1a252f);
            color: white;
            padding: 20px 0;
            z-index: 1000;
            box-shadow: 3px 0 15px rgba(0, 0, 0, 0.1);
            transition: var(--transition);
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            padding: 0 20px 30px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            flex-shrink: 0;
        }

        .company-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 15px;
        }

        .logo-icon {
            font-size: 28px;
            color: var(--secondary-color);
        }

        .logo-text {
            font-size: 20px;
            font-weight: 700;
        }

        .sidebar-user {
            text-align: center;
            padding: 15px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: var(--border-radius);
            margin: 0 15px 20px;
            flex-shrink: 0;
        }

        .user-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--secondary-color), var(--info-color));
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            font-size: 24px;
            color: white;
        }

        .user-name {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .user-role {
            font-size: 14px;
            color: #bdc3c7;
        }

        /* Navigation */
        .nav-links {
            list-style: none;
            padding: 0 15px;
            overflow-y: auto;
            flex: 1;
        }

        .nav-links::-webkit-scrollbar {
            width: 5px;
        }

        .nav-links::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
        }

        .nav-item {
            margin-bottom: 5px;
        }

        .nav-section-title {
            font-size: 11px;
            text-transform: uppercase;
            color: #7f8c8d;
            padding: 15px 15px 8px;
            letter-spacing: 1px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: #bdc3c7;
            text-decoration: none;
            border-radius: var(--border-radius);
            transition: var(--transition);
            gap: 12px;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateX(-5px);
        }

        .nav-link.active {
            background: linear-gradient(135deg, var(--secondary-color), #2980b9);
            color: white;
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
        }

        .nav-link i {
            font-size: 18px;
            width: 24px;
            text-align: center;
            flex-shrink: 0;
        }

        .nav-text {
            flex-grow: 1;
        }

        .badge {
            background: var(--danger-color);
            color: white;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 12px;
        }

        .sidebar-footer {
            padding: 20px 15px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            flex-shrink: 0;
        }

        /* ═══════════════════ Main Content ═══════════════════ */
        .main-content {
            margin-right: var(--sidebar-width);
            padding: 20px;
            min-height: 100vh;
            transition: var(--transition);
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            height: 70px;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .toggle-sidebar {
            background: none;
            border: none;
            color: var(--primary-color);
            font-size: 20px;
            cursor: pointer;
            transition: var(--transition);
            display: none;
        }

        .toggle-sidebar:hover {
            color: var(--secondary-color);
        }

        .page-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary-color);
            margin: 0;
        }

        /* Notification */
        .notification {
            position: relative;
        }

        .notification-btn {
            background: none;
            border: none;
            color: var(--primary-color);
            font-size: 20px;
            cursor: pointer;
            position: relative;
        }

        .notification-count {
            position: absolute;
            top: -5px;
            left: -5px;
            background: var(--danger-color);
            color: white;
            font-size: 12px;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Cards */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: var(--transition);
            border: none;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background: linear-gradient(135deg, var(--secondary-color), #2980b9);
            color: white;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-icon {
            font-size: 30px;
            opacity: 0.8;
        }

        .card-body {
            padding: 20px;
        }

        .card-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--primary-color);
        }

        .card-text {
            color: #666;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .stats-number {
            font-size: 28px;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 5px;
        }

        .stats-label {
            color: #666;
            font-size: 14px;
        }

        /* Buttons */
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: var(--border-radius);
            cursor: pointer;
            font-weight: 600;
            transition: var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--secondary-color), #2980b9);
            color: white;
        }

        .btn-success {
            background: linear-gradient(135deg, var(--success-color), #219653);
            color: white;
        }

        .btn-warning {
            background: linear-gradient(135deg, var(--warning-color), #e67e22);
            color: white;
        }

        .btn-danger {
            background: linear-gradient(135deg, var(--danger-color), #c0392b);
            color: white;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        /* Dashboard Sections */
        .section {
            background: white;
            border-radius: var(--border-radius);
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f1f1f1;
        }

        .section-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--primary-color);
            margin: 0;
        }

        /* Tables */
        .table-responsive {
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .table {
            margin: 0;
        }

        .table th {
            background: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            color: var(--primary-color);
        }

        .table td {
            vertical-align: middle;
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-active {
            background: rgba(39, 174, 96, 0.1);
            color: var(--success-color);
        }

        .status-pending {
            background: rgba(243, 156, 18, 0.1);
            color: var(--warning-color);
        }

        .status-inactive {
            background: rgba(231, 76, 60, 0.1);
            color: var(--danger-color);
        }

        /* Progress Bars */
        .progress {
            height: 10px;
            border-radius: 5px;
            background: #ecf0f1;
            overflow: hidden;
        }

        .progress-bar {
            border-radius: 5px;
        }

        /* Charts */
        .chart-container {
            position: relative;
            height: 300px;
            margin: 20px 0;
        }

        /* Quick Actions */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .action-btn {
            background: white;
            border: 2px solid #f1f1f1;
            border-radius: var(--border-radius);
            padding: 15px;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            color: var(--primary-color);
        }

        .action-btn:hover {
            border-color: var(--secondary-color);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.1);
        }

        .action-icon {
            font-size: 30px;
            margin-bottom: 10px;
            color: var(--secondary-color);
        }

        /* Search Bar */
        .search-box {
            position: relative;
            max-width: 400px;
        }

        .search-box input {
            width: 100%;
            padding: 10px 40px 10px 15px;
            border: 2px solid #ecf0f1;
            border-radius: var(--border-radius);
            font-size: 14px;
            transition: var(--transition);
        }

        .search-box input:focus {
            outline: none;
            border-color: var(--secondary-color);
        }

        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #95a5a6;
        }

        /* Tabs */
        .nav-tabs {
            border-bottom: 2px solid #ecf0f1;
        }

        .nav-tabs .nav-link {
            border: none;
            color: #666;
            font-weight: 600;
            padding: 10px 20px;
        }

        .nav-tabs .nav-link.active {
            color: var(--secondary-color);
            border-bottom: 2px solid var(--secondary-color);
            background: none;
        }

        /* Overlay for mobile sidebar */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            z-index: 999;
            animation: fadeIn 0.2s ease;
        }

        .sidebar-overlay.active {
            display: block;
        }

        /* ═══════════════════ Responsive ═══════════════════ */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(100%);
                width: 280px;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-right: 0;
                padding: 15px;
            }

            .toggle-sidebar {
                display: inline-flex;
            }

            .cards-grid {
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                height: auto;
                padding: 15px;
                gap: 15px;
            }

            .header-left,
            .header-right {
                width: 100%;
                justify-content: space-between;
            }

            .cards-grid {
                grid-template-columns: 1fr;
            }

            .quick-actions {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            }

            .search-box {
                max-width: 100%;
                flex: 1;
            }
        }

        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .fade-in {
            animation: fadeIn 0.5s ease forwards;
        }

        /* Dark Mode Support */
        .dark-mode {
            background: #1a1a2e;
            color: #e0e0e0;
        }

        .dark-mode .card,
        .dark-mode .section,
        .dark-mode .header {
            background: #16213e;
            color: #e0e0e0;
        }

        .dark-mode .table th {
            background: #0f3460;
            color: #e0e0e0;
        }

        .dark-mode .table td {
            color: #e0e0e0;
        }

        .dark-mode .search-box input {
            background: #0f3460;
            border-color: #0f3460;
            color: #e0e0e0;
        }
    </style>
    @yield('styles')
</head>
<body>

@php
    // شمارش‌ها برای نمایش در سایدبار
    $counts = [
        'categories'    => \App\Models\Category::count(),
        'productGroups' => \App\Models\ProductGroup::count(),
        'products'      => \App\Models\Product::count(),
        'catalogs'      => \App\Models\Catalog::count(),
        'gallery'       => \App\Models\Gallery::count(),
        'trades'        => \App\Models\TradeTransaction::count(),
        'buyers'        => \App\Models\Buyer::count(),
        'contacts'      => \App\Models\Contact::count(),
        'productExports'=> \App\Models\ProductExport::count(),
    ];
@endphp

    <!-- ═══════════════════ Sidebar ═══════════════════ -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="company-logo">
            <span class="logo-text">پنل مدیریت</span>
        </div>
        <small class="text-muted">مدیریت چندمنظوره</small>
    </div>

    <div class="sidebar-user">
        <div class="user-avatar">
            <i class="fas fa-user"></i>
        </div>
        <div class="user-name">{{ auth()->user()->name ?? 'مدیر سیستم' }}</div>
        <div class="user-role">{{ auth()->user()->role ?? 'Administrator' }}</div>
    </div>

    <ul class="nav-links">
        {{-- داشبورد --}}
        <li class="nav-item">
            <a href="{{ route('view.panel') }}"
               class="nav-link {{ request()->routeIs('view.panel') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                <span class="nav-text">داشبورد</span>
            </a>
        </li>

        {{-- بخش فروشگاه --}}
        <li class="nav-section-title">فروشگاه</li>

        <li class="nav-item">
            <a href="{{ route('admin.category.index') }}"
               class="nav-link {{ request()->routeIs('admin.category.*') ? 'active' : '' }}">
                <i class="fas fa-tags"></i>
                <span class="nav-text">دسته‌بندی‌ها</span>
                <span class="badge">{{ $counts['categories'] }}</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('admin.productGroup.index') }}"
               class="nav-link {{ request()->routeIs('admin.productGroup.*') ? 'active' : '' }}">
                <i class="fas fa-layer-group"></i>
                <span class="nav-text">گروه‌ها</span>
                <span class="badge">{{ $counts['productGroups'] }}</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('admin.product.index') }}"
               class="nav-link {{ request()->routeIs('admin.product.*') ? 'active' : '' }}">
                <i class="fas fa-box-open"></i>
                <span class="nav-text">محصولات</span>
                <span class="badge">{{ $counts['products'] }}</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('admin.catalog.index') }}"
               class="nav-link {{ request()->routeIs('admin.catalog.*') ? 'active' : '' }}">
                <i class="fas fa-book"></i>
                <span class="nav-text">کاتالوگ‌ها</span>
                <span class="badge">{{ $counts['catalogs'] }}</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('admin.gallery.index') }}"
               class="nav-link {{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}">
                <i class="fas fa-images"></i>
                <span class="nav-text">گالری</span>
                <span class="badge">{{ $counts['gallery'] }}</span>
            </a>
        </li>

        {{-- بخش معاملات --}}
        <li class="nav-section-title">معاملات</li>

        <li class="nav-item">
            <a href="{{ route('admin.trade-transaction.index') }}"
               class="nav-link {{ request()->routeIs('admin.trade-transaction.*') ? 'active' : '' }}">
                <i class="fas fa-exchange-alt"></i>
                <span class="nav-text">معاملات انجام‌شده</span>
                <span class="badge">{{ $counts['trades'] }}</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('admin.buyer.index') }}"
               class="nav-link {{ request()->routeIs('admin.buyer.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                <span class="nav-text">مشتریان</span>
                <span class="badge">{{ $counts['buyers'] }}</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('admin.contact.index') }}"
               class="nav-link {{ request()->routeIs('admin.contact.*') ? 'active' : '' }}">
                <i class="fas fa-envelope-open-text"></i>
                <span class="nav-text">درخواست‌های مشاوره</span>
                <span class="badge">{{ $counts['contacts'] }}</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('admin.productExport.index') }}"
               class="nav-link {{ request()->routeIs('admin.productExport.*') ? 'active' : '' }}">
                <i class="fas fa-shipping-fast"></i>
                <span class="nav-text">محصولات صادراتی</span>
                <span class="badge">{{ $counts['productExports'] }}</span>
            </a>
        </li>

        {{-- بخش پشتیبانی --}}
        <li class="nav-section-title">پشتیبانی</li>

        <li class="nav-item">
            <a href="{{ route('admin.support.index') }}"
               class="nav-link {{ request()->routeIs('admin.support.*') ? 'active' : '' }}">
                <i class="fas fa-headset"></i>
                <span class="nav-text">پشتیبانی آنلاین</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('admin.chat.index') }}"
               class="nav-link {{ request()->routeIs('admin.chat.*') ? 'active' : '' }}">
                <i class="fas fa-comments"></i>
                <span class="nav-text">چت اپراتورها</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('admin.chatbot.faqs.index') }}"
               class="nav-link {{ request()->routeIs('admin.chatbot.faqs.*') ? 'active' : '' }}">
                <i class="fas fa-question-circle"></i>
                <span class="nav-text">سوالات متداول</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('waiting-list') }}"
               class="nav-link {{ request()->routeIs('waiting-list') ? 'active' : '' }}">
                <i class="fas fa-hourglass-half"></i>
                <span class="nav-text">لیست انتظار چت</span>
            </a>
        </li>
    </ul>

    <div class="sidebar-footer">
        <form method="POST" action="">
            @csrf
            <button type="submit" class="nav-link text-danger w-100 border-0 bg-transparent text-start">
                <i class="fas fa-sign-out-alt"></i>
                <span class="nav-text">خروج از سیستم</span>
            </button>
        </form>
    </div>
</div>

<!-- Overlay موبایل -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- ═══════════════════ Main Content ═══════════════════ -->
<div class="main-content" id="mainContent">
    <!-- Header -->
    <header class="header">
        <div class="header-left">
            <button class="toggle-sidebar" id="toggleSidebar" aria-label="باز و بسته کردن منو">
                <i class="fas fa-bars"></i>
            </button>
            <h1 class="page-title" id="pageTitle">@yield('title', 'داشبورد مدیریت')</h1>
        </div>

        <div class="header-right">
            <div class="search-box">
                <input type="text" id="globalSearch" placeholder="جستجو در پنل...">
                <i class="fas fa-search"></i>
            </div>

            <div class="notification">
                <button class="notification-btn" type="button">
                    <i class="fas fa-bell"></i>
                    <span class="notification-count">0</span>
                </button>
            </div>

            <div class="user-dropdown">
                <a href="{{ route('view.panel') }}" class="btn btn-primary">
                    <i class="fas fa-user-circle"></i>
                    {{ auth()->user()->name ?? 'پروفایل' }}
                </a>
            </div>
        </div>
    </header>

    <div class="content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar       = document.getElementById('sidebar');
        const toggleBtn     = document.getElementById('toggleSidebar');
        const overlay       = document.getElementById('sidebarOverlay');

        /* ─── باز و بسته کردن سایدبار ─── */
        function openSidebar() {
            sidebar.classList.add('active');
            overlay.classList.add('active');
        }

        function closeSidebar() {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
        }

        if (toggleBtn) {
            toggleBtn.addEventListener('click', function () {
                sidebar.classList.contains('active') ? closeSidebar() : openSidebar();
            });
        }

        if (overlay) {
            overlay.addEventListener('click', closeSidebar);
        }

        /* ─── بستن سایدبار با تغییر سایز به دسکتاپ ─── */
        window.addEventListener('resize', function () {
            if (window.innerWidth >= 992) {
                closeSidebar();
            }
        });

        /* ─── جستجوی هدر ─── */
        const searchInput = document.getElementById('globalSearch');
        if (searchInput) {
            searchInput.addEventListener('keyup', function (e) {
                if (e.key === 'Enter' && this.value.trim() !== '') {
                    // می‌توانید اینجا به یک صفحه جستجو ریدایرکت کنید
                    console.log('Search for:', this.value);
                }
            });
        }
    });
</script>

{{-- اسکریپت اختصاصی هر صفحه --}}
@stack('scripts')
@yield('scripts')

</body>
</html>

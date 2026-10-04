
@extends('panelAdmin.layouts.panel')

@section('title', 'مدیریت ترجمه دسته‌بندی‌ها')

@section('style')
    <style>
        .translation-page {
            direction: rtl;
            width: 100%;
        }

        .translation-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .translation-title h1 {
            margin: 0 0 7px;
            font-size: 24px;
            font-weight: 800;
            color: #1f2937;
        }

        .translation-title p {
            margin: 0;
            color: #6b7280;
            font-size: 14px;
        }

        .btn-create {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 11px 18px;
            border-radius: 10px;
            background: #2563eb;
            color: #fff;
            text-decoration: none;
            font-size: 14px;
            font-weight: 700;
            transition: .2s;
            white-space: nowrap;
        }

        .btn-create:hover {
            background: #1d4ed8;
            color: #fff;
            transform: translateY(-1px);
        }

        .translation-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 3px 15px rgba(0, 0, 0, .04);
        }

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        .translation-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 900px;
        }

        .translation-table th {
            background: #f8fafc;
            color: #374151;
            font-size: 13px;
            font-weight: 800;
            padding: 15px 14px;
            text-align: right;
            white-space: nowrap;
            border-bottom: 1px solid #e5e7eb;
        }

        .translation-table td {
            padding: 14px;
            color: #4b5563;
            font-size: 14px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        .translation-table tbody tr {
            transition: background .15s;
        }

        .translation-table tbody tr:hover {
            background: #f8fafc;
        }

        .translation-table tbody tr:last-child td {
            border-bottom: 0;
        }

        .id-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 32px;
            height: 28px;
            padding: 0 8px;
            border-radius: 7px;
            background: #f1f5f9;
            color: #475569;
            font-size: 12px;
            font-weight: 700;
        }

        .category-name {
            font-weight: 700;
            color: #1f2937;
        }

        .translation-name {
            font-weight: 700;
            color: #111827;
        }

        .slug {
            direction: ltr;
            text-align: left;
            display: inline-block;
            padding: 5px 8px;
            border-radius: 6px;
            background: #f8fafc;
            color: #475569;
            font-family: monospace;
            font-size: 12px;
        }

        .language-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 65px;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 800;
        }

        .language-fa {
            background: #ecfdf5;
            color: #047857;
        }

        .language-en {
            background: #eff6ff;
            color: #1d4ed8;
        }

        .language-ar {
            background: #fff7ed;
            color: #c2410c;
        }

        .action-buttons {
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .action-btn {
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            background: #fff;
            text-decoration: none;
            transition: .2s;
            font-size: 14px;
        }

        .action-edit {
            color: #2563eb;
        }

        .action-edit:hover {
            background: #eff6ff;
            border-color: #bfdbfe;
        }

        .action-delete {
            color: #dc2626;
            cursor: pointer;
        }

        .action-delete:hover {
            background: #fef2f2;
            border-color: #fecaca;
        }

        .empty-state {
            text-align: center;
            padding: 65px 20px;
        }

        .empty-icon {
            width: 65px;
            height: 65px;
            margin: 0 auto 15px;
            border-radius: 50%;
            background: #eff6ff;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 25px;
        }

        .empty-state h3 {
            margin: 0 0 8px;
            color: #1f2937;
            font-size: 17px;
        }

        .empty-state p {
            margin: 0 0 20px;
            color: #6b7280;
            font-size: 14px;
        }

        .pagination-wrapper {
            padding: 18px;
            border-top: 1px solid #f1f5f9;
        }

        .pagination-wrapper nav {
            display: flex;
            justify-content: center;
        }

        .delete-form {
            display: inline;
            margin: 0;
        }

        @media (max-width: 768px) {
            .translation-header {
                align-items: stretch;
            }

            .translation-title {
                width: 100%;
            }

            .btn-create {
                width: 100%;
            }

            .translation-card {
                border-radius: 10px;
            }
        }
    </style>
@endsection

@section('content')

    <div class="translation-page">

        {{-- Header --}}
        <div class="translation-header">

            <div class="translation-title">
                <h1>مدیریت ترجمه دسته‌بندی‌ها</h1>
                <p>
                    مدیریت نام، توضیحات و اطلاعات سئو دسته‌بندی‌ها در زبان‌های مختلف
                </p>
            </div>

            <a
                href="{{ route('admin.category.translation.create') }}"
                class="btn-create"
            >
                <i class="fas fa-plus"></i>
                افزودن ترجمه
            </a>

        </div>


        {{-- پیام موفقیت --}}
        @if(session('success'))
            <div class="alert alert-success mb-3">
                {{ session('success') }}
            </div>
        @endif


        {{-- خطاها --}}
        @if($errors->any())
            <div class="alert alert-danger mb-3">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <div class="translation-card">

            @if($translations->count())

                <div class="table-wrapper">

                    <table class="translation-table">

                        <thead>
                        <tr>
                            <th>#</th>
                            <th>دسته‌بندی</th>
                            <th>زبان</th>
                            <th>نام ترجمه</th>
                            <th>Slug</th>
                            <th>عنوان SEO</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>

                        <tbody>

                        @foreach($translations as $translation)

                            <tr>

                                <td>
                                <span class="id-badge">
                                    {{ $translation->id }}
                                </span>
                                </td>

                                <td>
                                <span class="category-name">
                                    {{ $translation->category?->name ?? 'بدون دسته‌بندی' }}
                                </span>
                                </td>

                                <td>

                                    @if($translation->locale === 'fa')

                                        <span class="language-badge language-fa">
                                        فارسی
                                    </span>

                                    @elseif($translation->locale === 'en')

                                        <span class="language-badge language-en">
                                        English
                                    </span>

                                    @elseif($translation->locale === 'ar')

                                        <span class="language-badge language-ar">
                                        العربية
                                    </span>

                                    @endif

                                </td>

                                <td>
                                <span class="translation-name">
                                    {{ $translation->name }}
                                </span>
                                </td>

                                <td>
                                <span class="slug">
                                    {{ $translation->slug }}
                                </span>
                                </td>

                                <td>
                                    {{ $translation->meta_title ?: '—' }}
                                </td>

                                <td>

                                    <div class="action-buttons">

                                        <a
                                            href="{{ route('admin.category.translation.edit', $translation) }}"
                                            class="action-btn action-edit"
                                            title="ویرایش"
                                        >
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form
                                            action="{{ route('admin.category.translation.delete', $translation) }}"
                                            method="POST"
                                            class="delete-form"
                                            onsubmit="return confirm('آیا از حذف این ترجمه مطمئن هستید؟');"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="action-btn action-delete"
                                                title="حذف"
                                            >
                                                <i class="fas fa-trash"></i>
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                        </tbody>

                    </table>

                </div>


                {{-- Pagination --}}
                @if($translations->hasPages())

                    <div class="pagination-wrapper">
                        {{ $translations->links() }}
                    </div>

                @endif

            @else

                <div class="empty-state">

                    <div class="empty-icon">
                        <i class="fas fa-language"></i>
                    </div>

                    <h3>
                        هنوز ترجمه‌ای ثبت نشده است
                    </h3>

                    <p>
                        برای شروع، اولین ترجمه دسته‌بندی را ایجاد کنید.
                    </p>

                    <a
                        href="{{ route('panelAdmin.category-translations.create') }}"
                        class="btn-create"
                    >
                        <i class="fas fa-plus"></i>
                        افزودن اولین ترجمه
                    </a>

                </div>

            @endif

        </div>

    </div>

@endsection


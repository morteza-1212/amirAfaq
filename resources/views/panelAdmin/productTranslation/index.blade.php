@extends('panelAdmin.layouts.panel')

@section('title', 'ترجمه‌های گروه محصول')

@section('style')
    <style>
        .translation-page {
            direction: rtl;
        }

        .translation-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
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

        .translation-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .translation-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 10px 16px;
            border-radius: 10px;
            text-decoration: none;
            border: 0;
            cursor: pointer;
            font-size: 14px;
            font-weight: 700;
        }

        .translation-btn-primary {
            background: #2563eb;
            color: #fff;
        }

        .translation-btn-secondary {
            background: #f3f4f6;
            color: #374151;
        }

        .translation-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,.06);
            overflow: hidden;
        }

        .translation-table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        .translation-table {
            width: 100%;
            min-width: 850px;
            border-collapse: collapse;
        }

        .translation-table th {
            background: #f9fafb;
            color: #374151;
            font-size: 13px;
            padding: 15px;
            text-align: right;
            white-space: nowrap;
        }

        .translation-table td {
            padding: 15px;
            border-top: 1px solid #f1f5f9;
            vertical-align: middle;
            color: #4b5563;
        }

        .language-badge {
            display: inline-flex;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }

        .language-fa {
            background: #dcfce7;
            color: #166534;
        }

        .language-en {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .language-ar {
            background: #fef3c7;
            color: #92400e;
        }

        .action-buttons {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        .action-btn {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            border: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            cursor: pointer;
        }

        .action-show {
            background: #eff6ff;
            color: #2563eb;
        }

        .action-edit {
            background: #fef3c7;
            color: #b45309;
        }

        .action-delete {
            background: #fee2e2;
            color: #dc2626;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            border-radius: 10px;
            padding: 12px 15px;
            margin-bottom: 20px;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #6b7280;
        }

        .empty-state-icon {
            font-size: 45px;
            margin-bottom: 15px;
        }

        @media (max-width: 768px) {
            .translation-header {
                align-items: stretch;
            }

            .translation-title {
                width: 100%;
            }

            .translation-actions {
                width: 100%;
            }

            .translation-btn {
                flex: 1;
            }
        }
    </style>
@endsection

@section('content')

    <div class="translation-page">

        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="translation-header">

            <div class="translation-title">
                <h1>ترجمه‌های گروه محصول</h1>

                <p>
                    گروه:
                    <strong>
                        {{ $productGroup->name ?? 'گروه محصول' }}
                    </strong>
                </p>
            </div>

            <div class="translation-actions">

                <a
                    href="{{ route('admin.productGroup.translations.create', $productGroup) }}"
                    class="translation-btn translation-btn-primary"
                >
                    + افزودن ترجمه
                </a>

                <a
                    href="{{ url()->previous() }}"
                    class="translation-btn translation-btn-secondary"
                >
                    بازگشت
                </a>

            </div>

        </div>


        <div class="translation-card">

            @if($translations->count())

                <div class="translation-table-wrapper">

                    <table class="translation-table">

                        <thead>
                        <tr>
                            <th>#</th>
                            <th>زبان</th>
                            <th>نام</th>
                            <th>Slug</th>
                            <th>عنوان SEO</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>

                        <tbody>

                        @foreach($translations as $translation)

                            <tr>

                                <td>
                                    {{ $translations->firstItem() + $loop->index }}
                                </td>

                                <td>

                                <span class="
                                    language-badge
                                    language-{{ $translation->locale }}
                                ">
                                    {{ $translation->locale_name }}
                                </span>

                                </td>

                                <td>
                                    <strong>
                                        {{ $translation->name }}
                                    </strong>
                                </td>

                                <td>
                                    {{ $translation->slug ?: '-' }}
                                </td>

                                <td>
                                    {{ $translation->meta_title ?: '-' }}
                                </td>

                                <td>

                                    <div class="action-buttons">

{{--                                        <a--}}
{{--                                            href="{{ route(--}}
{{--                                            'panelAdmin.product-groups.translations.show',--}}
{{--                                            [$productGroup, $translation]--}}
{{--                                        ) }}"--}}
{{--                                            class="action-btn action-show"--}}
{{--                                            title="مشاهده"--}}
{{--                                        >--}}
{{--                                            👁--}}
{{--                                        </a>--}}

                                        <a
                                            href="{{ route(
                                            'admin.productGroup.translations.edit',
                                            [$productGroup, $translation]
                                        ) }}"
                                            class="action-btn action-edit"
                                            title="ویرایش"
                                        >
                                            ✏
                                        </a>

                                        <form
                                            action="{{ route(
                                            'admin.productGroup.translations.delete',
                                            [$productGroup, $translation]
                                        ) }}"
                                            method="POST"
                                            onsubmit="return confirm('آیا از حذف این ترجمه مطمئن هستید؟')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="action-btn action-delete"
                                                title="حذف"
                                            >
                                                🗑
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                        </tbody>

                    </table>

                </div>

                @if($translations->hasPages())
                    <div style="padding:20px;">
                        {{ $translations->links() }}
                    </div>
                @endif

            @else

                <div class="empty-state">

                    <div class="empty-state-icon">
                        🌐
                    </div>

                    <h3>
                        هنوز ترجمه‌ای ثبت نشده است
                    </h3>

                    <p>
                        برای این گروه محصول ترجمه فارسی، انگلیسی یا عربی ایجاد کنید.
                    </p>

                    <br>

                    <a
                        href="{{ route(
                        'admin.productGroup.translations.create',
                        $productGroup
                    ) }}"
                        class="translation-btn translation-btn-primary"
                    >
                        افزودن اولین ترجمه
                    </a>

                </div>

            @endif

        </div>

    </div>

@endsection

@extends('panelAdmin.layouts.panel')

@section('title', 'ترجمه‌های محصول')

@section('style')
    <style>
        .translation-page {
            direction: rtl;
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 25px;
        }

        .card {
            background: white;
            border-radius: 14px;
            padding: 20px;
        }

        .translation-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .translation-card {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 20px;
        }

        .language {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .status {
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 12px;
            display: inline-block;
        }

        .exists {
            background: #dcfce7;
            color: #166534;
        }

        .missing {
            background: #fee2e2;
            color: #991b1b;
        }

        .btn {
            display: inline-block;
            padding: 9px 15px;
            border-radius: 8px;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }

        .primary {
            background: #2563eb;
            color: white;
        }

        .warning {
            background: #f59e0b;
            color: white;
        }

        .danger {
            background: #dc2626;
            color: white;
        }

        .actions {
            display: flex;
            gap: 7px;
            margin-top: 15px;
            flex-wrap: wrap;
        }

        @media(max-width:900px) {
            .translation-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media(max-width:600px) {
            .translation-page {
                padding: 10px;
            }

            .translation-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection

@section('content')

    <div class="translation-page">

        <div class="header">

            <div>

                <h1>ترجمه‌های محصول</h1>

                <p>
                    محصول:
                    <strong>
                        {{ $product->translation('fa')?->name
                            ?? $product->code }}
                    </strong>
                </p>

            </div>

            <a
                href="{{ route('admin.product.translation.create', $product) }}"
                class="btn primary">
                + افزودن ترجمه
            </a>

        </div>

        @if(session('success'))
            <div class="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="translation-grid">

            @foreach([
                'fa' => 'فارسی',
                'en' => 'English',
                'ar' => 'العربية'
            ] as $locale => $language)

                @php
                    $translation = $product
                        ->translations
                        ->firstWhere('locale', $locale);
                @endphp

                <div class="translation-card">

                    <div class="language">
                        {{ $language }}
                    </div>

                    @if($translation)

                        <span class="status exists">
                        ترجمه ثبت شده
                    </span>

                        <h3>
                            {{ $translation->name }}
                        </h3>

                        <p>
                            {{ $translation->short_description }}
                        </p>

                        <div class="actions">

                            <a
                                href="{{ route(
                                'admin.product.translation.edit',
                                [$product, $translation]
                            ) }}"
                                class="btn warning">
                                ویرایش
                            </a>

                            <form
                                method="POST"
                                action="{{ route(
                                'admin.product.translation.delete',
                                [$product, $translation]
                            ) }}"
                                onsubmit="return confirm('حذف ترجمه؟')">

                                @csrf
                                @method('DELETE')

                                <button class="btn danger">
                                    حذف
                                </button>

                            </form>

                        </div>

                    @else

                        <span class="status missing">
                        ترجمه ثبت نشده
                    </span>

                        <p>
                            برای این زبان هنوز ترجمه‌ای ثبت نشده است.
                        </p>

                        <a
                            href="{{ route(
                            'admin.product.translation.create',
                            ['product' => $product, 'locale' => $locale]
                        ) }}"
                            class="btn primary">

                            افزودن {{ $language }}

                        </a>

                    @endif

                </div>

            @endforeach

        </div>

    </div>

@endsection

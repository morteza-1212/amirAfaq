@extends('panelAdmin.layouts.panel')

@section('title', 'ویرایش ترجمه گروه محصول')

@section('style')
    <style>
        .translation-edit-page {
            direction: rtl;
            max-width: 1100px;
            margin: 0 auto;
        }

        .translation-card {
            background: #ffffff;
            border-radius: 18px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, .06);
            overflow: hidden;
        }

        .translation-card-header {
            padding: 24px 28px;
            border-bottom: 1px solid #eef2f7;
            background: linear-gradient(
                135deg,
                #f8fafc,
                #ffffff
            );
        }

        .translation-card-header h1 {
            margin: 0 0 8px;
            color: #1f2937;
            font-size: 24px;
            font-weight: 800;
        }

        .translation-card-header p {
            margin: 0;
            color: #6b7280;
            font-size: 14px;
        }

        .translation-card-header strong {
            color: #2563eb;
        }

        .translation-card-body {
            padding: 28px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 22px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-label {
            color: #374151;
            font-size: 14px;
            font-weight: 700;
        }

        .form-label .required {
            color: #dc2626;
        }

        .form-control {
            width: 100%;
            box-sizing: border-box;
            border: 1px solid #d1d5db;
            border-radius: 11px;
            background: #ffffff;
            color: #1f2937;
            padding: 12px 14px;
            font-size: 14px;
            outline: none;
            transition: all .2s ease;
        }

        .form-control:hover {
            border-color: #9ca3af;
        }

        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .10);
        }

        textarea.form-control {
            min-height: 140px;
            resize: vertical;
            line-height: 1.8;
        }

        .short-description {
            min-height: 110px !important;
        }

        .seo-description {
            min-height: 120px !important;
        }

        .field-hint {
            color: #9ca3af;
            font-size: 12px;
            line-height: 1.6;
        }

        .error-message {
            color: #dc2626;
            font-size: 12px;
            line-height: 1.6;
        }

        .input-error {
            border-color: #dc2626 !important;
        }

        .translation-info {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 13px 15px;
            margin-bottom: 25px;
            background: #eff6ff;
            border: 1px solid #dbeafe;
            border-radius: 11px;
            color: #1e40af;
            font-size: 13px;
        }

        .translation-info-icon {
            font-size: 18px;
        }

        .language-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: fit-content;
            padding: 5px 11px;
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

        .form-footer {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 10px;
            margin-top: 30px;
            padding-top: 22px;
            border-top: 1px solid #eef2f7;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-width: 130px;
            padding: 11px 18px;
            border: 0;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            transition: all .2s ease;
        }

        .btn-primary {
            background: #2563eb;
            color: #ffffff;
        }

        .btn-primary:hover {
            background: #1d4ed8;
        }

        .btn-secondary {
            background: #f3f4f6;
            color: #374151;
        }

        .btn-secondary:hover {
            background: #e5e7eb;
        }

        .btn-danger {
            background: #fee2e2;
            color: #b91c1c;
        }

        .btn-danger:hover {
            background: #fecaca;
        }

        .meta-section {
            grid-column: 1 / -1;
            margin-top: 5px;
            padding: 20px;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            background: #fafafa;
        }

        .meta-section-title {
            margin-bottom: 18px;
        }

        .meta-section-title h3 {
            margin: 0 0 5px;
            color: #374151;
            font-size: 16px;
            font-weight: 800;
        }

        .meta-section-title p {
            margin: 0;
            color: #9ca3af;
            font-size: 12px;
        }

        .slug-wrapper {
            display: flex;
            direction: ltr;
        }

        .slug-wrapper .form-control {
            text-align: left;
        }

        @media (max-width: 900px) {

            .translation-edit-page {
                width: 100%;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-group.full-width {
                grid-column: auto;
            }

            .meta-section {
                grid-column: auto;
            }
        }

        @media (max-width: 600px) {

            .translation-card-header {
                padding: 20px;
            }

            .translation-card-body {
                padding: 18px;
            }

            .translation-card-header h1 {
                font-size: 20px;
            }

            .form-grid {
                gap: 17px;
            }

            .form-footer {
                flex-direction: column-reverse;
                align-items: stretch;
            }

            .form-footer .btn {
                width: 100%;
            }

            textarea.form-control {
                min-height: 120px;
            }
        }
    </style>
@endsection


@section('content')

    <div class="translation-edit-page">

        <div class="translation-card">

            {{-- Header --}}
            <div class="translation-card-header">

                <h1>
                    ویرایش ترجمه گروه محصول
                </h1>

                <p>
                    گروه محصول:
                    <strong>
                        {{ $productGroup->name ?? 'بدون نام' }}
                    </strong>
                </p>

            </div>


            {{-- Body --}}
            <div class="translation-card-body">

                {{-- اطلاعات ترجمه --}}
                <div class="translation-info">

                <span class="translation-info-icon">
                    🌐
                </span>

                    <span>
                    در حال ویرایش ترجمه
                    <strong>
                        {{ $translation->locale_name }}
                    </strong>
                    هستید.
                </span>

                </div>


                <form
                    action="{{ route(
                    'admin.productGroup.translations.update',
                    [
                        'productGroup' => $productGroup,
                        'translation' => $translation
                    ]
                ) }}"
                    method="POST"
                >

                    @csrf
                    @method('PUT')


                    <div class="form-grid">


                        {{-- زبان --}}
                        <div class="form-group">

                            <label class="form-label">
                                زبان
                                <span class="required">*</span>
                            </label>

                            <select
                                name="locale"
                                class="form-control @error('locale') input-error @enderror"
                                required
                            >

                                <option value="">
                                    انتخاب زبان
                                </option>

                                <option
                                    value="fa"
                                    @selected(old('locale', $translation->locale) === 'fa')
                                >
                                    فارسی
                                </option>

                                <option
                                    value="en"
                                    @selected(old('locale', $translation->locale) === 'en')
                                >
                                    English
                                </option>

                                <option
                                    value="ar"
                                    @selected(old('locale', $translation->locale) === 'ar')
                                >
                                    العربية
                                </option>

                            </select>

                            @error('locale')
                            <span class="error-message">
                                {{ $message }}
                            </span>
                            @enderror

                        </div>


                        {{-- نام --}}
                        <div class="form-group">

                            <label class="form-label">
                                نام گروه
                                <span class="required">*</span>
                            </label>

                            <input
                                type="text"
                                name="name"
                                value="{{ old('name', $translation->name) }}"
                                class="form-control @error('name') input-error @enderror"
                                required
                                maxlength="255"
                            >

                            @error('name')
                            <span class="error-message">
                                {{ $message }}
                            </span>
                            @enderror

                        </div>


                        {{-- Slug --}}
                        <div class="form-group">

                            <label class="form-label">
                                Slug
                            </label>

                            <div class="slug-wrapper">

                                <input
                                    type="text"
                                    name="slug"
                                    value="{{ old('slug', $translation->slug) }}"
                                    class="form-control @error('slug') input-error @enderror"
                                    maxlength="255"
                                    dir="ltr"
                                    placeholder="example-product"
                                >

                            </div>

                            <span class="field-hint">
                            برای URL صفحه استفاده می‌شود.
                        </span>

                            @error('slug')
                            <span class="error-message">
                                {{ $message }}
                            </span>
                            @enderror

                        </div>


                        {{-- نمایش زبان --}}
                        <div class="form-group">

                            <label class="form-label">
                                زبان انتخاب‌شده
                            </label>

                            <div>

                            <span
                                class="
                                    language-badge
                                    language-{{ $translation->locale }}
                                "
                            >
                                {{ $translation->locale_name }}
                            </span>

                            </div>

                        </div>


                        {{-- توضیح کوتاه --}}
                        <div class="form-group full-width">

                            <label class="form-label">
                                توضیح کوتاه
                            </label>

                            <textarea
                                name="short_description"
                                class="form-control short-description @error('short_description') input-error @enderror"
                                maxlength="500"
                            >{{ old(
                            'short_description',
                            $translation->short_description
                        ) }}</textarea>

                            <span class="field-hint">
                            حداکثر ۵۰۰ کاراکتر.
                        </span>

                            @error('short_description')
                            <span class="error-message">
                                {{ $message }}
                            </span>
                            @enderror

                        </div>


                        {{-- توضیحات --}}
                        <div class="form-group full-width">

                            <label class="form-label">
                                توضیحات کامل
                            </label>

                            <textarea
                                name="description"
                                class="form-control @error('description') input-error @enderror"
                            >{{ old(
                            'description',
                            $translation->description
                        ) }}</textarea>

                            @error('description')
                            <span class="error-message">
                                {{ $message }}
                            </span>
                            @enderror

                        </div>


                        {{-- SEO --}}
                        <div class="meta-section">

                            <div class="meta-section-title">

                                <h3>
                                    تنظیمات SEO
                                </h3>

                                <p>
                                    اطلاعات مربوط به موتورهای جستجو برای این ترجمه
                                </p>

                            </div>


                            <div class="form-grid">


                                {{-- Meta title --}}
                                <div class="form-group">

                                    <label class="form-label">
                                        عنوان SEO
                                    </label>

                                    <input
                                        type="text"
                                        name="meta_title"
                                        value="{{ old(
                                        'meta_title',
                                        $translation->meta_title
                                    ) }}"
                                        class="form-control @error('meta_title') input-error @enderror"
                                        maxlength="255"
                                    >

                                    @error('meta_title')
                                    <span class="error-message">
                                        {{ $message }}
                                    </span>
                                    @enderror

                                </div>


                                {{-- Keywords --}}
                                <div class="form-group">

                                    <label class="form-label">
                                        کلمات کلیدی
                                    </label>

                                    <input
                                        type="text"
                                        name="meta_keywords"
                                        value="{{ old(
                                        'meta_keywords',
                                        $translation->meta_keywords
                                    ) }}"
                                        class="form-control @error('meta_keywords') input-error @enderror"
                                        maxlength="255"
                                        placeholder="pistachio, iranian pistachio, export"
                                    >

                                    @error('meta_keywords')
                                    <span class="error-message">
                                        {{ $message }}
                                    </span>
                                    @enderror

                                </div>


                                {{-- Meta description --}}
                                <div class="form-group full-width">

                                    <label class="form-label">
                                        توضیحات SEO
                                    </label>

                                    <textarea
                                        name="meta_description"
                                        class="form-control seo-description @error('meta_description') input-error @enderror"
                                    >{{ old(
                                    'meta_description',
                                    $translation->meta_description
                                ) }}</textarea>

                                    <span class="field-hint">
                                    توضیح کوتاه و مناسب برای نمایش در نتایج جستجو.
                                </span>

                                    @error('meta_description')
                                    <span class="error-message">
                                        {{ $message }}
                                    </span>
                                    @enderror

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- دکمه‌ها --}}
                    <div class="form-footer">

                        <a
                            href="{{ route(
                            'admin.productGroup.translations.index',
                            $productGroup
                        ) }}"
                            class="btn btn-secondary"
                        >
                            انصراف
                        </a>

                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            ذخیره تغییرات
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

@endsection

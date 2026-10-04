
@extends('panelAdmin.layouts.panel')

@section('title', 'ویرایش ترجمه دسته‌بندی')

@section('style')
    <style>
        .translation-form-page {
            direction: rtl;
            max-width: 1100px;
            margin: 0 auto;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .page-header h1 {
            margin: 0 0 7px;
            font-size: 24px;
            font-weight: 800;
            color: #1f2937;
        }

        .page-header p {
            margin: 0;
            color: #6b7280;
            font-size: 14px;
        }

        .translation-id {
            direction: ltr;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: #f1f5f9;
            color: #475569;
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 12px;
            font-weight: 700;
        }

        .form-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 25px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, .04);
            margin-bottom: 20px;
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 10px;
            padding-bottom: 15px;
            margin-bottom: 22px;
            border-bottom: 1px solid #eef2f7;
        }

        .section-title-icon {
            width: 36px;
            height: 36px;
            border-radius: 9px;
            background: #eff6ff;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .section-title h2 {
            margin: 0;
            font-size: 17px;
            font-weight: 800;
            color: #1f2937;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
        }

        .form-group {
            margin-bottom: 0;
        }

        .form-group.full {
            grid-column: 1 / -1;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            color: #374151;
            font-size: 13px;
            font-weight: 700;
        }

        .required {
            color: #dc2626;
            margin-right: 3px;
        }

        .form-control,
        .form-select {
            width: 100%;
            height: 45px;
            border: 1px solid #dbe1e8;
            border-radius: 9px;
            padding: 0 13px;
            background: #fff;
            color: #1f2937;
            font-size: 14px;
            outline: none;
            transition: .2s;
            box-sizing: border-box;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .10);
        }

        textarea.form-control {
            height: auto;
            min-height: 130px;
            padding: 12px 13px;
            resize: vertical;
            line-height: 1.8;
        }

        .short-description {
            min-height: 100px !important;
        }

        .slug-input {
            direction: ltr;
            text-align: left;
        }

        .help-text {
            display: block;
            margin-top: 6px;
            color: #9ca3af;
            font-size: 11px;
            line-height: 1.7;
        }

        .invalid-feedback {
            display: block;
            margin-top: 6px;
            color: #dc2626;
            font-size: 12px;
        }

        .is-invalid {
            border-color: #dc2626 !important;
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #eef2f7;
        }

        .right-actions,
        .left-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn {
            min-height: 44px;
            padding: 0 18px;
            border: 0;
            border-radius: 9px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            transition: .2s;
        }

        .btn-primary {
            background: #2563eb;
            color: #fff;
        }

        .btn-primary:hover {
            background: #1d4ed8;
            color: #fff;
        }

        .btn-secondary {
            background: #f1f5f9;
            color: #475569;
        }

        .btn-secondary:hover {
            background: #e2e8f0;
            color: #334155;
        }

        .btn-danger {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        .btn-danger:hover {
            background: #fee2e2;
            color: #b91c1c;
        }

        .seo-note {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 13px 15px;
            margin-bottom: 20px;
            color: #64748b;
            font-size: 12px;
            line-height: 1.9;
        }

        @media (max-width: 768px) {

            .form-card {
                padding: 18px;
                border-radius: 10px;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 18px;
            }

            .form-group.full {
                grid-column: auto;
            }

            .page-header h1 {
                font-size: 21px;
            }

            .page-header {
                align-items: stretch;
            }

            .translation-id {
                width: fit-content;
            }

            .form-actions {
                flex-direction: column;
                align-items: stretch;
            }

            .right-actions,
            .left-actions {
                width: 100%;
                flex-direction: column;
            }

            .right-actions .btn,
            .left-actions .btn {
                width: 100%;
            }
        }
    </style>
@endsection

@section('content')

    <div class="translation-form-page">

        {{-- Header --}}

        <div class="page-header">

            <div>
                <h1>ویرایش ترجمه دسته‌بندی</h1>

                <p>
                    اطلاعات ترجمه و مشخصات سئو را ویرایش کنید.
                </p>
            </div>

            <div class="translation-id">
                <i class="fas fa-hashtag"></i>
                {{ $categoryTranslation->id }}
            </div>

        </div>


        @if($errors->any())

            <div class="alert alert-danger mb-3">

                <strong>
                    لطفاً خطاهای زیر را بررسی کنید:
                </strong>

                <ul class="mb-0 mt-2">

                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                </ul>

            </div>

        @endif


        <form
            action="{{ route('admin.category.translation.update', $categoryTranslation->id) }}"
            method="POST"
        >

            @csrf
            @method('PUT')


            {{-- اطلاعات اصلی --}}

            <div class="form-card">

                <div class="section-title">

                    <div class="section-title-icon">
                        <i class="fas fa-language"></i>
                    </div>

                    <h2>اطلاعات ترجمه</h2>

                </div>


                <div class="form-grid">

                    {{-- Category --}}

                    <div class="form-group">

                        <label class="form-label">
                            دسته‌بندی
                            <span class="required">*</span>
                        </label>

                        <select
                            name="category_id"
                            class="form-select @error('category_id') is-invalid @enderror"
                        >

                            <option value="">
                                انتخاب دسته‌بندی
                            </option>

                            @foreach($categories as $category)

                                <option
                                    value="{{ $category->id }}"
                                    @selected(
                                        old(
                                            'category_id',
                                            $categoryTranslation->category_id
                                        ) == $category->id
                                    )
                                >
                                    {{ $category->name ?? 'دسته‌بندی #' . $category->id }}
                                </option>

                            @endforeach

                        </select>

                        @error('category_id')
                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                        @enderror

                    </div>


                    {{-- Locale --}}

                    <div class="form-group">

                        <label class="form-label">
                            زبان
                            <span class="required">*</span>
                        </label>

                        <select
                            name="locale"
                            class="form-select @error('locale') is-invalid @enderror"
                        >

                            <option value="">
                                انتخاب زبان
                            </option>

                            <option
                                value="fa"
                                @selected(
                                    old(
                                        'locale',
                                        $categoryTranslation->locale
                                    ) === 'fa'
                                )
                            >
                                فارسی
                            </option>

                            <option
                                value="en"
                                @selected(
                                    old(
                                        'locale',
                                        $categoryTranslation->locale
                                    ) === 'en'
                                )
                            >
                                English
                            </option>

                            <option
                                value="ar"
                                @selected(
                                    old(
                                        'locale',
                                        $categoryTranslation->locale
                                    ) === 'ar'
                                )
                            >
                                العربية
                            </option>

                        </select>

                        @error('locale')
                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                        @enderror

                    </div>


                    {{-- Name --}}

                    <div class="form-group">

                        <label class="form-label">
                            نام دسته‌بندی
                            <span class="required">*</span>
                        </label>

                        <input
                            type="text"
                            name="name"
                            value="{{ old('name', $categoryTranslation->name) }}"
                            class="form-control @error('name') is-invalid @enderror"
                            placeholder="نام دسته‌بندی"
                        >

                        @error('name')
                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                        @enderror

                    </div>


                    {{-- Slug --}}

                    <div class="form-group">

                        <label class="form-label">
                            Slug
                            <span class="required">*</span>
                        </label>

                        <input
                            type="text"
                            name="slug"
                            value="{{ old('slug', $categoryTranslation->slug) }}"
                            class="form-control slug-input @error('slug') is-invalid @enderror"
                            placeholder="saffron"
                            dir="ltr"
                        >

                        <span class="help-text">
                        فقط حروف انگلیسی کوچک، اعداد و خط تیره.
                    </span>

                        @error('slug')
                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                        @enderror

                    </div>


                    {{-- Short Description --}}

                    <div class="form-group full">

                        <label class="form-label">
                            توضیح کوتاه
                        </label>

                        <textarea
                            name="short_description"
                            class="form-control short-description @error('short_description') is-invalid @enderror"
                            placeholder="توضیح کوتاه..."
                        >{{ old('short_description', $categoryTranslation->short_description) }}</textarea>

                        @error('short_description')
                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                        @enderror

                    </div>


                    {{-- Description --}}

                    <div class="form-group full">

                        <label class="form-label">
                            توضیحات کامل
                        </label>

                        <textarea
                            name="description"
                            class="form-control @error('description') is-invalid @enderror"
                            placeholder="توضیحات کامل..."
                        >{{ old('description', $categoryTranslation->description) }}</textarea>

                        @error('description')
                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                        @enderror

                    </div>

                </div>

            </div>


            {{-- SEO --}}

            <div class="form-card">

                <div class="section-title">

                    <div class="section-title-icon">
                        <i class="fas fa-search"></i>
                    </div>

                    <h2>اطلاعات SEO</h2>

                </div>


                <div class="seo-note">
                    عنوان SEO حداکثر ۶۰ کاراکتر و توضیحات SEO حداکثر ۱۶۰ کاراکتر باشد.
                </div>


                <div class="form-grid">

                    {{-- Meta Title --}}

                    <div class="form-group full">

                        <label class="form-label">
                            عنوان SEO
                        </label>

                        <input
                            type="text"
                            name="meta_title"
                            value="{{ old('meta_title', $categoryTranslation->meta_title) }}"
                            maxlength="60"
                            class="form-control @error('meta_title') is-invalid @enderror"
                            placeholder="عنوان مناسب برای موتورهای جستجو"
                        >

                        @error('meta_title')
                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                        @enderror

                    </div>


                    {{-- Meta Description --}}

                    <div class="form-group full">

                        <label class="form-label">
                            توضیحات SEO
                        </label>

                        <textarea
                            name="meta_description"
                            maxlength="160"
                            class="form-control short-description @error('meta_description') is-invalid @enderror"
                            placeholder="توضیحات مناسب برای نتایج جستجو..."
                        >{{ old('meta_description', $categoryTranslation->meta_description) }}</textarea>

                        @error('meta_description')
                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                        @enderror

                    </div>


                    {{-- Meta Keywords --}}

                    <div class="form-group full">

                        <label class="form-label">
                            کلمات کلیدی
                        </label>

                        <input
                            type="text"
                            name="meta_keywords"
                            value="{{ old('meta_keywords', $categoryTranslation->meta_keywords) }}"
                            class="form-control @error('meta_keywords') is-invalid @enderror"
                            placeholder="زعفران، صادرات زعفران، زعفران ایرانی"
                        >

                        <span class="help-text">
                        کلمات کلیدی را با کاما از یکدیگر جدا کنید.
                    </span>

                        @error('meta_keywords')
                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                        @enderror

                    </div>

                </div>


                {{-- Actions --}}

                <div class="form-actions">

                    <div class="right-actions">

                        <a
                            href="{{ route('admin.category.translation.index') }}"
                            class="btn btn-secondary"
                        >
                            <i class="fas fa-arrow-right"></i>
                            بازگشت
                        </a>

                    </div>


                    <div class="left-actions">

                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            <i class="fas fa-save"></i>
                            ذخیره تغییرات
                        </button>

                    </div>

                </div>

            </div>

        </form>


        {{-- Delete --}}

        <div class="form-card">

            <div class="section-title">

                <div class="section-title-icon"
                     style="background:#fef2f2;color:#dc2626;">
                    <i class="fas fa-trash"></i>
                </div>

                <h2>حذف ترجمه</h2>

            </div>

            <p style="
            margin:0 0 15px;
            color:#6b7280;
            font-size:13px;
            line-height:1.8;
        ">
                در صورت حذف این ترجمه، اطلاعات این زبان از دسته‌بندی حذف خواهد شد.
                خود دسته‌بندی حذف نمی‌شود.
            </p>


            <form
                action="{{ route('admin.category.translation.delete', $categoryTranslation) }}"
                method="POST"
                onsubmit="return confirm('آیا از حذف این ترجمه مطمئن هستید؟');"
            >

                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    class="btn btn-danger"
                >
                    <i class="fas fa-trash"></i>
                    حذف این ترجمه
                </button>

            </form>

        </div>

    </div>

@endsection

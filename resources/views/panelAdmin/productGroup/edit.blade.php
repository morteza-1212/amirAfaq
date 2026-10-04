@extends('panelAdmin.layouts.panel')

@section('title', 'ویرایش گروه محصول')
@section('style')
    <style>
        /* ═══════════════════════════════════════════════════════════
           Product Group - Create Page Styles
           صفحه افزودن گروه محصول
        ═══════════════════════════════════════════════════════════ */

        /* ─────────── متغیرهای رنگی ─────────── */
        .product-groups-page {
            --pg-primary: #2563eb;
            --pg-primary-dark: #1d4ed8;
            --pg-primary-light: #eff6ff;
            --pg-primary-50: #f0f7ff;
            --pg-success: #16a34a;
            --pg-danger: #dc2626;
            --pg-danger-light: #fef2f2;
            --pg-warning: #eab308;
            --pg-gray-50: #f9fafb;
            --pg-gray-100: #f3f4f6;
            --pg-gray-200: #e5e7eb;
            --pg-gray-300: #d1d5db;
            --pg-gray-400: #9ca3af;
            --pg-gray-500: #6b7280;
            --pg-gray-600: #4b5563;
            --pg-gray-700: #374151;
            --pg-gray-800: #1f2937;
            --pg-gray-900: #111827;
            --pg-transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* ═══════════════════════════════════════════════════════════
           فرم اصلی
        ═══════════════════════════════════════════════════════════ */
        .pg-form-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.125rem;
        }

        /* فیلد */
        .pg-field {
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        /* فیلد تمام‌عرض */
        .pg-field-full {
            grid-column: 1 / -1;
        }

        /* برچسب */
        .pg-field label {
            display: inline-flex;
            align-items: center;
            font-size: 0.8125rem;
            font-weight: 600;
            color: var(--pg-gray-700);
            margin-bottom: 0.5rem;
            letter-spacing: -0.005em;
        }

        /* ستاره الزامی */
        .pg-required {
            color: var(--pg-danger);
            margin-right: 0.125rem;
            font-size: 0.875rem;
            line-height: 1;
        }

        /* راهنمای زیر فیلد */
        .pg-hint {
            display: block;
            font-size: 0.7rem;
            color: var(--pg-gray-500);
            margin-top: 0.375rem;
            line-height: 1.5;
        }

        .pg-hint code {
            background: var(--pg-gray-100);
            color: var(--pg-gray-700);
            padding: 0.0625rem 0.375rem;
            border-radius: 0.25rem;
            font-family: 'Courier New', monospace;
            font-size: 0.6875rem;
            direction: ltr;
            display: inline-block;
        }

        /* پیام خطای هر فیلد */
        .pg-field-error {
            display: block;
            font-size: 0.75rem;
            color: var(--pg-danger);
            margin-top: 0.375rem;
            line-height: 1.5;
            animation: pgErrorSlide 0.25s ease-out;
        }

        @keyframes pgErrorSlide {
            from { opacity: 0; transform: translateY(-4px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ═══════════════════════════════════════════════════════════
           ورودی‌ها (تقویت کلاس‌های پایه)
        ═══════════════════════════════════════════════════════════ */
        .product-groups-page .pg-input,
        .product-groups-page .pg-select {
            height: 2.75rem;
            font-size: 0.875rem;
            padding-top: 0;
            padding-bottom: 0;
        }

        .product-groups-page .pg-input:focus,
        .product-groups-page .pg-select:focus {
            background: #fff;
        }

        /* حالت خطا */
        .product-groups-page .pg-input.pg-input-error,
        .product-groups-page .pg-select.pg-select-error,
        .product-groups-page .pg-file-input.pg-input-error {
            border-color: var(--pg-danger);
            background: #fff8f8;
        }

        .product-groups-page .pg-input.pg-input-error:focus,
        .product-groups-page .pg-select.pg-select-error:focus,
        .product-groups-page .pg-file-input.pg-input-error:focus {
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.12);
        }

        /* ═══════════════════════════════════════════════════════════
           باکس آپلود تصویر
        ═══════════════════════════════════════════════════════════ */
        .pg-upload-box {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            flex-wrap: wrap;
            padding: 1rem;
            background: var(--pg-gray-50);
            border: 1px dashed var(--pg-gray-300);
            border-radius: 0.75rem;
            transition: var(--pg-transition);
        }

        .pg-upload-box:hover {
            background: var(--pg-primary-50);
            border-color: var(--pg-primary);
        }

        /* پیش‌نمایش */
        .pg-upload-preview {
            position: relative;
            width: 5.5rem;
            height: 5.5rem;
            border-radius: 0.75rem;
            overflow: hidden;
            background: #fff;
            border: 2px dashed var(--pg-gray-300);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--pg-transition);
            flex-shrink: 0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        }

        .pg-upload-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            animation: pgFadeIn 0.3s ease;
        }

        @keyframes pgFadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }

        .pg-upload-preview:hover {
            border-color: var(--pg-primary);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15);
        }

        .pg-upload-preview-placeholder {
            color: var(--pg-gray-400);
            font-size: 1.5rem;
            transition: var(--pg-transition);
        }

        .pg-upload-preview:hover .pg-upload-preview-placeholder {
            color: var(--pg-primary);
            transform: scale(1.1);
        }

        /* ورودی فایل */
        .pg-upload-input-wrap {
            flex: 1;
            min-width: 200px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .pg-file-input {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid var(--pg-gray-300);
            border-radius: 0.5rem;
            font-size: 0.875rem;
            background: #fff;
            transition: var(--pg-transition);
            font-family: inherit;
            cursor: pointer;
            min-height: 2.75rem;
        }

        .pg-file-input:hover {
            border-color: var(--pg-gray-400);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
        }

        .pg-file-input:focus {
            outline: none;
            border-color: var(--pg-primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }

        .pg-file-input::file-selector-button {
            background: var(--pg-gray-100);
            color: var(--pg-gray-700);
            border: none;
            padding: 0.4rem 0.875rem;
            border-radius: 0.375rem;
            margin-left: 0.5rem;
            font-size: 0.8125rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--pg-transition);
            font-family: inherit;
        }

        .pg-file-input::file-selector-button:hover {
            background: var(--pg-primary);
            color: #fff;
        }

        /* ═══════════════════════════════════════════════════════════
           باکس اطلاعات راهنما
        ═══════════════════════════════════════════════════════════ */
        .pg-info-box {
            grid-column: 1 / -1;
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            border: 1px solid #bfdbfe;
            border-right: 4px solid var(--pg-primary);
            border-radius: 0.625rem;
            padding: 0.875rem 1rem;
            font-size: 0.8125rem;
            color: #1e40af;
            display: flex;
            align-items: flex-start;
            gap: 0.625rem;
            line-height: 1.7;
            box-shadow: 0 1px 2px rgba(37, 99, 235, 0.05);
        }

        .pg-info-box svg {
            width: 1.125rem;
            height: 1.125rem;
            flex-shrink: 0;
            margin-top: 0.1875rem;
            color: var(--pg-primary);
        }

        .pg-info-box strong {
            font-weight: 700;
            color: #1e3a8a;
        }

        /* ═══════════════════════════════════════════════════════════
           نوار دکمه‌ها
        ═══════════════════════════════════════════════════════════ */
        .pg-form-actions {
            grid-column: 1 / -1;
            display: flex;
            flex-direction: column-reverse;
            gap: 0.75rem;
            padding-top: 1.25rem;
            border-top: 1px solid var(--pg-gray-100);
            margin-top: 0.5rem;
        }

        /* دکمه انصراف */
        .pg-btn-cancel {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            background: #fff;
            color: var(--pg-gray-700);
            border: 1px solid var(--pg-gray-300);
            padding: 0.6875rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 600;
            transition: var(--pg-transition);
            text-decoration: none;
            width: 100%;
            cursor: pointer;
            font-family: inherit;
            min-height: 2.75rem;
        }

        .pg-btn-cancel:hover {
            background: var(--pg-gray-50);
            border-color: var(--pg-gray-400);
            color: var(--pg-gray-900);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.06);
        }

        .pg-btn-cancel:active {
            transform: translateY(0);
        }

        /* دکمه ذخیره */
        .pg-form-actions .pg-btn-add {
            width: 100%;
            min-height: 2.75rem;
            padding: 0.6875rem 1rem;
            font-size: 0.875rem;
            font-weight: 600;
            border-radius: 0.5rem;
        }

        /* آیکون داخل دکمه‌ها */
        .pg-btn-cancel svg,
        .pg-form-actions .pg-btn-add svg {
            width: 1rem;
            height: 1rem;
            flex-shrink: 0;
        }

        /* ═══════════════════════════════════════════════════════════
           کارت فرم
        ═══════════════════════════════════════════════════════════ */
        .product-groups-page .pg-filter-card {
            padding: 1.25rem 1rem;
        }

        /* ═══════════════════════════════════════════════════════════
           ریسپانسیو
        ═══════════════════════════════════════════════════════════ */

        /* ── موبایل کوچک ── */
        @media (max-width: 480px) {
            .pg-form-grid {
                gap: 1rem;
            }

            .product-groups-page .pg-filter-card {
                padding: 1rem 0.875rem;
            }

            .pg-field label {
                font-size: 0.75rem;
            }

            .pg-upload-box {
                padding: 0.875rem;
                gap: 0.875rem;
            }

            .pg-upload-preview {
                width: 4.5rem;
                height: 4.5rem;
            }

            .pg-upload-preview-placeholder {
                font-size: 1.25rem;
            }

            .pg-info-box {
                font-size: 0.75rem;
                padding: 0.75rem 0.875rem;
            }
        }

        /* ── موبایل/تبلت کوچک ── */
        @media (min-width: 640px) {
            .pg-form-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 1.25rem;
            }

            .product-groups-page .pg-filter-card {
                padding: 1.5rem;
            }

            .pg-form-actions {
                flex-direction: row;
                justify-content: flex-end;
                gap: 0.75rem;
            }

            .pg-btn-cancel {
                width: auto;
                min-width: 8rem;
            }

            .pg-form-actions .pg-btn-add {
                width: auto;
                min-width: 10rem;
            }
        }

        /* ── تبلت ── */
        @media (min-width: 768px) {
            .pg-upload-preview {
                width: 6rem;
                height: 6rem;
            }

            .pg-upload-preview-placeholder {
                font-size: 1.75rem;
            }
        }

        /* ── دسکتاپ ── */
        @media (min-width: 1024px) {
            .pg-form-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 1.5rem;
            }

            .product-groups-page .pg-filter-card {
                padding: 2rem;
            }

            .pg-field label {
                font-size: 0.875rem;
            }

            .pg-upload-preview {
                width: 6.5rem;
                height: 6.5rem;
            }

            .pg-form-actions {
                gap: 1rem;
                padding-top: 1.5rem;
            }
        }

        /* ── دسکتاپ بزرگ ── */
        @media (min-width: 1280px) {
            .product-groups-page .pg-filter-card {
                padding: 2.25rem;
            }
        }

        /* ═══════════════════════════════════════════════════════════
           حالت چاپ
        ═══════════════════════════════════════════════════════════ */
        @media print {
            .pg-form-actions,
            .pg-btn-cancel,
            .pg-upload-input-wrap,
            .pg-info-box {
                display: none !important;
            }

            .pg-form-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .pg-upload-box {
                border: 1px solid var(--pg-gray-300);
                background: #fff;
            }
        }

        /* ═══════════════════════════════════════════════════════════
           دسترسی‌پذیری
        ═══════════════════════════════════════════════════════════ */
        .pg-form-grid input:focus-visible,
        .pg-form-grid select:focus-visible,
        .pg-form-grid button:focus-visible,
        .pg-form-grid a:focus-visible {
            outline: 2px solid var(--pg-primary);
            outline-offset: 2px;
        }

        @media (prefers-reduced-motion: reduce) {
            .pg-form-grid *,
            .pg-form-grid *::before,
            .pg-form-grid *::after {
                animation-duration: 0.01ms !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>

@endsection


@section('content')
    <div class="product-groups-page">
        <div class="pg-container">

            {{-- ═══════════════════ هدر ═══════════════════ --}}
            <div class="pg-header">
                <div>
                    <h1 class="pg-title">
                        <span class="pg-title-icon">

                        </span>
                        ویرایش گروه محصول
                    </h1>
                    <p class="pg-subtitle">
                        در حال ویرایش گروه
                        <strong style="color:#2563eb;">{{ $productGroup->code }}</strong>
                    </p>
                </div>

                <a href="{{ route('admin.productGroup.index') }}"
                   class="pg-btn-cancel"
                   style="width:auto;padding:0.625rem 1rem;">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11 17l-5-5m0 0l5-5m-5 5h12"/>
                    </svg>
                    بازگشت به لیست
                </a>
            </div>

            {{-- ═══════════════════ خطاهای کلی ═══════════════════ --}}
            @if ($errors->any())
                <div class="pg-alert pg-alert-error" role="alert">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <strong style="display:block;margin-bottom:0.25rem;">
                            لطفاً خطاهای زیر را برطرف کنید:
                        </strong>
                        <ul style="margin:0;padding-right:1.25rem;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            {{-- ═══════════════════ فرم ═══════════════════ --}}
            <div class="pg-filter-card">
                <form method="POST"
                      action="{{ route('admin.productGroup.update', $productGroup->id) }}"
                      enctype="multipart/form-data"
                      class="pg-form-grid"
                      novalidate>
                    @csrf
                    @method('PUT')

                    {{-- کد گروه --}}
                    <div class="pg-field">
                        <label for="code">
                            کد گروه <span class="pg-required">*</span>
                        </label>
                        <input type="text"
                               name="code"
                               id="code"
                               value="{{ old('code', $productGroup->code) }}"
                               placeholder="مثال: GRP-001"
                               class="pg-input @error('code') pg-input-error @enderror"
                               required
                               autofocus>
                        @error('code')
                        <span class="pg-field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- نوع --}}
                    <div class="pg-field">
                        <label for="type">
                            نوع <span class="pg-required">*</span>
                        </label>
                        <select name="type"
                                id="type"
                                class="pg-select @error('type') pg-select-error @enderror"
                                required>
                            <option value="agricultural" @selected(old('type', $productGroup->type) === 'agricultural')>کشاورزی</option>
                            <option value="industrial"   @selected(old('type', $productGroup->type) === 'industrial')>صنعتی</option>
                            <option value="raw_material" @selected(old('type', $productGroup->type) === 'raw_material')>مواد خام</option>
                        </select>
                        @error('type')
                        <span class="pg-field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- ترتیب --}}
                    <div class="pg-field">
                        <label for="sort_order">ترتیب</label>
                        <input type="number"
                               name="sort_order"
                               id="sort_order"
                               min="0"
                               value="{{ old('sort_order', $productGroup->sort_order) }}"
                               placeholder="0"
                               class="pg-input @error('sort_order') pg-input-error @enderror">
                        <span class="pg-hint">عدد کوچکتر = نمایش بالاتر</span>
                        @error('sort_order')
                        <span class="pg-field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- آیکون --}}
                    <div class="pg-field">
                        <label for="icon">آیکون (کلاس Font Awesome)</label>
                        <input type="text"
                               name="icon"
                               id="icon"
                               value="{{ old('icon', $productGroup->icon) }}"
                               placeholder="fas fa-box"
                               class="pg-input @error('icon') pg-input-error @enderror">
                        <span class="pg-hint">
                            مثال:
                            <code style="background:#f3f4f6;padding:1px 4px;border-radius:3px;">fas fa-leaf</code>
                        </span>
                        @error('icon')
                        <span class="pg-field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- وضعیت --}}
                    <div class="pg-field">
                        <label for="status">وضعیت</label>
                        <select name="status"
                                id="status"
                                class="pg-select @error('status') pg-select-error @enderror">
                            <option value="1" @selected(old('status', $productGroup->status ? '1' : '0') === '1')>فعال</option>
                            <option value="0" @selected(old('status', $productGroup->status ? '1' : '0') === '0')>غیرفعال</option>
                        </select>
                        @error('status')
                        <span class="pg-field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- ویژه --}}
                    <div class="pg-field">
                        <label for="is_featured">ویژه</label>
                        <select name="is_featured"
                                id="is_featured"
                                class="pg-select @error('is_featured') pg-select-error @enderror">
                            <option value="0" @selected(old('is_featured', $productGroup->is_featured ? '1' : '0') === '0')>خیر</option>
                            <option value="1" @selected(old('is_featured', $productGroup->is_featured ? '1' : '0') === '1')>بله</option>
                        </select>
                        @error('is_featured')
                        <span class="pg-field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- تصویر --}}
                    <div class="pg-field pg-field-full">
                        <label for="image">تصویر گروه</label>
                        <div class="pg-upload-box">

                            {{-- پیش‌نمایش --}}
                            <div class="pg-upload-preview" id="imagePreview">
                                @if ($productGroup->image)
                                    <img src="{{ asset('storage/' . $productGroup->image) }}"
                                         alt="{{ $productGroup->code }}"
                                         id="previewImg">
                                @else
                                    <span class="pg-upload-preview-placeholder" id="previewPlaceholder">
                                        <i class="fas fa-image"></i>
                                    </span>
                                @endif
                            </div>

                            {{-- ورودی فایل --}}
                            <div class="pg-upload-input-wrap">
                                <input type="file"
                                       name="image"
                                       id="image"
                                       accept="image/jpeg,image/png,image/webp,image/svg+xml"
                                       class="pg-file-input @error('image') pg-input-error @enderror">
                                <span class="pg-hint">
                                    فرمت‌های مجاز: JPG، PNG، WebP، SVG — حداکثر ۲ مگابایت
                                </span>
                                @error('image')
                                <span class="pg-field-error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- اطلاعات راهنما --}}
                    <div class="pg-info-box">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <strong>توجه:</strong>
                            اگر تصویر جدیدی انتخاب نکنید، تصویر فعلی حفظ می‌شود.
                            در صورت انتخاب تصویر جدید، تصویر قبلی به‌طور خودکار حذف خواهد شد.
                        </div>
                    </div>

                    {{-- دکمه‌ها --}}
                    <div class="pg-form-actions">
                        <a href="{{ route('admin.productGroup.index') }}" class="pg-btn-cancel">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            انصراف
                        </a>

                        <button type="submit" class="pg-btn-add">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M5 13l4 4L19 7"/>
                            </svg>
                            بروزرسانی گروه
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const fileInput   = document.getElementById('image');
            const preview     = document.getElementById('imagePreview');
            const previewImg  = document.getElementById('previewImg');
            const placeholder = document.getElementById('previewPlaceholder');

            if (!fileInput || !preview) return;

            fileInput.addEventListener('change', function (e) {
                const file = e.target.files && e.target.files[0];
                if (!file) return;

                // اعتبارسنجی سریع سمت کلاینت
                const maxSize = 2 * 1024 * 1024; // 2MB
                if (file.size > maxSize) {
                    alert('حجم تصویر نباید بیشتر از ۲ مگابایت باشد.');
                    fileInput.value = '';
                    return;
                }

                const allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml'];
                if (!allowed.includes(file.type)) {
                    alert('فرمت تصویر مجاز نیست.');
                    fileInput.value = '';
                    return;
                }

                // پیش‌نمایش
                const reader = new FileReader();
                reader.onload = function (ev) {
                    // اگر img وجود ندارد، بساز
                    let img = document.getElementById('previewImg');
                    if (!img) {
                        img = document.createElement('img');
                        img.id = 'previewImg';
                        preview.innerHTML = '';
                        preview.appendChild(img);
                    }
                    img.src = ev.target.result;
                    img.alt = 'پیش‌نمایش تصویر جدید';
                };
                reader.readAsDataURL(file);
            });
        });
    </script>
@endpush

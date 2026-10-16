@extends('panelAdmin.layouts.panel')

@section('title', 'افزودن محصول جدید')

@section('content')
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">
                    <i class="fas fa-plus-circle me-2"></i>
                    افزودن محصول جدید
                </h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.product.index') }}">محصولات</a>
                        </li>
                        <li class="breadcrumb-item active">ایجاد</li>
                    </ol>
                </nav>
            </div>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                <h6 class="alert-heading">
                    <i class="fas fa-exclamation-triangle me-1"></i>
                    خطاهای زیر را برطرف کنید:
                </h6>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @php
            $locales       = \App\Models\Product::LOCALES;
            $defaultLocale = \App\Models\Product::DEFAULT_LOCALE;
        @endphp

        <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-3">

                {{-- تب‌های زبان --}}
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs" role="tablist">
                                @foreach($locales as $code => $label)
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link @if($loop->first) active @endif"
                                                data-bs-toggle="tab"
                                                data-bs-target="#lang-{{ $code }}"
                                                type="button"
                                                role="tab">
                                            <i class="fas fa-globe me-1"></i>
                                            {{ $label }}
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="card-body">
                            <div class="tab-content">
                                @foreach($locales as $code => $label)
                                    @php $isDefault = $code === $defaultLocale; @endphp
                                    <div class="tab-pane fade @if($loop->first) show active @endif"
                                         id="lang-{{ $code }}">
                                        <div class="mb-3">
                                            <label class="form-label">
                                                نام محصول @if($isDefault)<span class="text-danger">*</span>@endif
                                            </label>
                                            <input type="text"
                                                   name="translations[{{ $code }}][name]"
                                                   class="form-control"
                                                   value="{{ old("translations.{$code}.name") }}"
                                                   @if($isDefault) required @endif>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">نامک (Slug)</label>
                                            <input type="text"
                                                   name="translations[{{ $code }}][slug]"
                                                   class="form-control"
                                                   value="{{ old("translations.{$code}.slug") }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">توضیح کوتاه</label>
                                            <textarea name="translations[{{ $code }}][short_description]"
                                                      class="form-control" rows="2">{{ old("translations.{$code}.short_description") }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">توضیحات کامل</label>
                                            <textarea name="translations[{{ $code }}][description]"
                                                      class="form-control" rows="5">{{ old("translations.{$code}.description") }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">مشخصات</label>
                                            <textarea name="translations[{{ $code }}][specifications]"
                                                      class="form-control" rows="3">{{ old("translations.{$code}.specifications") }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">ویژگی‌ها</label>
                                            <textarea name="translations[{{ $code }}][features]"
                                                      class="form-control" rows="3">{{ old("translations.{$code}.features") }}</textarea>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">بسته‌بندی</label>
                                                <textarea name="translations[{{ $code }}][packaging]"
                                                          class="form-control" rows="2">{{ old("translations.{$code}.packaging") }}</textarea>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">اطلاعات حمل</label>
                                                <textarea name="translations[{{ $code }}][shipping_info]"
                                                          class="form-control" rows="2">{{ old("translations.{$code}.shipping_info") }}</textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">عنوان متا</label>
                                                <input type="text"
                                                       name="translations[{{ $code }}][meta_title]"
                                                       class="form-control"
                                                       value="{{ old("translations.{$code}.meta_title") }}">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">کلمات کلیدی متا</label>
                                                <input type="text"
                                                       name="translations[{{ $code }}][meta_keywords]"
                                                       class="form-control"
                                                       value="{{ old("translations.{$code}.meta_keywords") }}">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">متن جایگزین تصویر</label>
                                                <input type="text"
                                                       name="translations[{{ $code }}][alt_text]"
                                                       class="form-control"
                                                       value="{{ old("translations.{$code}.alt_text") }}">
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label class="form-label">توضیحات متا</label>
                                                <textarea name="translations[{{ $code }}][meta_description]"
                                                          class="form-control" rows="2">{{ old("translations.{$code}.meta_description") }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- اطلاعات پایه --}}
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-info-circle me-1"></i>
                                اطلاعات پایه
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">دسته‌بندی <span class="text-danger">*</span></label>
                                <select name="category_id" class="form-select" required>
                                    <option value="">-- انتخاب --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}"
                                            @selected(old('category_id') == $category->id)>
                                            {{ $category->translation('fa')?->name
                                                ?? $category->translation('en')?->name
                                                ?? 'بدون نام' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">SKU</label>
                                <input type="text" name="sku" class="form-control"
                                       value="{{ old('sku') }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">نوع محصول</label>
                                <select name="type" class="form-select">
                                    @foreach(\App\Models\Product::TYPES as $key => $labels)
                                        <option value="{{ $key }}" @selected(old('type') === $key)>
                                            {{ $labels[app()->getLocale()] ?? $labels['fa'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">وضعیت موجودی</label>
                                <select name="stock_status" class="form-select">
                                    @foreach(\App\Models\Product::STOCK_STATUSES as $key => $labels)
                                        <option value="{{ $key }}" @selected(old('stock_status') === $key)>
                                            {{ $labels[app()->getLocale()] ?? $labels['fa'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">ترتیب نمایش</label>
                                <input type="number" name="sort_order" class="form-control"
                                       value="{{ old('sort_order', 0) }}" min="0">
                            </div>

                            <div class="d-flex gap-4">
                                <div class="form-check form-switch">
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox" name="is_active" value="1"
                                           class="form-check-input" id="is_active"
                                        @checked(old('is_active', true))>
                                    <label class="form-check-label" for="is_active">فعال</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input type="hidden" name="is_featured" value="0">
                                    <input type="checkbox" name="is_featured" value="1"
                                           class="form-check-input" id="is_featured"
                                        @checked(old('is_featured', false))>
                                    <label class="form-check-label" for="is_featured">ویژه</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- مشخصات فنی --}}
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-cogs me-1"></i>
                                مشخصات فنی
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">واحد</label>
                                    <select name="unit" class="form-select">
                                        <option value="">-- انتخاب --</option>
                                        @foreach(\App\Models\Product::UNITS as $key => $labels)
                                            <option value="{{ $key }}" @selected(old('unit') === $key)>
                                                {{ $labels[app()->getLocale()] ?? $labels['fa'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">وزن</label>
                                    <input type="number" step="0.001" name="weight" class="form-control"
                                           value="{{ old('weight') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">کشور مبدا</label>
                                    <input type="text" name="origin_country" class="form-control"
                                           value="{{ old('origin_country', 'Iran') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">حداقل سفارش</label>
                                    <input type="number" step="0.001" name="minimum_order" class="form-control"
                                           value="{{ old('minimum_order') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">مدت آماده‌سازی (روز)</label>
                                    <input type="number" name="preparation_days" class="form-control"
                                           value="{{ old('preparation_days') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- تصاویر --}}
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-image me-1"></i>
                                تصاویر
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">تصویر اصلی <span class="text-danger">*</span></label>
                                    <input type="file" name="image" id="image" accept="image/*"
                                           class="form-control" onchange="previewImage(this)" required>
                                    <small class="text-muted">JPG, PNG, WEBP - حداکثر ۴ مگابایت</small>
                                    <div class="text-center mt-3">
                                        <img id="image-preview" src="" class="img-thumbnail d-none"
                                             style="max-height: 200px;">
                                        <div id="no-image-placeholder" class="text-muted py-4 border rounded">
                                            <i class="fas fa-image fa-3x mb-2"></i>
                                            <p class="mb-0">پیش‌نمایش تصویر</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">گالری (چندتایی)</label>
                                    <input type="file" name="gallery[]" id="gallery" accept="image/*"
                                           class="form-control" onchange="previewGallery(this)" multiple>
                                    <div id="gallery-preview" class="d-flex flex-wrap gap-2 mt-3"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- دکمه‌ها --}}
            <div class="card mt-3">
                <div class="card-body d-flex justify-content-between">
                    <a href="{{ route('admin.product.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-right me-1"></i>
                        انصراف
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>
                        ذخیره محصول
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('styles')
    <style>
        .nav-tabs .nav-link { color: #495057; }
        .nav-tabs .nav-link.active { font-weight: bold; }
        #gallery-preview img {
            width: 90px; height: 90px; object-fit: cover;
            border-radius: 8px; border: 1px solid #dee2e6;
        }
    </style>
@endpush

@push('scripts')
    <script>
        function previewImage(input) {
            const preview = document.getElementById('image-preview');
            const placeholder = document.getElementById('no-image-placeholder');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                    if (placeholder) placeholder.classList.add('d-none');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        function previewGallery(input) {
            const container = document.getElementById('gallery-preview');
            container.innerHTML = '';
            if (input.files) {
                Array.from(input.files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = e => {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        container.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                });
            }
        }
    </script>
@endpush

@extends('panelAdmin.layouts.panel')

@section('title', 'ویرایش محصول')

@section('content')
    <div class="container-fluid">

        {{-- هدر --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">
                    <i class="fas fa-edit me-2"></i>
                    ویرایش محصول
                </h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.product.index') }}">محصولات</a>
                        </li>
                        <li class="breadcrumb-item active">ویرایش</li>
                    </ol>
                </nav>
            </div>
        </div>

        {{-- پیام موفقیت --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-1"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- خطاها --}}
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

        <form action="{{ route('admin.product.update', $product) }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-3">

                {{-- ==================== تب‌های زبان ==================== --}}
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs" role="tablist">
                                @foreach($locales as $code => $label)
                                    @php $t = $product->translations->firstWhere('locale', $code); @endphp
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link @if($loop->first) active @endif"
                                                data-bs-toggle="tab"
                                                data-bs-target="#lang-{{ $code }}"
                                                type="button"
                                                role="tab">
                                            <i class="fas fa-globe me-1"></i>
                                            {{ $label }}
                                            @if($t)
                                                <span class="badge bg-success ms-1">✓</span>
                                            @endif
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="card-body">
                            <div class="tab-content">
                                @foreach($locales as $code => $label)
                                    @php
                                        $t = $product->translations->firstWhere('locale', $code);
                                        $isDefault = $code === $defaultLocale;
                                    @endphp

                                    <div class="tab-pane fade @if($loop->first) show active @endif"
                                         id="lang-{{ $code }}"
                                         role="tabpanel">

                                        {{-- نام --}}
                                        <div class="mb-3">
                                            <label class="form-label">
                                                نام محصول
                                                @if($isDefault) <span class="text-danger">*</span> @endif
                                                <small class="text-muted">({{ $label }})</small>
                                            </label>
                                            <input type="text"
                                                   name="translations[{{ $code }}][name]"
                                                   class="form-control @error("translations.{$code}.name") is-invalid @enderror"
                                                   value="{{ old("translations.{$code}.name", $t?->name) }}"
                                                   @if($isDefault) required @endif>
                                            @error("translations.{$code}.name")
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- slug --}}
                                        <div class="mb-3">
                                            <label class="form-label">
                                                نامک (Slug)
                                                <small class="text-muted">({{ $label }})</small>
                                            </label>
                                            <input type="text"
                                                   name="translations[{{ $code }}][slug]"
                                                   class="form-control @error("translations.{$code}.slug") is-invalid @enderror"
                                                   value="{{ old("translations.{$code}.slug", $t?->slug) }}"
                                                   placeholder="در صورت خالی بودن، خودکار ساخته می‌شود">
                                            @error("translations.{$code}.slug")
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- توضیح کوتاه --}}
                                        <div class="mb-3">
                                            <label class="form-label">
                                                توضیح کوتاه
                                                <small class="text-muted">({{ $label }})</small>
                                            </label>
                                            <textarea name="translations[{{ $code }}][short_description]"
                                                      class="form-control"
                                                      rows="2">{{ old("translations.{$code}.short_description", $t?->short_description) }}</textarea>
                                        </div>

                                        {{-- توضیحات کامل --}}
                                        <div class="mb-3">
                                            <label class="form-label">
                                                توضیحات کامل
                                                <small class="text-muted">({{ $label }})</small>
                                            </label>
                                            <textarea name="translations[{{ $code }}][description]"
                                                      class="form-control"
                                                      rows="5">{{ old("translations.{$code}.description", $t?->description) }}</textarea>
                                        </div>

                                        {{-- مشخصات --}}
                                        <div class="mb-3">
                                            <label class="form-label">
                                                مشخصات
                                                <small class="text-muted">({{ $label }})</small>
                                            </label>
                                            <textarea name="translations[{{ $code }}][specifications]"
                                                      class="form-control"
                                                      rows="3">{{ old("translations.{$code}.specifications", $t?->specifications) }}</textarea>
                                        </div>

                                        {{-- ویژگی‌ها --}}
                                        <div class="mb-3">
                                            <label class="form-label">
                                                ویژگی‌ها
                                                <small class="text-muted">({{ $label }})</small>
                                            </label>
                                            <textarea name="translations[{{ $code }}][features]"
                                                      class="form-control"
                                                      rows="3">{{ old("translations.{$code}.features", $t?->features) }}</textarea>
                                        </div>

                                        {{-- بسته‌بندی و حمل --}}
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">بسته‌بندی</label>
                                                <textarea name="translations[{{ $code }}][packaging]"
                                                          class="form-control"
                                                          rows="2">{{ old("translations.{$code}.packaging", $t?->packaging) }}</textarea>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">اطلاعات حمل و نقل</label>
                                                <textarea name="translations[{{ $code }}][shipping_info]"
                                                          class="form-control"
                                                          rows="2">{{ old("translations.{$code}.shipping_info", $t?->shipping_info) }}</textarea>
                                            </div>
                                        </div>

                                        {{-- SEO --}}
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">عنوان متا</label>
                                                <input type="text"
                                                       name="translations[{{ $code }}][meta_title]"
                                                       class="form-control"
                                                       value="{{ old("translations.{$code}.meta_title", $t?->meta_title) }}">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">کلمات کلیدی متا</label>
                                                <input type="text"
                                                       name="translations[{{ $code }}][meta_keywords]"
                                                       class="form-control"
                                                       value="{{ old("translations.{$code}.meta_keywords", $t?->meta_keywords) }}">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">متن جایگزین تصویر</label>
                                                <input type="text"
                                                       name="translations[{{ $code }}][alt_text]"
                                                       class="form-control"
                                                       value="{{ old("translations.{$code}.alt_text", $t?->alt_text) }}">
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label class="form-label">توضیحات متا</label>
                                                <textarea name="translations[{{ $code }}][meta_description]"
                                                          class="form-control"
                                                          rows="2">{{ old("translations.{$code}.meta_description", $t?->meta_description) }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ==================== اطلاعات پایه ==================== --}}
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-info-circle me-1"></i>
                                اطلاعات پایه
                            </h5>
                        </div>
                        <div class="card-body">

                            {{-- کد (readonly) --}}
                            <div class="mb-3">
                                <label class="form-label">کد محصول</label>
                                <input type="text"
                                       class="form-control bg-light"
                                       value="{{ $product->code }}"
                                       readonly
                                       style="cursor: not-allowed;">
                                <small class="text-muted">
                                    <i class="fas fa-lock me-1"></i>
                                    این کد به‌صورت خودکار ساخته شده و قابل ویرایش نیست.
                                </small>
                            </div>

                            {{-- دسته‌بندی --}}
                            <div class="mb-3">
                                <label class="form-label">
                                    دسته‌بندی <span class="text-danger">*</span>
                                </label>
                                <select name="category_id"
                                        class="form-select @error('category_id') is-invalid @enderror"
                                        required>
                                    <option value="">-- انتخاب --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}"
                                            @selected(old('category_id', $product->category_id) == $category->id)>
                                            {{ $category->translation('fa')?->name
                                                ?? $category->translation('en')?->name
                                                ?? 'بدون نام' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- SKU --}}
                            <div class="mb-3">
                                <label class="form-label">SKU</label>
                                <input type="text"
                                       name="sku"
                                       class="form-control @error('sku') is-invalid @enderror"
                                       value="{{ old('sku', $product->sku) }}">
                                @error('sku')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- نوع --}}
                            <div class="mb-3">
                                <label class="form-label">
                                    نوع محصول <span class="text-danger">*</span>
                                </label>
                                <select name="type" class="form-select" required>
                                    @foreach(\App\Models\Product::TYPES as $key => $labels)
                                        <option value="{{ $key }}"
                                            @selected(old('type', $product->type) === $key)>
                                            {{ $labels[app()->getLocale()] ?? $labels['fa'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- وضعیت موجودی --}}
                            <div class="mb-3">
                                <label class="form-label">
                                    وضعیت موجودی <span class="text-danger">*</span>
                                </label>
                                <select name="stock_status" class="form-select" required>
                                    @foreach(\App\Models\Product::STOCK_STATUSES as $key => $labels)
                                        <option value="{{ $key }}"
                                            @selected(old('stock_status', $product->stock_status) === $key)>
                                            {{ $labels[app()->getLocale()] ?? $labels['fa'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- ترتیب --}}
                            <div class="mb-3">
                                <label class="form-label">ترتیب نمایش</label>
                                <input type="number"
                                       name="sort_order"
                                       class="form-control"
                                       min="0"
                                       value="{{ old('sort_order', $product->sort_order) }}">
                            </div>

                            {{-- وضعیت --}}
                            <div class="d-flex gap-4">
                                <div class="form-check form-switch">
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox"
                                           name="is_active"
                                           value="1"
                                           class="form-check-input"
                                           id="is_active"
                                        @checked(old('is_active', $product->is_active))>
                                    <label class="form-check-label" for="is_active">فعال</label>
                                </div>

                                <div class="form-check form-switch">
                                    <input type="hidden" name="is_featured" value="0">
                                    <input type="checkbox"
                                           name="is_featured"
                                           value="1"
                                           class="form-check-input"
                                           id="is_featured"
                                        @checked(old('is_featured', $product->is_featured))>
                                    <label class="form-check-label" for="is_featured">ویژه</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ==================== مشخصات فنی ==================== --}}
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

                                {{-- واحد --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">واحد</label>
                                    <select name="unit" class="form-select">
                                        <option value="">-- انتخاب --</option>
                                        @foreach(\App\Models\Product::UNITS as $key => $labels)
                                            <option value="{{ $key }}"
                                                @selected(old('unit', $product->unit) === $key)>
                                                {{ $labels[app()->getLocale()] ?? $labels['fa'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- وزن --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">وزن</label>
                                    <input type="number" step="0.001"
                                           name="weight"
                                           class="form-control"
                                           value="{{ old('weight', $product->weight) }}">
                                </div>

                                {{-- کشور مبدا --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">کشور مبدا</label>
                                    <input type="text"
                                           name="origin_country"
                                           class="form-control"
                                           value="{{ old('origin_country', $product->origin_country) }}">
                                </div>

                                {{-- حداقل سفارش --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">حداقل سفارش</label>
                                    <input type="number" step="0.001"
                                           name="minimum_order"
                                           class="form-control"
                                           value="{{ old('minimum_order', $product->minimum_order) }}">
                                </div>

                                {{-- مدت آماده‌سازی --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">مدت آماده‌سازی (روز)</label>
                                    <input type="number"
                                           name="preparation_days"
                                           class="form-control"
                                           value="{{ old('preparation_days', $product->preparation_days) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ==================== تصاویر ==================== --}}
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

                                {{-- تصویر اصلی --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">تغییر تصویر اصلی</label>
                                    <input type="file"
                                           name="image"
                                           id="image"
                                           accept="image/*"
                                           class="form-control @error('image') is-invalid @enderror"
                                           onchange="previewImage(this)">
                                    <small class="text-muted">
                                        در صورت عدم انتخاب، تصویر فعلی حفظ می‌شود.
                                    </small>
                                    @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    <div class="text-center mt-3">
                                        @if($product->image)
                                            <img id="image-preview"
                                                 src="{{ $product->image_url }}"
                                                 class="img-thumbnail"
                                                 style="max-height: 200px;">
                                        @else
                                            <img id="image-preview"
                                                 src=""
                                                 class="img-thumbnail d-none"
                                                 style="max-height: 200px;">
                                            <div id="no-image-placeholder"
                                                 class="text-muted py-4 border rounded">
                                                <i class="fas fa-image fa-3x mb-2"></i>
                                                <p class="mb-0">پیش‌نمایش تصویر</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                {{-- گالری --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">تغییر گالری تصاویر</label>
                                    <input type="file"
                                           name="gallery[]"
                                           id="gallery"
                                           accept="image/*"
                                           class="form-control"
                                           onchange="previewGallery(this)"
                                           multiple>
                                    <small class="text-muted">
                                        در صورت انتخاب، گالری فعلی جایگزین می‌شود.
                                    </small>

                                    <div id="gallery-preview" class="d-flex flex-wrap gap-2 mt-3">
                                        @if(! empty($product->gallery_urls))
                                            @foreach($product->gallery_urls as $url)
                                                <img src="{{ $url }}"
                                                     style="width:90px;height:90px;object-fit:cover;border-radius:8px;border:1px solid #dee2e6;">
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ==================== دکمه‌ها ==================== --}}
            <div class="card mt-3">
                <div class="card-body d-flex justify-content-between">
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.product.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-right me-1"></i>
                            بازگشت
                        </a>
                        <a href="{{ route('admin.product.show', $product) }}" class="btn btn-outline-secondary">
                            <i class="fas fa-eye me-1"></i>
                            مشاهده
                        </a>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="button"
                                class="btn btn-outline-danger"
                                onclick="if(confirm('آیا از حذف این محصول اطمینان دارید؟')) document.getElementById('delete-form').submit();">
                            <i class="fas fa-trash me-1"></i>
                            حذف
                        </button>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>
                            به‌روزرسانی
                        </button>
                    </div>
                </div>
            </div>
        </form>

        {{-- فرم مخفی حذف --}}
        <form id="delete-form"
              action="{{ route('admin.product.delete', $product) }}"
              method="POST"
              class="d-none">
            @csrf
            @method('DELETE')
        </form>
    </div>
@endsection

@push('styles')
    <style>
        .nav-tabs .nav-link { color: #495057; }
        .nav-tabs .nav-link.active { font-weight: bold; }

        #gallery-preview img {
            width: 90px;
            height: 90px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #dee2e6;
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
                reader.onload = function (e) {
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
                    reader.onload = function (e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.cssText = 'width:90px;height:90px;object-fit:cover;border-radius:8px;border:1px solid #dee2e6;';
                        container.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                });
            }
        }
    </script>
@endpush

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

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-1"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

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
                {{-- تب‌های زبان --}}
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs" role="tablist">
                                @foreach($locales as $code => $label)
                                    @php
                                        $t = $product->translations->firstWhere('locale', $code);
                                    @endphp
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

                                        <div class="mb-3">
                                            <label class="form-label">
                                                نام محصول
                                                @if($isDefault) <span class="text-danger">*</span> @endif
                                                <small class="text-muted">({{ $label }})</small>
                                            </label>
                                            <input type="text"
                                                   name="translations[{{ $code }}][name]"
                                                   class="form-control"
                                                   value="{{ old("translations.{$code}.name", $t?->name) }}"
                                                   @if($isDefault) required @endif>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">نامک (Slug)</label>
                                            <input type="text"
                                                   name="translations[{{ $code }}][slug]"
                                                   class="form-control"
                                                   value="{{ old("translations.{$code}.slug", $t?->slug) }}" >
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">توضیح کوتاه</label>
                                            <textarea name="translations[{{ $code }}][short_description]"
                                                      class="form-control"
                                                      rows="2">{{ old("translations.{$code}.short_description", $t?->short_description) }}</textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">توضیحات کامل</label>
                                            <textarea name="translations[{{ $code }}][description]"
                                                      class="form-control"
                                                      rows="5">{{ old("translations.{$code}.description", $t?->description) }}</textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">مشخصات</label>
                                            <textarea name="translations[{{ $code }}][specifications]"
                                                      class="form-control"
                                                      rows="3">{{ old("translations.{$code}.specifications", $t?->specifications) }}</textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">ویژگی‌ها</label>
                                            <textarea name="translations[{{ $code }}][features]"
                                                      class="form-control"
                                                      rows="3">{{ old("translations.{$code}.features", $t?->features) }}</textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">بسته‌بندی</label>
                                            <textarea name="translations[{{ $code }}][packaging]"
                                                      class="form-control"
                                                      rows="2">{{ old("translations.{$code}.packaging", $t?->packaging) }}</textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">اطلاعات حمل و نقل</label>
                                            <textarea name="translations[{{ $code }}][shipping_info]"
                                                      class="form-control"
                                                      rows="2">{{ old("translations.{$code}.shipping_info", $t?->shipping_info) }}</textarea>
                                        </div>

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
                                            @selected(old('category_id', $product->category_id) == $category->id)>
                                            {{ $category->translation('fa')?->name
                                                ?? $category->translation('en')?->name
                                                ?? 'بدون نام' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">کد محصول <span class="text-danger">*</span></label>
                                <input type="text"
                                       name="code"
                                       class="form-control"
                                       value="{{ old('code', $product->code) }}"
                                       required
                                       disabled
                                >
                            </div>

                            <div class="mb-3">
                                <label class="form-label">SKU</label>
                                <input type="text"
                                       name="sku"
                                       class="form-control"
                                       value="{{ old('sku', $product->sku) }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">نوع محصول</label>
                                <select name="type" class="form-select">
                                    @foreach(\App\Models\Product::TYPES as $key => $labels)
                                        <option value="{{ $key }}"
                                            @selected(old('type', $product->type) === $key)>
                                            {{ $labels[app()->getLocale()] ?? $labels['fa'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">وضعیت موجودی</label>
                                <select name="stock_status" class="form-select">
                                    @foreach(\App\Models\Product::STOCK_STATUSES as $key => $labels)
                                        <option value="{{ $key }}"
                                            @selected(old('stock_status', $product->stock_status) === $key)>
                                            {{ $labels[app()->getLocale()] ?? $labels['fa'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">ترتیب نمایش</label>
                                <input type="number"
                                       name="sort_order"
                                       class="form-control"
                                       min="0"
                                       value="{{ old('sort_order', $product->sort_order) }}">
                            </div>

                            <div class="d-flex gap-4 mb-3">
                                <div class="form-check form-switch">
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox"
                                           name="is_active"
                                           value="1"
                                           class="form-check-input"
                                           id="is_active"
                                        @checked(old('is_active', $product->is_active))>
                                    <label class="form-check-label" for="is_active">فعال باشد</label>
                                </div>

                                <div class="form-check form-switch">
                                    <input type="hidden" name="is_featured" value="0">
                                    <input type="checkbox"
                                           name="is_featured"
                                           value="1"
                                           class="form-check-input"
                                           id="is_featured"
                                        @checked(old('is_featured', $product->is_featured))>
                                    <label class="form-check-label" for="is_featured">محصول ویژه</label>
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
                                    <input type="text"
                                           name="unit"
                                           class="form-control"
                                           value="{{ old('unit', $product->unit) }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">وزن</label>
                                    <input type="number" step="0.001"
                                           name="weight"
                                           class="form-control"
                                           value="{{ old('weight', $product->weight) }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">کشور مبدا</label>
                                    <input type="text"
                                           name="origin_country"
                                           class="form-control"
                                           value="{{ old('origin_country', $product->origin_country) }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">حداقل سفارش</label>
                                    <input type="number" step="0.001"
                                           name="minimum_order"
                                           class="form-control"
                                           value="{{ old('minimum_order', $product->minimum_order) }}">
                                </div>

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
                                    <label class="form-label">تصویر اصلی</label>
                                    <input type="file"
                                           name="image"
                                           id="image"
                                           accept="image/*"
                                           class="form-control"
                                           onchange="previewImage(this)">
                                    <small class="text-muted">در صورت عدم انتخاب، تصویر فعلی حفظ می‌شود.</small>

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
                                                <p class="mb-0">پیش‌نمایش تصویر اصلی</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">گالری تصاویر (چندتایی)</label>
                                    <input type="file"
                                           name="gallery[]"
                                           id="gallery"
                                           accept="image/*"
                                           class="form-control"
                                           onchange="previewGallery(this)"
                                           multiple>
                                    <small class="text-muted">در صورت انتخاب، گالری فعلی جایگزین می‌شود.</small>

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

            {{-- دکمه‌ها --}}
            <div class="card mt-3">
                <div class="card-body d-flex justify-content-between">
                    <a href="{{ route('admin.product.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-right me-1"></i>
                        بازگشت
                    </a>
                    <div class="d-flex gap-2">
                        <button type="button"
                                class="btn btn-outline-danger"
                                onclick="if(confirm('حذف شود؟')) document.getElementById('delete-form').submit();">
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

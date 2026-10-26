@extends('panelAdmin.layouts.panel')

@section('title', 'ویرایش محصول صادراتی')

@section('content')
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">
                    <i class="fas fa-edit me-2"></i>
                    ویرایش محصول صادراتی
                </h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.productExport.index') }}">محصولات صادراتی</a>
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
            $locales       = \App\Models\ProductExport::LOCALES;
            $defaultLocale = \App\Models\ProductExport::DEFAULT_LOCALE;
        @endphp

        <form action="{{ route('admin.productExport.update', $productExport) }}"
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
                                    @php $t = $productExport->translations->firstWhere('locale', $code); @endphp
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link @if($loop->first) active @endif"
                                                data-bs-toggle="tab"
                                                data-bs-target="#lang-{{ $code }}"
                                                type="button"
                                                role="tab">
                                            <i class="fas fa-globe me-1"></i>
                                            {{ $label }}
                                            @if($t)<span class="badge bg-success ms-1">✓</span>@endif
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="card-body">
                            <div class="tab-content">
                                @foreach($locales as $code => $label)
                                    @php
                                        $t = $productExport->translations->firstWhere('locale', $code);
                                        $isDefault = $code === $defaultLocale;
                                    @endphp
                                    <div class="tab-pane fade @if($loop->first) show active @endif"
                                         id="lang-{{ $code }}">

                                        <div class="mb-3">
                                            <label class="form-label">
                                                نام محصول
                                                @if($isDefault) <span class="text-danger">*</span> @endif
                                            </label>
                                            <input type="text"
                                                   name="translations[{{ $code }}][name]"
                                                   class="form-control"
                                                   value="{{ old("translations.{$code}.name", $t?->name) }}"
                                                   @if($isDefault) required @endif>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">عنوان متا</label>
                                            <input type="text"
                                                   name="translations[{{ $code }}][meta_title]"
                                                   class="form-control"
                                                   value="{{ old("translations.{$code}.meta_title", $t?->meta_title) }}">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">توضیح کوتاه</label>
                                            <input type="text"
                                                   name="translations[{{ $code }}][short_description]"
                                                   class="form-control"
                                                   value="{{ old("translations.{$code}.short_description", $t?->short_description) }}">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">توضیحات کامل</label>
                                            <textarea name="translations[{{ $code }}][description]"
                                                      class="form-control"
                                                      rows="5">{{ old("translations.{$code}.description", $t?->description) }}</textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">ویژگی‌ها</label>
                                            <textarea name="translations[{{ $code }}][features]"
                                                      class="form-control"
                                                      rows="3">{{ old("translations.{$code}.features", $t?->features) }}</textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">توضیحات بسته‌بندی</label>
                                            <textarea name="translations[{{ $code }}][packaging_description]"
                                                      class="form-control"
                                                      rows="2">{{ old("translations.{$code}.packaging_description", $t?->packaging_description) }}</textarea>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">کلمات کلیدی متا</label>
                                                <input type="text"
                                                       name="translations[{{ $code }}][meta_keywords]"
                                                       class="form-control"
                                                       value="{{ old("translations.{$code}.meta_keywords", $t?->meta_keywords) }}">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">توضیحات متا</label>
                                                <input type="text"
                                                       name="translations[{{ $code }}][meta_description]"
                                                       class="form-control"
                                                       value="{{ old("translations.{$code}.meta_description", $t?->meta_description) }}">
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
                                <label class="form-label">دسته‌بندی</label>
                                <select name="category_id" class="form-select">
                                    <option value="">-- انتخاب --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}"
                                            @selected(old('category_id', $productExport->category_id) == $category->id)>
                                            {{ $category->full_name ?? $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">SKU</label>
                                <input type="text" name="sku" class="form-control"
                                       value="{{ old('sku', $productExport->sku) }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    نوع محصول <span class="text-danger">*</span>
                                </label>
                                <select name="product_type" class="form-select" required>
                                    @foreach(\App\Models\ProductExport::PRODUCT_TYPES as $key => $labels)
                                        <option value="{{ $key }}"
                                            @selected(old('product_type', $productExport->product_type) === $key)>
                                            {{ $labels[app()->getLocale()] ?? $labels['fa'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">واحد</label>
                                <select name="unit" class="form-select">
                                    <option value="">-- انتخاب --</option>
                                    @foreach(\App\Models\ProductExport::UNITS as $key => $labels)
                                        <option value="{{ $key }}"
                                            @selected(old('unit', $productExport->unit) === $key)>
                                            {{ $labels[app()->getLocale()] ?? $labels['fa'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">ترتیب نمایش</label>
                                <input type="number" name="sort_order" class="form-control"
                                       min="0" value="{{ old('sort_order', $productExport->sort_order) }}">
                            </div>

                            <div class="d-flex flex-wrap gap-3">
                                <div class="form-check form-switch">
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox" name="is_active" value="1"
                                           class="form-check-input" id="is_active"
                                        @checked(old('is_active', $productExport->is_active))>
                                    <label class="form-check-label" for="is_active">فعال</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input type="hidden" name="is_featured" value="0">
                                    <input type="checkbox" name="is_featured" value="1"
                                           class="form-check-input" id="is_featured"
                                        @checked(old('is_featured', $productExport->is_featured))>
                                    <label class="form-check-label" for="is_featured">ویژه</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input type="hidden" name="is_exportable" value="0">
                                    <input type="checkbox" name="is_exportable" value="1"
                                           class="form-check-input" id="is_exportable"
                                        @checked(old('is_exportable', $productExport->is_exportable))>
                                    <label class="form-check-label" for="is_exportable">قابل صادرات</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input type="hidden" name="is_available_domestic" value="0">
                                    <input type="checkbox" name="is_available_domestic" value="1"
                                           class="form-check-input" id="is_available_domestic"
                                        @checked(old('is_available_domestic', $productExport->is_available_domestic))>
                                    <label class="form-check-label" for="is_available_domestic">عرضه داخلی</label>
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
                                    <label class="form-label">حداقل مقدار سفارش</label>
                                    <input type="number" step="0.001"
                                           name="minimum_order_quantity"
                                           class="form-control"
                                           value="{{ old('minimum_order_quantity', $productExport->minimum_order_quantity) }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">حداکثر مقدار تأمین</label>
                                    <input type="number" step="0.001"
                                           name="maximum_supply_quantity"
                                           class="form-control"
                                           value="{{ old('maximum_supply_quantity', $productExport->maximum_supply_quantity) }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">کشور مبدا</label>
                                    <input type="text"
                                           name="origin_country"
                                           class="form-control"
                                           value="{{ old('origin_country', $productExport->origin_country) }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">نوع بسته‌بندی</label>
                                    <input type="text"
                                           name="packaging_type"
                                           class="form-control"
                                           value="{{ old('packaging_type', $productExport->packaging_type) }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">شرایط نگهداری</label>
                                    <input type="text"
                                           name="storage_conditions"
                                           class="form-control"
                                           value="{{ old('storage_conditions', $productExport->storage_conditions) }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">مدت ماندگاری</label>
                                    <input type="text"
                                           name="shelf_life"
                                           class="form-control"
                                           value="{{ old('shelf_life', $productExport->shelf_life) }}">
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label">مشخصات فنی (JSON)</label>
                                    <textarea name="specifications"
                                              class="form-control"
                                              rows="3">{{ old('specifications', ! empty($productExport->specifications) ? json_encode($productExport->specifications, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) : '') }}</textarea>
                                    <small class="text-muted">
                                        JSON معتبر یا خالی.
                                    </small>
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
                                <div class="col-md-6">
                                    <label class="form-label">تغییر تصویر اصلی</label>
                                    <input type="file" name="image" id="image" accept="image/*"
                                           class="form-control" onchange="previewImage(this)">
                                    <small class="text-muted">در صورت عدم انتخاب، تصویر فعلی حفظ می‌شود.</small>

                                    <div class="text-center mt-3">
                                        @if($productExport->image)
                                            <img id="image-preview" src="{{ $productExport->image_url }}"
                                                 class="img-thumbnail" style="max-height: 200px;">
                                        @else
                                            <img id="image-preview" src="" class="img-thumbnail d-none"
                                                 style="max-height: 200px;">
                                            <div id="no-image-placeholder"
                                                 class="text-muted py-4 border rounded">
                                                <i class="fas fa-image fa-3x mb-2"></i>
                                                <p class="mb-0">پیش‌نمایش</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">تغییر گالری</label>
                                    <input type="file" name="gallery[]" id="gallery" accept="image/*"
                                           class="form-control" onchange="previewGallery(this)" multiple>
                                    <small class="text-muted">در صورت انتخاب، گالری فعلی جایگزین می‌شود.</small>

                                    <div id="gallery-preview" class="d-flex flex-wrap gap-2 mt-3">
                                        @if(! empty($productExport->gallery_urls))
                                            @foreach($productExport->gallery_urls as $url)
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
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.productExport.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-right me-1"></i>
                            بازگشت
                        </a>
                        <a href="{{ route('admin.productExport.show', $productExport) }}"
                           class="btn btn-outline-secondary">
                            <i class="fas fa-eye me-1"></i>
                            مشاهده
                        </a>
                    </div>

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

        <form id="delete-form"
              action="{{ route('admin.productExport.delete', $productExport) }}"
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
                        img.style.cssText = 'width:90px;height:90px;object-fit:cover;border-radius:8px;border:1px solid #dee2e6;';
                        container.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                });
            }
        }
    </script>
@endpush

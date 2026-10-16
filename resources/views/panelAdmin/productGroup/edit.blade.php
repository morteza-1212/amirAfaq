@extends('panelAdmin.layouts.panel')

@section('title', 'ویرایش گروه محصول')

@section('content')
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">
                    <i class="fas fa-edit me-2"></i>
                    ویرایش گروه محصول
                </h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.productGroup.index') }}">گروه‌های محصول</a>
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
            $locales       = \App\Models\ProductGroup::LOCALES;
            $defaultLocale = \App\Models\ProductGroup::DEFAULT_LOCALE;
        @endphp

        <form action="{{ route('admin.productGroup.update', $productGroup) }}"
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
                                    @php $t = $productGroup->translations->firstWhere('locale', $code); @endphp
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
                                        $t = $productGroup->translations->firstWhere('locale', $code);
                                        $isDefault = $code === $defaultLocale;
                                    @endphp

                                    <div class="tab-pane fade @if($loop->first) show active @endif"
                                         id="lang-{{ $code }}">

                                        <div class="mb-3">
                                            <label class="form-label">
                                                نام گروه
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
                                                   value="{{ old("translations.{$code}.slug", $t?->slug) }}">
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
                                                      rows="4">{{ old("translations.{$code}.description", $t?->description) }}</textarea>
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

                            {{-- کد --}}
                            <div class="mb-3">
                                <label class="form-label">کد گروه</label>
                                <input type="text"
                                       class="form-control bg-light"
                                       value="{{ $productGroup->code }}"
                                       readonly>
                                <small class="text-muted">
                                    <i class="fas fa-lock me-1"></i>
                                    این کد خودکار ساخته شده و قابل ویرایش نیست.
                                </small>
                            </div>

                            {{-- نوع --}}
                            <div class="mb-3">
                                <label class="form-label">
                                    نوع گروه <span class="text-danger">*</span>
                                </label>
                                <select name="type" class="form-select" required>
                                    @foreach(\App\Models\ProductGroup::TYPES as $key => $labels)
                                        <option value="{{ $key }}"
                                            @selected(old('type', $productGroup->type) === $key)>
                                            {{ $labels[app()->getLocale()] ?? $labels['fa'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- آیکون --}}
                            <div class="mb-3">
                                <label class="form-label">آیکون</label>
                                <input type="text"
                                       name="icon"
                                       class="form-control"
                                       value="{{ old('icon', $productGroup->icon) }}">
                            </div>

                            {{-- ترتیب --}}
                            <div class="mb-3">
                                <label class="form-label">ترتیب نمایش</label>
                                <input type="number"
                                       name="sort_order"
                                       class="form-control"
                                       min="0"
                                       value="{{ old('sort_order', $productGroup->sort_order) }}">
                            </div>

                            {{-- وضعیت --}}
                            <div class="d-flex gap-4">
                                <div class="form-check form-switch">
                                    <input type="hidden" name="status" value="0">
                                    <input type="checkbox"
                                           name="status"
                                           value="1"
                                           class="form-check-input"
                                           id="status"
                                        @checked(old('status', $productGroup->status))>
                                    <label class="form-check-label" for="status">فعال</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input type="hidden" name="is_featured" value="0">
                                    <input type="checkbox"
                                           name="is_featured"
                                           value="1"
                                           class="form-check-input"
                                           id="is_featured"
                                        @checked(old('is_featured', $productGroup->is_featured))>
                                    <label class="form-check-label" for="is_featured">ویژه</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- تصویر --}}
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-image me-1"></i>
                                تصویر گروه
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">تغییر تصویر</label>
                                <input type="file"
                                       name="image"
                                       id="image"
                                       accept="image/*"
                                       class="form-control"
                                       onchange="previewImage(this)">
                                <small class="text-muted">
                                    در صورت عدم انتخاب، تصویر فعلی حفظ می‌شود.
                                </small>
                            </div>
                            <div class="text-center">
                                @if($productGroup->image)
                                    <img id="image-preview"
                                         src="{{ $productGroup->image_url }}"
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
                    </div>
                </div>
            </div>

            {{-- دکمه‌ها --}}
            <div class="card mt-3">
                <div class="card-body d-flex justify-content-between">
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.productGroup.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-right me-1"></i>
                            بازگشت
                        </a>
                        <a href="{{ route('admin.productGroup.show', $productGroup) }}"
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

        {{-- فرم مخفی حذف --}}
        <form id="delete-form"
              action="{{ route('admin.productGroup.delete', $productGroup) }}"
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
    </script>
@endpush

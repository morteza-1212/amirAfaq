@extends('panelAdmin.layouts.panel')

@section('title', 'ویرایش گالری')

@section('content')
    <div class="container-fluid">
        {{-- هدر --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">
                    <i class="fas fa-edit me-2"></i>
                    ویرایش گالری
                </h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.gallery.index') }}">گالری‌ها</a>
                        </li>
                        <li class="breadcrumb-item active">ویرایش</li>
                    </ol>
                </nav>
            </div>

            {{-- لینک به ترجمه‌ها --}}
            <a href="{{ route('admin.gallery.translations.index', $gallery) }}"
               class="btn btn-outline-info">
                <i class="fas fa-language me-1"></i>
                مدیریت ترجمه‌ها
                <span class="badge bg-info ms-1">{{ $gallery->translations->count() }}</span>
            </a>
        </div>

        {{-- پیام موفقیت --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-1"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- خطاهای کلی --}}
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
            $locales       = \App\Models\Gallery::LOCALES;
            $activityTypes = \App\Models\Gallery::ACTIVITY_TYPES;

            $icons = [
                'commerce'       => 'fa-shopping-cart',
                'logistics'      => 'fa-truck',
                'exhibition'     => 'fa-store',
                'exports'        => 'fa-ship',
                'imports'        => 'fa-plane-arrival',
                'global_markets' => 'fa-globe',
            ];

            $selectedType = old('activity_type', $gallery->activity_type);
        @endphp

        {{-- فرم --}}
        <form action="{{ route('admin.gallery.update', $gallery) }}"
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
                                    @php
                                        $translation = $gallery->translations->firstWhere('locale', $code);
                                        $hasError = $errors->has("translations.{$code}.title");
                                    @endphp
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link @if($loop->first) active @endif @if($hasError) text-danger @endif"
                                                data-bs-toggle="tab"
                                                data-bs-target="#lang-{{ $code }}"
                                                type="button"
                                                role="tab">
                                            <i class="fas fa-globe me-1"></i>
                                            {{ $label }}
                                            @if($translation)
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
                                        $translation = $gallery->translations->firstWhere('locale', $code);
                                        $isDefault = $code === \App\Models\Gallery::DEFAULT_LOCALE;
                                    @endphp

                                    <div class="tab-pane fade @if($loop->first) show active @endif"
                                         id="lang-{{ $code }}"
                                         role="tabpanel">

                                        {{-- عنوان --}}
                                        <div class="mb-3">
                                            <label class="form-label">
                                                عنوان
                                                @if($isDefault)
                                                    <span class="text-danger">*</span>
                                                @endif
                                                <small class="text-muted">({{ $label }})</small>
                                            </label>
                                            <input type="text"
                                                   name="translations[{{ $code }}][title]"
                                                   class="form-control @error("translations.{$code}.title") is-invalid @enderror"
                                                   value="{{ old("translations.{$code}.title", $translation?->title) }}"
                                                   @if($isDefault) required @endif>
                                            @error("translations.{$code}.title")
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
                                                   value="{{ old("translations.{$code}.slug", $translation?->slug) }}"
                                                   placeholder="در صورت خالی بودن، خودکار ساخته می‌شود">
                                            @error("translations.{$code}.slug")
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- متن جایگزین --}}
                                        <div class="mb-3">
                                            <label class="form-label">
                                                متن جایگزین تصویر (Alt)
                                                <small class="text-muted">({{ $label }})</small>
                                            </label>
                                            <input type="text"
                                                   name="translations[{{ $code }}][alt_text]"
                                                   class="form-control @error("translations.{$code}.alt_text") is-invalid @enderror"
                                                   value="{{ old("translations.{$code}.alt_text", $translation?->alt_text) }}">
                                            @error("translations.{$code}.alt_text")
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- توضیحات --}}
                                        <div class="mb-3">
                                            <label class="form-label">
                                                توضیحات
                                                <small class="text-muted">({{ $label }})</small>
                                            </label>
                                            <textarea name="translations[{{ $code }}][description]"
                                                      class="form-control @error("translations.{$code}.description") is-invalid @enderror"
                                                      rows="4">{{ old("translations.{$code}.description", $translation?->description) }}</textarea>
                                            @error("translations.{$code}.description")
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ==================== تنظیمات ==================== --}}
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-cog me-1"></i>
                                تنظیمات
                            </h5>
                        </div>
                        <div class="card-body">
                            {{-- نوع فعالیت --}}
                            <div class="mb-4">
                                <label class="form-label">
                                    نوع فعالیت <span class="text-danger">*</span>
                                </label>

                                <div class="row g-2">
                                    @foreach($activityTypes as $key => $data)
                                        @php
                                            $checked = $selectedType === $key;
                                            $faLabel = $data['labels']['fa'] ?? $key;
                                            $enLabel = $data['labels']['en'] ?? '';
                                            $arLabel = $data['labels']['ar'] ?? '';
                                            $currentLabel = $data['labels'][app()->getLocale()] ?? $faLabel;
                                        @endphp
                                        <div class="col-md-6">
                                            <input type="radio"
                                                   name="activity_type"
                                                   id="type-{{ $key }}"
                                                   value="{{ $key }}"
                                                   class="btn-check"
                                                   @checked($checked)
                                                   required>

                                            <label class="activity-card w-100 h-100 p-3 border rounded-3 cursor-pointer"
                                                   for="type-{{ $key }}">
                                                <div class="d-flex align-items-start">
                                                    <div class="activity-icon me-3">
                                                        <i class="fas {{ $icons[$key] ?? 'fa-tag' }}"></i>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <div class="fw-bold mb-1">
                                                            {{ $faLabel }}
                                                        </div>
                                                        <div class="text-muted small mb-1" style="direction: ltr; text-align: right;">
                                                            {{ $enLabel }}
                                                        </div>
                                                        <div class="text-muted small mb-1" style="direction: rtl;">
                                                            {{ $arLabel }}
                                                        </div>
                                                        <div class="text-secondary small border-top pt-1 mt-1">
                                                            {{ $data['description'] ?? '' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>

                                @error('activity_type')
                                <div class="text-danger small mt-2">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            {{-- ترتیب نمایش --}}
                            <div class="mb-3">
                                <label class="form-label">ترتیب نمایش</label>
                                <input type="number"
                                       name="sort_order"
                                       class="form-control @error('sort_order') is-invalid @enderror"
                                       min="0"
                                       value="{{ old('sort_order', $gallery->sort_order) }}">
                                <small class="text-muted">عدد کوچکتر = نمایش بالاتر</small>
                                @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- وضعیت فعال --}}
                            <div class="form-check form-switch mb-3">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox"
                                       name="is_active"
                                       value="1"
                                       class="form-check-input"
                                       id="is_active"
                                    @checked(old('is_active', $gallery->is_active))>
                                <label class="form-check-label" for="is_active">
                                    فعال باشد
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ==================== تصویر ==================== --}}
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-image me-1"></i>
                                تصویر
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">تغییر تصویر</label>
                                <input type="file"
                                       name="image"
                                       id="image"
                                       accept="image/*"
                                       class="form-control @error('image') is-invalid @enderror"
                                       onchange="previewImage(this)">
                                <small class="text-muted">
                                    در صورت عدم انتخاب، تصویر فعلی حفظ می‌شود.
                                    <br>
                                    فرمت‌های مجاز: JPG, PNG, WEBP - حداکثر ۴ مگابایت
                                </small>
                                @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- پیش‌نمایش تصویر --}}
                            <div id="image-preview-container" class="text-center">
                                @if($gallery->image)
                                    <img id="image-preview"
                                         src="{{ $gallery->image_url }}"
                                         alt="{{ $gallery->alt_text }}"
                                         class="img-thumbnail"
                                         style="max-height: 250px;">
                                @else
                                    <img id="image-preview"
                                         src=""
                                         alt=""
                                         class="img-thumbnail d-none"
                                         style="max-height: 250px;">
                                    <div id="no-image-placeholder" class="text-muted py-5">
                                        <i class="fas fa-image fa-4x mb-2"></i>
                                        <p>پیش‌نمایش تصویر</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- دکمه‌های عملیات --}}
            <div class="card mt-3">
                <div class="card-body d-flex justify-content-between">
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.gallery.index') }}"
                           class="btn btn-secondary">
                            <i class="fas fa-arrow-right me-1"></i>
                            بازگشت
                        </a>
                    </div>

                    <div class="d-flex gap-2">
                        {{-- حذف --}}
                        <button type="button"
                                class="btn btn-outline-danger"
                                onclick="if(confirm('آیا از حذف این گالری اطمینان دارید؟')) document.getElementById('delete-form').submit();">
                            <i class="fas fa-trash me-1"></i>
                            حذف
                        </button>

                        {{-- ذخیره --}}
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
              action="{{ route('admin.gallery.destroy', $gallery) }}"
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

        /* کارت نوع فعالیت */
        .activity-card {
            transition: all 0.2s ease;
            background: #fff;
            border: 1px solid #dee2e6 !important;
        }

        .activity-card:hover {
            border-color: #0d6efd !important;
            background: #f8f9ff;
            box-shadow: 0 2px 8px rgba(13, 110, 253, 0.1);
        }

        .btn-check:checked + .activity-card {
            border-color: #0d6efd !important;
            background: #e7f1ff;
            box-shadow: 0 2px 12px rgba(13, 110, 253, 0.2);
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: #e7f1ff;
            color: #0d6efd;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .btn-check:checked + .activity-card .activity-icon {
            background: #0d6efd;
            color: #fff;
        }

        .cursor-pointer {
            cursor: pointer;
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
    </script>
@endpush

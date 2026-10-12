@extends('panelAdmin.layouts.panel')

@section('title', 'ویرایش ترجمه')

@section('content')
    <div class="container-fluid">
        {{-- هدر --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">
                    <i class="fas fa-edit me-2"></i>
                    ویرایش ترجمه
                    <span class="badge bg-primary">
                    {{ $locales[$translation->locale] ?? $translation->locale }}
                </span>
                </h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.gallery.index') }}">گالری‌ها</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.gallery.translations.index', $gallery) }}">
                                ترجمه‌ها
                            </a>
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
            $allLocales = \App\Models\Gallery::LOCALES;
            $isDefault  = $translation->locale === \App\Models\Gallery::DEFAULT_LOCALE;
        @endphp

        <form action="{{ route('admin.gallery.translations.update', [$gallery, $translation]) }}"
              method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3">
                {{-- اطلاعات گالری --}}
                <div class="col-12">
                    <div class="card border-info">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-2 text-center">
                                    <img src="{{ $gallery->image_url }}"
                                         alt="{{ $gallery->alt_text }}"
                                         class="img-thumbnail"
                                         style="max-height: 80px;">
                                </div>
                                <div class="col-md-10">
                                    <h6 class="mb-1">
                                        <i class="fas fa-images me-1"></i>
                                        گالری مرتبط:
                                        <strong>{{ $gallery->title ?? '#' . $gallery->id }}</strong>
                                    </h6>
                                    <small class="text-muted">
                                        نوع فعالیت:
                                        <span class="badge bg-info">
                                        {{ $gallery->activity_type_label }}
                                    </span>
                                        &nbsp;|&nbsp;
                                        زبان این ترجمه:
                                        <span class="badge bg-primary">
                                        {{ $allLocales[$translation->locale] ?? $translation->locale }}
                                    </span>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- زبان (غیرقابل تغییر) --}}
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-globe me-1"></i>
                                زبان ترجمه
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">زبان</label>

                                {{-- Hidden input برای ارسال locale --}}
                                <input type="hidden" name="locale" value="{{ $translation->locale }}">

                                <input type="text"
                                       class="form-control"
                                       value="{{ $allLocales[$translation->locale] ?? $translation->locale }} ({{ $translation->locale }})"
                                       disabled>
                                <small class="text-muted">
                                    زبان ترجمه قابل تغییر نیست. برای تغییر، ترجمه را حذف و مجدداً ایجاد کنید.
                                </small>
                            </div>

                            @if($isDefault)
                                <div class="alert alert-success mb-0">
                                    <small>
                                        <i class="fas fa-star me-1"></i>
                                        این ترجمه زبان <strong>پیش‌فرض</strong> سیستم است
                                        و قابل حذف نیست.
                                    </small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- عنوان و slug --}}
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-heading me-1"></i>
                                عنوان و نامک
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">
                                    عنوان <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       name="title"
                                       class="form-control @error('title') is-invalid @enderror"
                                       value="{{ old('title', $translation->title) }}"
                                       required>
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-0">
                                <label class="form-label">نامک (Slug)</label>
                                <input type="text"
                                       name="slug"
                                       class="form-control @error('slug') is-invalid @enderror"
                                       value="{{ old('slug', $translation->slug) }}">
                                @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">
                                    در صورت خالی بودن، از عنوان ساخته می‌شود.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- متن جایگزین --}}
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-image me-1"></i>
                                متن جایگزین تصویر (Alt)
                            </h5>
                        </div>
                        <div class="card-body">
                            <input type="text"
                                   name="alt_text"
                                   class="form-control @error('alt_text') is-invalid @enderror"
                                   value="{{ old('alt_text', $translation->alt_text) }}"
                                   placeholder="توضیح کوتاه تصویر برای موتورهای جستجو">
                            @error('alt_text')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- توضیحات --}}
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-align-right me-1"></i>
                                توضیحات
                            </h5>
                        </div>
                        <div class="card-body">
                        <textarea name="description"
                                  class="form-control @error('description') is-invalid @enderror"
                                  rows="6">{{ old('description', $translation->description) }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- اطلاعات تکمیلی --}}
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row text-muted small">
                                <div class="col-md-3">
                                    <i class="fas fa-calendar-plus me-1"></i>
                                    ایجاد:
                                    {{ $translation->created_at->format('Y/m/d H:i') }}
                                </div>
                                <div class="col-md-3">
                                    <i class="fas fa-calendar-check me-1"></i>
                                    آخرین ویرایش:
                                    {{ $translation->updated_at->format('Y/m/d H:i') }}
                                </div>
                                <div class="col-md-3">
                                    <i class="fas fa-fingerprint me-1"></i>
                                    شناسه: {{ $translation->id }}
                                </div>
                                <div class="col-md-3">
                                    <i class="fas fa-link me-1"></i>
                                    Gallery ID: {{ $translation->gallery_id }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- دکمه‌های عملیات --}}
            <div class="card mt-3">
                <div class="card-body d-flex justify-content-between">
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.gallery.translations.index', $gallery) }}"
                           class="btn btn-secondary">
                            <i class="fas fa-arrow-right me-1"></i>
                            بازگشت
                        </a>
                    </div>

                    <div class="d-flex gap-2">
                        @unless($isDefault)
                            <button type="button"
                                    class="btn btn-outline-danger"
                                    onclick="if(confirm('آیا از حذف این ترجمه اطمینان دارید؟')) document.getElementById('delete-form').submit();">
                                <i class="fas fa-trash me-1"></i>
                                حذف
                            </button>
                        @endunless

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>
                            به‌روزرسانی
                        </button>
                    </div>
                </div>
            </div>
        </form>

        {{-- فرم مخفی حذف (فقط اگر زبان پیش‌فرض نباشد) --}}
        @unless($isDefault)
            <form id="delete-form"
                  action="{{ route('admin.gallery.translations.destroy', [$gallery, $translation]) }}"
                  method="POST"
                  class="d-none">
                @csrf
                @method('DELETE')
            </form>
        @endunless
    </div>
@endsection

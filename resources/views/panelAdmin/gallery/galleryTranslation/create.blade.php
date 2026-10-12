@extends('panelAdmin.layouts.panel')

@section('title', 'افزودن ترجمه جدید')

@section('content')
    <div class="container-fluid">
        {{-- هدر --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">
                    <i class="fas fa-plus-circle me-2"></i>
                    افزودن ترجمه جدید
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
                        <li class="breadcrumb-item active">ایجاد</li>
                    </ol>
                </nav>
            </div>
        </div>

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
        @endphp

        <form action="{{ route('admin.gallery.translations.store', $gallery) }}"
              method="POST">
            @csrf

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
                                        ترجمه‌های موجود: {{ $gallery->translations->count() }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- انتخاب زبان --}}
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-globe me-1"></i>
                                انتخاب زبان
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">
                                    زبان ترجمه <span class="text-danger">*</span>
                                </label>
                                <select name="locale"
                                        class="form-select @error('locale') is-invalid @enderror"
                                        required>
                                    <option value="">-- انتخاب کنید --</option>
                                    @foreach($availableLocales as $code => $label)
                                        <option value="{{ $code }}"
                                            @selected(old('locale') === $code)>
                                            {{ $label }} ({{ $code }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('locale')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                @if(empty($availableLocales))
                                    <div class="alert alert-warning mt-3 mb-0">
                                        <i class="fas fa-info-circle me-1"></i>
                                        همه زبان‌ها ترجمه دارند. ابتدا یک ترجمه را حذف کنید.
                                    </div>
                                @endif
                            </div>

                            <div class="alert alert-info mb-0">
                                <small>
                                    <i class="fas fa-info-circle me-1"></i>
                                    زبان پیش‌فرض سیستم:
                                    <strong>{{ $allLocales[\App\Models\Gallery::DEFAULT_LOCALE] }}</strong>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- عنوان --}}
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-heading me-1"></i>
                                عنوان ترجمه
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
                                       value="{{ old('title') }}"
                                       placeholder="عنوان ترجمه را وارد کنید"
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
                                       value="{{ old('slug') }}"
                                       placeholder="در صورت خالی بودن، خودکار ساخته می‌شود">
                                @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">
                                    نامک باید در هر زبان یکتا باشد.
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
                                   value="{{ old('alt_text') }}"
                                   placeholder="توضیح کوتاه تصویر برای موتورهای جستجو و دسترس‌پذیری">
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
                                  rows="6"
                                  placeholder="توضیحات کامل ترجمه...">{{ old('description') }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- دکمه‌های عملیات --}}
            <div class="card mt-3">
                <div class="card-body d-flex justify-content-between">
                    <a href="{{ route('admin.gallery.translations.index', $gallery) }}"
                       class="btn btn-secondary">
                        <i class="fas fa-arrow-right me-1"></i>
                        انصراف
                    </a>
                    <button type="submit"
                            class="btn btn-primary"
                            @if(empty($availableLocales)) disabled @endif>
                        <i class="fas fa-save me-1"></i>
                        ذخیره ترجمه
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

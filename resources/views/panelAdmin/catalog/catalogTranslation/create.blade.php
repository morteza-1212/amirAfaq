@extends('panelAdmin.layouts.panel')

@section('content')

    <div class="container">

        {{-- هدر صفحه --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">
                <i class="fas fa-plus-circle text-primary me-1"></i>
                افزودن ترجمه جدید
            </h4>

            <a href="{{ route('admin.catalog.translation.index', $catalog) }}"
               class="btn btn-secondary">
                <i class="fas fa-arrow-right"></i>
                بازگشت به لیست
            </a>
        </div>


        {{-- خطاهای اعتبارسنجی --}}
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <strong>
                    <i class="fas fa-exclamation-triangle me-1"></i>
                    خطا در اطلاعات وارد شده:
                </strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif


        <div class="card shadow-sm border-0">

            <div class="card-header bg-white">
                <strong>
                    <i class="fas fa-language text-primary me-1"></i>
                    فرم افزودن ترجمه
                </strong>
            </div>

            <div class="card-body">

                <form action="{{ route('admin.catalog.translation.store', $catalog) }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf


                    {{-- زبان --}}
                    <div class="mb-3">
                        <label for="locale" class="form-label fw-semibold">
                            زبان <span class="text-danger">*</span>
                        </label>

                        <select name="locale"
                                id="locale"
                                class="form-select @error('locale') is-invalid @enderror"
                                required>

                            <option value="">-- انتخاب زبان --</option>

                            <option value="fa" {{ old('locale') == 'fa' ? 'selected' : '' }}>
                                فارسی
                            </option>

                            <option value="en" {{ old('locale') == 'en' ? 'selected' : '' }}>
                                English
                            </option>

                            <option value="ar" {{ old('locale') == 'ar' ? 'selected' : '' }}>
                                العربية
                            </option>

                        </select>

                        @error('locale')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    {{-- عنوان --}}
                    <div class="mb-3">
                        <label for="title" class="form-label fw-semibold">
                            عنوان <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               name="title"
                               id="title"
                               value="{{ old('title') }}"
                               placeholder="مثال: کاتالوگ محصولات ۱۴۰۳"
                               class="form-control @error('title') is-invalid @enderror"
                               required>

                        @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    {{-- توضیحات --}}
                    <div class="mb-3">
                        <label for="description" class="form-label fw-semibold">
                            توضیحات
                        </label>

                        <textarea name="description"
                                  id="description"
                                  rows="5"
                                  placeholder="توضیحات اختیاری درباره این ترجمه..."
                                  class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>

                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    {{-- فایل PDF --}}
                    <div class="mb-3">
                        <label for="file" class="form-label fw-semibold">
                            فایل PDF
                        </label>

                        <input type="file"
                               name="file"
                               id="file"
                               accept=".pdf,application/pdf"
                               class="form-control @error('file') is-invalid @enderror">

                        <small class="text-muted d-block mt-2">
                            <i class="fas fa-info-circle"></i>
                            فقط فایل‌های PDF با حجم حداکثر 50 مگابایت مجاز هستند.
                        </small>

                        @error('file')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    {{-- دکمه‌ها --}}
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-save"></i>
                            ذخیره ترجمه
                        </button>

                        <a href="{{ route('admin.catalog.translation.index', $catalog) }}"
                           class="btn btn-outline-secondary px-4">
                            <i class="fas fa-times"></i>
                            انصراف
                        </a>
                    </div>

                </form>

            </div>

        </div>

    </div>

@endsection

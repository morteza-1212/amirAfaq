@extends('panelAdmin.layouts.panel')

@section('title', 'افزودن کاتالوگ جدید')

@section('style')
    <style>
        .bg-gradient-info { background: linear-gradient(135deg, #2196f3, #00bcd4); }
        .form-control-lg { font-size: 1rem; }
    </style>
@endsection

@section('content')
    <div class="container-fluid py-4" dir="rtl">

        {{-- هدر --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2 small">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.catalog.index') }}" class="text-decoration-none">کاتالوگ‌ها</a>
                        </li>
                        <li class="breadcrumb-item active">افزودن</li>
                    </ol>
                </nav>
                <h3 class="mb-0 fw-bold">
                    <i class="bi bi-plus-circle text-primary"></i> افزودن کاتالوگ جدید
                </h3>
                <p class="text-muted mb-0 small">اطلاعات کاتالوگ جدید را وارد کنید</p>
            </div>
            <a href="{{ route('admin.catalog.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-right"></i> بازگشت
            </a>
        </div>

        <form action="{{ route('admin.catalog.store') }}" method="POST" autocomplete="off">
            @csrf

            {{-- خطاها --}}
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show shadow-sm">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>خطا در اطلاعات وارد شده:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row g-4">
                {{-- ستون اصلی --}}
                <div class="col-lg-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white border-bottom py-3">
                            <h6 class="mb-0 fw-bold">
                                <i class="bi bi-info-circle text-primary me-2"></i> اطلاعات کاتالوگ
                            </h6>
                        </div>
                        <div class="card-body p-4">

                            {{-- اسلاگ --}}
                            <div class="mb-4">
                                <label for="slug" class="form-label fw-semibold">
                                    اسلاگ
                                    <span class="text-muted small">(اختیاری - در صورت خالی بودن، خودکار ساخته می‌شود)</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-link-45deg"></i></span>
                                    <input type="text" name="slug" id="slug"
                                           class="form-control form-control-lg @error('slug') is-invalid @enderror"
                                           value="{{ old('slug') }}"
                                           placeholder="مثال: my-catalog (خالی = خودکار)"
                                           dir="ltr" autocomplete="off">
                                    @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="form-text mt-2">
                                    <i class="bi bi-info-circle"></i>
                                    اگر خالی بگذارید، به‌صورت خودکار مثل
                                    <code>catalog-1712345678-123</code> ساخته می‌شود.
                                </div>
                                <div class="mt-3 p-3 bg-light rounded-3 border" dir="ltr">
                                    <small class="text-muted d-block mb-1">
                                        <i class="bi bi-globe"></i> پیش‌نمایش آدرس:
                                    </small>
                                    <code class="text-primary">
                                        {{ url('/catalogs') }}/<span id="slugPreview">...</span>
                                    </code>
                                </div>
                            </div>

                            {{-- ترتیب --}}
                            <div class="mb-4">
                                <label for="sort_order" class="form-label fw-semibold">ترتیب نمایش</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-sort-numeric-down"></i></span>
                                    <input type="number" name="sort_order" id="sort_order"
                                           class="form-control @error('sort_order') is-invalid @enderror"
                                           value="{{ old('sort_order', 0) }}" min="0">
                                    @error('sort_order') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="form-text">
                                    <i class="bi bi-info-circle"></i> عدد کوچک‌تر = نمایش زودتر.
                                </div>
                            </div>

                            {{-- وضعیت --}}
                            <div class="mb-2">
                                <label class="form-label fw-semibold d-block">وضعیت</label>
                                <div class="form-check form-switch fs-5">
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox" name="is_active" id="is_active"
                                           class="form-check-input" value="1" role="switch"
                                        {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label for="is_active" class="form-check-label fs-6 align-middle ms-2">
                                    <span id="statusLabel" class="badge bg-success-subtle text-success">
                                        <i class="bi bi-check-circle-fill"></i> فعال
                                    </span>
                                    </label>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- ستون کناری --}}
                <div class="col-lg-4">
                    <div class="card shadow-sm border-0 mb-4 bg-gradient-info">
                        <div class="card-body text-white">
                            <h6 class="fw-bold mb-3">
                                <i class="bi bi-lightbulb-fill"></i> راهنمای اسلاگ
                            </h6>
                            <ul class="small mb-0 ps-3">
                                <li>برای URL تمیز و سئوپسند استفاده می‌شود.</li>
                                <li>فقط حروف کوچک: <code class="text-white">a-z</code></li>
                                <li>اعداد: <code class="text-white">0-9</code></li>
                                <li>خط تیره: <code class="text-white">-</code></li>
                                <li>مثال درست: <code class="text-white">web-design</code></li>
                            </ul>
                        </div>
                    </div>

                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3">
                                <i class="bi bi-check2-square text-success"></i> نکات مهم
                            </h6>
                            <div class="d-flex gap-2 mb-2 small">
                                <i class="bi bi-check-circle-fill text-success"></i>
                                <span>اسلاگ باید یکتا باشد.</span>
                            </div>
                            <div class="d-flex gap-2 mb-2 small">
                                <i class="bi bi-check-circle-fill text-success"></i>
                                <span>اسلاگ بعداً قابل تغییر است.</span>
                            </div>
                            <div class="d-flex gap-2 small">
                                <i class="bi bi-check-circle-fill text-success"></i>
                                <span>ترتیب نمایش برای منو کاربرد دارد.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- دکمه‌ها --}}
            <div class="card shadow-sm border-0 mt-4">
                <div class="card-body d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <a href="{{ route('admin.catalog.index') }}" class="btn btn-outline-secondary px-4">
                        <i class="bi bi-arrow-right"></i> بازگشت به لیست
                    </a>
                    <div class="d-flex gap-2">
                        <button type="reset" class="btn btn-outline-warning px-4">
                            <i class="bi bi-arrow-counterclockwise"></i> بازنشانی
                        </button>
                        <button type="submit" class="btn btn-primary px-4 shadow-sm">
                            <i class="bi bi-check-circle"></i> ذخیره کاتالوگ
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const slugInput = document.getElementById('slug');
            const slugPrev  = document.getElementById('slugPreview');
            const statusIn  = document.getElementById('is_active');
            const statusLbl = document.getElementById('statusLabel');

            slugInput?.addEventListener('input', function () {
                let val = this.value.toLowerCase()
                    .replace(/\s+/g, '-')
                    .replace(/[^a-z0-9\-]/g, '');
                this.value = val;
                slugPrev.textContent = val || 'my-catalog';
            });

            statusIn?.addEventListener('change', function () {
                if (this.checked) {
                    statusLbl.className = 'badge bg-success-subtle text-success';
                    statusLbl.innerHTML = '<i class="bi bi-check-circle-fill"></i> فعال';
                } else {
                    statusLbl.className = 'badge bg-secondary-subtle text-secondary';
                    statusLbl.innerHTML = '<i class="bi bi-x-circle-fill"></i> غیرفعال';
                }
            });
        });
    </script>
@endsection

@extends('panelAdmin.layouts.panel')

@section('title', 'ویرایش کاتالوگ')

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
                        <li class="breadcrumb-item active">ویرایش</li>
                    </ol>
                </nav>
                <h3 class="mb-0 fw-bold">
                    <i class="bi bi-pencil-square text-warning"></i> ویرایش کاتالوگ
                </h3>
                <p class="text-muted mb-0 small">
                    در حال ویرایش: <code class="text-primary">{{ $catalog->slug }}</code>
                </p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.catalog.show', $catalog) }}" class="btn btn-outline-info">
                    <i class="bi bi-eye"></i> نمایش
                </a>
                <a href="{{ route('admin.catalog.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-right"></i> بازگشت
                </a>
            </div>
        </div>

        {{-- هشدار --}}
        <div class="alert alert-warning shadow-sm d-flex align-items-center">
            <i class="bi bi-exclamation-triangle-fill me-2 fs-4"></i>
            <div>
                <strong>توجه:</strong>
                با تغییر اسلاگ، آدرس قبلی کاتالوگ از دسترس خارج می‌شود.
            </div>
        </div>

        <form action="{{ route('admin.catalog.update', $catalog) }}" method="POST" autocomplete="off">
            @csrf
            @method('PUT')

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
                            {{-- اسلاگ --}}
                            <div class="mb-4">
                                <label for="slug" class="form-label fw-semibold">
                                    اسلاگ
                                    <span class="text-muted small">(خالی = بدون تغییر)</span>
                                </label>
                                <div class="input-group">
        <span class="input-group-text bg-light">
            <i class="bi bi-link-45deg"></i>
        </span>
                                    <input type="text" name="slug" id="slug"
                                           class="form-control form-control-lg @error('slug') is-invalid @enderror"
                                           value="{{ old('slug', $catalog->slug) }}"
                                           dir="ltr" autocomplete="off">
                                    @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="form-text mt-2">
                                    <i class="bi bi-info-circle"></i>
                                    فقط حروف کوچک انگلیسی، اعداد و خط تیره (-) مجاز است.
                                </div>

                                {{-- هشدار تغییر اسلاگ --}}
                                <div class="alert alert-warning mt-3 mb-0 py-2 small d-none" id="slugChangeWarning">
                                    <i class="bi bi-exclamation-triangle-fill"></i>
                                    <strong>هشدار:</strong> با تغییر اسلاگ، آدرس قبلی
                                    <code>{{ url('/catalogs/' . $catalog->slug) }}</code>
                                    از دسترس خارج می‌شود.
                                </div>

                                {{-- پیش‌نمایش URL --}}
                                <div class="mt-3 p-3 bg-light rounded-3 border" dir="ltr">
                                    <small class="text-muted d-block mb-1">
                                        <i class="bi bi-globe"></i> پیش‌نمایش آدرس:
                                    </small>
                                    <code class="text-primary">
                                        {{ url('/catalogs') }}/<span id="slugPreview">{{ $catalog->slug }}</span>
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
                                           value="{{ old('sort_order', $catalog->sort_order) }}" min="0">
                                    @error('sort_order') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            {{-- وضعیت --}}
                            <div class="mb-2">
                                <label class="form-label fw-semibold d-block">وضعیت</label>
                                <div class="form-check form-switch fs-5">
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox" name="is_active" id="is_active"
                                           class="form-check-input" value="1" role="switch"
                                        {{ old('is_active', $catalog->is_active) ? 'checked' : '' }}>
                                    <label for="is_active" class="form-check-label fs-6 align-middle ms-2">
                                    <span id="statusLabel"
                                          class="badge {{ $catalog->is_active ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">
                                        <i class="bi {{ $catalog->is_active ? 'bi-check-circle-fill' : 'bi-x-circle-fill' }}"></i>
                                        {{ $catalog->status_label }}
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
                                <li>فقط حروف کوچک: <code class="text-white">a-z</code></li>
                                <li>اعداد: <code class="text-white">0-9</code></li>
                                <li>خط تیره: <code class="text-white">-</code></li>
                                <li>مثال: <code class="text-white">web-design</code></li>
                            </ul>
                        </div>
                    </div>

                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white border-bottom py-3">
                            <h6 class="mb-0 fw-bold">
                                <i class="bi bi-clock-history text-secondary me-2"></i> اطلاعات سیستم
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2 small">
                                <span class="text-muted">شناسه:</span>
                                <strong>#{{ $catalog->id }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2 small">
                                <span class="text-muted">تاریخ ایجاد:</span>
                                <strong>{{ $catalog->created_at->format('Y/m/d H:i') }}</strong>
                            </div>
                            <div class="d-flex justify-content-between small">
                                <span class="text-muted">آخرین ویرایش:</span>
                                <strong>{{ $catalog->updated_at->format('Y/m/d H:i') }}</strong>
                            </div>
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
                                <span>تغییر اسلاگ روی سئو اثر دارد.</span>
                            </div>
                            <div class="d-flex gap-2 small">
                                <i class="bi bi-check-circle-fill text-success"></i>
                                <span>غیرفعال = عدم نمایش در سایت.</span>
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
                            <i class="bi bi-check-circle"></i> به‌روزرسانی کاتالوگ
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

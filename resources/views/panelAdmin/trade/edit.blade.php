@extends('panelAdmin.layouts.panel')

@section('title', 'ویرایش پروژه')

@section('content')
    @php
        $locales       = \App\Models\TradeTransaction::LOCALES;
        $defaultLocale = \App\Models\TradeTransaction::DEFAULT_LOCALE;
    @endphp
    <td>
        <small>
            {{ $transaction->contract_date_jalali ?? '—' }}
        </small>
    </td>

    <div class="container-fluid">

        {{-- هدر --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">
                    <i class="fas fa-edit me-2"></i>
                    ویرایش پروژه
                </h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.trade-transaction.index') }}">پروژه‌ها</a>
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

        <form action="{{ route('admin.trade-transaction.update', $tradeTransaction) }}"
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
                                    @php $t = $tradeTransaction->translations->firstWhere('locale', $code); @endphp
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
                                        $t = $tradeTransaction->translations->firstWhere('locale', $code);
                                        $isDefault = $code === $defaultLocale;
                                    @endphp

                                    <div class="tab-pane fade @if($loop->first) show active @endif"
                                         id="lang-{{ $code }}"
                                         role="tabpanel">

                                        {{-- عنوان --}}
                                        <div class="mb-3">
                                            <label class="form-label">
                                                عنوان پروژه
                                                @if($isDefault) <span class="text-danger">*</span> @endif
                                                <small class="text-muted">({{ $label }})</small>
                                            </label>
                                            <input type="text"
                                                   name="translations[{{ $code }}][title]"
                                                   class="form-control"
                                                   value="{{ old("translations.{$code}.title", $t?->title) }}"
                                                   @if($isDefault) required @endif>
                                        </div>

                                        {{-- نام کالا --}}
                                        <div class="mb-3">
                                            <label class="form-label">
                                                نام کالا
                                                @if($isDefault) <span class="text-danger">*</span> @endif
                                            </label>
                                            <input type="text"
                                                   name="translations[{{ $code }}][product]"
                                                   class="form-control"
                                                   value="{{ old("translations.{$code}.product", $t?->product) }}"
                                                   @if($isDefault) required @endif>
                                        </div>

                                        {{-- کشورها --}}
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">کشور مبدا</label>
                                                <input type="text"
                                                       name="translations[{{ $code }}][origin_country]"
                                                       class="form-control"
                                                       value="{{ old("translations.{$code}.origin_country", $t?->origin_country) }}">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">کشور مقصد</label>
                                                <input type="text"
                                                       name="translations[{{ $code }}][destination_country]"
                                                       class="form-control"
                                                       value="{{ old("translations.{$code}.destination_country", $t?->destination_country) }}">
                                            </div>
                                        </div>

                                        {{-- بسته‌بندی و alt --}}
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">بسته‌بندی</label>
                                                <input type="text"
                                                       name="translations[{{ $code }}][packaging]"
                                                       class="form-control"
                                                       value="{{ old("translations.{$code}.packaging", $t?->packaging) }}">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">متن جایگزین تصویر</label>
                                                <input type="text"
                                                       name="translations[{{ $code }}][alt_text]"
                                                       class="form-control"
                                                       value="{{ old("translations.{$code}.alt_text", $t?->alt_text) }}">
                                            </div>
                                        </div>

                                        {{-- توضیحات --}}
                                        <div class="mb-3">
                                            <label class="form-label">توضیحات</label>
                                            <textarea name="translations[{{ $code }}][description]"
                                                      class="form-control"
                                                      rows="5">{{ old("translations.{$code}.description", $t?->description) }}</textarea>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ==================== اطلاعات معامله ==================== --}}
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-info-circle me-1"></i>
                                اطلاعات معامله
                            </h5>
                        </div>
                        <div class="card-body">

                            {{-- کد --}}
                            <div class="mb-3">
                                <label class="form-label">کد پروژه</label>
                                <input type="text"
                                       class="form-control bg-light"
                                       value="{{ $tradeTransaction->transaction_code }}"
                                       readonly
                                       style="cursor: not-allowed;">
                                <small class="text-muted">
                                    <i class="fas fa-lock me-1"></i>
                                    این کد به‌صورت خودکار ساخته شده و قابل ویرایش نیست.
                                </small>
                            </div>

                            {{-- نوع معامله --}}
                            <div class="mb-3">
                                <label class="form-label">
                                    نوع معامله <span class="text-danger">*</span>
                                </label>
                                <select name="transaction_type" class="form-select" required>
                                    @foreach(\App\Models\TradeTransaction::TRANSACTION_TYPES as $key => $labels)
                                        <option value="{{ $key }}"
                                            @selected(old('transaction_type', $tradeTransaction->transaction_type) === $key)>
                                            {{ $labels[app()->getLocale()] ?? $labels['fa'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- مقدار و واحد --}}
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">مقدار</label>
                                    <input type="number" step="0.001"
                                           name="quantity"
                                           class="form-control"
                                           value="{{ old('quantity', $tradeTransaction->quantity) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">واحد</label>
                                    <select name="unit" class="form-select" required>
                                        @foreach(\App\Models\TradeTransaction::UNITS as $key => $labels)
                                            <option value="{{ $key }}"
                                                @selected(old('unit', $tradeTransaction->unit) === $key)>
                                                {{ $labels[app()->getLocale()] ?? $labels['fa'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- روش حمل --}}
                            <div class="mb-3">
                                <label class="form-label">روش حمل</label>
                                <select name="transport_method" class="form-select">
                                    <option value="">-- انتخاب --</option>
                                    @foreach(\App\Models\TradeTransaction::TRANSPORT_METHODS as $key => $labels)
                                        <option value="{{ $key }}"
                                            @selected(old('transport_method', $tradeTransaction->transport_method) === $key)>
                                            {{ $labels[app()->getLocale()] ?? $labels['fa'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- زمان تحویل --}}
                            <div class="mb-3">
                                <label class="form-label">زمان تحویل</label>
                                <input type="text"
                                       name="delivery_time"
                                       class="form-control"
                                       placeholder="مثال: ۳۰ روز پس از قرارداد"
                                       value="{{ old('delivery_time', $tradeTransaction->delivery_time) }}">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ==================== تاریخ‌ها و تنظیمات ==================== --}}
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-calendar me-1"></i>
                                تاریخ‌ها و تنظیمات
                            </h5>
                        </div>
                        <div class="card-body">

                            {{-- تاریخ قرارداد و تحویل --}}
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">تاریخ قرارداد (شمسی)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-calendar-alt"></i>
                                        </span>
                                        <input type="text"
                                               name="contract_date"
                                               id="contract_date"
                                               class="form-control jalali-date"
                                               placeholder="1403/07/15"
                                               value="{{ old('contract_date', $tradeTransaction->contract_date
                                                    ? Verta::instance($tradeTransaction->contract_date)->format('Y/m/d')
                                                    : '') }}"
                                               autocomplete="off">
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">تاریخ تحویل (شمسی)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-calendar-alt"></i>
                                        </span>
                                        <input type="text"
                                               name="delivery_date"
                                               id="delivery_date"
                                               class="form-control jalali-date"
                                               placeholder="1403/08/01"
                                               value="{{ old('delivery_date', $tradeTransaction->delivery_date
                                                    ? Verta::instance($tradeTransaction->delivery_date)->format('Y/m/d')
                                                    : '') }}"
                                               autocomplete="off">
                                    </div>
                                </div>
                            </div>

                            {{-- ترتیب نمایش --}}
                            <div class="mb-3">
                                <label class="form-label">ترتیب نمایش</label>
                                <input type="number"
                                       name="sort_order"
                                       class="form-control"
                                       min="0"
                                       value="{{ old('sort_order', $tradeTransaction->sort_order) }}">
                                <small class="text-muted">عدد کوچکتر = نمایش بالاتر</small>
                            </div>

                            {{-- وضعیت انتشار --}}
                            <div class="form-check form-switch mb-3">
                                <input type="hidden" name="is_published" value="0">
                                <input type="checkbox"
                                       name="is_published"
                                       value="1"
                                       class="form-check-input"
                                       id="is_published"
                                    @checked(old('is_published', $tradeTransaction->is_published))>
                                <label class="form-check-label" for="is_published">
                                    منتشر شده باشد
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ==================== تصویر ==================== --}}
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-image me-1"></i>
                                تصویر پروژه
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">تغییر تصویر</label>
                                    <input type="file"
                                           name="image"
                                           id="image"
                                           accept="image/*"
                                           class="form-control"
                                           onchange="previewImage(this)">
                                    <small class="text-muted">
                                        در صورت عدم انتخاب، تصویر فعلی حفظ می‌شود.
                                        <br>
                                        فرمت‌های مجاز: JPG, PNG, WEBP - حداکثر ۴ مگابایت
                                    </small>
                                </div>
                                <div class="col-md-6 text-center">
                                    @if($tradeTransaction->image)
                                        <img id="image-preview"
                                             src="{{ $tradeTransaction->image_url }}"
                                             class="img-thumbnail"
                                             style="max-height: 200px;">
                                    @else
                                        <img id="image-preview"
                                             src=""
                                             class="img-thumbnail d-none"
                                             style="max-height: 200px;">
                                        <div id="no-image-placeholder"
                                             class="text-muted py-5 border rounded">
                                            <i class="fas fa-image fa-3x mb-2"></i>
                                            <p class="mb-0">پیش‌نمایش تصویر</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- دکمه‌ها --}}
            <div class="card mt-3">
                <div class="card-body d-flex justify-content-between">
                    <a href="{{ route('admin.trade-transaction.index') }}" class="btn btn-secondary">
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
              action="{{ route('admin.trade-transaction.delete', $tradeTransaction) }}"
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

        .jalali-date {
            cursor: pointer;
            background-color: #fff !important;
        }

        .input-group-text {
            background: #f1f5f9;
            color: #2563eb;
            cursor: pointer;
        }

        .datepicker-plot-area {
            font-family: inherit !important;
            border-radius: 8px !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15) !important;
            z-index: 9999 !important;
        }

        .datepicker-day-view .table-days td.selected span,
        .datepicker-day-view .table-days td.selected span:hover {
            background-color: #2563eb !important;
            color: white !important;
            border-radius: 50% !important;
        }

        .datepicker-day-view .table-days td:hover span {
            background-color: #3b82f6 !important;
            color: white !important;
            border-radius: 50% !important;
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

        $(document).ready(function () {
            $('.jalali-date').persianDatepicker({
                format: 'YYYY/MM/DD',
                initialValue: false,
                autoClose: true,
                persianDigit: false,
                observer: true,
                responsive: true,
                position: 'auto',
                calendar: {
                    persian: {
                        locale: 'fa',
                        leapYearMode: 'algorithmic'
                    }
                },
                navigator: { scroll: { enabled: false } },
                toolbox: {
                    calendarSwitch: { enabled: false },
                    todayButton: { enabled: true, text: { fa: 'امروز' } },
                    submitButton: { enabled: true, text: { fa: 'تأیید' } }
                },
                timePicker: { enabled: false }
            });
        });
    </script>
@endpush

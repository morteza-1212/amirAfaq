@extends('panelAdmin.layouts.panel')

@section('title', 'مدیریت پروژه‌های انجام شده')

@section('content')
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
                    <i class="fas fa-handshake me-2"></i>
                    پروژه‌های انجام شده
                </h1>
                <p class="text-muted mb-0 mt-1">شرکت امیرآفاق گستر</p>
            </div>
            <a href="{{ route('admin.trade-transaction.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>
                افزودن پروژه جدید
            </a>
        </div>

        {{-- پیام‌ها --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-1"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle me-1"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- فیلتر --}}
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.trade-transaction.index') }}" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">جستجو</label>
                        <input type="text" name="search" class="form-control"
                               placeholder="عنوان، کد، کالا یا کشور..."
                               value="{{ request('search') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">نوع معامله</label>
                        <select name="type" class="form-select">
                            <option value="">همه</option>
                            @foreach(\App\Models\TradeTransaction::TRANSACTION_TYPES as $key => $labels)
                                <option value="{{ $key }}" @selected(request('type') === $key)>
                                    {{ $labels[app()->getLocale()] ?? $labels['fa'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">وضعیت</label>
                        <select name="status" class="form-select">
                            <option value="">همه</option>
                            <option value="published" @selected(request('status') === 'published')>منتشر شده</option>
                            <option value="draft" @selected(request('status') === 'draft')>پیش‌نویس</option>
                        </select>
                    </div>

                    <div class="col-md-2 d-flex align-items-end gap-2">
                        <button class="btn btn-primary w-100">
                            <i class="fas fa-search me-1"></i>
                            فیلتر
                        </button>
                        <a href="{{ route('admin.trade-transaction.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- جدول --}}
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-light">
                        <tr>
                            <th width="60">#</th>
                            <th width="90">تصویر</th>
                            <th>عنوان</th>
                            <th width="130">کد</th>
                            <th width="130">نوع</th>
                            <th width="130">مقدار</th>
                            <th width="120">روش حمل</th>
                            <th width="110">تاریخ قرارداد</th>
                            <th width="100">ترجمه‌ها</th>
                            <th width="100">وضعیت</th>
                            <th width="170">عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($transactions as $transaction)
                            <tr>
                                <td>{{ $transactions->firstItem() + $loop->index }}</td>

                                <td>
                                    @if($transaction->image)
                                        <img src="{{ $transaction->image_url }}"
                                             class="img-thumbnail"
                                             style="width: 60px; height: 60px; object-fit: cover;">
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>

                                <td>
                                    <strong>{{ $transaction->title ?? '—' }}</strong>
                                    @if($transaction->product)
                                        <br>
                                        <small class="text-muted">
                                            <i class="fas fa-box me-1"></i>
                                            {{ \Illuminate\Support\Str::limit($transaction->product, 40) }}
                                        </small>
                                    @endif
                                </td>

                                <td>
                                    <code>{{ $transaction->transaction_code }}</code>
                                </td>

                                <td>
                                    @if($transaction->transaction_type === 'export')
                                        <span class="badge bg-info">
                                            <i class="fas fa-arrow-up me-1"></i>
                                            {{ $transaction->transaction_type_label }}
                                        </span>
                                    @else
                                        <span class="badge bg-warning text-dark">
                                            <i class="fas fa-arrow-down me-1"></i>
                                            {{ $transaction->transaction_type_label }}
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    @if($transaction->quantity)
                                        {{ number_format($transaction->quantity, 2) }}
                                        <small class="text-muted">{{ $transaction->unit_label }}</small>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>

                                <td>
                                    @if($transaction->transport_method_label)
                                        <span class="badge bg-secondary">
                                            {{ $transaction->transport_method_label }}
                                        </span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>

                                <td>
                                    @if($transaction->contract_date)
                                        <small>
                                            {{ Verta::instance($transaction->contract_date)->format('Y/m/d') }}
                                        </small>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>

                                <td>
                                    <span class="badge bg-primary">
                                        <i class="fas fa-language me-1"></i>
                                        {{ $transaction->translations->count() }} / 3
                                    </span>
                                </td>

                                <td>
                                    @if($transaction->is_published)
                                        <span class="badge bg-success">منتشر شده</span>
                                    @else
                                        <span class="badge bg-secondary">پیش‌نویس</span>
                                    @endif
                                </td>

                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.trade-transaction.edit', $transaction) }}"
                                           class="btn btn-warning" title="ویرایش">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('admin.trade-transaction.delete', $transaction) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('آیا از حذف این پروژه اطمینان دارید؟');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger" title="حذف">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center py-5 text-muted">
                                    <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                    هیچ پروژه‌ای یافت نشد.
                                    <br>
                                    <a href="{{ route('admin.trade-transaction.create') }}"
                                       class="btn btn-sm btn-primary mt-3">
                                        افزودن اولین پروژه
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($transactions->hasPages())
                <div class="card-footer">
                    {{ $transactions->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

@extends('panelAdmin.layouts.panel')

@section('title', 'مدیریت درخواست‌های خریداران')

@section('content')
    <div class="container-fluid">

        {{-- هدر --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">
                    <i class="fas fa-shopping-cart me-2"></i>
                    درخواست‌های خریداران
                </h1>
                <p class="text-muted mb-0 mt-1">شرکت امیرآفاق گستر</p>
            </div>
        </div>

        {{-- پیام‌ها --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-1"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- کارت‌های آماری --}}
        <div class="row g-3 mb-4">
            <div class="col-md-3 col-sm-6">
                <div class="card border-start border-4 border-primary h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">کل درخواست‌ها</div>
                            <h3 class="mb-0 mt-1">{{ $stats['total'] }}</h3>
                        </div>
                        <i class="fas fa-inbox fa-2x text-primary"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="card border-start border-4 border-info h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">جدید</div>
                            <h3 class="mb-0 mt-1">{{ $stats['new'] }}</h3>
                        </div>
                        <i class="fas fa-bell fa-2x text-info"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="card border-start border-4 border-warning h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">تماس گرفته</div>
                            <h3 class="mb-0 mt-1">{{ $stats['contacted'] }}</h3>
                        </div>
                        <i class="fas fa-phone fa-2x text-warning"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="card border-start border-4 border-success h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">بسته‌شده</div>
                            <h3 class="mb-0 mt-1">{{ $stats['closed'] }}</h3>
                        </div>
                        <i class="fas fa-check fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- فیلتر --}}
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.buyer.index') }}" class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">جستجو</label>
                        <input type="text"
                               name="search"
                               class="form-control"
                               placeholder="محصول، کشور، نام، ایمیل یا تلفن..."
                               value="{{ request('search') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">وضعیت</label>
                        <select name="status" class="form-select">
                            <option value="">همه</option>
                            @foreach(\App\Models\Buyer::STATUSES as $key => $labels)
                                <option value="{{ $key }}" @selected(request('status') === $key)>
                                    {{ $labels[app()->getLocale()] ?? $labels['fa'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 d-flex align-items-end gap-2">
                        <button class="btn btn-primary w-100">
                            <i class="fas fa-search me-1"></i>
                            فیلتر
                        </button>
                        <a href="{{ route('admin.buyer.index') }}" class="btn btn-outline-secondary">
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
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                        <tr>
                            <th width="60">#</th>
                            <th>محصول</th>
                            <th width="120">مقدار</th>
                            <th width="150">مقصد</th>
                            <th width="130">نام خریدار</th>
                            <th width="130">تلفن</th>
                            <th width="110">وضعیت</th>
                            <th width="130">تاریخ</th>
                            <th width="200">عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($buyers as $buyer)
                            <tr>
                                <td>{{ $buyers->firstItem() + $loop->index }}</td>

                                <td>
                                    <strong>{{ $buyer->product }}</strong>
                                    @if($buyer->company_information)
                                        <br>
                                        <small class="text-muted">
                                            {{ \Illuminate\Support\Str::limit($buyer->company_information, 50) }}
                                        </small>
                                    @endif
                                </td>

                                <td>{{ $buyer->quantity }}</td>

                                <td>
                                    <i class="fas fa-location-dot text-muted me-1"></i>
                                    {{ $buyer->destination_country }}
                                    @if($buyer->destination_port)
                                        <br>
                                        <small class="text-muted">
                                            {{ $buyer->destination_port }}
                                        </small>
                                    @endif
                                </td>

                                <td>
                                    {{ $buyer->name ?? '—' }}
                                    @if($buyer->email)
                                        <br>
                                        <small class="text-muted" style="direction: ltr;">
                                            {{ $buyer->email }}
                                        </small>
                                    @endif
                                </td>

                                <td>
                                    @if($buyer->phone)
                                        <a href="tel:{{ $buyer->phone }}">
                                            {{ $buyer->phone }}
                                        </a>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>

                                <td>
                                    <span class="badge bg-{{ $buyer->status_color }}">
                                        {{ $buyer->status_label }}
                                    </span>
                                </td>

                                <td>
                                    <small>
                                        {{ $buyer->created_at->format('Y/m/d') }}
                                        <br>
                                        {{ $buyer->created_at->format('H:i') }}
                                    </small>
                                </td>

                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.buyer.show', $buyer) }}"
                                           class="btn btn-info" title="مشاهده">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <a href="{{ route('admin.buyer.edit', $buyer) }}"
                                           class="btn btn-warning" title="ویرایش">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('admin.buyer.delete', $buyer) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('حذف شود؟');">
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
                                <td colspan="9" class="text-center py-5 text-muted">
                                    <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                    هیچ درخواستی یافت نشد.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($buyers->hasPages())
                <div class="card-footer">
                    {{ $buyers->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

@extends('panelAdmin.layouts.panel')

@section('title', 'سفارش‌ها')
@section('page-title', 'مدیریت سفارش‌ها')

@section('content')
    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <form method="GET" class="row g-2">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control form-control-sm"
                           placeholder="جستجو (شماره، موبایل، نام...)" value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select form-select-sm">
                        <option value="">همه وضعیت‌ها</option>
                        @foreach(['pending','paid','processing','shipped','delivered','cancelled','refunded'] as $s)
                            <option value="{{ $s }}" @selected(request('status') === $s)>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="payment_method" class="form-select form-select-sm">
                        <option value="">روش پرداخت</option>
                        @foreach(['online','cod','wallet'] as $m)
                            <option value="{{ $m }}" @selected(request('payment_method') === $m)>{{ $m }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" name="from" class="form-control form-control-sm" value="{{ request('from') }}">
                </div>
                <div class="col-md-2">
                    <input type="date" name="to" class="form-control form-control-sm" value="{{ request('to') }}">
                </div>
                <div class="col-md-1">
                    <button class="btn btn-sm btn-primary w-100">فیلتر</button>
                </div>
            </form>
        </div>
    </div>

    <div class="d-flex justify-content-between mb-2">
        <a href="{{ route('admin.orders.export', request()->only(['search','status','from','to'])) }}"
           class="btn btn-sm btn-outline-success">
            <i class="bi bi-file-earmark-excel"></i> خروجی CSV
        </a>
        <span class="text-muted small">{{ $orders->total() }} سفارش</span>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                <tr>
                    <th>شماره</th>
                    <th>مشتری</th>
                    <th>موبایل</th>
                    <th>مبلغ</th>
                    <th>روش پرداخت</th>
                    <th>وضعیت</th>
                    <th>تاریخ</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}" class="fw-bold">
                                {{ $order->order_number }}
                            </a>
                            <div class="small text-muted">{{ $order->tracking_code }}</div>
                        </td>
                        <td>{{ $order->customer_name }}</td>
                        <td>{{ $order->customer_phone }}</td>
                        <td>{{ number_format($order->total_amount) }} ت</td>
                        <td>{{ $order->payment_method }}</td>
                        <td>
                            @php
                                $colors = [
                                    'pending' => 'warning', 'paid' => 'success',
                                    'processing' => 'info', 'shipped' => 'primary',
                                    'delivered' => 'success', 'cancelled' => 'danger',
                                    'refunded' => 'secondary',
                                ];
                            @endphp
                            <span class="badge bg-{{ $colors[$order->status] ?? 'secondary' }} status-badge">
                                    {{ $order->status }}
                                </span>
                        </td>
                        <td class="small">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-pencil"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center text-muted py-4">سفارشی یافت نشد.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white">{{ $orders->links() }}</div>
    </div>
@endsection

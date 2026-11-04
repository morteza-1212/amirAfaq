@extends('panelAdmin.layouts.panel')

@section('title', 'داشبورد')
@section('page-title', 'داشبورد')

@section('content')
    <div class="row g-3 mb-4">
        @php
            $cards = [
                ['label' => 'کل سفارش‌ها', 'value' => number_format($stats['orders_total']),  'icon' => 'bi-bag',           'color' => 'primary'],
                ['label' => 'در انتظار',   'value' => number_format($stats['orders_pending']), 'icon' => 'bi-clock',        'color' => 'warning'],
                ['label' => 'پرداخت‌شده',  'value' => number_format($stats['orders_paid']),    'icon' => 'bi-check2-circle', 'color' => 'success'],
                ['label' => 'ارسال‌شده',   'value' => number_format($stats['orders_shipped']), 'icon' => 'bi-truck',         'color' => 'info'],
                ['label' => 'درآمد کل',    'value' => number_format($stats['revenue_total']) . ' ت', 'icon' => 'bi-cash-stack', 'color' => 'success'],
                ['label' => 'درآمد امروز', 'value' => number_format($stats['revenue_today']) . ' ت', 'icon' => 'bi-calendar-day','color' => 'success'],
            ];
        @endphp

        @foreach($cards as $card)
            <div class="col-md-4 col-xl-2">
                <div class="card stat-card shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="text-muted small mb-1">{{ $card['label'] }}</div>
                                <div class="fw-bold fs-5">{{ $card['value'] }}</div>
                            </div>
                            <div class="stat-icon bg-{{ $card['color'] }}-subtle text-{{ $card['color'] }}">
                                <i class="bi {{ $card['icon'] }}"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row g-3">
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between">
                    <strong>آخرین سفارش‌ها</strong>
                    <a href="{{ route('admin.orders.index') }}" class="small">همه</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead class="table-light">
                        <tr><th>شماره</th><th>مشتری</th><th>مبلغ</th><th>وضعیت</th></tr>
                        </thead>
                        <tbody>
                        @foreach($recentOrders as $o)
                            <tr>
                                <td><a href="{{ route('admin.orders.show', $o) }}">{{ $o->order_number }}</a></td>
                                <td>{{ $o->customer_name }}</td>
                                <td>{{ number_format($o->total_amount) }}</td>
                                <td><span class="badge bg-secondary status-badge">{{ $o->status }}</span></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between">
                    <strong>آخرین پرداخت‌ها</strong>
                    <a href="{{ route('admin.payments.index') }}" class="small">همه</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead class="table-light">
                        <tr><th>شماره</th><th>سفارش</th><th>مبلغ</th><th>وضعیت</th></tr>
                        </thead>
                        <tbody>
                        @foreach($recentPayments as $p)
                            <tr>
                                <td><a href="{{ route('admin.payments.show', $p) }}">{{ $p->payment_number }}</a></td>
                                <td>{{ $p->order?->order_number }}</td>
                                <td>{{ number_format($p->amount) }}</td>
                                <td><span class="badge bg-secondary status-badge">{{ $p->status }}</span></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('panelAdmin.layouts.panel')

@section('title', 'پرداخت‌ها')
@section('page-title', 'مدیریت پرداخت‌ها')

@section('content')
    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <form method="GET" class="row g-2">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control form-control-sm"
                           placeholder="جستجو (شماره، تراکنش...)" value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select form-select-sm">
                        <option value="">همه وضعیت‌ها</option>
                        @foreach(['pending','success','failed','canceled','refunded'] as $s)
                            <option value="{{ $s }}" @selected(request('status') === $s)>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="text" name="gateway" class="form-control form-control-sm" placeholder="درگاه" value="{{ request('gateway') }}">
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

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                <tr>
                    <th>شماره پرداخت</th>
                    <th>سفارش</th>
                    <th>مبلغ</th>
                    <th>درگاه</th>
                    <th>وضعیت</th>
                    <th>تاریخ</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @forelse($payments as $payment)
                    <tr>
                        <td><a href="{{ route('admin.payments.show', $payment) }}" class="fw-bold">{{ $payment->payment_number }}</a></td>
                        <td>
                            @if($payment->order)
                                <a href="{{ route('admin.orders.show', $payment->order) }}">{{ $payment->order->order_number }}</a>
                            @else — @endif
                        </td>
                        <td>{{ number_format($payment->amount) }} {{ $payment->currency }}</td>
                        <td>{{ $payment->gateway }}</td>
                        <td>
                            @php
                                $colors = ['pending'=>'warning','success'=>'success','failed'=>'danger','canceled'=>'secondary','refunded'=>'info'];
                            @endphp
                            <span class="badge bg-{{ $colors[$payment->status] ?? 'secondary' }} status-badge">
                                    {{ $payment->status }}
                                </span>
                        </td>
                        <td class="small">{{ $payment->created_at->format('Y-m-d H:i') }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.payments.show', $payment) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">پرداختی یافت نشد.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white">{{ $payments->links() }}</div>
    </div>
@endsection

@extends('panelAdmin.layouts.panel')

@section('title', 'پرداخت ' . $payment->payment_number)
@section('page-title', 'جزئیات پرداخت')

@section('content')
    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-white"><strong>اطلاعات پرداخت</strong></div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6"><strong>شماره پرداخت:</strong> {{ $payment->payment_number }}</div>
                        <div class="col-md-6"><strong>وضعیت:</strong>
                            <span class="badge bg-primary">{{ $payment->status }}</span>
                        </div>
                        <div class="col-md-6"><strong>مبلغ:</strong> {{ number_format($payment->amount) }} {{ $payment->currency }}</div>
                        <div class="col-md-6"><strong>درگاه:</strong> {{ $payment->gateway }}</div>
                        <div class="col-md-6"><strong>شناسه تراکنش:</strong> {{ $payment->transaction_id ?? '—' }}</div>
                        <div class="col-md-6"><strong>زمان پرداخت:</strong> {{ $payment->paid_at?->format('Y-m-d H:i') ?? '—' }}</div>
                        <div class="col-md-6"><strong>زمان شکست:</strong> {{ $payment->failed_at?->format('Y-m-d H:i') ?? '—' }}</div>
                        <div class="col-md-6"><strong>زمان بازگشت:</strong> {{ $payment->refunded_at?->format('Y-m-d H:i') ?? '—' }}</div>
                        @if($payment->failure_reason)
                            <div class="col-12"><strong>دلیل شکست:</strong> {{ $payment->failure_reason }}</div>
                        @endif
                    </div>
                </div>
            </div>

            @if($payment->gateway_response)
                <div class="card shadow-sm mb-3">
                    <div class="card-header bg-white"><strong>پاسخ درگاه</strong></div>
                    <div class="card-body">
                        <pre class="bg-light p-2 rounded mb-0 small">{{ json_encode($payment->gateway_response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                    </div>
                </div>
            @endif

            @if($payment->metadata)
                <div class="card shadow-sm">
                    <div class="card-header bg-white"><strong>Metadata</strong></div>
                    <div class="card-body">
                        <pre class="bg-light p-2 rounded mb-0 small">{{ json_encode($payment->metadata, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                    </div>
                </div>
            @endif
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-white"><strong>سفارش مرتبط</strong></div>
                <div class="card-body small">
                    @if($payment->order)
                        <p class="mb-1"><strong>شماره:</strong>
                            <a href="{{ route('admin.orders.show', $payment->order) }}">{{ $payment->order->order_number }}</a>
                        </p>
                        <p class="mb-1"><strong>کد رهگیری:</strong> {{ $payment->order->tracking_code }}</p>
                        <p class="mb-1"><strong>مشتری:</strong> {{ $payment->order->customer_name }}</p>
                        <p class="mb-1"><strong>مبلغ سفارش:</strong> {{ number_format($payment->order->total_amount) }}</p>
                    @else
                        <p class="text-muted mb-0">سفارش حذف شده است.</p>
                    @endif
                </div>
            </div>

            @if($payment->verifiedBy)
                <div class="card shadow-sm mb-3">
                    <div class="card-header bg-white"><strong>تاییدکننده</strong></div>
                    <div class="card-body small">
                        {{ $payment->verifiedBy->full_name ?? $payment->verifiedBy->name }}
                    </div>
                </div>
            @endif

            @if($payment->refundedBy)
                <div class="card shadow-sm mb-3">
                    <div class="card-header bg-white"><strong>بازگرداننده وجه</strong></div>
                    <div class="card-body small">
                        {{ $payment->refundedBy->full_name ?? $payment->refundedBy->name }}
                    </div>
                </div>
            @endif

            {{-- تایید دستی --}}
            @can('verify', $payment)
                <form method="POST" action="{{ route('admin.payments.verify', $payment) }}"
                      onsubmit="return confirm('تایید دستی این پرداخت؟')">
                    @csrf @method('PATCH')
                    <button class="btn btn-success w-100 mb-2">
                        <i class="bi bi-check2-circle"></i> تایید دستی پرداخت
                    </button>
                </form>
            @endcan

            {{-- بازگشت وجه --}}
            @can('refund', $payment)
                <form method="POST" action="{{ route('admin.payments.refund', $payment) }}"
                      onsubmit="return confirm('بازگشت وجه انجام شود؟')">
                    @csrf
                    <textarea name="note" rows="2" class="form-control form-control-sm mb-2" placeholder="یادداشت بازگشت وجه (اختیاری)"></textarea>
                    <button class="btn btn-warning w-100 mb-2">
                        <i class="bi bi-arrow-counterclockwise"></i> بازگشت وجه
                    </button>
                </form>
            @endcan

            {{-- حذف --}}
            @can('delete', $payment)
                <form method="POST" action="{{ route('admin.payments.destroy', $payment) }}"
                      onsubmit="return confirm('حذف این پرداخت؟')">
                    @csrf @method('DELETE')
                    <button class="btn btn-outline-danger w-100">حذف پرداخت</button>
                </form>
            @endcan
        </div>
    </div>
@endsection

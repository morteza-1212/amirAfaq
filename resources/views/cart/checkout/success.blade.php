@extends('layouts.home')

@section('title', 'سفارش ثبت شد')

@section('content')
    <div class="container-xl py-5">
        <div class="mx-auto text-center" style="max-width: 600px;">
            <div class="mb-4" style="font-size: 4rem;">✅</div>
            <h1 class="h3 fw-bold mb-3">سفارش شما با موفقیت ثبت شد!</h1>
            <p class="text-muted mb-4">
                شماره سفارش شما: <strong class="text-dark">{{ $order->id }}</strong>
            </p>

            <div class="bg-white rounded-3 p-4 text-start soft-shadow mb-4">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">مبلغ کل:</span>
                    <strong>{{ number_format($order->total_amount) }} تومان</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">روش پرداخت:</span>
                    <strong>{{ $order->payment_method === 'online' ? 'پرداخت آنلاین' : 'پرداخت در محل' }}</strong>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted">وضعیت:</span>
                    <strong class="
        @switch($order->status)
            @case('pending') text-warning @break
            @case('paid') text-success @break
            @case('shipped') text-info @break
            @case('delivered') text-primary @break
            @case('cancelled') text-danger @break
            @default text-secondary
        @endswitch
    ">
                        @switch($order->status)
                            @case('pending') در انتظار پرداخت @break
                            @case('paid') پرداخت شده @break
                            @case('shipped') ارسال شده @break
                            @case('delivered') تحویل داده شده @break
                            @case('cancelled') لغو شده @break
                            @default {{ $order->status }}
                        @endswitch
                    </strong>
                </div>
            </div>

            <a href="{{ route('products.index', ['locale' => app()->getLocale()]) }}"
               class="btn btn-primary">بازگشت به فروشگاه</a>
        </div>
    </div>
@endsection

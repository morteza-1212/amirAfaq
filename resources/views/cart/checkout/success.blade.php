@extends('layouts.home')

@section('title', 'سفارش ثبت شد')

@section('content')

    <div class="container-xl py-5">

        <div class="mx-auto text-center" style="max-width: 600px;">

            <div class="mb-4" style="font-size: 4rem;">
                ✅
            </div>

            <h1 class="h3 fw-bold mb-3">
                سفارش شما با موفقیت ثبت شد!
            </h1>

            <p class="text-muted mb-4">
                شماره سفارش شما:
                <strong class="text-dark">
                    {{ $order->order_number ?? $order->id }}
                </strong>
            </p>

            {{-- اطلاعات سفارش --}}
            <div class="bg-white rounded-3 p-4 text-start soft-shadow mb-4">

                <div class="d-flex justify-content-between mb-3">
                    <span class="text-muted">
                        مبلغ کل:
                    </span>

                    <strong>
                        {{ number_format($order->total_amount) }} تومان
                    </strong>
                </div>

                <div class="d-flex justify-content-between mb-3">
                    <span class="text-muted">
                        روش پرداخت:
                    </span>

                    <strong>
                        @switch($order->payment_method)
                            @case('online')
                                پرداخت آنلاین
                                @break

                            @case('cod')
                                پرداخت در محل
                                @break

                            @default
                                {{ $order->payment_method }}
                        @endswitch
                    </strong>
                </div>

                <div class="d-flex justify-content-between">
                    <span class="text-muted">
                        وضعیت:
                    </span>

                    <strong class="
                        @switch($order->status)
                            @case('pending')
                                text-warning
                                @break

                            @case('paid')
                                text-success
                                @break

                            @case('processing')
                                text-primary
                                @break

                            @case('shipped')
                                text-info
                                @break

                            @case('delivered')
                                text-primary
                                @break

                            @case('cancelled')
                            @case('refunded')
                                text-danger
                                @break

                            @default
                                text-secondary
                        @endswitch
                    ">

                        @switch($order->status)
                            @case('pending')
                                در انتظار پرداخت
                                @break

                            @case('paid')
                                پرداخت شده
                                @break

                            @case('processing')
                                در حال آماده‌سازی
                                @break

                            @case('shipped')
                                ارسال شده
                                @break

                            @case('delivered')
                                تحویل داده شده
                                @break

                            @case('cancelled')
                                لغو شده
                                @break

                            @case('refunded')
                                وجه بازگردانده شده
                                @break

                            @default
                                {{ $order->status }}
                        @endswitch

                    </strong>
                </div>

            </div>

            {{-- دکمه‌های عملیات --}}
            <div class="d-flex gap-2 justify-content-center flex-wrap">

                <a href="{{ route('checkout.invoice', [
                    'locale' => app()->getLocale(),
                    'order' => $order->id
                ]) }}"
                   class="btn btn-outline-primary">

                    🧾 مشاهده فاکتور

                </a>

                <a href="{{ route('products.index', [
                    'locale' => app()->getLocale()
                ]) }}"
                   class="btn btn-primary">

                    بازگشت به فروشگاه

                </a>

            </div>

        </div>

    </div>

@endsection

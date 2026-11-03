@extends('layouts.home')

@section('title', 'پرداخت موفق')

@section('content')

    <div class="payment-result-page" dir="rtl">

        <div class="container py-5">

            <div class="result-card">

                <div class="result-icon success-icon">
                    <i class="fas fa-check"></i>
                </div>

                <h2 class="text-success">پرداخت با موفقیت انجام شد</h2>

                <p class="result-description">
                    پرداخت سفارش شما با موفقیت ثبت شد.
                    از خرید شما سپاسگزاریم.
                </p>

                <div class="result-info">

                    <div>
                        <span>شماره سفارش</span>
                        <strong>{{ $payment->order->tracking_code }}</strong>
                    </div>

                    <div>
                        <span>شماره تراکنش</span>
                        <strong>{{ $payment->transaction_id }}</strong>
                    </div>

                    <div>
                        <span>مبلغ پرداختی</span>
                        <strong>
                            {{ number_format($payment->amount) }} تومان
                        </strong>
                    </div>

                    <div>
                        <span>وضعیت پرداخت</span>
                        <strong class="text-success">موفق</strong>
                    </div>

                </div>

                <a href="{{ route('checkout.success', [
                'locale' => $locale,
                'order' => $payment->order->id
            ]) }}" class="btn btn-success w-100 mt-4">

                    مشاهده سفارش

                </a>

                <a href="{{ url('/' . $locale) }}"
                   class="btn btn-outline-secondary w-100 mt-2">

                    بازگشت به صفحه اصلی

                </a>

            </div>

        </div>

    </div>

@endsection

@push('styles')
    <style>
        .payment-result-page {
            background: #f4f7fb;
            min-height: 75vh;
        }

        .result-card {
            max-width: 550px;
            margin: auto;
            background: #fff;
            padding: 45px 35px;
            border-radius: 18px;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0,0,0,.07);
        }

        .result-icon {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            font-size: 40px;
        }

        .success-icon {
            background: #d1f2df;
            color: #198754;
        }

        .result-card h2 {
            font-size: 23px;
            font-weight: 700;
        }

        .result-description {
            color: #777;
            line-height: 2;
            margin: 18px 0 25px;
        }

        .result-info {
            background: #f8f9fc;
            border-radius: 12px;
            padding: 20px;
            text-align: right;
        }

        .result-info div {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 17px;
        }

        .result-info div:last-child {
            margin-bottom: 0;
        }

        .result-info span {
            color: #777;
        }

        .result-card .btn {
            padding: 12px;
            border-radius: 9px;
        }
    </style>
@endpush

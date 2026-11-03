@extends('layouts.home')

@section('title', 'درگاه پرداخت')

@section('content')

    <div class="payment-page" dir="rtl">

        <div class="container py-5">

            <div class="row justify-content-center">

                <div class="col-lg-6 col-md-8">

                    <div class="payment-card">

                        <div class="payment-header">
                            <div class="payment-icon">
                                <i class="fas fa-credit-card"></i>
                            </div>

                            <h3>درگاه پرداخت آزمایشی</h3>
                            <p>پرداخت امن سفارش شما</p>
                        </div>

                        <div class="payment-body">

                            <div class="alert alert-warning text-center">
                                این درگاه صرفاً جهت آزمایش است و هیچ مبلغی از حساب بانکی شما کسر نمی‌شود.
                            </div>

                            <div class="payment-info">

                                <div class="info-row">
                                    <span>شماره سفارش</span>
                                    <strong>{{ $order->tracking_code }}</strong>
                                </div>

                                <div class="info-row">
                                    <span>شماره تراکنش</span>
                                    <strong>{{ $payment->transaction_id }}</strong>
                                </div>

                                <div class="info-row">
                                    <span>وضعیت پرداخت</span>
                                    <span class="badge bg-warning">در انتظار پرداخت</span>
                                </div>

                                <hr>

                                <div class="amount-row">
                                    <span>مبلغ قابل پرداخت</span>
                                    <strong>
                                        {{ number_format($payment->amount) }}
                                        تومان
                                    </strong>
                                </div>

                            </div>

                            <form method="POST"
                                  action="{{ route('payment.process', [
                                  'locale' => $locale,
                                  'order' => $order->id
                              ]) }}">

                                @csrf

                                <input type="hidden"
                                       name="payment_id"
                                       value="{{ $payment->id }}">

                                <button type="submit"
                                        name="action"
                                        value="success"
                                        class="btn btn-success w-100 mb-3">

                                    <i class="fas fa-check-circle"></i>
                                    پرداخت موفق

                                </button>

                                <button type="submit"
                                        name="action"
                                        value="failed"
                                        class="btn btn-danger w-100 mb-3">

                                    <i class="fas fa-times-circle"></i>
                                    پرداخت ناموفق

                                </button>

                                <button type="submit"
                                        name="action"
                                        value="canceled"
                                        class="btn btn-outline-secondary w-100">

                                    <i class="fas fa-ban"></i>
                                    انصراف از پرداخت

                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection

@push('styles')
    <style>
        .payment-page {
            background: #f4f7fb;
            min-height: 75vh;
        }

        .payment-card {
            background: #fff;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0,0,0,.07);
        }

        .payment-header {
            background: #123b63;
            color: #fff;
            text-align: center;
            padding: 35px 20px;
        }

        .payment-header h3 {
            font-weight: 700;
            margin: 15px 0 8px;
        }

        .payment-header p {
            margin: 0;
            opacity: .8;
        }

        .payment-icon {
            font-size: 40px;
        }

        .payment-body {
            padding: 30px;
        }

        .payment-info {
            background: #f8f9fc;
            padding: 20px;
            border-radius: 12px;
            margin: 25px 0;
        }

        .info-row,
        .amount-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 18px;
        }

        .info-row:last-child {
            margin-bottom: 0;
        }

        .amount-row strong {
            color: #198754;
            font-size: 22px;
        }

        .payment-body .btn {
            padding: 13px;
            border-radius: 9px;
            font-weight: 600;
        }
    </style>
@endpush

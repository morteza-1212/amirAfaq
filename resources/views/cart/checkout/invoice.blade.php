@extends('layouts.home')

@section('title', 'فاکتور سفارش #' . $order->order_number)

@push('styles')
    <style>
        /* ===== فاکتور ===== */
        .invoice-wrapper {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 16px rgba(0,0,0,.06);
            padding: 2rem;
            max-width: 900px;
            margin: 0 auto;
        }

        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 1.25rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .invoice-brand {
            font-size: 1.5rem;
            font-weight: 800;
            color: #0d6efd;
            letter-spacing: -.5px;
        }

        .invoice-meta {
            text-align: left;
            font-size: .9rem;
            color: #6b7280;
            line-height: 1.8;
        }

        .invoice-meta strong {
            color: #111827;
        }

        .invoice-title {
            text-align: center;
            font-weight: 700;
            font-size: 1.15rem;
            margin: 1.5rem 0;
            letter-spacing: 1px;
            color: #374151;
        }

        .invoice-section {
            margin-bottom: 1.5rem;
        }

        .invoice-section-title {
            font-size: .85rem;
            font-weight: 700;
            color: #0d6efd;
            margin-bottom: .5rem;
            padding-bottom: .25rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .invoice-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: .75rem 1.5rem;
            font-size: .9rem;
        }

        .invoice-grid .label {
            color: #6b7280;
            font-size: .82rem;
        }

        .invoice-grid .value {
            color: #111827;
            font-weight: 600;
        }

        /* جدول اقلام */
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            font-size: .9rem;
        }

        .invoice-table thead th {
            background: #f3f4f6;
            color: #374151;
            font-weight: 700;
            padding: .65rem .5rem;
            text-align: right;
            border-bottom: 2px solid #e5e7eb;
            font-size: .82rem;
        }

        .invoice-table tbody td {
            padding: .65rem .5rem;
            border-bottom: 1px solid #f3f4f6;
            vertical-align: middle;
        }

        .invoice-table tbody tr:last-child td {
            border-bottom: none;
        }

        .product-cell {
            display: flex;
            align-items: center;
            gap: .65rem;
        }

        .product-thumb {
            width: 44px;
            height: 44px;
            border-radius: 8px;
            object-fit: cover;
            background: #f3f4f6;
            flex-shrink: 0;
        }

        .product-name {
            font-weight: 600;
            color: #111827;
        }

        .product-sku {
            font-size: .75rem;
            color: #9ca3af;
        }

        /* خلاصه مبالغ */
        .invoice-summary {
            margin-top: 1.5rem;
            display: flex;
            justify-content: flex-start;
        }

        .summary-box {
            width: 100%;
            max-width: 340px;
            margin-right: auto;
            font-size: .9rem;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: .45rem 0;
            color: #4b5563;
        }

        .summary-row.total {
            border-top: 2px solid #111827;
            margin-top: .35rem;
            padding-top: .65rem;
            font-size: 1.05rem;
            font-weight: 800;
            color: #111827;
        }

        .summary-row.discount {
            color: #dc2626;
        }

        /* وضعیت پرداخت */
        .status-badge {
            display: inline-block;
            padding: .25rem .75rem;
            border-radius: 999px;
            font-size: .78rem;
            font-weight: 700;
        }

        .status-paid    { background: #dcfce7; color: #166534; }
        .status-pending { background: #fef9c3; color: #854d0e; }
        .status-failed  { background: #fee2e2; color: #991b1b; }
        .status-canceled{ background: #f3f4f6; color: #4b5563; }

        /* دکمه‌ها */
        .invoice-actions {
            display: flex;
            gap: .75rem;
            justify-content: center;
            margin-top: 2rem;
            flex-wrap: wrap;
        }

        /* ===== حالت چاپ ===== */
        @media print {
            body * { visibility: hidden; }

            .invoice-wrapper,
            .invoice-wrapper * { visibility: visible; }

            .invoice-wrapper {
                position: absolute;
                inset: 0;
                box-shadow: none;
                border-radius: 0;
                padding: 0;
                max-width: 100%;
                margin: 0;
            }

            .invoice-actions,
            .no-print { display: none !important; }

            .invoice-table thead th { background: #f3f4f6 !important; -webkit-print-color-adjust: exact; }

            @page { margin: 1.2cm; size: A4; }
        }
    </style>
@endpush

@section('content')
    <div class="container-xl py-5">

        {{-- پیام موفقیت --}}
        <div class="text-center mb-4 no-print">
            <div class="mb-2" style="font-size: 3rem;">✅</div>
            <h1 class="h4 fw-bold mb-2">سفارش شما با موفقیت ثبت شد!</h1>
            <p class="text-muted mb-0">
                شماره سفارش: <strong class="text-dark">{{ $order->order_number }}</strong>
            </p>
        </div>

        {{-- فاکتور --}}
        <div class="invoice-wrapper" id="invoice">

            {{-- هدر --}}
            <div class="invoice-header">
                <div>
                    <div class="invoice-brand">{{ config('امیر آفاق', 'امیر آفاق') }}</div>
                    <div class="text-muted small mt-1">فاکتور رسمی فروش</div>
                </div>
                <div class="invoice-meta">
                    <div>شماره فاکتور: <strong>{{ $order->order_number }}</strong></div>
                    <div>کد رهگیری: <strong>{{ $order->tracking_code }}</strong></div>
                    <div>تاریخ صدور: <strong>{{ verta($order->created_at)->format('Y/m/d H:i') }}</strong></div>
                </div>
            </div>

            <div class="invoice-title">فاکتور فروش</div>

            {{-- اطلاعات خریدار و ارسال --}}
            <div class="row g-4 invoice-section">
                <div class="col-md-6">
                    <div class="invoice-section-title">اطلاعات خریدار</div>
                    <div class="invoice-grid">
                        <div>
                            <div class="label">نام</div>
                            <div class="value">{{ $order->customer_name }}</div>
                        </div>
                        <div>
                            <div class="label">تلفن</div>
                            <div class="value" dir="ltr">{{ $order->customer_phone }}</div>
                        </div>
                        @if($order->customer_email)
                            <div>
                                <div class="label">ایمیل</div>
                                <div class="value" dir="ltr">{{ $order->customer_email }}</div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="invoice-section-title">اطلاعات ارسال</div>
                    <div class="invoice-grid">
                        <div>
                            <div class="label">استان / شهر</div>
                            <div class="value">{{ $order->province }} / {{ $order->city }}</div>
                        </div>
                        @if($order->postal_code)
                            <div>
                                <div class="label">کد پستی</div>
                                <div class="value" dir="ltr">{{ $order->postal_code }}</div>
                            </div>
                        @endif
                        <div class="grid-full" style="grid-column: 1 / -1;">
                            <div class="label">آدرس</div>
                            <div class="value">{{ $order->shipping_address }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- جدول اقلام --}}
            <div class="invoice-section">
                <div class="invoice-section-title">اقلام سفارش</div>
                <div class="table-responsive">
                    <table class="invoice-table">
                        <thead>
                        <tr>
                            <th style="width: 40px;">#</th>
                            <th>محصول</th>
                            <th style="width: 90px;">تعداد</th>
                            <th style="width: 130px;">قیمت واحد</th>
                            <th style="width: 130px;">جمع</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($order->items as $i => $item)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>
                                    <div class="product-cell">
                                        @if($item->product_image)
                                            <img src="{{ asset('storage/' . $item->product_image) }}"
                                                 alt="{{ $item->product_name }}"
                                                 class="product-thumb">
                                        @else
                                            <div class="product-thumb d-flex align-items-center justify-content-center text-muted">
                                                <small>—</small>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="product-name">{{ $item->product_name }}</div>
                                            @if($item->product_sku)
                                                <div class="product-sku">کد: {{ $item->product_sku }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>{{ number_format($item->quantity) }}</td>
                                <td>{{ number_format($item->unit_price) }} تومان</td>
                                <td><strong>{{ number_format($item->total_price) }} تومان</strong></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- خلاصه مبالغ --}}
            <div class="invoice-summary">
                <div class="summary-box">
                    <div class="summary-row">
                        <span>جمع اقلام</span>
                        <span>{{ number_format($order->subtotal) }} تومان</span>
                    </div>
                    <div class="summary-row">
                        <span>هزینه ارسال</span>
                        <span>{{ number_format($order->shipping_cost) }} تومان</span>
                    </div>
                    @if($order->discount > 0)
                        <div class="summary-row discount">
                            <span>تخفیف</span>
                            <span>− {{ number_format($order->discount) }} تومان</span>
                        </div>
                    @endif
                    <div class="summary-row total">
                        <span>مبلغ قابل پرداخت</span>
                        <span>{{ number_format($order->total_amount) }} تومان</span>
                    </div>
                </div>
            </div>

            {{-- وضعیت پرداخت --}}
            <div class="invoice-section mt-4">
                <div class="invoice-section-title">وضعیت پرداخت</div>
                <div class="d-flex flex-wrap gap-4 align-items-center" style="font-size: .9rem;">
                    <div>
                        <span class="text-muted">روش پرداخت:</span>
                        <strong>
                            @switch($order->payment_method)
                                @case('online') پرداخت آنلاین @break
                                @case('cod') پرداخت در محل @break
                                @case('wallet') کیف پول @break
                                @default {{ $order->payment_method }}
                            @endswitch
                        </strong>
                    </div>
                    <div>
                        <span class="text-muted">وضعیت سفارش:</span>
                        @php
                            $statusMap = [
                                'pending'    => ['label' => 'در انتظار پرداخت', 'class' => 'status-pending'],
                                'paid'       => ['label' => 'پرداخت شده',       'class' => 'status-paid'],
                                'processing' => ['label' => 'در حال پردازش',    'class' => 'status-pending'],
                                'shipped'    => ['label' => 'ارسال شده',        'class' => 'status-paid'],
                                'delivered'  => ['label' => 'تحویل شده',        'class' => 'status-paid'],
                                'cancelled'  => ['label' => 'لغو شده',          'class' => 'status-canceled'],
                                'refunded'   => ['label' => 'بازگشت داده شده',  'class' => 'status-failed'],
                            ];
                            $st = $statusMap[$order->status] ?? ['label' => $order->status, 'class' => 'status-pending'];
                        @endphp
                        <span class="status-badge {{ $st['class'] }}">{{ $st['label'] }}</span>
                    </div>
                    @if($order->successfulPayment)
                        <div>
                            <span class="text-muted">کد تراکنش:</span>
                            <strong dir="ltr">{{ $order->successfulPayment->transaction_id }}</strong>
                        </div>
                    @endif
                    @if($order->paid_at)
                        <div>
                            <span class="text-muted">تاریخ پرداخت:</span>
                            <strong>{{ \Morilog\Jalali\Jalalian::fromCarbon($order->paid_at)->format('Y/m/d H:i') }}</strong>
                        </div>
                    @endif
                </div>
            </div>

            {{-- پانویس --}}
            <div class="text-center text-muted small mt-5 pt-3" style="border-top: 1px dashed #e5e7eb;">
                این فاکتور به‌صورت سیستمی صادر شده و بدون مهر و امضا نیز معتبر است.
            </div>
        </div>

        {{-- دکمه‌ها --}}
        <div class="invoice-actions no-print">
            <button onclick="window.print()" class="btn btn-primary">
                🖨️ چاپ فاکتور
            </button>
{{--            <a href="{{ route('checkout.invoice.download', ['locale' => $locale, 'order' => $order->id]) }}"--}}
{{--               class="btn btn-outline-primary">--}}
{{--                ⬇️ دانلود PDF--}}
{{--            </a>--}}
            <a href="{{ route('products.index', ['locale' => $locale]) }}" class="btn btn-outline-secondary">
                بازگشت به فروشگاه
            </a>
        </div>
    </div>
@endsection

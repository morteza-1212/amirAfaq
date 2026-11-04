<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>فاکتور {{ $order->order_number ?? $order->id }}</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            direction: rtl;
            font-size: 12px;
            color: #111827;
            margin: 0;
            padding: 20px;
        }
        .header {
            display: table;
            width: 100%;
            border-bottom: 2px solid #0d6efd;
            padding-bottom: 12px;
            margin-bottom: 16px;
        }
        .header-right, .header-left {
            display: table-cell;
            vertical-align: top;
        }
        .header-left { text-align: left; }
        .brand {
            font-size: 20px;
            font-weight: bold;
            color: #0d6efd;
        }
        .brand-sub { color: #6b7280; font-size: 11px; margin-top: 2px; }
        .meta { line-height: 1.9; font-size: 11px; color: #4b5563; }
        .meta strong { color: #111827; }

        .title {
            text-align: center;
            font-weight: bold;
            font-size: 16px;
            margin: 16px 0;
            color: #374151;
        }

        .section-title {
            font-size: 12px;
            font-weight: bold;
            color: #0d6efd;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 4px;
            margin: 14px 0 8px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }
        .info-table td {
            padding: 4px 6px;
            vertical-align: top;
        }
        .info-table .label { color: #6b7280; width: 90px; }
        .info-table .value { color: #111827; font-weight: 600; }

        .items {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            margin-top: 4px;
        }
        .items thead th {
            background: #f3f4f6;
            color: #374151;
            padding: 7px 6px;
            text-align: right;
            border-bottom: 2px solid #d1d5db;
            font-weight: bold;
        }
        .items tbody td {
            padding: 7px 6px;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: middle;
        }
        .items tbody tr:last-child td { border-bottom: none; }

        .summary {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            margin-top: 10px;
        }
        .summary td { padding: 5px 6px; }
        .summary .sum-label { color: #4b5563; }
        .summary .sum-value { text-align: left; font-weight: 600; }
        .summary .total-row td {
            border-top: 2px solid #111827;
            padding-top: 8px;
            font-size: 13px;
            font-weight: bold;
            color: #111827;
        }

        .status {
            display: inline-block;
            padding: 2px 10px;
            border-radius: 10px;
            font-size: 10px;
            font-weight: bold;
            background: #f3f4f6;
            color: #374151;
        }

        .footer {
            text-align: center;
            color: #6b7280;
            font-size: 10px;
            margin-top: 24px;
            padding-top: 10px;
            border-top: 1px dashed #d1d5db;
        }
    </style>
</head>
<body>

{{-- هدر --}}
<div class="header">
    <div class="header-right">
        <div class="brand">{{ config('app.name', 'فروشگاه') }}</div>
        <div class="brand-sub">فاکتور رسمی فروش</div>
    </div>
    <div class="header-left">
        <div class="meta">
            <div>شماره فاکتور: <strong>{{ $order->order_number ?? $order->id }}</strong></div>
            <div>کد رهگیری: <strong>{{ $order->tracking_code }}</strong></div>
            <div>
                تاریخ صدور:
                <strong>
                    @if($order->created_at)
                        {{ \Morilog\Jalali\Jalalian::fromCarbon($order->created_at)->format('Y/m/d H:i') }}
                    @else
                        -
                    @endif
                </strong>
            </div>
        </div>
    </div>
</div>

<div class="title">فاکتور فروش</div>

{{-- اطلاعات خریدار --}}
<div class="section-title">اطلاعات خریدار</div>
<table class="info-table">
    <tr>
        <td class="label">نام:</td>
        <td class="value">{{ $order->customer_name }}</td>
        <td class="label">تلفن:</td>
        <td class="value" dir="ltr">{{ $order->customer_phone }}</td>
    </tr>
    @if($order->customer_email)
        <tr>
            <td class="label">ایمیل:</td>
            <td class="value" dir="ltr" colspan="3">{{ $order->customer_email }}</td>
        </tr>
    @endif
</table>

{{-- اطلاعات ارسال --}}
<div class="section-title">اطلاعات ارسال</div>
<table class="info-table">
    <tr>
        <td class="label">استان/شهر:</td>
        <td class="value">{{ $order->province }} / {{ $order->city }}</td>
        <td class="label">کد پستی:</td>
        <td class="value" dir="ltr">{{ $order->postal_code ?? '-' }}</td>
    </tr>
    <tr>
        <td class="label">آدرس:</td>
        <td class="value" colspan="3">{{ $order->shipping_address }}</td>
    </tr>
</table>

{{-- اقلام سفارش --}}
<div class="section-title">اقلام سفارش</div>
<table class="items">
    <thead>
    <tr>
        <th style="width: 30px;">#</th>
        <th>محصول</th>
        <th style="width: 60px;">تعداد</th>
        <th style="width: 100px;">قیمت واحد</th>
        <th style="width: 100px;">جمع</th>
    </tr>
    </thead>
    <tbody>
    @foreach($order->items as $i => $item)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>
                {{ $item->product_name }}
                @if($item->product_sku)
                    <span style="color:#9ca3af; font-size:10px;">({{ $item->product_sku }})</span>
                @endif
            </td>
            <td>{{ number_format($item->quantity) }}</td>
            <td>{{ number_format($item->unit_price) }}</td>
            <td><strong>{{ number_format($item->total_price) }}</strong></td>
        </tr>
    @endforeach
    </tbody>
</table>

{{-- خلاصه مبالغ --}}
<table class="summary">
    <tr>
        <td class="sum-label">جمع اقلام:</td>
        <td class="sum-value">{{ number_format($order->subtotal) }} تومان</td>
    </tr>
    <tr>
        <td class="sum-label">هزینه ارسال:</td>
        <td class="sum-value">{{ number_format($order->shipping_cost) }} تومان</td>
    </tr>
    @if($order->discount > 0)
        <tr>
            <td class="sum-label">تخفیف:</td>
            <td class="sum-value" style="color:#dc2626;">− {{ number_format($order->discount) }} تومان</td>
        </tr>
    @endif
    <tr class="total-row">
        <td>مبلغ قابل پرداخت:</td>
        <td class="sum-value">{{ number_format($order->total_amount) }} تومان</td>
    </tr>
</table>

{{-- وضعیت پرداخت --}}
<div class="section-title">وضعیت پرداخت</div>
<table class="info-table">
    <tr>
        <td class="label">روش پرداخت:</td>
        <td class="value">
            @switch($order->payment_method)
                @case('online') پرداخت آنلاین @break
                @case('cod') پرداخت در محل @break
                @case('wallet') کیف پول @break
                @default {{ $order->payment_method }}
            @endswitch
        </td>
        <td class="label">وضعیت:</td>
        <td class="value">
            @switch($order->status)
                @case('pending') در انتظار پرداخت @break
                @case('paid') پرداخت شده @break
                @case('processing') در حال پردازش @break
                @case('shipped') ارسال شده @break
                @case('delivered') تحویل شده @break
                @case('cancelled') لغو شده @break
                @case('refunded') بازگشت داده شده @break
                @default {{ $order->status }}
            @endswitch
        </td>
    </tr>
    @if($order->successfulPayment)
        <tr>
            <td class="label">کد تراکنش:</td>
            <td class="value" dir="ltr" colspan="3">{{ $order->successfulPayment->transaction_id }}</td>
        </tr>
    @endif
    @if($order->paid_at)
        <tr>
            <td class="label">تاریخ پرداخت:</td>
            <td class="value" colspan="3">
                {{ \Morilog\Jalali\Jalalian::fromCarbon($order->paid_at)->format('Y/m/d H:i') }}
            </td>
        </tr>
    @endif
</table>

<div class="footer">
    این فاکتور به‌صورت سیستمی صادر شده و بدون مهر و امضا نیز معتبر است.
</div>

</body>
</html>

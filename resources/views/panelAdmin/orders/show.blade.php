@extends('panelAdmin.layouts.panel')

@section('title', 'سفارش ' . $order->order_number)
@section('page-title', 'جزئیات سفارش')

@section('content')
    <div class="row g-3">
        <div class="col-lg-8">

            {{-- اطلاعات مشتری --}}
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-white"><strong>اطلاعات مشتری</strong></div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6"><strong>نام:</strong> {{ $order->customer_name }}</div>
                        <div class="col-md-6"><strong>موبایل:</strong> {{ $order->customer_phone }}</div>
                        <div class="col-md-6"><strong>ایمیل:</strong> {{ $order->customer_email ?? '—' }}</div>
                        <div class="col-md-6"><strong>کاربر:</strong> {{ $order->user?->full_name ?? 'مهمان' }}</div>
                        <div class="col-12"><strong>آدرس:</strong> {{ $order->shipping_address }}</div>
                        <div class="col-md-4"><strong>استان:</strong> {{ $order->province }}</div>
                        <div class="col-md-4"><strong>شهر:</strong> {{ $order->city }}</div>
                        <div class="col-md-4"><strong>کد پستی:</strong> {{ $order->postal_code ?? '—' }}</div>
                    </div>
                </div>
            </div>

            {{-- آیتم‌ها --}}
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-white"><strong>آیتم‌های سفارش</strong></div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                        <tr>
                            <th>محصول</th>
                            <th>SKU</th>
                            <th>قیمت واحد</th>
                            <th>تعداد</th>
                            <th>تخفیف</th>
                            <th>جمع</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>{{ $item->product_name }}</td>
                                <td>{{ $item->product_sku ?? '—' }}</td>
                                <td>{{ number_format($item->unit_price) }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->discount) }}</td>
                                <td>{{ number_format($item->total_price) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between"><span>جمع کل:</span><strong>{{ number_format($order->subtotal) }} ت</strong></div>
                    <div class="d-flex justify-content-between"><span>هزینه ارسال:</span><span>{{ number_format($order->shipping_cost) }} ت</span></div>
                    <div class="d-flex justify-content-between"><span>تخفیف:</span><span>{{ number_format($order->discount) }} ت</span></div>
                    <hr>
                    <div class="d-flex justify-content-between fs-5"><span>مبلغ نهایی:</span><strong class="text-primary">{{ number_format($order->total_amount) }} ت</strong></div>
                </div>
            </div>

            {{-- پرداخت‌ها --}}
            <div class="card shadow-sm">
                <div class="card-header bg-white"><strong>پرداخت‌ها</strong></div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                        <tr><th>شماره</th><th>مبلغ</th><th>وضعیت</th><th>تاریخ</th><th></th></tr>
                        </thead>
                        <tbody>
                        @forelse($order->payments as $p)
                            <tr>
                                <td><a href="{{ route('admin.payments.show', $p) }}">{{ $p->payment_number }}</a></td>
                                <td>{{ number_format($p->amount) }}</td>
                                <td><span class="badge bg-secondary">{{ $p->status }}</span></td>
                                <td class="small">{{ $p->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <a href="{{ route('admin.payments.show', $p) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted">پرداختی ثبت نشده است.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- ستون کناری --}}
        <div class="col-lg-4">
            {{-- تغییر وضعیت --}}
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-white"><strong>وضعیت سفارش</strong></div>
                <div class="card-body">
                    <p class="mb-2">وضعیت فعلی:
                        <span class="badge bg-primary">{{ $order->status }}</span>
                    </p>
                    <form method="POST" action="{{ route('admin.orders.status', $order) }}">
                        @csrf @method('PATCH')
                        <select name="status" class="form-select form-select-sm mb-2">
                            @foreach(['pending','paid','processing','shipped','delivered','cancelled','refunded'] as $s)
                                <option value="{{ $s }}" @selected($order->status === $s)>{{ $s }}</option>
                            @endforeach
                        </select>
                        <input type="text" name="note" class="form-control form-control-sm mb-2" placeholder="یادداشت (اختیاری)">
                        <button class="btn btn-primary btn-sm w-100">ذخیره وضعیت</button>
                    </form>
                </div>
            </div>

            {{-- خلاصه --}}
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-white"><strong>خلاصه</strong></div>
                <div class="card-body small">
                    <p class="mb-1"><strong>شماره سفارش:</strong> {{ $order->order_number }}</p>
                    <p class="mb-1"><strong>کد رهگیری:</strong> {{ $order->tracking_code }}</p>
                    <p class="mb-1"><strong>روش پرداخت:</strong> {{ $order->payment_method }}</p>
                    <p class="mb-1"><strong>تاریخ ثبت:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
                    <p class="mb-1"><strong>آخرین ویرایش:</strong> {{ $order->updated_at->format('Y-m-d H:i') }}</p>
                    @if($order->updatedBy)
                        <p class="mb-1"><strong>ویرایشگر:</strong> {{ $order->updatedBy->full_name ?? $order->updatedBy->name }}</p>
                    @endif
                </div>
            </div>

            {{-- تاریخچه وضعیت --}}
            @if($order->status_history && count($order->status_history))
                <div class="card shadow-sm mb-3">
                    <div class="card-header bg-white"><strong>تاریخچه وضعیت</strong></div>
                    <ul class="list-group list-group-flush small">
                        @foreach(array_reverse($order->status_history) as $h)
                            <li class="list-group-item">
                                <div><strong>{{ $h['from'] ?? '—' }} → {{ $h['to'] }}</strong></div>
                                <div class="text-muted">{{ $h['at'] ?? '' }}</div>
                                @if(!empty($h['note']))<div>{{ $h['note'] }}</div>@endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- یادداشت ادمین --}}
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-white"><strong>یادداشت ادمین</strong></div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.orders.update', $order) }}">
                        @csrf @method('PATCH')
                        <input type="hidden" name="customer_name" value="{{ $order->customer_name }}">
                        <input type="hidden" name="customer_phone" value="{{ $order->customer_phone }}">
                        <input type="hidden" name="customer_email" value="{{ $order->customer_email }}">
                        <input type="hidden" name="shipping_address" value="{{ $order->shipping_address }}">
                        <input type="hidden" name="postal_code" value="{{ $order->postal_code }}">
                        <input type="hidden" name="city" value="{{ $order->city }}">
                        <input type="hidden" name="province" value="{{ $order->province }}">
                        <textarea name="admin_note" rows="3" class="form-control form-control-sm mb-2"
                                  placeholder="یادداشت داخلی">{{ $order->admin_note }}</textarea>
                        <button class="btn btn-primary btn-sm w-100">ذخیره</button>
                    </form>
                </div>
            </div>

            {{-- حذف --}}
            @can('delete', $order)
                <form method="POST" action="{{ route('admin.orders.destroy', $order) }}"
                      onsubmit="return confirm('آیا مطمئن هستید؟')">
                    @csrf @method('DELETE')
                    <button class="btn btn-outline-danger btn-sm w-100">حذف سفارش</button>
                </form>
            @endcan
        </div>
    </div>
@endsection

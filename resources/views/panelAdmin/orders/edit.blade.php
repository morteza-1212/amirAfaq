@extends('panelAdmin.layouts.panel')

@section('title', 'ویرایش سفارش ' . $order->order_number)
@section('page-title', 'ویرایش سفارش')

@section('content')
    <form method="POST" action="{{ route('admin.orders.update', $order) }}">
        @csrf @method('PATCH')

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">نام مشتری *</label>
                        <input type="text" name="customer_name" class="form-control" value="{{ old('customer_name', $order->customer_name) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">موبایل *</label>
                        <input type="text" name="customer_phone" class="form-control" value="{{ old('customer_phone', $order->customer_phone) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">ایمیل</label>
                        <input type="email" name="customer_email" class="form-control" value="{{ old('customer_email', $order->customer_email) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">کد پستی</label>
                        <input type="text" name="postal_code" class="form-control" value="{{ old('postal_code', $order->postal_code) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">استان *</label>
                        <input type="text" name="province" class="form-control" value="{{ old('province', $order->province) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">شهر *</label>
                        <input type="text" name="city" class="form-control" value="{{ old('city', $order->city) }}" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">آدرس *</label>
                        <textarea name="shipping_address" class="form-control" rows="2" required>{{ old('shipping_address', $order->shipping_address) }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">روش ارسال</label>
                        <input type="text" name="shipping_method" class="form-control" value="{{ old('shipping_method', $order->shipping_method) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">کد رهگیری پست</label>
                        <input type="text" name="shipping_tracking_code" class="form-control" value="{{ old('shipping_tracking_code', $order->shipping_tracking_code) }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label">یادداشت ادمین</label>
                        <textarea name="admin_note" class="form-control" rows="3">{{ old('admin_note', $order->admin_note) }}</textarea>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white d-flex justify-content-between">
                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-secondary">انصراف</a>
                <button class="btn btn-primary">ذخیره تغییرات</button>
            </div>
        </div>
    </form>
@endsection

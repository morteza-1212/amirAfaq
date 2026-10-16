@extends('panelAdmin.layouts.panel')

@section('title', 'ویرایش درخواست خریدار')

@section('content')
    <div class="container-fluid">

        {{-- هدر --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">
                    <i class="fas fa-edit me-2"></i>
                    ویرایش درخواست خریدار
                </h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.buyer.index') }}">درخواست‌ها</a>
                        </li>
                        <li class="breadcrumb-item active">ویرایش</li>
                    </ol>
                </nav>
            </div>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                <h6 class="alert-heading">
                    <i class="fas fa-exclamation-triangle me-1"></i>
                    خطاهای زیر را برطرف کنید:
                </h6>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.buyer.update', $buyer) }}"
              method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3">

                {{-- اطلاعات محصول --}}
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-box me-1"></i>
                                اطلاعات محصول
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">
                                    محصول <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       name="product"
                                       class="form-control @error('product') is-invalid @enderror"
                                       value="{{ old('product', $buyer->product) }}"
                                       required>
                                @error('product')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    مقدار <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       name="quantity"
                                       class="form-control @error('quantity') is-invalid @enderror"
                                       value="{{ old('quantity', $buyer->quantity) }}"
                                       required>
                                @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">بسته‌بندی</label>
                                <input type="text"
                                       name="packaging"
                                       class="form-control"
                                       value="{{ old('packaging', $buyer->packaging) }}">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- مقصد --}}
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-location-dot me-1"></i>
                                مقصد
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">
                                    کشور مقصد <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       name="destination_country"
                                       class="form-control @error('destination_country') is-invalid @enderror"
                                       value="{{ old('destination_country', $buyer->destination_country) }}"
                                       required>
                                @error('destination_country')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">بندر مقصد</label>
                                <input type="text"
                                       name="destination_port"
                                       class="form-control"
                                       value="{{ old('destination_port', $buyer->destination_port) }}">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- شرایط --}}
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-file-contract me-1"></i>
                                شرایط
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">زمان تحویل</label>
                                <input type="text"
                                       name="delivery_time"
                                       class="form-control"
                                       value="{{ old('delivery_time', $buyer->delivery_time) }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">شرایط تحویل (Incoterms)</label>
                                <input type="text"
                                       name="incoterms"
                                       class="form-control"
                                       placeholder="FOB, CIF, EXW ..."
                                       value="{{ old('incoterms', $buyer->incoterms) }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">شرایط پرداخت</label>
                                <input type="text"
                                       name="payment_terms"
                                       class="form-control"
                                       value="{{ old('payment_terms', $buyer->payment_terms) }}">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- وضعیت --}}
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-tag me-1"></i>
                                وضعیت
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">
                                    وضعیت درخواست <span class="text-danger">*</span>
                                </label>
                                <select name="status"
                                        class="form-select @error('status') is-invalid @enderror"
                                        required>
                                    @foreach(\App\Models\Buyer::STATUSES as $key => $labels)
                                        <option value="{{ $key }}"
                                            @selected(old('status', $buyer->status) === $key)>
                                            {{ $labels[app()->getLocale()] ?? $labels['fa'] }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- اطلاعات شرکت --}}
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-building me-1"></i>
                                اطلاعات شرکت
                            </h5>
                        </div>
                        <div class="card-body">
                            <textarea name="company_information"
                                      class="form-control @error('company_information') is-invalid @enderror"
                                      rows="4"
                                      required>{{ old('company_information', $buyer->company_information) }}</textarea>
                            @error('company_information')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- اطلاعات تماس --}}
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-user me-1"></i>
                                اطلاعات تماس
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">نام</label>
                                <input type="text"
                                       name="name"
                                       class="form-control"
                                       value="{{ old('name', $buyer->name) }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">ایمیل</label>
                                <input type="email"
                                       name="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email', $buyer->email) }}">
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">تلفن</label>
                                <input type="text"
                                       name="phone"
                                       class="form-control"
                                       value="{{ old('phone', $buyer->phone) }}">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- پیام --}}
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-comment me-1"></i>
                                پیام
                            </h5>
                        </div>
                        <div class="card-body">
                            <textarea name="message"
                                      class="form-control"
                                      rows="7">{{ old('message', $buyer->message) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- دکمه‌ها --}}
            <div class="card mt-3">
                <div class="card-body d-flex justify-content-between">
                    <a href="{{ route('admin.buyer.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-right me-1"></i>
                        بازگشت
                    </a>

                    <div class="d-flex gap-2">
                        <button type="button"
                                class="btn btn-outline-danger"
                                onclick="if(confirm('حذف شود؟')) document.getElementById('delete-form').submit();">
                            <i class="fas fa-trash me-1"></i>
                            حذف
                        </button>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>
                            به‌روزرسانی
                        </button>
                    </div>
                </div>
            </div>
        </form>

        {{-- فرم مخفی حذف --}}
        <form id="delete-form"
              action="{{ route('admin.buyer.delete', $buyer) }}"
              method="POST"
              class="d-none">
            @csrf
            @method('DELETE')
        </form>
    </div>
@endsection

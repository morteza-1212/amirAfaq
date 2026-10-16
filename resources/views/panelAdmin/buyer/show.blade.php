@extends('panelAdmin.layouts.panel')

@section('title', 'مشاهده درخواست خریدار')

@section('content')
    <div class="container-fluid">

        {{-- هدر --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">
                    <i class="fas fa-eye me-2"></i>
                    مشاهده درخواست خریدار
                </h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.buyer.index') }}">درخواست‌ها</a>
                        </li>
                        <li class="breadcrumb-item active">مشاهده</li>
                    </ol>
                </nav>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('admin.buyer.edit', $buyer) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-1"></i>
                    ویرایش
                </a>
                <a href="{{ route('admin.buyer.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-right me-1"></i>
                    بازگشت
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-1"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

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
                        <table class="table table-sm mb-0">
                            <tr>
                                <th width="40%">محصول:</th>
                                <td>{{ $buyer->product }}</td>
                            </tr>
                            <tr>
                                <th>مقدار:</th>
                                <td>{{ $buyer->quantity }}</td>
                            </tr>
                            <tr>
                                <th>بسته‌بندی:</th>
                                <td>{{ $buyer->packaging ?? '—' }}</td>
                            </tr>
                        </table>
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
                        <table class="table table-sm mb-0">
                            <tr>
                                <th width="40%">کشور مقصد:</th>
                                <td>{{ $buyer->destination_country }}</td>
                            </tr>
                            <tr>
                                <th>بندر مقصد:</th>
                                <td>{{ $buyer->destination_port ?? '—' }}</td>
                            </tr>
                        </table>
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
                        <table class="table table-sm mb-0">
                            <tr>
                                <th width="40%">زمان تحویل:</th>
                                <td>{{ $buyer->delivery_time ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th>شرایط تحویل (Incoterms):</th>
                                <td>{{ $buyer->incoterms ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th>شرایط پرداخت:</th>
                                <td>{{ $buyer->payment_terms ?? '—' }}</td>
                            </tr>
                        </table>
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
                        <form action="{{ route('admin.buyer.status', $buyer) }}"
                              method="POST"
                              class="d-flex gap-2">
                            @csrf
                            @method('PATCH')

                            <select name="status" class="form-select">
                                @foreach(\App\Models\Buyer::STATUSES as $key => $labels)
                                    <option value="{{ $key }}" @selected($buyer->status === $key)>
                                        {{ $labels[app()->getLocale()] ?? $labels['fa'] }}
                                    </option>
                                @endforeach
                            </select>

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>
                                ذخیره
                            </button>
                        </form>

                        <div class="mt-3">
                            <span class="badge bg-{{ $buyer->status_color }} fs-6">
                                {{ $buyer->status_label }}
                            </span>
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
                        <p class="mb-0" style="white-space: pre-wrap;">{{ $buyer->company_information }}</p>
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
                        <table class="table table-sm mb-0">
                            <tr>
                                <th width="40%">نام:</th>
                                <td>{{ $buyer->name ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th>ایمیل:</th>
                                <td>
                                    @if($buyer->email)
                                        <a href="mailto:{{ $buyer->email }}">{{ $buyer->email }}</a>
                                    @else
                                        —
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>تلفن:</th>
                                <td>
                                    @if($buyer->phone)
                                        <a href="tel:{{ $buyer->phone }}">{{ $buyer->phone }}</a>
                                    @else
                                        —
                                    @endif
                                </td>
                            </tr>
                        </table>
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
                        @if($buyer->message)
                            <p class="mb-0" style="white-space: pre-wrap;">{{ $buyer->message }}</p>
                        @else
                            <p class="text-muted mb-0">پیامی ثبت نشده است.</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- زمان --}}
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-muted small">
                        <i class="fas fa-calendar-plus me-1"></i>
                        تاریخ ثبت: {{ $buyer->created_at->format('Y/m/d H:i') }}
                        &nbsp;|&nbsp;
                        <i class="fas fa-calendar-check me-1"></i>
                        آخرین ویرایش: {{ $buyer->updated_at->format('Y/m/d H:i') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('panelAdmin.layouts.panel')

@section('title', 'مشاهده درخواست تماس')

@section('content')
    <div class="container-fluid">

        {{-- هدر --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">
                    <i class="fas fa-envelope-open-text me-2"></i>
                    مشاهده درخواست تماس
                </h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.contact.index') }}">درخواست‌ها</a>
                        </li>
                        <li class="breadcrumb-item active">مشاهده</li>
                    </ol>
                </nav>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('admin.contact.edit', $contact) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-1"></i>
                    ویرایش
                </a>
                <a href="{{ route('admin.contact.index') }}" class="btn btn-secondary">
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

            {{-- اطلاعات فرستنده --}}
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-user me-1"></i>
                            اطلاعات فرستنده
                        </h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm mb-0">
                            <tr>
                                <th width="35%">نام و نام خانوادگی:</th>
                                <td>{{ $contact->name }}</td>
                            </tr>
                            <tr>
                                <th>ایمیل:</th>
                                <td>
                                    <a href="mailto:{{ $contact->email }}"
                                       style="direction: ltr; display: inline-block;">
                                        {{ $contact->email }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th>تلفن تماس:</th>
                                <td>
                                    <a href="tel:{{ $contact->phone }}"
                                       style="direction: ltr; display: inline-block;">
                                        {{ $contact->phone }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th>تاریخ ارسال:</th>
                                <td>{{ $contact->created_at->format('Y/m/d H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            {{-- یادداشت ادمین --}}
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-sticky-note me-1"></i>
                            یادداشت ادمین
                        </h5>
                        <a href="{{ route('admin.contact.edit', $contact) }}"
                           class="btn btn-sm btn-outline-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                    </div>
                    <div class="card-body">
                        @if($contact->admin_note)
                            <div class="alert alert-secondary mb-0"
                                 style="white-space: pre-wrap;">{{ $contact->admin_note }}</div>
                        @else
                            <p class="text-muted mb-0">
                                <i class="fas fa-info-circle me-1"></i>
                                هنوز یادداشتی ثبت نشده است.
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- موضوع و متن پیام --}}
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-comment me-1"></i>
                            موضوع و متن پیام
                        </h5>
                    </div>
                    <div class="card-body">
                        <h5 class="text-primary mb-3">{{ $contact->title }}</h5>
                        <p class="mb-0" style="white-space: pre-wrap;">{{ $contact->description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

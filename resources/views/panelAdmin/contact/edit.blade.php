@extends('panelAdmin.layouts.panel')

@section('title', 'ویرایش درخواست تماس')

@section('content')
    <div class="container-fluid">

        {{-- هدر --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">
                    <i class="fas fa-edit me-2"></i>
                    ویرایش درخواست تماس
                </h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.contact.index') }}">درخواست‌ها</a>
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

        <form action="{{ route('admin.contact.update', $contact) }}"
              method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3">

                {{-- اطلاعات فرستنده (فقط خواندنی) --}}
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
                                    <th width="35%">نام:</th>
                                    <td>{{ $contact->name }}</td>
                                </tr>
                                <tr>
                                    <th>ایمیل:</th>
                                    <td style="direction: ltr; text-align: right;">
                                        {{ $contact->email }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>تلفن:</th>
                                    <td style="direction: ltr; text-align: right;">
                                        {{ $contact->phone }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>موضوع:</th>
                                    <td>{{ $contact->title }}</td>
                                </tr>
                                <tr>
                                    <th>تاریخ:</th>
                                    <td>{{ $contact->created_at->format('Y/m/d H:i') }}</td>
                                </tr>
                            </table>

                            <small class="text-muted d-block mt-3">
                                <i class="fas fa-info-circle me-1"></i>
                                اطلاعات فرستنده قابل ویرایش نیست.
                            </small>
                        </div>
                    </div>
                </div>

                {{-- یادداشت ادمین --}}
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-sticky-note me-1"></i>
                                یادداشت ادمین
                            </h5>
                        </div>
                        <div class="card-body">
                            <label class="form-label">یادداشت داخلی</label>
                            <textarea name="admin_note"
                                      class="form-control @error('admin_note') is-invalid @enderror"
                                      rows="10"
                                      placeholder="یادداشت داخلی برای پیگیری این درخواست...">{{ old('admin_note', $contact->admin_note) }}</textarea>
                            @error('admin_note')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted d-block mt-2">
                                <i class="fas fa-lock me-1"></i>
                                این یادداشت فقط در پنل ادمین نمایش داده می‌شود.
                            </small>
                        </div>
                    </div>
                </div>

                {{-- متن پیام --}}
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-comment me-1"></i>
                                متن پیام فرستنده
                            </h5>
                        </div>
                        <div class="card-body">
                            <h6 class="text-primary mb-3">{{ $contact->title }}</h6>
                            <p class="mb-0" style="white-space: pre-wrap;">{{ $contact->description }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- دکمه‌ها --}}
            <div class="card mt-3">
                <div class="card-body d-flex justify-content-between">
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.contact.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-right me-1"></i>
                            بازگشت
                        </a>
                        <a href="{{ route('admin.contact.show', $contact) }}"
                           class="btn btn-outline-secondary">
                            <i class="fas fa-eye me-1"></i>
                            مشاهده
                        </a>
                    </div>

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
              action="{{ route('admin.contact.delete', $contact) }}"
              method="POST"
              class="d-none">
            @csrf
            @method('DELETE')
        </form>
    </div>
@endsection

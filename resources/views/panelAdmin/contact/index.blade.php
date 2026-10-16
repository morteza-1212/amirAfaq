@extends('panelAdmin.layouts.panel')

@section('title', 'مدیریت درخواست‌های تماس')

@section('content')
    <div class="container-fluid">

        {{-- هدر --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">
                    <i class="fas fa-envelope me-2"></i>
                    درخواست‌های تماس
                </h1>
                <p class="text-muted mb-0 mt-1">شرکت امیرآفاق گستر</p>
            </div>
        </div>

        {{-- پیام‌ها --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-1"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle me-1"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- کارت آماری --}}
        <div class="row g-3 mb-4">
            <div class="col-md-12">
                <div class="card border-start border-4 border-primary">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">کل درخواست‌ها</div>
                            <h3 class="mb-0 mt-1">{{ $stats['total'] }}</h3>
                        </div>
                        <i class="fas fa-envelope fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- فیلتر --}}
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.contact.index') }}" class="row g-3">
                    <div class="col-md-9">
                        <label class="form-label">جستجو</label>
                        <input type="text"
                               name="search"
                               class="form-control"
                               placeholder="نام، ایمیل، تلفن، موضوع..."
                               value="{{ request('search') }}">
                    </div>

                    <div class="col-md-3 d-flex align-items-end gap-2">
                        <button class="btn btn-primary w-100">
                            <i class="fas fa-search me-1"></i>
                            فیلتر
                        </button>
                        <a href="{{ route('admin.contact.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- جدول --}}
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                        <tr>
                            <th width="60">#</th>
                            <th width="150">نام</th>
                            <th width="200">ایمیل</th>
                            <th width="140">تلفن</th>
                            <th>موضوع</th>
                            <th width="130">تاریخ</th>
                            <th width="180">عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($contacts as $contact)
                            <tr>
                                <td>{{ $contacts->firstItem() + $loop->index }}</td>

                                <td>
                                    <strong>{{ $contact->name }}</strong>
                                </td>

                                <td style="direction: ltr; text-align: right;">
                                    <a href="mailto:{{ $contact->email }}">
                                        {{ $contact->email }}
                                    </a>
                                </td>

                                <td style="direction: ltr; text-align: right;">
                                    <a href="tel:{{ $contact->phone }}">
                                        {{ $contact->phone }}
                                    </a>
                                </td>

                                <td>
                                    {{ \Illuminate\Support\Str::limit($contact->title, 60) }}
                                </td>

                                <td>
                                    <small>
                                        {{ $contact->created_at->format('Y/m/d') }}
                                        <br>
                                        {{ $contact->created_at->format('H:i') }}
                                    </small>
                                </td>

                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.contact.show', $contact) }}"
                                           class="btn btn-info" title="مشاهده">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <a href="{{ route('admin.contact.edit', $contact) }}"
                                           class="btn btn-warning" title="ویرایش">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('admin.contact.delete', $contact) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('حذف شود؟');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger" title="حذف">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                    هیچ درخواستی یافت نشد.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($contacts->hasPages())
                <div class="card-footer">
                    {{ $contacts->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

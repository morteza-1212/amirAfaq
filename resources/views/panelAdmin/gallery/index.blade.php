@extends('panelAdmin.layouts.panel')

@section('title', 'مدیریت گالری تصاویر')

@section('content')
    <div class="container-fluid">
        {{-- هدر صفحه --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">
                    <i class="fas fa-images me-2"></i>
                    مدیریت گالری تصاویر
                </h1>
                <p class="text-muted mb-0">شرکت امیرآفاق گستر</p>
            </div>
            <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>
                افزودن گالری جدید
            </a>
        </div>

        {{-- پیام‌های وضعیت --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-1"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-1"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- کارت فیلتر --}}
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.gallery.index') }}" class="row g-3">
                    <div class="col-md-5">
                        <label class="form-label">جستجو</label>
                        <input type="text" name="search" class="form-control"
                               placeholder="عنوان یا توضیحات..."
                               value="{{ request('search') }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">نوع فعالیت</label>
                        <select name="activity_type" class="form-select">
                            <option value="">همه</option>
                            @foreach(\App\Models\Gallery::ACTIVITY_TYPES as $key => $data)
                                <option value="{{ $key }}"
                                    @selected(request('activity_type') === $key)>
                                    {{ $data['labels'][app()->getLocale()] ?? $data['labels']['fa'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search me-1"></i> فیلتر
                        </button>
                        <a href="{{ route('admin.gallery.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- جدول گالری‌ها --}}
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-light">
                        <tr>
                            <th width="60">#</th>
                            <th width="100">تصویر</th>
                            <th>عنوان</th>
                            <th width="150">نوع فعالیت</th>
                            <th width="100">ترتیب</th>
                            <th width="100">وضعیت</th>
                            <th width="150">تاریخ ایجاد</th>
                            <th width="220">عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($galleries as $gallery)
                            <tr>
                                <td>{{ $galleries->firstItem() + $loop->index }}</td>
                                <td>
                                    <img src="{{ $gallery->image_url }}"
                                         alt="{{ $gallery->alt_text }}"
                                         class="img-thumbnail"
                                         style="width: 70px; height: 70px; object-fit: cover;">
                                </td>
                                <td>
                                    <strong>{{ $gallery->title ?? '—' }}</strong>
                                    @if($gallery->description)
                                        <br>
                                        <small class="text-muted">
                                            {{ \Illuminate\Support\Str::limit($gallery->description, 60) }}
                                        </small>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-info">
                                        {{ $gallery->activity_type_label }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $gallery->sort_order }}</span>
                                </td>
                                <td>
                                    @if($gallery->is_active)
                                        <span class="badge bg-success">فعال</span>
                                    @else
                                        <span class="badge bg-danger">غیرفعال</span>
                                    @endif
                                </td>
                                <td>
                                    <small>{{ $gallery->created_at->format('Y/m/d H:i') }}</small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.gallery.translations.index', $gallery) }}"
                                           class="btn btn-info"
                                           title="مدیریت ترجمه‌ها">
                                            <i class="fas fa-language"></i>
                                            ({{ $gallery->translations->count() }})
                                        </a>

{{--                                        <a href="{{ route('panelAdmin.galleries.show', $gallery) }}"--}}
{{--                                           class="btn btn-secondary"--}}
{{--                                           title="مشاهده">--}}
{{--                                            <i class="fas fa-eye"></i>--}}
{{--                                        </a>--}}

                                        <a href="{{ route('admin.gallery.edit', $gallery) }}"
                                           class="btn btn-warning"
                                           title="ویرایش">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('admin.gallery.destroy', $gallery) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('آیا از حذف این گالری اطمینان دارید؟');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-danger"
                                                    title="حذف">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                    هیچ گالری‌ای یافت نشد.
                                    <br>
                                    <a href="{{ route('admin.gallery.create') }}"
                                       class="btn btn-sm btn-primary mt-3">
                                        افزودن اولین گالری
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($galleries->hasPages())
                <div class="card-footer">
                    {{ $galleries->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

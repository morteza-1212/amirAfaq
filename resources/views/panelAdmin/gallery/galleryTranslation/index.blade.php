@extends('panelAdmin.layouts.panel')

@section('title', 'مدیریت ترجمه‌های گالری')

@section('content')
    <div class="container-fluid">
        {{-- هدر صفحه --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">
                    <i class="fas fa-language me-2"></i>
                    مدیریت ترجمه‌های گالری
                </h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.gallery.index') }}">گالری‌ها</a>
                        </li>
{{--                        <li class="breadcrumb-item">--}}
{{--                            <a href="{{ route('panelAdmin.galleries.show', $gallery) }}">--}}
{{--                                {{ $gallery->title ?? 'گالری #' . $gallery->id }}--}}
{{--                            </a>--}}
{{--                        </li>--}}
                        <li class="breadcrumb-item active">ترجمه‌ها</li>
                    </ol>
                </nav>
            </div>

            <a href="{{ route('admin.gallery.translations.create', $gallery) }}"
               class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>
                افزودن ترجمه جدید
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

        {{-- اطلاعات گالری --}}
        <div class="card mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-2 text-center">
                        <img src="{{ $gallery->image_url }}"
                             alt="{{ $gallery->alt_text }}"
                             class="img-thumbnail"
                             style="max-height: 100px;">
                    </div>
                    <div class="col-md-10">
                        <h5 class="mb-2">
                            {{ $gallery->title ?? 'گالری #' . $gallery->id }}
                        </h5>
                        <div class="d-flex gap-3 flex-wrap">
                        <span class="badge bg-info">
                            <i class="fas fa-tag me-1"></i>
                            {{ $gallery->activity_type_label }}
                        </span>
                            <span class="badge bg-secondary">
                            <i class="fas fa-sort me-1"></i>
                            ترتیب: {{ $gallery->sort_order }}
                        </span>
                            @if($gallery->is_active)
                                <span class="badge bg-success">
                                <i class="fas fa-check me-1"></i>فعال
                            </span>
                            @else
                                <span class="badge bg-danger">
                                <i class="fas fa-times me-1"></i>غیرفعال
                            </span>
                            @endif
                            <span class="badge bg-primary">
                            <i class="fas fa-language me-1"></i>
                            {{ $gallery->translations->count() }} ترجمه
                        </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- جدول ترجمه‌ها --}}
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-list me-1"></i>
                    لیست ترجمه‌ها
                </h5>
                <span class="badge bg-primary">{{ $translations->total() }} مورد</span>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-light">
                        <tr>
                            <th width="60">#</th>
                            <th width="120">زبان</th>
                            <th>عنوان</th>
                            <th width="200">نامک (Slug)</th>
                            <th>متن جایگزین</th>
                            <th width="150">آخرین ویرایش</th>
                            <th width="180">عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($translations as $translation)
                            <tr>
                                <td>{{ $translations->firstItem() + $loop->index }}</td>
                                <td>
                                    <span class="badge bg-primary">
                                        <i class="fas fa-globe me-1"></i>
                                        {{ $locales[$translation->locale] ?? $translation->locale }}
                                    </span>
                                    @if($translation->locale === \App\Models\Gallery::DEFAULT_LOCALE)
                                        <br>
                                        <small class="text-success">
                                            <i class="fas fa-star"></i> پیش‌فرض
                                        </small>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $translation->title }}</strong>
                                    @if($translation->description)
                                        <br>
                                        <small class="text-muted">
                                            {{ \Illuminate\Support\Str::limit($translation->description, 70) }}
                                        </small>
                                    @endif
                                </td>
                                <td>
                                    <code class="text-dark">{{ $translation->slug }}</code>
                                </td>
                                <td>
                                    @if($translation->alt_text)
                                        {{ \Illuminate\Support\Str::limit($translation->alt_text, 40) }}
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ $translation->updated_at->format('Y/m/d H:i') }}
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.gallery.translations.edit', [$gallery, $translation]) }}"
                                           class="btn btn-warning"
                                           title="ویرایش">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        @if($translation->locale !== \App\Models\Gallery::DEFAULT_LOCALE)
                                            <form action="{{ route('admin.gallery.translations.destroy', [$gallery, $translation]) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('آیا از حذف این ترجمه اطمینان دارید؟');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-danger"
                                                        title="حذف">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @else
                                            <button type="button"
                                                    class="btn btn-danger"
                                                    disabled
                                                    title="ترجمه زبان پیش‌فرض قابل حذف نیست">
                                                <i class="fas fa-lock"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="fas fa-language fa-3x mb-3 d-block"></i>
                                    هیچ ترجمه‌ای برای این گالری ثبت نشده است.
                                    <br>
                                    <a href="{{ route('admin.gallery.translations.create', $gallery) }}"
                                       class="btn btn-sm btn-primary mt-3">
                                        افزودن اولین ترجمه
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($translations->hasPages())
                <div class="card-footer">
                    {{ $translations->links() }}
                </div>
            @endif
        </div>

        {{-- دکمه بازگشت --}}
        <div class="mt-3">
            <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-right me-1"></i>
                بازگشت به گالری‌ها
            </a>
        </div>
    </div>
@endsection

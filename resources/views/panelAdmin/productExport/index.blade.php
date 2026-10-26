@extends('panelAdmin.layouts.panel')

@section('title', 'مدیریت محصولات صادراتی')

@section('content')
    <div class="container-fluid">

        {{-- هدر --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">
                    <i class="fas fa-ship me-2"></i>
                    مدیریت محصولات صادراتی
                </h1>
                <p class="text-muted mb-0 mt-1">شرکت امیرآفاق گستر</p>
            </div>
            <a href="{{ route('admin.productExport.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>
                افزودن محصول صادراتی
            </a>
        </div>

        {{-- پیام‌ها --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-1"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- فیلتر --}}
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.productExport.index') }}" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">جستجو</label>
                        <input type="text" name="search" class="form-control"
                               placeholder="نام یا SKU..."
                               value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">نوع محصول</label>
                        <select name="type" class="form-select">
                            <option value="">همه</option>
                            @foreach(\App\Models\ProductExport::PRODUCT_TYPES as $key => $labels)
                                <option value="{{ $key }}" @selected(request('type') === $key)>
                                    {{ $labels[app()->getLocale()] ?? $labels['fa'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">وضعیت</label>
                        <select name="status" class="form-select">
                            <option value="">همه</option>
                            <option value="active" @selected(request('status') === 'active')>فعال</option>
                            <option value="inactive" @selected(request('status') === 'inactive')>غیرفعال</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end gap-2">
                        <button class="btn btn-primary w-100">
                            <i class="fas fa-search"></i>
                        </button>
                        <a href="{{ route('admin.productExport.index') }}" class="btn btn-outline-secondary">
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
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-light">
                        <tr>
                            <th width="60">#</th>
                            <th width="80">تصویر</th>
                            <th>نام</th>
                            <th width="120">SKU</th>
                            <th width="130">دسته‌بندی</th>
                            <th width="130">نوع</th>
                            <th width="100">ترجمه‌ها</th>
                            <th width="100">ویژه</th>
                            <th width="100">وضعیت</th>
                            <th width="180">عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>{{ $products->firstItem() + $loop->index }}</td>
                                <td>
                                    @if($product->image)
                                        <img src="{{ $product->image_url }}"
                                             class="img-thumbnail"
                                             style="width: 60px; height: 60px; object-fit: cover;">
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $product->name ?? '—' }}</strong>
                                    @if($product->short_description)
                                        <br>
                                        <small class="text-muted">
                                            {{ \Illuminate\Support\Str::limit($product->short_description, 50) }}
                                        </small>
                                    @endif
                                </td>
                                <td><code>{{ $product->sku ?? '—' }}</code></td>
                                <td>
                                    {{ $product->category?->translation('fa')?->name
                                        ?? $product->category?->translation('en')?->name
                                        ?? '—' }}
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $product->product_type_label }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-primary">
                                        <i class="fas fa-language"></i>
                                        {{ $product->translations->count() }} / 3
                                    </span>
                                </td>
                                <td>
                                    @if($product->is_featured)
                                        <span class="badge bg-warning text-dark">
                                            <i class="fas fa-star"></i>
                                        </span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if($product->is_active)
                                        <span class="badge bg-success">فعال</span>
                                    @else
                                        <span class="badge bg-secondary">غیرفعال</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.productExport.show', $product) }}"
                                           class="btn btn-info" title="مشاهده">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.productExport.edit', $product) }}"
                                           class="btn btn-warning" title="ویرایش">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.productExport.delete', $product) }}"
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('حذف شود؟')">
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
                                <td colspan="10" class="text-center py-5 text-muted">
                                    <i class="fas fa-ship fa-3x mb-3 d-block"></i>
                                    هیچ محصول صادراتی یافت نشد.
                                    <br>
                                    <a href="{{ route('admin.productExport.create') }}"
                                       class="btn btn-sm btn-primary mt-3">
                                        افزودن اولین محصول
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($products->hasPages())
                <div class="card-footer">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

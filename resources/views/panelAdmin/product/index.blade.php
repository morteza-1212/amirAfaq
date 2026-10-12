@extends('panelAdmin.layouts.panel')

@section('title', 'مدیریت محصولات')

@section('style')
    <style>
        .products-page {
            direction: rtl;
            padding: 20px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 25px;
        }

        .page-title h1 {
            margin: 0;
            font-size: 25px;
        }

        .page-title p {
            margin: 5px 0 0;
            color: #64748b;
            font-size: 14px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 10px 18px;
            border-radius: 8px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.2s;
        }

        .btn-sm {
            padding: 7px 10px;
            font-size: 13px;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-primary:hover {
            background: #1d4ed8;
        }

        .btn-warning {
            background: #f59e0b;
            color: white;
        }

        .btn-warning:hover {
            background: #d97706;
        }

        .btn-danger {
            background: #dc2626;
            color: white;
        }

        .btn-danger:hover {
            background: #b91c1c;
        }

        .btn-secondary {
            background: #64748b;
            color: white;
        }

        .btn-secondary:hover {
            background: #475569;
        }

        .filter-box {
            background: white;
            padding: 18px;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .filter-form {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr auto;
            gap: 12px;
        }

        .form-control,
        .form-select {
            width: 100%;
            box-sizing: border-box;
            padding: 11px 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background: white;
            font-size: 14px;
        }

        .form-control:focus,
        .form-select:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .table-wrapper {
            overflow-x: auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        table {
            width: 100%;
            min-width: 900px;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 13px;
            border-bottom: 1px solid #eee;
            text-align: right;
            font-size: 14px;
            vertical-align: middle;
        }

        th {
            background: #f8fafc;
            font-weight: 600;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover {
            background: #f8fafc;
        }

        .product-image {
            width: 55px;
            height: 55px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        .no-image {
            width: 55px;
            height: 55px;
            background: #f1f5f9;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
        }

        .product-name {
            font-weight: 600;
            color: #1e293b;
        }

        .product-name-en {
            font-size: 12px;
            color: #64748b;
            direction: ltr;
            text-align: right;
        }

        .badge {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .badge-success {
            background: #dcfce7;
            color: #166534;
        }

        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-info {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-warning {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-secondary {
            background: #f1f5f9;
            color: #475569;
        }

        .badge-translation {
            background: #f3e8ff;
            color: #6b21a8;
        }

        .actions {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        .actions form {
            margin: 0;
            display: inline-block;
        }

        .alert {
            padding: 13px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #94a3b8;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 15px;
            opacity: 0.5;
        }

        .pagination-wrapper {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }

        @media (max-width: 768px) {
            .products-page {
                padding: 12px;
            }

            .filter-form {
                grid-template-columns: 1fr;
            }

            .page-header {
                align-items: stretch;
            }

            .page-header .btn {
                width: 100%;
            }
        }
    </style>
@endsection

@section('content')
    <div class="products-page">

        {{-- هدر صفحه --}}
        <div class="page-header">
            <div class="page-title">
                <h1>
                    <i class="fas fa-box me-2"></i>
                    مدیریت محصولات
                </h1>
                <p>شرکت امیرآفاق گستر</p>
            </div>

            <a href="{{ route('admin.product.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                افزودن محصول
            </a>
        </div>

        {{-- پیام‌ها --}}
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        {{-- فیلتر --}}
        <div class="filter-box">
            <form method="GET"
                  action="{{ route('admin.product.index') }}"
                  class="filter-form">

                <input type="text"
                       name="search"
                       class="form-control"
                       placeholder="جستجوی نام، کد یا SKU..."
                       value="{{ request('search') }}">

                <select name="type" class="form-select">
                    <option value="">همه نوع‌ها</option>
                    @foreach(\App\Models\Product::TYPES as $key => $labels)
                        <option value="{{ $key }}" @selected(request('type') === $key)>
                            {{ $labels[app()->getLocale()] ?? $labels['fa'] }}
                        </option>
                    @endforeach
                </select>

                <select name="status" class="form-select">
                    <option value="">همه وضعیت‌ها</option>
                    <option value="active" @selected(request('status') === 'active')>فعال</option>
                    <option value="inactive" @selected(request('status') === 'inactive')>غیرفعال</option>
                </select>

                <button class="btn btn-secondary">
                    <i class="fas fa-search"></i>
                    جستجو
                </button>
            </form>
        </div>

        {{-- جدول --}}
        <div class="table-wrapper">
            <table>
                <thead>
                <tr>
                    <th width="60">#</th>
                    <th width="80">تصویر</th>
                    <th>نام محصول</th>
                    <th width="120">کد</th>
                    <th width="150">دسته‌بندی</th>
                    <th width="130">نوع</th>
                    <th width="130">موجودی</th>
                    <th width="100">ترجمه‌ها</th>
                    <th width="100">وضعیت</th>
                    <th width="200">عملیات</th>
                </tr>
                </thead>
                <tbody>
                @forelse($products as $product)
                    @php
                        $faName = $product->translation('fa')?->name;
                        $enName = $product->translation('en')?->name;
                        $mainName = $faName ?? $enName ?? 'بدون نام';
                    @endphp
                    <tr>
                        <td>{{ $products->firstItem() + $loop->index }}</td>

                        {{-- تصویر --}}
                        <td>
                            @if($product->image)
                                <img src="{{ $product->image_url }}"
                                     class="product-image"
                                     alt="{{ $product->translation('fa')?->alt_text ?? '' }}">
                            @else
                                <div class="no-image">
                                    <i class="fas fa-image"></i>
                                </div>
                            @endif
                        </td>

                        {{-- نام --}}
                        <td>
                            <div class="product-name">{{ $mainName }}</div>
                            @if($enName && $enName !== $faName)
                                <div class="product-name-en">{{ $enName }}</div>
                            @endif
                        </td>

                        {{-- کد --}}
                        <td>
                            <code>{{ $product->code }}</code>
                        </td>

                        {{-- دسته‌بندی --}}
                        <td>
                            @if($product->category)
                                {{ $product->category->translation('fa')?->name
                                    ?? $product->category->translation('en')?->name
                                    ?? '—' }}
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>

                        {{-- نوع --}}
                        <td>
                            @php
                                $typeClass = match($product->type) {
                                    'export' => 'badge-info',
                                    'import' => 'badge-warning',
                                    'both'   => 'badge-secondary',
                                    default  => 'badge-secondary',
                                };
                            @endphp
                            <span class="badge {{ $typeClass }}">
                                {{ $product->type_label }}
                            </span>
                        </td>

                        {{-- وضعیت موجودی --}}
                        <td>
                            @php
                                $stockClass = match($product->stock_status) {
                                    'in_stock'     => 'badge-success',
                                    'out_of_stock' => 'badge-danger',
                                    'on_request'   => 'badge-warning',
                                    default        => 'badge-secondary',
                                };
                            @endphp
                            <span class="badge {{ $stockClass }}">
                                {{ $product->stock_status_label }}
                            </span>
                        </td>

                        {{-- ترجمه‌ها --}}
                        <td>
                            <span class="badge badge-translation">
                                <i class="fas fa-language me-1"></i>
                                {{ $product->translations->count() }} / 3
                            </span>
                        </td>

                        {{-- وضعیت فعال --}}
                        <td>
                            @if($product->is_active)
                                <span class="badge badge-success">فعال</span>
                            @else
                                <span class="badge badge-danger">غیرفعال</span>
                            @endif

                            @if($product->is_featured)
                                <span class="badge badge-warning" title="محصول ویژه">
                                    <i class="fas fa-star"></i>
                                </span>
                            @endif
                        </td>

                        {{-- عملیات --}}
                        <td>
                            <div class="actions">
                                <a href="{{ route('admin.product.edit', $product) }}"
                                   class="btn btn-primary btn-sm"
                                   title="ویرایش">
                                    <i class="fas fa-edit"></i>
                                    ویرایش
                                </a>

                                <form method="POST"
                                      action="{{ route('admin.product.delete', $product) }}"
                                      onsubmit="return confirm('آیا از حذف محصول مطمئن هستید؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" title="حذف">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10">
                            <div class="empty-state">
                                <i class="fas fa-box-open d-block"></i>
                                <p>محصولی پیدا نشد.</p>
                                <a href="{{ route('admin.product.create') }}"
                                   class="btn btn-primary mt-2">
                                    <i class="fas fa-plus"></i>
                                    افزودن اولین محصول
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{-- صفحه‌بندی --}}
        @if($products->hasPages())
            <div class="pagination-wrapper">
                {{ $products->links() }}
            </div>
        @endif
    </div>
@endsection

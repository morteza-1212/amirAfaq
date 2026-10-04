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

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 18px;
            border-radius: 8px;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-warning {
            background: #f59e0b;
            color: white;
        }

        .btn-danger {
            background: #dc2626;
            color: white;
        }

        .btn-secondary {
            background: #64748b;
            color: white;
        }

        .filter-box {
            background: white;
            padding: 18px;
            border-radius: 12px;
            margin-bottom: 20px;
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
        }

        .table-wrapper {
            overflow-x: auto;
            background: white;
            border-radius: 12px;
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
        }

        th {
            background: #f8fafc;
        }

        .product-image {
            width: 55px;
            height: 55px;
            object-fit: cover;
            border-radius: 8px;
        }

        .badge {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 20px;
            font-size: 12px;
        }

        .badge-success {
            background: #dcfce7;
            color: #166534;
        }

        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .actions {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        .alert {
            padding: 13px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
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

        <div class="page-header">

            <div class="page-title">
                <h1>مدیریت محصولات</h1>
            </div>

            <a href="{{ route('admin.product.create') }}"
               class="btn btn-primary">
                + افزودن محصول
            </a>

        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="filter-box">

            <form method="GET"
                  action="{{ route('admin.product.index') }}"
                  class="filter-form">

                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="جستجوی نام، کد یا SKU..."
                    value="{{ request('search') }}"
                >

                <select name="type" class="form-select">
                    <option value="">همه نوع‌ها</option>
                    <option value="export"
                            @selected(request('type') === 'export')}>
                        صادرات
                    </option>
                    <option value="import"
                            @selected(request('type') === 'import')}>
                        واردات
                    </option>
                    <option value="both"
                            @selected(request('type') === 'both')}>
                        هر دو
                    </option>
                </select>

                <select name="status" class="form-select">
                    <option value="">همه وضعیت‌ها</option>
                    <option value="active"
                            @selected(request('status') === 'active')}>
                        فعال
                    </option>
                    <option value="inactive"
                            @selected(request('status') === 'inactive')}>
                        غیرفعال
                    </option>
                </select>

                <button class="btn btn-secondary">
                    جستجو
                </button>

            </form>

        </div>

        <div class="table-wrapper">

            <table>

                <thead>
                <tr>
                    <th>#</th>
                    <th>تصویر</th>
                    <th>نام محصول</th>
                    <th>کد</th>
                    <th>دسته‌بندی</th>
                    <th>نوع</th>
                    <th>ترجمه‌ها</th>
                    <th>وضعیت</th>
                    <th>عملیات</th>
                </tr>
                </thead>

                <tbody>

                @forelse($products as $product)

                    <tr>

                        <td>
                            {{ $products->firstItem() + $loop->index }}
                        </td>

                        <td>
                            @if($product->image)
                                <img
                                    src="{{ asset('storage/' . $product->image) }}"
                                    class="product-image"
                                    alt=""
                                >
                            @else
                                -
                            @endif
                        </td>

                        <td>
                            {{ $product->translation('fa')?->name
                                ?? $product->translation('en')?->name
                                ?? 'بدون نام' }}
                        </td>

                        <td>
                            {{ $product->code }}
                        </td>

                        <td>
                            {{ $product->category?->translation('fa')?->name
                                ?? '-' }}
                        </td>

                        <td>
                            @if($product->type === 'export')
                                صادرات
                            @elseif($product->type === 'import')
                                واردات
                            @else
                                صادرات و واردات
                            @endif
                        </td>

                        <td>
                            {{ $product->translations->count() }} / 3
                        </td>

                        <td>

                            @if($product->is_active)
                                <span class="badge badge-success">
                                فعال
                            </span>
                            @else
                                <span class="badge badge-danger">
                                غیرفعال
                            </span>
                            @endif

                        </td>

                        <td>

                            <div class="actions">

{{--                                <a--}}
{{--                                    href="{{ route('products.show', $product) }}"--}}
{{--                                    class="btn btn-secondary">--}}
{{--                                    مشاهده--}}
{{--                                </a>--}}
                                <a
                                    href="{{ route('admin.product.translation.index', $product->id) }}"
                                    title="مدیریت ترجمه‌ها"
                                    class="pg-action"
                                    style="color:#7c3aed;"
                                >
                                    <svg
                                        width="17"
                                        height="17"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M3 5h12M9 3v2m4 0a8 8 0 01-8 8m0 0H3m2 0a8 8 0 008 8M17 13l4 8m-2-4h-4"
                                        />
                                    </svg>
                                </a>

                                <a
                                    href="{{ route('admin.product.edit', $product) }}"
                                    class="btn btn-primary">
                                    ویرایش
                                </a>

                                <form
                                    method="POST"
                                    action="{{ route('admin.product.delete', $product) }}"
                                    onsubmit="return confirm('آیا از حذف محصول مطمئن هستید؟')">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger">
                                        حذف
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="9" style="text-align:center">
                            محصولی پیدا نشد.
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

        <div style="margin-top:20px">
            {{ $products->links() }}
        </div>

    </div>

@endsection

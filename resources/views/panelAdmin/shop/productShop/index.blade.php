@extends('panelAdmin.layouts.panel')

@section('title', 'مدیریت محصولات')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">محصولات فروشگاه</h4>
        <a href="{{ route('admin.productShop.create') }}" class="btn btn-primary">
            + افزودن محصول
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped mb-0 text-center">
                    <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>تصویر</th>
                        <th>نام</th>
                        <th>SKU</th>
                        <th>دسته‌بندی</th>
                        <th>قیمت</th>
                        <th>موجودی</th>
                        <th>وضعیت</th>
                        <th>ویژه</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>
                                @if($product->image && Storage::disk('public')->exists($product->image))
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="" width="50" class="rounded">
                                @else
                                    —
                                @endif
                            </td>
                            <td>{{ $product->name }}</td>
                            <td><code>{{ $product->sku }}</code></td>
                            <td>{{ $product->categoryShop?->name ?? '—' }}</td>
                            <td>{{ number_format($product->price) }} تومان</td>
                            <td>{{ $product->stock_quantity }}</td>
                            <td>
                                @switch($product->status)
                                    @case('published')
                                        <span class="badge bg-success">منتشرشده</span>
                                        @break
                                    @case('draft')
                                        <span class="badge bg-warning text-dark">پیش‌نویس</span>
                                        @break
                                    @case('archived')
                                        <span class="badge bg-secondary">بایگانی</span>
                                        @break
                                @endswitch
                            </td>
                            <td>
                                @if($product->is_featured)
                                    <span class="badge bg-info">ویژه</span>
                                @else
                                    —
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.productShop.edit', $product) }}"
                                   class="btn btn-sm btn-warning">ویرایش</a>

                                <form action="{{ route('admin.productShop.destroy', $product) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('آیا از حذف این محصول مطمئن هستید؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">حذف</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-muted py-4">محصولی ثبت نشده است.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

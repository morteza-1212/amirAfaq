@extends('panelAdmin.layouts.panel')

@section('title', 'مدیریت زیردسته‌ها')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">زیردسته‌های فروشگاه</h4>
        <a href="{{ route('admin.categoryShop.create') }}" class="btn btn-primary">
            + افزودن زیردسته
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
                        <th>نام</th>
                        <th>دسته اصلی</th>
                        <th>والد</th>
                        <th>Slug</th>
                        <th>تصویر</th>
                        <th>ترتیب</th>
                        <th>وضعیت</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->parentCategory?->name ?? '—' }}</td>
                            <td>{{ $category->parent?->name ?? '—' }}</td>
                            <td><code>{{ $category->slug }}</code></td>
                            <td>
                                @if($category->image && Storage::disk('public')->exists($category->image))
                                    <img src="{{ asset('storage/' . $category->image) }}" alt="" width="50" class="rounded">
                                @else
                                    —
                                @endif
                            </td>
                            <td>{{ $category->sort_order }}</td>
                            <td>
                                @if($category->is_active)
                                    <span class="badge bg-success">فعال</span>
                                @else
                                    <span class="badge bg-secondary">غیرفعال</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.categoryShop.edit', $category) }}"
                                   class="btn btn-sm btn-warning">ویرایش</a>

                                <form action="{{ route('admin.categoryShop.destroy', $category) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('آیا از حذف این زیردسته مطمئن هستید؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">حذف</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-muted py-4">زیردسته‌ای ثبت نشده است.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

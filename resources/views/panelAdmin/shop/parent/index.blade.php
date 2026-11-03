@extends('panelAdmin.layouts.panel')

@section('title', 'مدیریت دسته‌بندی‌های اصلی')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">دسته‌بندی‌های اصلی</h4>
        <a href="{{ route('admin.parentShop.create') }}" class="btn btn-primary">
            + افزودن دسته‌بندی
        </a>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped mb-0 text-center">
                    <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>نام</th>
                        <th>Slug</th>
                        <th>تصویر</th>
                        <th>آیکون</th>
                        <th>ترتیب</th>
                        <th>وضعیت</th>
                        <th>تاریخ ایجاد</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td><code>{{ $category->slug }}</code></td>
                            <td>
                                @if($category->image && Storage::disk('public')->exists($category->image))
                                    <img src="{{ Storage::disk('public')->url($category->image) }}"
                                         alt="{{ $category->name }}"
                                         width="50"
                                         class="rounded">
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>{{ $category->icon ?? '—' }}</td>
                            <td>{{ $category->sort_order }}</td>
                            <td>
                                @if($category->is_active)
                                    <span class="badge bg-success">فعال</span>
                                @else
                                    <span class="badge bg-secondary">غیرفعال</span>
                                @endif
                            </td>
                            <td>{{ $category->created_at?->format('Y/m/d') }}</td>
                            <td>
                                <a href="{{ route('admin.parentShop.edit', $category) }}"
                                   class="btn btn-sm btn-warning">ویرایش</a>

                                <form action="{{ route('admin.parentShop.destroy', $category) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('آیا از حذف این دسته‌بندی مطمئن هستید؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">حذف</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-muted py-4">دسته‌بندی‌ای ثبت نشده است.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

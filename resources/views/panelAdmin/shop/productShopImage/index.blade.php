@extends('panelAdmin.layouts.panel')

@section('title', 'مدیریت گالری تصاویر محصولات')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">گالری تصاویر محصولات</h4>
        <a href="{{ route('admin.productShopImage.create') }}" class="btn btn-primary">
            + افزودن تصویر
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
                        <th>محصول</th>
                        <th>متن جایگزین</th>
                        <th>ترتیب</th>
                        <th>تصویر اصلی</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($images as $image)
                        <tr>
                            <td>{{ $image->id }}</td>
                            <td>
                                @if($image->image_path && Storage::disk('public')->exists($image->image_path))
                                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="" width="60" class="rounded">
                                @else
                                    —
                                @endif
                            </td>
                            <td>{{ $image->product?->name ?? '—' }}</td>
                            <td>{{ $image->alt_text ?? '—' }}</td>
                            <td>{{ $image->sort_order }}</td>
                            <td>
                                @if($image->is_primary)
                                    <span class="badge bg-success">اصلی</span>
                                @else
                                    <span class="badge bg-secondary">فرعی</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.productShopImage.edit', $image) }}"
                                   class="btn btn-sm btn-warning">ویرایش</a>

                                <form action="{{ route('admin.productShopImage.destroy', $image) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('آیا از حذف این تصویر مطمئن هستید؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">حذف</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-muted py-4">تصویری ثبت نشده است.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

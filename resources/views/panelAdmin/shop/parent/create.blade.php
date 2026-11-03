@extends('panelAdmin.layouts.panel')

@section('title', 'افزودن دسته‌بندی اصلی')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">افزودن دسته‌بندی اصلی</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.parentShop.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">نام دسته‌بندی <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control"
                               value="{{ old('name') }}" required maxlength="150">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Slug (آدرس اختصاصی)</label>
                        <input type="text" name="slug" class="form-control"
                               value="{{ old('slug') }}"
                               placeholder="در صورت خالی بودن از نام ساخته می‌شود" maxlength="180">
                    </div>

                    <div class="col-12">
                        <label class="form-label">توضیحات</label>
                        <textarea name="description" rows="3" class="form-control">{{ old('description') }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">مسیر تصویر</label>
                        <input type="file" name="image" class="form-control"
                               value="{{ old('image') }}"
                               placeholder="مثلاً storage/categories/icon.png" maxlength="255">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">آیکون</label>
                        <input type="text" name="icon" class="form-control"
                               value="{{ old('icon') }}"
                               placeholder="مثلاً fa fa-folder" maxlength="100">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">عنوان سئو (Meta Title)</label>
                        <input type="text" name="meta_title" class="form-control"
                               value="{{ old('meta_title') }}" maxlength="255">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">توضیحات سئو (Meta Description)</label>
                        <input type="text" name="meta_description" class="form-control"
                               value="{{ old('meta_description') }}" maxlength="500">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">ترتیب نمایش</label>
                        <input type="number" name="sort_order" class="form-control" min="0"
                               value="{{ old('sort_order', 0) }}">
                    </div>

                    <div class="col-md-6 d-flex align-items-end">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active"
                                {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">فعال باشد</label>
                        </div>
                    </div>

                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary">ذخیره</button>
                        <a href="{{ route('admin.parentShop.index') }}" class="btn btn-secondary">انصراف</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection@extends('admin.layouts.app')

@section('title', 'افزودن دسته‌بندی اصلی')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">افزودن دسته‌بندی اصلی</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.parentShop.store') }}" method="POST">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">نام دسته‌بندی <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control"
                               value="{{ old('name') }}" required maxlength="150">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Slug (آدرس اختصاصی)</label>
                        <input type="text" name="slug" class="form-control"
                               value="{{ old('slug') }}"
                               placeholder="در صورت خالی بودن از نام ساخته می‌شود" maxlength="180">
                    </div>

                    <div class="col-12">
                        <label class="form-label">توضیحات</label>
                        <textarea name="description" rows="3" class="form-control">{{ old('description') }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">مسیر تصویر</label>
                        <input type="text" name="image" class="form-control"
                               value="{{ old('image') }}"
                               placeholder="مثلاً storage/categories/icon.png" maxlength="255">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">آیکون</label>
                        <input type="text" name="icon" class="form-control"
                               value="{{ old('icon') }}"
                               placeholder="مثلاً fa fa-folder" maxlength="100">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">عنوان سئو (Meta Title)</label>
                        <input type="text" name="meta_title" class="form-control"
                               value="{{ old('meta_title') }}" maxlength="255">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">توضیحات سئو (Meta Description)</label>
                        <input type="text" name="meta_description" class="form-control"
                               value="{{ old('meta_description') }}" maxlength="500">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">ترتیب نمایش</label>
                        <input type="number" name="sort_order" class="form-control" min="0"
                               value="{{ old('sort_order', 0) }}">
                    </div>

                    <div class="col-md-6 d-flex align-items-end">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active"
                                {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">فعال باشد</label>
                        </div>
                    </div>

                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary">ذخیره</button>
                        <a href="{{ route('admin.parentShop.index') }}" class="btn btn-secondary">انصراف</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

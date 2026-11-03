@extends('panelAdmin.layouts.panel')

@section('title', 'ویرایش زیردسته')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">ویرایش زیردسته: {{ $categoryShop->name }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.categoryShop.update', $categoryShop) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    {{-- دسته‌بندی اصلی --}}
                    <div class="col-md-6">
                        <label class="form-label">دسته‌بندی اصلی <span class="text-danger">*</span></label>
                        <select name="parent_category_id" class="form-select @error('parent_category_id') is-invalid @enderror" required>
                            <option value="">-- انتخاب کنید --</option>
                            @foreach($parentCategories as $pc)
                                <option value="{{ $pc->id }}"
                                    {{ old('parent_category_id', $categoryShop->parent_category_id) == $pc->id ? 'selected' : '' }}>
                                    {{ $pc->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('parent_category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- زیردسته والد --}}
                    <div class="col-md-6">
                        <label class="form-label">زیردسته والد (اختیاری)</label>
                        <select name="parent_id" class="form-select @error('parent_id') is-invalid @enderror">
                            <option value="">-- بدون والد (سطح اول) --</option>
                            @foreach($parents as $p)
                                <option value="{{ $p->id }}"
                                    {{ old('parent_id', $categoryShop->parent_id) == $p->id ? 'selected' : '' }}>
                                    {{ $p->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('parent_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- نام --}}
                    <div class="col-md-6">
                        <label class="form-label">نام <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $categoryShop->name) }}" required maxlength="150">
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Slug --}}
                    <div class="col-md-6">
                        <label class="form-label">Slug</label>
                        <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror"
                               value="{{ old('slug', $categoryShop->slug) }}" maxlength="180"
                               placeholder="به صورت خودکار از نام پر می‌شود">
                        @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">اگر خالی بماند، از نام ساخته می‌شود.</small>
                    </div>

                    {{-- توضیحات --}}
                    <div class="col-12">
                        <label class="form-label">توضیحات</label>
                        <textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description', $categoryShop->description) }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- تصویر --}}
                    <div class="col-md-6">
                        <label class="form-label">تصویر</label>
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                        @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if($categoryShop->image && Storage::disk('public')->exists($categoryShop->image))
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $categoryShop->image) }}" alt="" width="80" class="rounded border">
                                <small class="text-muted d-block">تصویر فعلی — برای تغییر، فایل جدید انتخاب کنید.</small>
                            </div>
                        @endif
                    </div>

                    {{-- آیکون --}}
                    <div class="col-md-6">
                        <label class="form-label">آیکون</label>
                        <input type="text" name="icon" class="form-control @error('icon') is-invalid @enderror"
                               value="{{ old('icon', $categoryShop->icon) }}" maxlength="100"
                               placeholder="مثلاً fa fa-folder">
                        @error('icon')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Meta Title --}}
                    <div class="col-md-6">
                        <label class="form-label">عنوان سئو (Meta Title)</label>
                        <input type="text" name="meta_title" class="form-control @error('meta_title') is-invalid @enderror"
                               value="{{ old('meta_title', $categoryShop->meta_title) }}" maxlength="255">
                        @error('meta_title')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Meta Description --}}
                    <div class="col-md-6">
                        <label class="form-label">توضیحات سئو (Meta Description)</label>
                        <input type="text" name="meta_description" class="form-control @error('meta_description') is-invalid @enderror"
                               value="{{ old('meta_description', $categoryShop->meta_description) }}" maxlength="500">
                        @error('meta_description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- ترتیب --}}
                    <div class="col-md-6">
                        <label class="form-label">ترتیب نمایش</label>
                        <input type="number" name="sort_order" class="form-control @error('sort_order') is-invalid @enderror"
                               min="0" value="{{ old('sort_order', $categoryShop->sort_order) }}">
                        @error('sort_order')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- وضعیت --}}
                    <div class="col-md-6 d-flex align-items-end">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active"
                                {{ old('is_active', $categoryShop->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">فعال باشد</label>
                        </div>
                    </div>

                    {{-- دکمه‌ها --}}
                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary">به‌روزرسانی</button>
                        <a href="{{ route('admin.categoryShop.index') }}" class="btn btn-secondary">انصراف</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (function () {
            const nameInput = document.getElementById('name');
            const slugInput = document.getElementById('slug');
            if (!nameInput || !slugInput) return;

            // در فرم ویرایش، slug از قبل پر است، پس خودکار پر نمی‌شود
            let slugTouched = slugInput.value.trim().length > 0;

            slugInput.addEventListener('input', function () {
                slugTouched = slugInput.value.trim().length > 0;
            });

            function makeSlug(text) {
                return text
                    .toString()
                    .trim()
                    .toLowerCase()
                    .replace(/[\s_،,\.]+/g, '-')
                    .replace(/[^\u0600-\u06FFa-z0-9\-]/g, '')
                    .replace(/-+/g, '-')
                    .replace(/^-+|-+$/g, '');
            }

            nameInput.addEventListener('input', function () {
                if (!slugTouched) {
                    slugInput.value = makeSlug(nameInput.value);
                }
            });
        })();
    </script>
@endpush

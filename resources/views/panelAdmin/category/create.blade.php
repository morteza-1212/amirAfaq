@extends('panelAdmin.layouts.panel')

@section('title', 'ایجاد دسته بندی')

@section('content')

    <div style="direction:rtl; max-width:900px; margin:auto;">

        <div class="card" style="background:#fff; padding:30px; border-radius:16px;">

            <h2>ایجاد دسته بندی جدید</h2>

            {{-- نمایش خطاهای اعتبارسنجی --}}
            @if($errors->any())
                <div class="alert alert-danger" style="background:#f8d7da; color:#721c24; padding:12px; border-radius:8px; margin-bottom:15px;">
                    <ul style="margin:0; padding-right:20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- نمایش پیام موفقیت --}}
            @if(session('success'))
                <div class="alert alert-success" style="background:#d4edda; color:#155724; padding:12px; border-radius:8px; margin-bottom:15px;">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.category.store') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                {{-- ========================= --}}
                {{-- گروه محصول --}}
                {{-- ========================= --}}
                <label>گروه محصول</label>
                <select name="product_group_id" class="form-control">
                    @foreach($productGroups as $group)
                        <option value="{{ $group->id }}"
                            {{ old('product_group_id') == $group->id ? 'selected' : '' }}>
                            {{ $group->fa?->name ?? $group->code ?? 'گروه #'.$group->id }}
                        </option>
                    @endforeach
                </select>

                <br>

                {{-- ========================= --}}
                {{-- دسته والد --}}
                {{-- ========================= --}}
                <label>دسته والد</label>
                <select name="parent_id" class="form-control">
                    <option value="">دسته اصلی</option>

                    @foreach($categories as $item)
                        <option value="{{ $item->id }}"
                            {{ old('parent_id') == $item->id ? 'selected' : '' }}>
                            {{ $item->fa?->name ?? 'دسته #'.$item->id }}
                        </option>
                    @endforeach
                </select>

                <br>

                {{-- ========================= --}}
                {{-- نام دسته --}}
                {{-- ========================= --}}
                <label>نام دسته</label>
                <input type="text"
                       name="name"
                       class="form-control"
                       value="{{ old('name') }}"
                       placeholder="مثلاً: پوشاک مردانه"
                       required>

                <br>

                {{-- ========================= --}}
                {{-- اسلاگ --}}
                {{-- ========================= --}}
                <label>اسلاگ (اختیاری)</label>
                <input type="text"
                       name="slug"
                       class="form-control"
                       value="{{ old('slug') }}"
                       placeholder="men-clothing">

                <br>

                {{-- ========================= --}}
                {{-- توضیح کوتاه --}}
                {{-- ========================= --}}
                <label>توضیح کوتاه</label>
                <input type="text"
                       name="short_description"
                       class="form-control"
                       value="{{ old('short_description') }}"
                       placeholder="توضیح کوتاه دسته بندی">

                <br>

                {{-- ========================= --}}
                {{-- توضیحات --}}
                {{-- ========================= --}}
                <label>توضیحات</label>
                <textarea name="description"
                          class="form-control"
                          rows="4"
                          placeholder="توضیحات کامل دسته بندی">{{ old('description') }}</textarea>

                <br>

                {{-- ========================= --}}
                {{-- کد دسته --}}
                {{-- ========================= --}}
{{--                <label>کد دسته</label>--}}
{{--                <input type="text"--}}
{{--                       name="code"--}}
{{--                       class="form-control"--}}
{{--                       value="{{ old('code') }}"--}}
{{--                       placeholder="PST-001"--}}
{{--                       required>--}}

                <br>

                {{-- ========================= --}}
                {{-- تصویر --}}
                {{-- ========================= --}}
                <label>تصویر</label>
                <input type="file"
                       name="image"
                       class="form-control"
                       accept="image/*">

                <br>

                {{-- ========================= --}}
                {{-- آیکون --}}
                {{-- ========================= --}}
                <label>آیکون</label>
                <input type="text"
                       name="icon"
                       class="form-control"
                       value="{{ old('icon') }}"
                       placeholder="نام یا کلاس آیکون">

                <br>

                {{-- ========================= --}}
                {{-- ترتیب نمایش --}}
                {{-- ========================= --}}
                <label>ترتیب نمایش</label>
                <input type="number"
                       name="sort_order"
                       class="form-control"
                       value="{{ old('sort_order', 0) }}">

                <br>

                {{-- ========================= --}}
                {{-- وضعیت فعال --}}
                {{-- ========================= --}}
                <label>
                    <input type="checkbox"
                           name="status"
                           value="1"
                        {{ old('status', 1) ? 'checked' : '' }}>
                    فعال
                </label>

                <br>

                {{-- ========================= --}}
                {{-- دسته ویژه --}}
                {{-- ========================= --}}
                <label>
                    <input type="checkbox"
                           name="is_featured"
                           value="1"
                        {{ old('is_featured') ? 'checked' : '' }}>
                    دسته ویژه
                </label>

                <br><br>

                {{-- ========================= --}}
                {{-- دکمه‌ها --}}
                {{-- ========================= --}}
                <button type="submit" class="btn btn-primary">
                    ذخیره
                </button>

                <a href="{{ route('admin.category.index') }}"
                   class="btn btn-secondary"
                   style="margin-right:10px;">
                    انصراف
                </a>

            </form>

        </div>

    </div>

@endsection

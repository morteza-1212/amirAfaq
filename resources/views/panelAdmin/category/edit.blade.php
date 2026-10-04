@extends('panelAdmin.layouts.panel')

@section('title', 'ویرایش دسته بندی')

@section('content')

    <div style="direction:rtl; max-width:900px; margin:auto;">

        <div class="card" style="background:#fff; padding:30px; border-radius:16px;">

            <h2>ویرایش دسته بندی</h2>

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

            <form action="{{ route('admin.category.update', $category) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf
                @method('PUT')

                {{-- ========================= --}}
                {{-- گروه محصول --}}
                {{-- ========================= --}}
                <label>گروه محصول</label>
                <select name="product_group_id" class="form-control">
                    @foreach($productGroups as $group)
                        <option value="{{ $group->id }}"
                            @selected(old('product_group_id', $category->product_group_id) == $group->id)>
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
                        {{-- جلوگیری از انتخاب خود دسته به عنوان والد --}}
                        @if($item->id !== $category->id)
                            <option value="{{ $item->id }}"
                                @selected(old('parent_id', $category->parent_id) == $item->id)>
                                {{ $item->fa?->name ?? 'دسته #'.$item->id }}
                            </option>
                        @endif
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
                       value="{{ old('name', $category->fa?->name) }}"
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
                       value="{{ old('slug', $category->fa?->slug) }}"
                       placeholder="men-clothing">

                <br>

                {{-- ========================= --}}
                {{-- توضیح کوتاه --}}
                {{-- ========================= --}}
                <label>توضیح کوتاه</label>
                <input type="text"
                       name="short_description"
                       class="form-control"
                       value="{{ old('short_description', $category->fa?->short_description) }}"
                       placeholder="توضیح کوتاه دسته بندی">

                <br>

                {{-- ========================= --}}
                {{-- توضیحات --}}
                {{-- ========================= --}}
                <label>توضیحات</label>
                <textarea name="description"
                          class="form-control"
                          rows="4"
                          placeholder="توضیحات کامل دسته بندی">{{ old('description', $category->fa?->description) }}</textarea>

                <br>

                {{-- ========================= --}}
                {{-- کد دسته --}}
                {{-- ========================= --}}
                <label>کد دسته</label>
                <input type="text"
                       name="code"
                       class="form-control"
                       value="{{ old('code', $category->code) }}"
                       placeholder="PST-001"
                       required
                disabled>

                <br>

                {{-- ========================= --}}
                {{-- تصویر --}}
                {{-- ========================= --}}
                <label>تصویر جدید</label>
                <input type="file"
                       name="image"
                       class="form-control"
                       accept="image/*">

                @if($category->image)
                    <br>
                    <img src="{{ asset('storage/'.$category->image) }}"
                         width="120"
                         style="border-radius:8px; border:1px solid #ddd;">
                @endif

                <br>

                {{-- ========================= --}}
                {{-- آیکون --}}
                {{-- ========================= --}}
                <label>آیکون</label>
                <input type="text"
                       name="icon"
                       class="form-control"
                       value="{{ old('icon', $category->icon) }}"
                       placeholder="نام یا کلاس آیکون">

                <br>

                {{-- ========================= --}}
                {{-- ترتیب نمایش --}}
                {{-- ========================= --}}
                <label>ترتیب نمایش</label>
                <input type="number"
                       name="sort_order"
                       class="form-control"
                       value="{{ old('sort_order', $category->sort_order) }}">

                <br>

                {{-- ========================= --}}
                {{-- وضعیت فعال --}}
                {{-- ========================= --}}
                <label>
                    <input type="checkbox"
                           name="status"
                           value="1"
                        @checked(old('status', $category->status))>
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
                        @checked(old('is_featured', $category->is_featured))>
                    دسته ویژه
                </label>

                <br><br>

                {{-- ========================= --}}
                {{-- دکمه‌ها --}}
                {{-- ========================= --}}
                <button type="submit" class="btn btn-primary">
                    بروزرسانی
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

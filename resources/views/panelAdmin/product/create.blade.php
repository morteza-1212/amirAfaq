@extends('panelAdmin.layouts.panel')

@section('title', 'افزودن محصول')

@section('style')
    <style>
        .product-form-page {
            direction: rtl;
            padding: 20px;
        }

        .form-card {
            background: white;
            padding: 25px;
            border-radius: 14px;
            max-width: 1100px;
            margin: auto;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        .form-group.full {
            grid-column: 1 / -1;
        }

        label {
            font-weight: 600;
        }

        .form-control,
        .form-select {
            width: 100%;
            box-sizing: border-box;
            padding: 11px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        .checkbox-group {
            display: flex;
            gap: 25px;
            align-items: center;
        }

        .form-actions {
            margin-top: 25px;
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 11px 20px;
            border: 0;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-secondary {
            background: #64748b;
            color: white;
        }

        .error {
            color: #dc2626;
            font-size: 13px;
        }

        @media(max-width:768px) {
            .product-form-page {
                padding: 10px;
            }

            .form-card {
                padding: 15px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-group.full {
                grid-column: auto;
            }
        }
    </style>
@endsection

@section('content')

    <div class="product-form-page">

        <div class="form-card">

            <h1>افزودن محصول</h1>

            <form
                action="{{ route('admin.product.store') }}"
                method="POST"
                enctype="multipart/form-data">

                @csrf

                <div class="form-grid">

                    <div class="form-group">

                        <label>دسته‌بندی</label>

                        <select
                            name="category_id"
                            class="form-select"
                            required>

                            <option value="">
                                انتخاب دسته‌بندی
                            </option>

                            @foreach($categories as $category)

                                <option
                                    value="{{ $category->id }}"
                                    @selected(old('category_id') == $category->id)>

                                    {{
                                        $category->translation('fa')?->name
                                        ?? $category->translation('en')?->name
                                        ?? 'دسته بدون نام'
                                    }}

                                </option>

                            @endforeach

                        </select>

                        @error('category_id')
                        <span class="error">{{ $message }}</span>
                        @enderror

                    </div>

{{--                    <div class="form-group">--}}

{{--                        <label>کد محصول</label>--}}

{{--                        <input--}}
{{--                            type="text"--}}
{{--                            name="code"--}}
{{--                            class="form-control"--}}
{{--                            value="{{ old('code') }}"--}}
{{--                            required>--}}

{{--                        @error('code')--}}
{{--                        <span class="error">{{ $message }}</span>--}}
{{--                        @enderror--}}

{{--                    </div>--}}

                    <div class="form-group">

                        <label>SKU</label>

                        <input
                            type="text"
                            name="sku"
                            class="form-control"
                            value="{{ old('sku') }}">

                    </div>

                    <div class="form-group">

                        <label>نوع محصول</label>

                        <select
                            name="type"
                            class="form-select">

                            <option value="export">
                                صادرات
                            </option>

                            <option value="import">
                                واردات
                            </option>

                            <option value="both">
                                صادرات و واردات
                            </option>

                        </select>

                    </div>

                    <div class="form-group">

                        <label>وضعیت موجودی</label>

                        <select
                            name="stock_status"
                            class="form-select">

                            <option value="in_stock">
                                موجود
                            </option>

                            <option value="out_of_stock">
                                ناموجود
                            </option>

                            <option value="on_request">
                                استعلام
                            </option>

                        </select>

                    </div>

                    <div class="form-group">

                        <label>واحد</label>

                        <input
                            type="text"
                            name="unit"
                            class="form-control"
                            placeholder="کیلوگرم، تن، عدد..."
                            value="{{ old('unit') }}">

                    </div>

                    <div class="form-group">

                        <label>وزن</label>

                        <input
                            type="number"
                            step="0.001"
                            name="weight"
                            class="form-control"
                            value="{{ old('weight') }}">

                    </div>

                    <div class="form-group">

                        <label>کشور مبدا</label>

                        <input
                            type="text"
                            name="origin_country"
                            class="form-control"
                            value="{{ old('origin_country', 'Iran') }}">

                    </div>

                    <div class="form-group">

                        <label>حداقل مقدار سفارش</label>

                        <input
                            type="number"
                            step="0.001"
                            name="minimum_order"
                            class="form-control"
                            value="{{ old('minimum_order') }}">

                    </div>

                    <div class="form-group">

                        <label>مدت آماده‌سازی (روز)</label>

                        <input
                            type="number"
                            name="preparation_days"
                            class="form-control"
                            value="{{ old('preparation_days') }}">

                    </div>

                    <div class="form-group">

                        <label>ترتیب نمایش</label>

                        <input
                            type="number"
                            name="sort_order"
                            class="form-control"
                            value="{{ old('sort_order', 0) }}">

                    </div>

                    <div class="form-group">

                        <label>تصویر اصلی</label>

                        <input
                            type="file"
                            name="image"
                            class="form-control"
                            accept="image/*">

                    </div>

                    <div class="form-group">

                        <label>تصاویر گالری</label>

                        <input
                            type="file"
                            name="gallery[]"
                            class="form-control"
                            accept="image/*"
                            multiple>

                    </div>

                    <div class="form-group full">

                        <div class="checkbox-group">

                            <label>
                                <input
                                    type="checkbox"
                                    name="is_active"
                                    value="1"
                                    checked>
                                فعال
                            </label>

                            <label>
                                <input
                                    type="checkbox"
                                    name="is_featured"
                                    value="1">
                                محصول ویژه
                            </label>

                        </div>

                    </div>

                </div>

                <div class="form-actions">

                    <button
                        type="submit"
                        class="btn btn-primary">
                        ذخیره محصول
                    </button>

                    <a
                        href="{{ route('admin.product.index') }}"
                        class="btn btn-secondary">
                        بازگشت
                    </a>

                </div>

            </form>

        </div>

    </div>

@endsection

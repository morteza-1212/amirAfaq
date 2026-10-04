@extends('panelAdmin.layouts.panel')

@section('title', 'ویرایش محصول')

@section('style')
    <style>
        .product-edit-page {
            direction: rtl;
            padding: 20px;
        }

        .card {
            background: #fff;
            padding: 25px;
            border-radius: 14px;
            max-width: 1100px;
            margin: auto;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .field {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        .field.full {
            grid-column: 1 / -1;
        }

        .field input,
        .field select {
            padding: 11px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        .current-image {
            width: 130px;
            height: 130px;
            object-fit: cover;
            border-radius: 10px;
            margin-top: 10px;
        }

        .actions {
            margin-top: 25px;
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 11px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
        }

        .primary {
            background: #2563eb;
            color: white;
        }

        .secondary {
            background: #64748b;
            color: white;
        }

        @media(max-width:768px) {

            .product-edit-page {
                padding: 10px;
            }

            .card {
                padding: 15px;
            }

            .grid {
                grid-template-columns: 1fr;
            }

            .field.full {
                grid-column: auto;
            }
        }
    </style>
@endsection

@section('content')

    <div class="product-edit-page">

        <div class="card">

            <h1>ویرایش محصول</h1>

            <form
                action="{{ route('admin.product.update', $product) }}"
                method="POST"
                enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="grid">

                    <div class="field">

                        <label>دسته‌بندی</label>

                        <select name="category_id">

                            @foreach($categories as $category)

                                <option
                                    value="{{ $category->id }}"
                                    @selected(
                                        old(
                                            'category_id',
                                            $product->category_id
                                        ) == $category->id
                                    )>

                                    {{
                                        $category->translation('fa')?->name
                                        ?? $category->translation('en')?->name
                                        ?? 'بدون نام'
                                    }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="field">

                        <label>کد محصول</label>

                        <input
                            type="text"
                            name="code"
                            value="{{ old('code', $product->code) }}"
                            required
                            disabled
                        >

                    </div>

                    <div class="field">

                        <label>SKU</label>

                        <input
                            type="text"
                            name="sku"
                            value="{{ old('sku', $product->sku) }}">

                    </div>

                    <div class="field">

                        <label>نوع محصول</label>

                        <select name="type">

                            <option
                                value="export"
                                @selected($product->type === 'export')}>
                                صادرات
                            </option>

                            <option
                                value="import"
                                @selected($product->type === 'import')}>
                                واردات
                            </option>

                            <option
                                value="both"
                                @selected($product->type === 'both')}>
                                صادرات و واردات
                            </option>

                        </select>

                    </div>

                    <div class="field">

                        <label>وضعیت موجودی</label>

                        <select name="stock_status">

                            <option
                                value="in_stock"
                                @selected($product->stock_status === 'in_stock')}>
                                موجود
                            </option>

                            <option
                                value="out_of_stock"
                                @selected($product->stock_status === 'out_of_stock')}>
                                ناموجود
                            </option>

                            <option
                                value="on_request"
                                @selected($product->stock_status === 'on_request')}>
                                استعلام
                            </option>

                        </select>

                    </div>

                    <div class="field">

                        <label>واحد</label>

                        <input
                            type="text"
                            name="unit"
                            value="{{ old('unit', $product->unit) }}">

                    </div>

                    <div class="field">

                        <label>وزن</label>

                        <input
                            type="number"
                            step="0.001"
                            name="weight"
                            value="{{ old('weight', $product->weight) }}">

                    </div>

                    <div class="field">

                        <label>کشور مبدا</label>

                        <input
                            type="text"
                            name="origin_country"
                            value="{{ old('origin_country', $product->origin_country) }}">

                    </div>

                    <div class="field">

                        <label>حداقل سفارش</label>

                        <input
                            type="number"
                            step="0.001"
                            name="minimum_order"
                            value="{{ old('minimum_order', $product->minimum_order) }}">

                    </div>

                    <div class="field">

                        <label>مدت آماده‌سازی</label>

                        <input
                            type="number"
                            name="preparation_days"
                            value="{{ old('preparation_days', $product->preparation_days) }}">

                    </div>

                    <div class="field">

                        <label>ترتیب نمایش</label>

                        <input
                            type="number"
                            name="sort_order"
                            value="{{ old('sort_order', $product->sort_order) }}">

                    </div>

                    <div class="field">

                        <label>تصویر اصلی جدید</label>

                        <input
                            type="file"
                            name="image"
                            accept="image/*">

                        @if($product->image)

                            <img
                                src="{{ asset('storage/' . $product->image) }}"
                                class="current-image">

                        @endif

                    </div>

                    <div class="field">

                        <label>افزودن تصاویر گالری</label>

                        <input
                            type="file"
                            name="gallery[]"
                            multiple
                            accept="image/*">

                    </div>

                    <div class="field full">

                        <label>
                            <input
                                type="checkbox"
                                name="is_active"
                                value="1"
                                @checked($product->is_active)>
                            فعال
                        </label>

                        <label>
                            <input
                                type="checkbox"
                                name="is_featured"
                                value="1"
                                @checked($product->is_featured)>
                            محصول ویژه
                        </label>

                    </div>

                </div>

                <div class="actions">

                    <button
                        class="btn primary">
                        ذخیره تغییرات
                    </button>

                    <a
                        href="{{ route('admin.product.index') }}"
                        class="btn secondary">
                        بازگشت
                    </a>

                </div>

            </form>

        </div>

    </div>

@endsection

@extends('panelAdmin.layouts.panel')

@section('title', 'افزودن محصول')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">افزودن محصول</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.productShop.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-3">
                    {{-- دسته‌بندی --}}
                    <div class="col-md-6">
                        <label class="form-label">دسته‌بندی <span class="text-danger">*</span></label>
                        <select name="category_shop_id" class="form-select @error('category_shop_id') is-invalid @enderror" required>
                            <option value="">-- انتخاب کنید --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_shop_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_shop_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- نام --}}
                    <div class="col-md-6">
                        <label class="form-label">نام محصول <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}" required maxlength="200">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Slug --}}
                    <div class="col-md-6">
                        <label class="form-label">Slug</label>
                        <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror"
                               value="{{ old('slug') }}" maxlength="220"
                               placeholder="به صورت خودکار از نام پر می‌شود">
                        @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    {{-- SKU --}}
                    <div class="col-md-6">
                        <label class="form-label">کد محصول (SKU)</label>
                        <input type="text" name="sku" id="sku" class="form-control @error('sku') is-invalid @enderror"
                               value="{{ old('sku', $nextSku ?? '') }}" maxlength="100"
                               placeholder="به صورت خودکار تولید می‌شود">
                        @error('sku')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <small class="text-muted">اگر خالی بماند، از ۱۰۰ به بعد به صورت خودکار تولید می‌شود.</small>
                    </div>

                    {{-- توضیح کوتاه --}}
                    <div class="col-12">
                        <label class="form-label">توضیح کوتاه</label>
                        <input type="text" name="short_description" class="form-control @error('short_description') is-invalid @enderror"
                               value="{{ old('short_description') }}" maxlength="500">
                        @error('short_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- توضیحات --}}
                    <div class="col-12">
                        <label class="form-label">توضیحات کامل</label>
                        <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- برند --}}
                    <div class="col-md-6">
                        <label class="form-label">برند</label>
                        <input type="text" name="brand" class="form-control @error('brand') is-invalid @enderror"
                               value="{{ old('brand') }}" maxlength="150">
                        @error('brand')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- کشور سازنده --}}
                    <div class="col-md-6">
                        <label class="form-label">کشور سازنده</label>
                        <input type="text" name="country_of_origin" class="form-control @error('country_of_origin') is-invalid @enderror"
                               value="{{ old('country_of_origin') }}" maxlength="100">
                        @error('country_of_origin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- نوع محصول --}}
                    <div class="col-md-6">
                        <label class="form-label">نوع محصول <span class="text-danger">*</span></label>
                        <select name="product_type" class="form-select @error('product_type') is-invalid @enderror" required>
                            <option value="physical" {{ old('product_type', 'physical') == 'physical' ? 'selected' : '' }}>فیزیکی</option>
                            <option value="digital" {{ old('product_type') == 'digital' ? 'selected' : '' }}>مجازی</option>
                        </select>
                        @error('product_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- قیمت فروش --}}
                    <div class="col-md-6">
                        <label class="form-label">قیمت فروش (تومان) <span class="text-danger">*</span></label>
                        <input type="text"
                               inputmode="numeric"
                               class="form-control price-input @error('price') is-invalid @enderror"
                               data-target="price"
                               value="{{ old('price') ? number_format((int) old('price')) : '' }}"
                               placeholder="مثلاً ۱٬۲۵۰٬۰۰۰"
                               autocomplete="off">
                        <input type="hidden" name="price" id="price" value="{{ old('price') }}">
                        @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- قیمت قبل از تخفیف --}}
                    <div class="col-md-6">
                        <label class="form-label">قیمت قبل از تخفیف (تومان)</label>
                        <input type="text"
                               inputmode="numeric"
                               class="form-control price-input @error('compare_price') is-invalid @enderror"
                               data-target="compare_price"
                               value="{{ old('compare_price') ? number_format((int) old('compare_price')) : '' }}"
                               placeholder="مثلاً ۱٬۵۰۰٬۰۰۰"
                               autocomplete="off">
                        <input type="hidden" name="compare_price" id="compare_price" value="{{ old('compare_price') }}">
                        @error('compare_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- قیمت تمام‌شده --}}
                    <div class="col-md-6">
                        <label class="form-label">قیمت تمام‌شده (تومان)</label>
                        <input type="text"
                               inputmode="numeric"
                               class="form-control price-input @error('cost_price') is-invalid @enderror"
                               data-target="cost_price"
                               value="{{ old('cost_price') ? number_format((int) old('cost_price')) : '' }}"
                               placeholder="مثلاً ۹۰۰٬۰۰۰"
                               autocomplete="off">
                        <input type="hidden" name="cost_price" id="cost_price" value="{{ old('cost_price') }}">
                        @error('cost_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- مالیات --}}
                    <div class="col-md-6">
                        <label class="form-label">مالیات (درصد)</label>
                        <input type="number" step="0.01" name="tax_rate" class="form-control @error('tax_rate') is-invalid @enderror"
                               value="{{ old('tax_rate', 0) }}" min="0" max="100">
                        @error('tax_rate')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- مدیریت موجودی --}}
                    <div class="col-md-6 d-flex align-items-end">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="manage_stock" value="1" id="manage_stock"
                                {{ old('manage_stock', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="manage_stock">مدیریت موجودی</label>
                        </div>
                    </div>

                    {{-- موجودی --}}
                    <div class="col-md-6">
                        <label class="form-label">موجودی</label>
                        <input type="number" name="stock_quantity" class="form-control @error('stock_quantity') is-invalid @enderror"
                               value="{{ old('stock_quantity', 0) }}" min="0">
                        @error('stock_quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- حداقل موجودی --}}
                    <div class="col-md-6">
                        <label class="form-label">حداقل موجودی برای هشدار</label>
                        <input type="number" name="low_stock_threshold" class="form-control @error('low_stock_threshold') is-invalid @enderror"
                               value="{{ old('low_stock_threshold', 5) }}" min="0">
                        @error('low_stock_threshold')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- پیش‌خرید --}}
                    <div class="col-md-6 d-flex align-items-end">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="allow_backorder" value="1" id="allow_backorder"
                                {{ old('allow_backorder') ? 'checked' : '' }}>
                            <label class="form-check-label" for="allow_backorder">امکان پیش‌خرید</label>
                        </div>
                    </div>

                    {{-- وزن --}}
                    <div class="col-md-3">
                        <label class="form-label">وزن (گرم)</label>
                        <input type="number" name="weight" class="form-control @error('weight') is-invalid @enderror"
                               value="{{ old('weight') }}" min="0">
                        @error('weight')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- ابعاد --}}
                    <div class="col-md-3">
                        <label class="form-label">طول (mm)</label>
                        <input type="number" name="length" class="form-control @error('length') is-invalid @enderror"
                               value="{{ old('length') }}" min="0">
                        @error('length')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">عرض (mm)</label>
                        <input type="number" name="width" class="form-control @error('width') is-invalid @enderror"
                               value="{{ old('width') }}" min="0">
                        @error('width')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">ارتفاع (mm)</label>
                        <input type="number" name="height" class="form-control @error('height') is-invalid @enderror"
                               value="{{ old('height') }}" min="0">
                        @error('height')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- تصویر --}}
                    <div class="col-md-6">
                        <label class="form-label">تصویر اصلی</label>
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- وضعیت --}}
                    <div class="col-md-6">
                        <label class="form-label">وضعیت <span class="text-danger">*</span></label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>پیش‌نویس</option>
                            <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>منتشرشده</option>
                            <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>بایگانی</option>
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- ویژه --}}
                    <div class="col-md-6 d-flex align-items-end">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="is_featured"
                                {{ old('is_featured') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">نمایش در صفحه اصلی (ویژه)</label>
                        </div>
                    </div>

                    {{-- ترتیب --}}
                    <div class="col-md-6">
                        <label class="form-label">ترتیب نمایش</label>
                        <input type="number" name="sort_order" class="form-control @error('sort_order') is-invalid @enderror"
                               value="{{ old('sort_order', 0) }}" min="0">
                        @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- زمان انتشار --}}
                    <div class="col-md-6">
                        <label class="form-label">زمان انتشار (اختیاری)</label>
                        <input type="datetime-local" name="published_at" class="form-control @error('published_at') is-invalid @enderror"
                               value="{{ old('published_at') }}">
                        @error('published_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Meta Title --}}
                    <div class="col-md-6">
                        <label class="form-label">عنوان سئو</label>
                        <input type="text" name="meta_title" class="form-control @error('meta_title') is-invalid @enderror"
                               value="{{ old('meta_title') }}" maxlength="255">
                        @error('meta_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Meta Description --}}
                    <div class="col-md-6">
                        <label class="form-label">توضیحات سئو</label>
                        <input type="text" name="meta_description" class="form-control @error('meta_description') is-invalid @enderror"
                               value="{{ old('meta_description') }}" maxlength="500">
                        @error('meta_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- دکمه‌ها --}}
                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary">ذخیره</button>
                        <a href="{{ route('admin.productShop.index') }}" class="btn btn-secondary">انصراف</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')

    <script>
        (function () {
            // --- Slug خودکار (قبلی) ---
            const nameInput = document.getElementById('name');
            const slugInput = document.getElementById('slug');
            if (nameInput && slugInput) {
                let slugTouched = slugInput.value.trim().length > 0;
                slugInput.addEventListener('input', function () {
                    slugTouched = slugInput.value.trim().length > 0;
                });
                function makeSlug(text) {
                    return text.toString().trim().toLowerCase()
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
            }

            // --- فرمت‌دهی قیمت ---
            function formatPrice(value) {
                // فقط اعداد را نگه دار
                const digits = value.replace(/[^\d]/g, '');
                if (!digits) return '';
                // جداکننده هزارگان با کاما
                return digits.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            }

            function setupPriceInput(input) {
                const targetId = input.dataset.target;
                const hidden = document.getElementById(targetId);
                if (!hidden) return;

                // مقدار اولیه را هم فرمت کن (برای edit و old)
                if (input.value) {
                    const digits = input.value.replace(/[^\d]/g, '');
                    input.value = formatPrice(digits);
                    hidden.value = digits;
                }

                input.addEventListener('input', function () {
                    const digits = input.value.replace(/[^\d]/g, '');
                    input.value = formatPrice(digits);
                    hidden.value = digits;
                });

                // جلوگیری از ورود غیرعدد (اختیاری)
                input.addEventListener('keypress', function (e) {
                    if (!/[0-9]/.test(e.key) && !['Backspace', 'Delete', 'ArrowLeft', 'ArrowRight', 'Tab'].includes(e.key)) {
                        e.preventDefault();
                    }
                });
            }

            document.querySelectorAll('.price-input').forEach(setupPriceInput);
        })();
    </script>


@endsection


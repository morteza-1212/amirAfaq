@extends('panelAdmin.layouts.panel')

@section('title', 'ویرایش تصویر محصول')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">ویرایش تصویر محصول</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.productShopImage.update', $productShopImage) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    {{-- محصول (جستجوپذیر) --}}
                    @php
                        $selectedProductId = old('product_shop_id', $productShopImage->product_shop_id);
                        $selectedProductName = $products->firstWhere('id', $selectedProductId)?->name ?? '';
                    @endphp
                    <div class="col-md-6">
                        <label class="form-label">محصول <span class="text-danger">*</span></label>
                        <input type="text"
                               id="product_search"
                               class="form-control @error('product_shop_id') is-invalid @enderror"
                               list="products_list"
                               placeholder="نام محصول را تایپ کنید..."
                               autocomplete="off"
                               value="{{ $selectedProductName }}">
                        <datalist id="products_list">
                            @foreach($products as $product)
                                <option data-id="{{ $product->id }}" value="{{ $product->name }}"></option>
                            @endforeach
                        </datalist>
                        {{-- فیلد مخفی برای ارسال id --}}
                        <input type="hidden" name="product_shop_id" id="product_shop_id" value="{{ $selectedProductId }}">
                        @error('product_shop_id')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        <small class="text-muted">نام محصول را تایپ کنید و از لیست پیشنهادی انتخاب کنید.</small>
                    </div>

                    {{-- تصویر --}}
                    <div class="col-md-6">
                        <label class="form-label">تصویر</label>
                        <input type="file" name="image_path" class="form-control @error('image_path') is-invalid @enderror">
                        @error('image_path')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        @if($productShopImage->image_path && Storage::disk('public')->exists($productShopImage->image_path))
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $productShopImage->image_path) }}" alt="" width="100" class="rounded border">
                                <small class="text-muted d-block">تصویر فعلی — برای تغییر، فایل جدید انتخاب کنید.</small>
                            </div>
                        @endif
                    </div>

                    {{-- متن جایگزین --}}
                    <div class="col-md-6">
                        <label class="form-label">متن جایگزین (Alt)</label>
                        <input type="text" name="alt_text" class="form-control @error('alt_text') is-invalid @enderror"
                               value="{{ old('alt_text', $productShopImage->alt_text) }}" maxlength="255">
                        @error('alt_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- ترتیب --}}
                    <div class="col-md-6">
                        <label class="form-label">ترتیب نمایش</label>
                        <input type="number" name="sort_order" class="form-control @error('sort_order') is-invalid @enderror"
                               value="{{ old('sort_order', $productShopImage->sort_order) }}" min="0">
                        @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- تصویر اصلی --}}
                    <div class="col-md-6 d-flex align-items-end">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_primary" value="1" id="is_primary"
                                {{ old('is_primary', $productShopImage->is_primary) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_primary">این تصویر اصلی محصول باشد</label>
                        </div>
                    </div>

                    {{-- دکمه‌ها --}}
                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary">به‌روزرسانی</button>
                        <a href="{{ route('admin.productShopImage.index') }}" class="btn btn-secondary">انصراف</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (function () {
            const searchInput = document.getElementById('product_search');
            const hiddenId    = document.getElementById('product_shop_id');
            const datalist    = document.getElementById('products_list');
            if (!searchInput || !hiddenId || !datalist) return;

            // نگاشت نام → id
            const map = {};
            Array.from(datalist.options).forEach(opt => {
                map[opt.value] = opt.dataset.id;
            });

            // هنگام تایپ، اگر مقدار با یک نام مطابقت داشت، id را ست کن
            searchInput.addEventListener('input', function () {
                const val = searchInput.value.trim();
                if (map[val]) {
                    hiddenId.value = map[val];
                } else {
                    hiddenId.value = '';
                }
            });

            // هنگام انتخاب از datalist (تغییر مقدار)
            searchInput.addEventListener('change', function () {
                const val = searchInput.value.trim();
                hiddenId.value = map[val] || '';
            });
        })();
    </script>
@endpush

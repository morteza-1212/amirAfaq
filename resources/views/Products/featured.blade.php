<div class="filter-card" x-data="filters()">
    <div class="filter-header">
        <h3 class="filter-title">
            <i class="fas fa-filter"></i>
            فیلترها
        </h3>
        <button type="button" @click="reset()" class="btn-clear-filter">
            <i class="fas fa-redo-alt"></i>
            پاک‌سازی
        </button>
    </div>

    <form @submit.prevent="apply()">
        {{-- جستجو --}}
        <div class="filter-group">
            <label class="filter-label">جستجو</label>
            <input type="text"
                   x-model="q"
                   placeholder="نام محصول..."
                   class="filter-input">
        </div>

        {{-- دسته‌بندی --}}
        <div class="filter-group">
            <label class="filter-label">دسته‌بندی</label>
            <select x-model="category_id" class="filter-select">
                <option value="">همه دسته‌ها</option>
                @php
                    try {
                        $categories = \App\Models\Shop\CategoryShop::query()->get(['id', 'name']);
                    } catch (\Throwable $e) {
                        $categories = collect();
                    }
                @endphp
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- برند --}}
        <div class="filter-group">
            <label class="filter-label">برند</label>
            <input type="text"
                   x-model="brand"
                   placeholder="مثلاً سامسونگ"
                   class="filter-input">
        </div>

        {{-- قیمت --}}
        <div class="filter-group">
            <label class="filter-label">قیمت (تومان)</label>
            <div class="filter-price-row">
                <input type="number"
                       x-model="min_price"
                       placeholder="از"
                       class="filter-input">
                <input type="number"
                       x-model="max_price"
                       placeholder="تا"
                       class="filter-input">
            </div>
        </div>

        {{-- گزینه‌ها --}}
        <div class="filter-group" style="padding-top: 0.5rem; border-top: 1px solid #f1f5f9;">
            <label class="filter-checkbox">
                <input type="checkbox" x-model="in_stock">
                <span>فقط کالاهای موجود</span>
            </label>
            <label class="filter-checkbox">
                <input type="checkbox" x-model="is_featured">
                <span>فقط محصولات ویژه ⭐</span>
            </label>
        </div>

        {{-- دکمه اعمال --}}
        <button type="submit" class="btn-apply-filter">
            اعمال فیلتر
        </button>
    </form>
</div>

@push('scripts')
    <script>
        function filters() {
            return {
                q:           @json(request('q', '')),
                category_id: @json((string) request('category_id', '')),
                brand:       @json(request('brand', '')),
                min_price:   @json((string) request('min_price', '')),
                max_price:   @json((string) request('max_price', '')),
                in_stock:    @json((bool) request('in_stock', false)),
                is_featured: @json((bool) request('is_featured', false)),

                apply() {
                    const params = new URLSearchParams();
                    if (this.q)           params.set('q', this.q);
                    if (this.category_id) params.set('category_id', this.category_id);
                    if (this.brand)       params.set('brand', this.brand);
                    if (this.min_price)   params.set('min_price', this.min_price);
                    if (this.max_price)   params.set('max_price', this.max_price);
                    if (this.in_stock)    params.set('in_stock', 1);
                    if (this.is_featured) params.set('is_featured', 1);

                    const sort = @json(request('sort', ''));
                    if (sort) params.set('sort', sort);

                    window.location = @json(route('products.index', ['locale' => app()->getLocale()]))
                        + (params.toString() ? '?' + params.toString() : '');
                },

                reset() {
                    window.location = @json(route('products.index', ['locale' => app()->getLocale()]));
                }
            }
        }
    </script>
@endpush

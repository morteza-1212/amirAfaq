@php
    $isMobile = $isMobile ?? false;
    $prefix   = $isMobile ? 'm_' : 'd_';
@endphp

<form method="GET"
      action="{{ route('products.index', ['locale' => app()->getLocale()]) }}"
      id="{{ $prefix }}filtersForm">

    {{-- حفظ sort فعلی --}}
    @if(request('sort'))
        <input type="hidden" name="sort" value="{{ request('sort') }}">
    @endif

    {{-- ========== جستجو ========== --}}
    <div class="filter-card soft-shadow">
        <div class="filter-card-title" data-toggle-collapse>
            <span>جستجو</span>
            <svg class="chevron" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>
        <div class="filter-card-body">
            <input type="text"
                   name="q"
                   class="filter-input"
                   placeholder="نام محصول..."
                   value="{{ request('q') }}">
        </div>
    </div>

    {{-- ========== دسته‌بندی ========== --}}
    @if(isset($categories) && $categories->count())
        <div class="filter-card soft-shadow">
            <div class="filter-card-title" data-toggle-collapse>
                <span>دسته‌بندی</span>
                <svg class="chevron" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>
            <div class="filter-card-body">
                <label class="filter-option">
                    <input type="radio" name="category_id" value=""
                        @checked(!request('category_id'))>
                    <label>همه دسته‌ها</label>
                </label>
                @foreach($categories as $cat)
                    <label class="filter-option">
                        <input type="radio" name="category_id" value="{{ $cat->id }}"
                            @checked((string) request('category_id') === (string) $cat->id)>
                        <label>{{ $cat->name }}</label>
                    </label>
                @endforeach
            </div>
        </div>
    @endif

    {{-- ========== برند ========== --}}
    @if(isset($brands) && $brands->count())
        <div class="filter-card soft-shadow">
            <div class="filter-card-title" data-toggle-collapse>
                <span>برند</span>
                <svg class="chevron" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>
            <div class="filter-card-body">
                @foreach($brands as $brandName)
                    <label class="filter-option">
                        <input type="radio" name="brand" value="{{ $brandName }}"
                            @checked(request('brand') === $brandName)>
                        <label>{{ $brandName }}</label>
                    </label>
                @endforeach
            </div>
        </div>
    @endif

    {{-- ========== محدوده قیمت ========== --}}
    <div class="filter-card soft-shadow">
        <div class="filter-card-title" data-toggle-collapse>
            <span>محدوده قیمت (تومان)</span>
            <svg class="chevron" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>
        <div class="filter-card-body">
            <div class="price-range-inputs">
                <input type="number" name="min_price" class="filter-input" placeholder="از"
                       min="0" value="{{ request('min_price') }}">
                <span class="text-muted small">—</span>
                <input type="number" name="max_price" class="filter-input" placeholder="تا"
                       min="0" value="{{ request('max_price') }}">
            </div>
        </div>
    </div>

    {{-- ========== گزینه‌های دیگر ========== --}}
    <div class="filter-card soft-shadow">
        <div class="filter-card-title" data-toggle-collapse>
            <span>گزینه‌های دیگر</span>
            <svg class="chevron" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>
        <div class="filter-card-body">
            <label class="filter-option">
                <input type="checkbox" name="in_stock" value="1" @checked(request('in_stock'))>
                <label>فقط کالاهای موجود</label>
            </label>
            <label class="filter-option">
                <input type="checkbox" name="is_featured" value="1" @checked(request('is_featured'))>
                <label>فقط محصولات ویژه ⭐</label>
            </label>
        </div>
    </div>

    {{-- ========== دکمه‌ها ========== --}}
    <div class="d-flex flex-column gap-2 mt-3">
        <button type="submit" class="filter-btn-apply">اعمال فیلترها</button>
        <a href="{{ route('products.index', ['locale' => app()->getLocale()]) }}"
           class="filter-btn-reset text-decoration-none text-center">
            حذف همه فیلترها
        </a>
    </div>
</form>

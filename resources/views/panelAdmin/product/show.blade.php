@extends('panelAdmin.layouts.panel')

@section('title', 'مشاهده محصول')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-eye me-2"></i>
                {{ $product->name ?? 'محصول' }}
            </h1>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.product.edit', $product) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-1"></i> ویرایش
                </a>
                <a href="{{ route('admin.product.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-right me-1"></i> بازگشت
                </a>
            </div>
        </div>

        <div class="row g-3">
            {{-- تصویر --}}
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header"><strong>تصویر اصلی</strong></div>
                    <div class="card-body text-center">
                        @if($product->image)
                            <img src="{{ $product->image_url }}" class="img-fluid rounded">
                        @else
                            <p class="text-muted">تصویری وجود ندارد.</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- اطلاعات --}}
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><strong>اطلاعات پایه</strong></div>
                    <div class="card-body">
                        <dl class="row mb-0">
                            <dt class="col-sm-4">کد محصول:</dt>
                            <dd class="col-sm-8"><code>{{ $product->code }}</code></dd>

                            <dt class="col-sm-4">SKU:</dt>
                            <dd class="col-sm-8">{{ $product->sku ?? '—' }}</dd>

                            <dt class="col-sm-4">دسته‌بندی:</dt>
                            <dd class="col-sm-8">
                                {{ $product->category?->translation('fa')?->name ?? '—' }}
                            </dd>

                            <dt class="col-sm-4">نوع:</dt>
                            <dd class="col-sm-8">
                                <span class="badge bg-info">{{ $product->type_label }}</span>
                            </dd>

                            <dt class="col-sm-4">وضعیت موجودی:</dt>
                            <dd class="col-sm-8">
                                <span class="badge bg-warning text-dark">
                                    {{ $product->stock_status_label }}
                                </span>
                            </dd>

                            <dt class="col-sm-4">واحد:</dt>
                            <dd class="col-sm-8">{{ $product->unit_label ?? '—' }}</dd>

                            <dt class="col-sm-4">وزن:</dt>
                            <dd class="col-sm-8">{{ $product->weight ?? '—' }}</dd>

                            <dt class="col-sm-4">کشور مبدا:</dt>
                            <dd class="col-sm-8">{{ $product->origin_country ?? '—' }}</dd>

                            <dt class="col-sm-4">حداقل سفارش:</dt>
                            <dd class="col-sm-8">{{ $product->minimum_order ?? '—' }}</dd>

                            <dt class="col-sm-4">مدت آماده‌سازی:</dt>
                            <dd class="col-sm-8">
                                {{ $product->preparation_days ? $product->preparation_days . ' روز' : '—' }}
                            </dd>

                            <dt class="col-sm-4">وضعیت:</dt>
                            <dd class="col-sm-8">
                                @if($product->is_active)
                                    <span class="badge bg-success">فعال</span>
                                @else
                                    <span class="badge bg-secondary">غیرفعال</span>
                                @endif
                                @if($product->is_featured)
                                    <span class="badge bg-warning text-dark">
                                        <i class="fas fa-star"></i> ویژه
                                    </span>
                                @endif
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>

            {{-- ترجمه‌ها --}}
            <div class="col-12">
                <div class="card">
                    <div class="card-header"><strong>ترجمه‌ها</strong></div>
                    <div class="card-body">
                        <ul class="nav nav-tabs mb-3" role="tablist">
                            @foreach(\App\Models\Product::LOCALES as $code => $label)
                                @php $t = $product->translations->firstWhere('locale', $code); @endphp
                                <li class="nav-item">
                                    <button class="nav-link @if($loop->first) active @endif"
                                            data-bs-toggle="tab"
                                            data-bs-target="#show-{{ $code }}"
                                            type="button">
                                        {{ $label }}
                                        @if($t)<span class="badge bg-success ms-1">✓</span>@endif
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-content">
                            @foreach(\App\Models\Product::LOCALES as $code => $label)
                                @php $t = $product->translations->firstWhere('locale', $code); @endphp
                                <div class="tab-pane fade @if($loop->first) show active @endif"
                                     id="show-{{ $code }}">
                                    @if($t)
                                        <h4>{{ $t->name }}</h4>
                                        <p class="text-muted"><code>{{ $t->slug }}</code></p>
                                        @if($t->short_description)
                                            <p><strong>توضیح کوتاه:</strong> {{ $t->short_description }}</p>
                                        @endif
                                        @if($t->description)
                                            <p><strong>توضیحات:</strong></p>
                                            <p style="white-space: pre-wrap;">{{ $t->description }}</p>
                                        @endif
                                    @else
                                        <p class="text-muted">ترجمه‌ای ثبت نشده است.</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

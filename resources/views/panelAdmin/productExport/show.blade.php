@extends('panelAdmin.layouts.panel')

@section('title', 'مشاهده محصول صادراتی')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-eye me-2"></i>
                {{ $productExport->name ?? 'محصول صادراتی' }}
            </h1>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.productExport.edit', $productExport) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-1"></i> ویرایش
                </a>
                <a href="{{ route('admin.productExport.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-right me-1"></i> بازگشت
                </a>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header"><strong>تصویر اصلی</strong></div>
                    <div class="card-body text-center">
                        @if($productExport->image)
                            <img src="{{ $productExport->image_url }}" class="img-fluid rounded">
                        @else
                            <p class="text-muted">تصویری وجود ندارد.</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><strong>اطلاعات پایه</strong></div>
                    <div class="card-body">
                        <dl class="row mb-0">
                            <dt class="col-sm-4">SKU:</dt>
                            <dd class="col-sm-8"><code>{{ $productExport->sku ?? '—' }}</code></dd>

                            <dt class="col-sm-4">دسته‌بندی:</dt>
                            <dd class="col-sm-8">
                                {{ $productExport->category?->name ?? '—' }}
                            </dd>

                            <dt class="col-sm-4">نوع محصول:</dt>
                            <dd class="col-sm-8">
                                <span class="badge bg-info">{{ $productExport->product_type_label }}</span>
                            </dd>

                            <dt class="col-sm-4">واحد:</dt>
                            <dd class="col-sm-8">{{ $productExport->unit_label ?? '—' }}</dd>

                            <dt class="col-sm-4">حداقل سفارش:</dt>
                            <dd class="col-sm-8">{{ $productExport->minimum_order_quantity ?? '—' }}</dd>

                            <dt class="col-sm-4">حداکثر تأمین:</dt>
                            <dd class="col-sm-8">{{ $productExport->maximum_supply_quantity ?? '—' }}</dd>

                            <dt class="col-sm-4">کشور مبدا:</dt>
                            <dd class="col-sm-8">{{ $productExport->origin_country ?? '—' }}</dd>

                            <dt class="col-sm-4">نوع بسته‌بندی:</dt>
                            <dd class="col-sm-8">{{ $productExport->packaging_type ?? '—' }}</dd>

                            <dt class="col-sm-4">شرایط نگهداری:</dt>
                            <dd class="col-sm-8">{{ $productExport->storage_conditions ?? '—' }}</dd>

                            <dt class="col-sm-4">مدت ماندگاری:</dt>
                            <dd class="col-sm-8">{{ $productExport->shelf_life ?? '—' }}</dd>

                            <dt class="col-sm-4">وضعیت:</dt>
                            <dd class="col-sm-8">
                                @if($productExport->is_active)
                                    <span class="badge bg-success">فعال</span>
                                @else
                                    <span class="badge bg-secondary">غیرفعال</span>
                                @endif
                                @if($productExport->is_featured)
                                    <span class="badge bg-warning text-dark">
                                        <i class="fas fa-star"></i> ویژه
                                    </span>
                                @endif
                                @if($productExport->is_exportable)
                                    <span class="badge bg-primary">قابل صادرات</span>
                                @endif
                                @if($productExport->is_available_domestic)
                                    <span class="badge bg-info">عرضه داخلی</span>
                                @endif
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>

            {{-- مشخصات فنی --}}
            @if(! empty($productExport->specifications))
                <div class="col-12">
                    <div class="card">
                        <div class="card-header"><strong>مشخصات فنی</strong></div>
                        <div class="card-body">
                            <table class="table table-sm mb-0">
                                @foreach($productExport->specifications as $key => $value)
                                    <tr>
                                        <th width="30%">{{ $key }}</th>
                                        <td>
                                            @if(is_array($value))
                                                <code>{{ json_encode($value, JSON_UNESCAPED_UNICODE) }}</code>
                                            @else
                                                {{ $value }}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            {{-- ترجمه‌ها --}}
            <div class="col-12">
                <div class="card">
                    <div class="card-header"><strong>ترجمه‌ها</strong></div>
                    <div class="card-body">
                        <ul class="nav nav-tabs mb-3" role="tablist">
                            @foreach(\App\Models\ProductExport::LOCALES as $code => $label)
                                @php $t = $productExport->translations->firstWhere('locale', $code); @endphp
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
                            @foreach(\App\Models\ProductExport::LOCALES as $code => $label)
                                @php $t = $productExport->translations->firstWhere('locale', $code); @endphp
                                <div class="tab-pane fade @if($loop->first) show active @endif"
                                     id="show-{{ $code }}">
                                    @if($t)
                                        <h4>{{ $t->name }}</h4>
                                        @if($t->short_description)
                                            <p class="text-muted">{{ $t->short_description }}</p>
                                        @endif
                                        @if($t->description)
                                            <p><strong>توضیحات:</strong></p>
                                            <p style="white-space: pre-wrap;">{{ $t->description }}</p>
                                        @endif
                                        @if($t->features)
                                            <p><strong>ویژگی‌ها:</strong></p>
                                            <p style="white-space: pre-wrap;">{{ $t->features }}</p>
                                        @endif
                                        @if($t->packaging_description)
                                            <p><strong>بسته‌بندی:</strong></p>
                                            <p style="white-space: pre-wrap;">{{ $t->packaging_description }}</p>
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

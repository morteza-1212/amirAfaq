@extends('panelAdmin.layouts.panel')

@section('title', 'مشاهده دسته‌بندی')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-eye me-2"></i>
                {{ $category->name ?? 'دسته‌بندی' }}
            </h1>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.category.edit', $category) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-1"></i> ویرایش
                </a>
                <a href="{{ route('admin.category.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-right me-1"></i> بازگشت
                </a>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header"><strong>تصویر</strong></div>
                    <div class="card-body text-center">
                        @if($category->image)
                            <img src="{{ $category->image_url }}" class="img-fluid rounded">
                        @else
                            <p class="text-muted">تصویری وجود ندارد.</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><strong>اطلاعات</strong></div>
                    <div class="card-body">
                        <dl class="row mb-0">
                            <dt class="col-sm-4">کد:</dt>
                            <dd class="col-sm-8"><code>{{ $category->code }}</code></dd>

                            <dt class="col-sm-4">گروه محصول:</dt>
                            <dd class="col-sm-8">{{ $category->productGroup?->name ?? '—' }}</dd>

                            <dt class="col-sm-4">دسته والد:</dt>
                            <dd class="col-sm-8">{{ $category->parent?->name ?? 'بدون والد' }}</dd>

                            <dt class="col-sm-4">آیکون:</dt>
                            <dd class="col-sm-8">
                                @if($category->icon)
                                    <i class="fas {{ $category->icon }}"></i>
                                    <code>{{ $category->icon }}</code>
                                @else
                                    —
                                @endif
                            </dd>

                            <dt class="col-sm-4">ترتیب:</dt>
                            <dd class="col-sm-8">{{ $category->sort_order }}</dd>

                            <dt class="col-sm-4">وضعیت:</dt>
                            <dd class="col-sm-8">
                                @if($category->status)
                                    <span class="badge bg-success">فعال</span>
                                @else
                                    <span class="badge bg-secondary">غیرفعال</span>
                                @endif
                                @if($category->is_featured)
                                    <span class="badge bg-warning text-dark">
                                        <i class="fas fa-star"></i> ویژه
                                    </span>
                                @endif
                            </dd>

                            <dt class="col-sm-4">تاریخ ایجاد:</dt>
                            <dd class="col-sm-8">{{ $category->created_at->format('Y/m/d H:i') }}</dd>
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
                            @foreach(\App\Models\Category::LOCALES as $code => $label)
                                @php $t = $category->translations->firstWhere('locale', $code); @endphp
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
                            @foreach(\App\Models\Category::LOCALES as $code => $label)
                                @php $t = $category->translations->firstWhere('locale', $code); @endphp
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

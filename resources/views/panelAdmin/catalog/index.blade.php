@extends('panelAdmin.layouts.panel')

@section('title', 'مدیریت کاتالوگ‌ها')

@section('style')
    <style>
        .stat-card {
            border: none;
            border-radius: 16px;
            color: #fff;
            overflow: hidden;
            position: relative;
            transition: transform .3s ease, box-shadow .3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,.15);
        }
        .stat-card .icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 60px;
            opacity: .25;
        }
        .stat-card.bg-grad-1 { background: linear-gradient(135deg,#667eea,#764ba2); }
        .stat-card.bg-grad-2 { background: linear-gradient(135deg,#11998e,#38ef7d); }
        .stat-card.bg-grad-3 { background: linear-gradient(135deg,#f7971e,#ffd200); }
        .stat-card.bg-grad-4 { background: linear-gradient(135deg,#ee0979,#ff6a00); }

        .table thead th {
            font-weight: 600;
            white-space: nowrap;
            font-size: .9rem;
        }
        .table td { vertical-align: middle; }

        .badge-status {
            padding: 6px 12px;
            border-radius: 50px;
            font-size: .78rem;
            font-weight: 600;
        }

        .action-btn {
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: all .2s ease;
        }
        .action-btn:hover { transform: scale(1.1); }

        .search-box .form-control {
            border-radius: 50px 0 0 50px;
            border-left: none;
        }
        .search-box .btn {
            border-radius: 0 50px 50px 0;
        }

        .empty-state {
            padding: 60px 20px;
            text-align: center;
            color: #9aa0a6;
        }
        .empty-state i { font-size: 80px; opacity: .4; }

        @media (max-width: 768px) {
            .stat-card .icon { font-size: 40px; }
            .table { font-size: .85rem; }
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid py-4" dir="rtl">

        {{-- ===== هدر صفحه ===== --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
            <div>
                <h3 class="mb-1 fw-bold">
                    <i class="bi bi-folder2-open text-primary"></i>
                    مدیریت کاتالوگ‌ها
                </h3>
                <p class="text-muted mb-0 small">مدیریت، ویرایش و حذف کاتالوگ‌های سایت</p>
            </div>

            <a href="{{ route('admin.catalog.create') }}" class="btn btn-primary px-4 py-2 shadow-sm">
                <i class="bi bi-plus-circle me-1"></i>
                افزودن کاتالوگ جدید
            </a>
        </div>

        {{-- ===== پیام موفقیت ===== --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- ===== کارت‌های آماری ===== --}}
        <div class="row g-3 mb-4">
            <div class="col-6 col-lg-3">
                <div class="card stat-card bg-grad-1 p-3">
                    <div class="card-body p-2">
                        <h6 class="mb-1 opacity-75">کل کاتالوگ‌ها</h6>
                        <h2 class="mb-0 fw-bold">{{ $stats['total'] ?? 0 }}</h2>
                    </div>
                    <i class="bi bi-collection icon"></i>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="card stat-card bg-grad-2 p-3">
                    <div class="card-body p-2">
                        <h6 class="mb-1 opacity-75">فعال</h6>
                        <h2 class="mb-0 fw-bold">{{ $stats['active'] ?? 0 }}</h2>
                    </div>
                    <i class="bi bi-check-circle icon"></i>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="card stat-card bg-grad-3 p-3">
                    <div class="card-body p-2">
                        <h6 class="mb-1 opacity-75">غیرفعال</h6>
                        <h2 class="mb-0 fw-bold">{{ $stats['inactive'] ?? 0 }}</h2>
                    </div>
                    <i class="bi bi-x-circle icon"></i>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="card stat-card bg-grad-4 p-3">
                    <div class="card-body p-2">
                        <h6 class="mb-1 opacity-75">امروز</h6>
                        <h2 class="mb-0 fw-bold">{{ $stats['today'] ?? 0 }}</h2>
                    </div>
                    <i class="bi bi-calendar-check icon"></i>
                </div>
            </div>
        </div>

        {{-- ===== نوار جستجو و فیلتر ===== --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.catalog.index') }}" class="row g-3 align-items-center">
                    <div class="col-md-5">
                        <div class="input-group search-box">
                            <input type="text" name="search" class="form-control"
                                   placeholder="جستجو بر اساس اسلاگ..."
                                   value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <select name="status" class="form-select" onchange="this.form.submit()">
                            <option value="">همه وضعیت‌ها</option>
                            <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>فعال</option>
                            <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>غیرفعال</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <select name="sort" class="form-select" onchange="this.form.submit()">
                            <option value="">مرتب‌سازی پیش‌فرض</option>
                            <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>جدیدترین</option>
                            <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>قدیمی‌ترین</option>
                            <option value="order"  {{ request('sort') === 'order'  ? 'selected' : '' }}>ترتیب نمایش</option>
                        </select>
                    </div>

                    <div class="col-md-2 text-end">
                        @if(request()->hasAny(['search','status','sort']))
                            <a href="{{ route('admin.catalog.index') }}" class="btn btn-outline-secondary w-100">
                                <i class="bi bi-x-circle"></i> پاک کردن فیلتر
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        {{-- ===== جدول کاتالوگ‌ها ===== --}}
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 text-center">
                        <thead class="table-light">
                        <tr>
                            <th width="60">#</th>
                            <th>اسلاگ</th>
                            <th width="120">وضعیت</th>
                            <th width="100">ترتیب</th>
                            <th width="150">تاریخ ایجاد</th>
                            <th width="220">عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($catalogs as $catalog)
                            <tr>
                                <td class="fw-bold text-muted">
                                    {{ $loop->iteration + ($catalogs->currentPage() - 1) * $catalogs->perPage() }}
                                </td>

                                <td class="text-start">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-folder-fill text-warning"></i>
                                        <span class="fw-semibold">{{ $catalog->slug }}</span>
                                    </div>
                                </td>

                                <td>
                                    <form action="{{ route('admin.catalog.toggle-status', $catalog) }}"
                                          method="POST" class="d-inline">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn p-0 border-0 bg-transparent">
                                            <span class="badge-status
                                                {{ $catalog->is_active ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">
                                                <i class="bi {{ $catalog->is_active ? 'bi-check-circle-fill' : 'bi-x-circle-fill' }}"></i>
                                                {{ $catalog->status_label }}
                                            </span>
                                        </button>
                                    </form>
                                </td>

                                <td>
                                    <span class="badge bg-light text-dark border">
                                        {{ $catalog->sort_order }}
                                    </span>
                                </td>

                                <td class="text-muted small">
                                    {{ $catalog->created_at->format('Y/m/d') }}
                                    <br>
                                    <span class="text-secondary">{{ $catalog->created_at->format('H:i') }}</span>
                                </td>

                                <td>
                                    <div class="action-group">
                                        {{-- ویرایش --}}
                                        <a href="{{ route('admin.catalog.edit', $catalog) }}"
                                           class="action-btn btn-edit"
                                           title="ویرایش"
                                           data-bs-toggle="tooltip">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>

                                        {{-- ترجمه --}}
                                        <a href="{{ route('admin.catalog.translation.index', $catalog) }}"
                                           class="action-btn btn-translate"
                                           title="ترجمه"
                                           data-bs-toggle="tooltip">
                                            <i class="bi bi-translate"></i>
                                        </a>
                                        {{-- حذف --}}
                                        <form action="{{ route('admin.catalog.destroy', $catalog) }}"
                                              method="POST"
                                              class="d-inline m-0"
                                              onsubmit="return confirm('آیا از حذف کاتالوگ «{{ $catalog->slug }}» مطمئن هستید؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="action-btn btn-delete"
                                                    title="حذف"
                                                    data-bs-toggle="tooltip">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <i class="bi bi-inbox"></i>
                                        <h5 class="mt-3">هیچ کاتالوگی یافت نشد</h5>
                                        <p class="mb-3">برای شروع، اولین کاتالوگ خود را ایجاد کنید.</p>
                                        <a href="{{ route('admin.catalog.create') }}" class="btn btn-primary">
                                            <i class="bi bi-plus-circle"></i> افزودن کاتالوگ
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- ===== صفحه‌بندی ===== --}}
            @if($catalogs->hasPages())
                <div class="card-footer bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <small class="text-muted">
                            نمایش {{ $catalogs->firstItem() }} تا {{ $catalogs->lastItem() }}
                            از {{ $catalogs->total() }} مورد
                        </small>
                        {{ $catalogs->withQueryString()->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- ===== مودال حذف ===== --}}
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        تأیید حذف
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <i class="bi bi-trash-fill text-danger" style="font-size: 60px;"></i>
                    <p class="mt-3 mb-1">آیا از حذف کاتالوگ زیر مطمئن هستید؟</p>
                    <h6 class="text-danger fw-bold" id="deleteSlug"></h6>
                    <small class="text-muted">این عملیات قابل بازگشت نیست.</small>
                </div>
                <div class="modal-footer justify-content-center border-0">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">انصراف</button>
                    <form id="deleteForm" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger px-4">
                            <i class="bi bi-trash"></i> حذف کن
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // پر کردن مودال حذف با داده‌های ردیف انتخاب‌شده
        document.addEventListener('DOMContentLoaded', function () {
            const deleteModal = document.getElementById('deleteModal');
            deleteModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const slug   = button.getAttribute('data-slug');
                const url    = button.getAttribute('data-url');

                document.getElementById('deleteSlug').textContent = slug;
                document.getElementById('deleteForm').setAttribute('action', url);
            });
        });
    </script>
@endsection

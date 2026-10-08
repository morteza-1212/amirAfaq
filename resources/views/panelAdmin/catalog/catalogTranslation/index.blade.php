@extends('panelAdmin.layouts.panel')

@section('content')

    <div class="container">

        {{-- هدر صفحه --}}
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h4 class="mb-1">
                    مدیریت ترجمه‌های کاتالوگ
                </h4>

                <small class="text-muted">
                    {{ $catalog->title }}
                </small>
            </div>

            <a href="{{ route('admin.catalog.translation.create', $catalog) }}"
               class="btn btn-primary">
                <i class="fas fa-plus"></i>
                افزودن ترجمه جدید
            </a>

        </div>


        {{-- پیام موفقیت --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-1"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif


        {{-- پیام خطا --}}
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle me-1"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif


        {{-- خطاهای اعتبارسنجی --}}
        @if($errors->any())
            <div class="alert alert-danger">
                <strong>خطا در اطلاعات وارد شده:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        {{-- جدول ترجمه‌ها --}}
        <div class="card shadow-sm border-0">

            <div class="card-header bg-white">
                <strong>
                    <i class="fas fa-language text-primary me-1"></i>
                    لیست ترجمه‌ها
                </strong>
            </div>


            <div class="card-body p-0">

                @if($translations->count())

                    <div class="table-responsive">

                        <table class="table table-bordered table-hover align-middle mb-0 text-center">

                            <thead class="table-light">
                            <tr>
                                <th style="width: 60px;">#</th>
                                <th>زبان</th>
                                <th>عنوان</th>
                                <th>فایل</th>
                                <th>حجم فایل</th>
                                <th style="width: 220px;">عملیات</th>
                            </tr>
                            </thead>


                            <tbody>

                            @foreach($translations as $translation)

                                <tr>

                                    {{-- شناسه --}}
                                    <td class="fw-bold text-muted">
                                        {{ $translation->id }}
                                    </td>


                                    {{-- زبان --}}
                                    <td>
                                        @if($translation->locale === 'fa')
                                            <span class="badge bg-primary">فارسی</span>
                                        @elseif($translation->locale === 'en')
                                            <span class="badge bg-success">English</span>
                                        @elseif($translation->locale === 'ar')
                                            <span class="badge bg-warning text-dark">العربية</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $translation->locale }}</span>
                                        @endif
                                    </td>


                                    {{-- عنوان --}}
                                    <td class="text-start">
                                        <strong>{{ $translation->title }}</strong>

                                        @if($translation->description)
                                            <div class="text-muted small mt-1">
                                                {{ Str::limit($translation->description, 100) }}
                                            </div>
                                        @endif
                                    </td>


                                    {{-- فایل --}}
                                    <td>
                                        @if($translation->file_path)
                                            <span class="text-success">
                                                <i class="fas fa-file-pdf"></i>
                                                {{ $translation->file_name }}
                                            </span>
                                        @else
                                            <span class="text-muted">فایلی ثبت نشده</span>
                                        @endif
                                    </td>


                                    {{-- حجم فایل --}}
                                    <td>
                                        @if($translation->file_size)
                                            {{ number_format($translation->file_size / 1024 / 1024, 2) }} MB
                                        @else
                                            -
                                        @endif
                                    </td>


                                    {{-- عملیات --}}
                                    <td>
                                        <div class="d-flex justify-content-center gap-1">

                                            {{-- ویرایش --}}
                                            <a href="{{ route('admin.catalog.translation.edit', [
        'catalog'     => $catalog,        {{-- ← مدل، نه id --}}
        'translation' => $translation,    {{-- ← مدل، نه id --}}
    ]) }}"
                                               class="btn btn-sm btn-warning text-white"
                                               title="ویرایش">
                                                <i class="fas fa-edit"></i>
                                                ویرایش
                                            </a>


                                            {{-- مشاهده فایل --}}
                                            @if($translation->file_path)
                                                <a href="{{ asset('storage/' . $translation->file_path) }}"
                                                   target="_blank"
                                                   class="btn btn-sm btn-info text-white"
                                                   title="مشاهده فایل">
                                                    <i class="fas fa-file-pdf"></i>
                                                </a>
                                            @endif


                                            {{-- حذف --}}
                                            <form action="{{ route('admin.catalog.translation.delete', [
        'catalog'     => $catalog,        {{-- ← خود مدل --}}
        'translation' => $translation,    {{-- ← خود مدل --}}
    ]) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('آیا از حذف این ترجمه مطمئن هستید؟ این عملیات قابل بازگشت نیست.');">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-sm btn-danger" title="حذف">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>

                                </tr>

                            @endforeach

                            </tbody>

                        </table>

                    </div>

                @else

                    {{-- حالت خالی --}}
                    <div class="text-center py-5">

                        <div class="mb-3">
                            <i class="fas fa-language fa-3x text-muted"></i>
                        </div>

                        <h5>هیچ ترجمه‌ای ثبت نشده است</h5>

                        <p class="text-muted">
                            برای این کاتالوگ هنوز هیچ ترجمه‌ای اضافه نکرده‌اید.
                            با کلیک روی دکمه زیر اولین ترجمه را ایجاد کنید.
                        </p>

                        <a href="{{ route('admin.catalog.translation.create', $catalog) }}"
                           class="btn btn-primary">
                            <i class="fas fa-plus"></i>
                            افزودن ترجمه جدید
                        </a>

                    </div>

                @endif

            </div>

        </div>

    </div>

@endsection

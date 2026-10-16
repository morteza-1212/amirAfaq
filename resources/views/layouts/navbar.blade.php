{{-- Admin Menu --}}
@auth
    @if(auth()->user()->role === 'admin')

        <div class="nav-item dropdown">
            <a href="#"
               class="nav-link dropdown-toggle"
               id="adminDropdown"
               role="button"
               data-bs-toggle="dropdown"
               aria-expanded="false">

                <i class="fas fa-user-shield me-1"></i>
                پنل مدیریت
            </a>

            <div class="dropdown-menu" aria-labelledby="adminDropdown">

                {{-- داشبورد --}}
                <a href="{{ route('view.panel') }}"
                   class="dropdown-item">
                    <i class="fas fa-tachometer-alt me-2"></i>
                    داشبورد مدیریت
                </a>

                {{-- گروه محصولات --}}
                <a href="{{ route('admin.productGroup.index') }}"
                   class="dropdown-item">
                    <i class="fas fa-layer-group me-2"></i>
                    گروه‌های محصولات
                </a>

                {{-- دسته‌بندی‌ها --}}
                <a href="{{ route('admin.category.index') }}"
                   class="dropdown-item">
                    <i class="fas fa-list me-2"></i>
                    دسته‌بندی‌ها
                </a>

                {{-- محصولات --}}
                <a href="{{ route('admin.product.index') }}"
                   class="dropdown-item">
                    <i class="fas fa-box me-2"></i>
                    محصولات
                </a>

                {{-- کاتالوگ‌ها --}}
                <a href="{{ route('admin.catalog.index') }}"
                   class="dropdown-item">
                    <i class="fas fa-book me-2"></i>
                    کاتالوگ‌ها
                </a>

                {{-- گالری --}}
                <a href="{{ route('admin.gallery.index') }}"
                   class="dropdown-item">
                    <i class="fas fa-images me-2"></i>
                    گالری تصاویر
                </a>

                {{-- معاملات تجاری --}}
                <a href="{{ route('admin.trade-transaction.index') }}"
                   class="dropdown-item">
                    <i class="fas fa-exchange-alt me-2"></i>
                    معاملات تجاری
                </a>

                {{-- درخواست‌های خریداران --}}
                <a href="{{ route('admin.buyer.index') }}"
                   class="dropdown-item">
                    <i class="fas fa-users me-2"></i>
                    درخواست‌های خریداران
                </a>

                {{-- پیام‌های تماس --}}
                <a href="{{ route('admin.contact.index') }}"
                   class="dropdown-item">
                    <i class="fas fa-envelope me-2"></i>
                    پیام‌های تماس
                </a>

                {{-- مدیریت سوالات متداول --}}
                <a href="{{ route('admin.chatbot.faqs.index') }}"
                   class="dropdown-item">
                    <i class="fas fa-question-circle me-2"></i>
                    مدیریت سوالات متداول
                </a>

                {{-- پشتیبانی --}}
                <a href="{{ route('admin.support.index') }}"
                   class="dropdown-item">
                    <i class="fas fa-headset me-2"></i>
                    پشتیبانی کاربران
                </a>

                {{-- چت اپراتورها --}}
                <a href="{{ route('admin.chat.index') }}"
                   class="dropdown-item">
                    <i class="fas fa-comments me-2"></i>
                    مدیریت چت اپراتورها
                </a>

            </div>
        </div>

    @endif
@endauth

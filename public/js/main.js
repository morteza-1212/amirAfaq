(function ($) {
    "use strict";

    // =========================================================
    // تشخیص جهت صفحه
    // =========================================================
    var isRtl = $('html').attr('dir') === 'rtl' ||
        document.documentElement.dir === 'rtl';


    // =========================================================
    // Spinner — مخفی‌سازی سریع (بدون وابستگی به load)
    // =========================================================
    function hideSpinner() {
        var $spinner = $('#spinner');
        if ($spinner.length > 0) {
            $spinner.removeClass('show').addClass('hide');
            setTimeout(function () {
                $spinner.remove();
            }, 400);
        }
    }

    // اجرا بلافاصله پس از DOM Ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', hideSpinner);
    } else {
        hideSpinner();
    }

    // fallback: هرگز بیشتر از 2.5 ثانیه نمایش داده نشود
    setTimeout(hideSpinner, 2500);


    // =========================================================
    // Initiate WOW.js (safe check)
    // =========================================================
    if (typeof WOW !== 'undefined') {
        new WOW({
            boxClass: 'wow',
            animateClass: 'animated',
            offset: 0,
            mobile: true,
            live: true
        }).init();
    }


    // =========================================================
    // Sticky Navbar — با throttle برای کاهش reflow
    // =========================================================
    var lastScrollY = 0;
    var ticking = false;

    function onScrollSticky() {
        var y = window.pageYOffset || document.documentElement.scrollTop;

        if (y > 300) {
            $('.sticky-top').css('top', '0px');
        } else {
            $('.sticky-top').css('top', '-100px');
        }
        lastScrollY = y;
        ticking = false;
    }

    window.addEventListener('scroll', function () {
        if (!ticking) {
            window.requestAnimationFrame(onScrollSticky);
            ticking = true;
        }
    }, { passive: true });


    // =========================================================
    // Dropdown on mouse hover (دسکتاپ)
    // =========================================================
    var $dropdown = $('.dropdown');
    var $dropdownToggle = $('.dropdown-toggle');
    var $dropdownMenu = $('.dropdown-menu');
    var showClass = 'show';

    function bindDropdownHover() {
        if (window.matchMedia('(min-width: 992px)').matches) {
            $dropdown.off('mouseenter mouseleave').hover(
                function () {
                    var $this = $(this);
                    $this.addClass(showClass);
                    $this.find($dropdownToggle).attr('aria-expanded', 'true');
                    $this.find($dropdownMenu).addClass(showClass);
                },
                function () {
                    var $this = $(this);
                    $this.removeClass(showClass);
                    $this.find($dropdownToggle).attr('aria-expanded', 'false');
                    $this.find($dropdownMenu).removeClass(showClass);
                }
            );
        } else {
            $dropdown.off('mouseenter mouseleave');
        }
    }

    // فقط یک بار با debounce
    var resizeTimer;
    window.addEventListener('resize', function () {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(bindDropdownHover, 200);
    });

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', bindDropdownHover);
    } else {
        bindDropdownHover();
    }


    // =========================================================
    // Back to top button — با throttle
    // =========================================================
    var backToTopTicking = false;

    function onScrollBackToTop() {
        var y = window.pageYOffset || document.documentElement.scrollTop;

        if (y > 300) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
        backToTopTicking = false;
    }

    window.addEventListener('scroll', function () {
        if (!backToTopTicking) {
            window.requestAnimationFrame(onScrollBackToTop);
            backToTopTicking = true;
        }
    }, { passive: true });

    $(document).on('click', '.back-to-top', function (e) {
        e.preventDefault();
        $('html, body').animate({ scrollTop: 0 }, 1500, 'easeInOutExpo');
        return false;
    });


    // =========================================================
    // Header carousel
    // =========================================================
    var $headerCarousel = $('.header-carousel');
    if ($headerCarousel.length && $.fn.owlCarousel) {
        $headerCarousel.owlCarousel({
            animateOut: 'fadeOut',
            animateIn: 'fadeIn',
            items: 1,
            smartSpeed: 1000,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            loop: true,
            dots: false,
            nav: true,
            rtl: isRtl,
            navText: [
                '<i class="fas fa-chevron-right"></i>',
                '<i class="fas fa-chevron-left"></i>'
            ],
            responsive: {
                0:    { items: 1 },
                768:  { items: 1 },
                1200: { items: 1 }
            }
        });
    }


    // =========================================================
    // Testimonials carousel
    // =========================================================
    var $testimonialCarousel = $('.testimonial-carousel');
    if ($testimonialCarousel.length && $.fn.owlCarousel) {
        $testimonialCarousel.owlCarousel({
            autoplay: true,
            smartSpeed: 1500,
            dots: true,
            loop: true,
            rtl: isRtl,
            items: 1
        });
    }


    // =========================================================
    // Related Product carousel
    // =========================================================
    var $relatedCarousel = $('.related-carousel');
    if ($relatedCarousel.length && $.fn.owlCarousel) {
        $relatedCarousel.owlCarousel({
            autoplay: true,
            smartSpeed: 1000,
            margin: 30,
            dots: false,
            loop: true,
            rtl: isRtl,
            nav: true,
            navText: [
                '<i class="fas fa-chevron-right"></i>',
                '<i class="fas fa-chevron-left"></i>'
            ],
            responsive: {
                0:   { items: 1 },
                576: { items: 2 },
                992: { items: 3 }
            }
        });
    }


    // =========================================================
    // Facts counter
    // =========================================================
    var $counters = $('[data-toggle="counter-up"]');
    if ($counters.length && $.fn.counterUp) {
        $counters.counterUp({
            delay: 10,
            time: 2000
        });
    }


    // =========================================================
    // اصلاح آیکون‌های back-to-top در RTL
    // =========================================================
    if (isRtl) {
        $('.back-to-top i').removeClass('fa-arrow-up').addClass('fa-arrow-up');
    }

})(jQuery);

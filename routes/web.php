<?php

<<<<<<< HEAD
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\LocalController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BlogController;
=======
use App\Http\Controllers\AgentChatController;
>>>>>>> a96f8e3 (complateforCartshoping)
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\Cart\CheckoutController;
use App\Http\Controllers\Cart\PaymentController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\ChatController;
<<<<<<< HEAD
use App\Http\Controllers\AgentChatController;
use App\Http\Controllers\Shop\ParentCategoryController;
use App\Http\Controllers\Shop\CategoryShopController;
use App\Http\Controllers\Shop\ProductShopController;
use App\Http\Controllers\Shop\ProductShopImageController;
use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\Cart\CheckoutController;
use App\Http\Controllers\Shop\PaymentController;
use App\Http\Controllers\Product\ProductViewController;
use App\Http\Controllers\panelAdmin\ProductGroupController;
use App\Http\Controllers\panelAdmin\ProductGroupTranslationController;
use App\Http\Controllers\panelAdmin\CategoryController;
use App\Http\Controllers\panelAdmin\CategoryTranslationController;
use App\Http\Controllers\panelAdmin\ProductController;
use App\Http\Controllers\panelAdmin\ProductTranlationController;
=======
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocalController;
>>>>>>> a96f8e3 (complateforCartshoping)
use App\Http\Controllers\panelAdmin\CatalogController;
use App\Http\Controllers\panelAdmin\CatalogTranslationController;
use App\Http\Controllers\panelAdmin\CategoryController;
use App\Http\Controllers\panelAdmin\CategoryTranslationController;
use App\Http\Controllers\panelAdmin\ContactController;
use App\Http\Controllers\panelAdmin\FaqController;
use App\Http\Controllers\panelAdmin\GalleryController;
use App\Http\Controllers\panelAdmin\GalleryTranslationController;
use App\Http\Controllers\panelAdmin\DashboardPanelController;
use App\Http\Controllers\panelAdmin\OrderPanelController;
use App\Http\Controllers\panelAdmin\PaymentPanelController;

use App\Http\Controllers\panelAdmin\ProductController;
use App\Http\Controllers\panelAdmin\ProductExportController;
use App\Http\Controllers\panelAdmin\ProductGroupController;
use App\Http\Controllers\panelAdmin\ProductGroupTranslationController;
use App\Http\Controllers\panelAdmin\ProductTranlationController;
use App\Http\Controllers\panelAdmin\SupportController;
use App\Http\Controllers\panelAdmin\TradeTransactionController;
use App\Http\Controllers\Product\ProductViewController;
use App\Http\Controllers\Shop\CategoryShopController;
use App\Http\Controllers\Shop\ParentCategoryController;
use App\Http\Controllers\Shop\ProductShopController;
use App\Http\Controllers\Shop\ProductShopImageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Helpers
|--------------------------------------------------------------------------
*/

if (! function_exists('resolveLocale')) {
    function resolveLocale(): string
    {
        $locale = session('locale', config('app.locale', 'fa'));

        return in_array($locale, ['fa', 'en', 'ar'], true) ? $locale : 'fa';
    }
}


/*
|--------------------------------------------------------------------------
| Helpers
|--------------------------------------------------------------------------
*/

if (! function_exists('resolveLocale')) {
    function resolveLocale(): string
    {
        $locale = session('locale', config('app.locale', 'fa'));

        return in_array($locale, ['fa', 'en', 'ar'], true) ? $locale : 'fa';
    }
}


/*
|--------------------------------------------------------------------------
| Root
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('home', ['locale' => resolveLocale()]);
});


/*
|--------------------------------------------------------------------------
| Language Switch
|--------------------------------------------------------------------------
*/

Route::get('/lang/{locale}', [LocalController::class, 'switch'])
    ->whereIn('locale', ['fa', 'en', 'ar'])
    ->name('locale.switch');


/*
|--------------------------------------------------------------------------
| Legacy redirects: /products*  →  /{locale}/products*
|--------------------------------------------------------------------------
| این دو مسیر بیرون از گروه {locale} هستند تا اگر کاربر آدرس قدیمی
| (بدون پیشوند زبان) را باز کند، خودکار به نسخه چندزبانه هدایت شود.
|--------------------------------------------------------------------------
*/

Route::get('/products', function () {
    return redirect()->route('products.index', ['locale' => resolveLocale()]);
})->name('products.redirect');

Route::get('/products/{slug}', function (string $slug) {
    return redirect()->route('products.show', [
        'locale' => resolveLocale(),
        'slug'   => $slug,
    ]);
})->name('products.show.redirect');


/*
|--------------------------------------------------------------------------
| Localized Routes
|--------------------------------------------------------------------------
*/

Route::prefix('{locale}')
    ->whereIn('locale', ['fa', 'en', 'ar'])
    ->middleware('setLocale')
    ->group(function () {

        // Home
        Route::get('/', [HomeController::class, 'index'])->name('home');

        // Authentication
        Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
        Route::post('/register', [AuthController::class, 'register'])->name('register.store');

        Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.store');

        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        // Public Pages
        Route::get('/about', [HomeController::class, 'AbouteUs'])->name('about');
        Route::get('/export', [HomeController::class, 'export'])->name('export');
        Route::get('/import', [HomeController::class, 'import'])->name('import');
        Route::get('/logistics', [HomeController::class, 'logistics'])->name('logistics');
        Route::get('/markets', [HomeController::class, 'markets'])->name('markets');
        Route::get('/suppliers', [HomeController::class, 'suppliers'])->name('suppliers');
        Route::get('/buyer', [HomeController::class, 'buyer'])->name('buyer');
        Route::post('/buyer', [HomeController::class, 'store'])->name('buyer.store');
        Route::get('/catalogs', [HomeController::class, 'catalogs'])->name('catalogs');
        Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
        Route::post('/contact', [HomeController::class, 'storeContact'])->name('contact.store');
        Route::get('/product-export', [HomeController::class, 'productExport'])->name('productExport');
        Route::get('/product-export/{productExport}', [HomeController::class, 'productExportShow'])
            ->name('productExport.show');
        Route::get('/gallery', [HomeController::class, 'gallery'])->name('gallery');
        Route::get('/projects', [HomeController::class, 'trads'])->name('trad');
        Route::get('/services', [HomeController::class, 'services'])->name('services');

        // Blog
        Route::get('/blog/export', [BlogController::class, 'export'])->name('blog.export');
        Route::get('/blog/import', [BlogController::class, 'import'])->name('blog.import');
        Route::get('/blog/markets', [BlogController::class, 'markets'])->name('blog.markets');

        // Chatbot
        Route::prefix('chatbot')->name('chatbot.')->middleware('throttle:30,1')->group(function () {
            Route::post('/start', [ChatbotController::class, 'start'])->name('start');
            Route::post('/send', [ChatbotController::class, 'send'])->name('send');
            Route::get('/messages', [ChatbotController::class, 'messages'])->name('messages');
        });

        // ✅ محصولات (فقط یک تعریف — داخل گروه {locale})
        Route::prefix('products')->middleware('throttle:120,1')->group(function () {
            Route::get('/',              [ProductViewController::class, 'index'])->name('products.index');
            Route::get('/featured',      [ProductViewController::class, 'featured'])->name('products.featured');
            Route::get('/{slug}',        [ProductViewController::class, 'show'])->name('products.show');
            Route::get('/{slug}/related',[ProductViewController::class, 'related'])->name('products.related');
        });

        /*
        |--------------------------------------------------------------------------
        | Alternative Chat Routes
        |--------------------------------------------------------------------------
        | NOTE: Route names changed from `chat.message` / `chat.messages`
        | to `chat.public.send` / `chat.public.messages` to avoid conflict
        | with the `chat.messages` route defined in the admin panel section.
        |--------------------------------------------------------------------------
        */
        Route::prefix('chat')->name('chat.public.')->middleware('throttle:30,1')->group(function () {
            Route::post('/message', [ChatbotController::class, 'send'])->name('send');
            Route::get('/messages', [ChatbotController::class, 'messages'])->name('messages');
        });
    });


/*
|--------------------------------------------------------------------------
| Admin Panel
|--------------------------------------------------------------------------
*/

Route::prefix('panelAdmin')->middleware(['admin'])->group(function () {

    // Admin Dashboard
    Route::get('/', [CatalogController::class, 'Admin'])->name('view.panel');


    /*
    |--------------------------------------------------------------------------
    | Product Groups
    |--------------------------------------------------------------------------
    */

    Route::prefix('productGroup')->group(function () {
        Route::get('/', [ProductGroupController::class, 'index'])->name('admin.productGroup.index');
        Route::get('/create', [ProductGroupController::class, 'create'])->name('admin.productGroup.create');
        Route::post('/create', [ProductGroupController::class, 'store'])->name('admin.productGroup.store');
        Route::get('/show/{productGroup}', [ProductGroupController::class, 'show'])->name('admin.productGroup.show');
        Route::get('/edit/{productGroup}', [ProductGroupController::class, 'edit'])->name('admin.productGroup.edit');
        Route::put('/update/{productGroup}', [ProductGroupController::class, 'update'])->name('admin.productGroup.update');
        Route::delete('/delete/{productGroup}', [ProductGroupController::class, 'destroy'])->name('admin.productGroup.delete');

        Route::prefix('productGroupTranslation')->group(function () {
            Route::get('/{productGroup}/translations', [ProductGroupTranslationController::class, 'index'])->name('admin.productGroup.translations.index');
            Route::get('/{productGroup}/translations/create', [ProductGroupTranslationController::class, 'create'])->name('admin.productGroup.translations.create');
            Route::post('/{productGroup}/translations/create', [ProductGroupTranslationController::class, 'store'])->name('admin.productGroup.translations.store');
            Route::get('/{productGroup}/translations/{translation}', [ProductGroupTranslationController::class, 'show'])->name('admin.productGroup.translations.show');
            Route::get('/{productGroup}/translations/{translation}/edit', [ProductGroupTranslationController::class, 'edit'])->name('admin.productGroup.translations.edit');
            Route::put('/{productGroup}/translations/{translation}/update', [ProductGroupTranslationController::class, 'update'])->name('admin.productGroup.translations.update');
            Route::delete('/{productGroup}/translations/{translation}/delete', [ProductGroupTranslationController::class, 'destroy'])->name('admin.productGroup.translations.delete');
        });
    });


    /*
    |--------------------------------------------------------------------------
    | Contacts
    |--------------------------------------------------------------------------
    */

    Route::prefix('contact')->group(function () {
        Route::get('/', [ContactController::class, 'index'])->name('admin.contact.index');
        Route::get('/show/{contact}', [ContactController::class, 'show'])->name('admin.contact.show');
        Route::get('/edit/{contact}', [ContactController::class, 'edit'])->name('admin.contact.edit');
        Route::put('/update/{contact}', [ContactController::class, 'update'])->name('admin.contact.update');
        Route::delete('/delete/{contact}', [ContactController::class, 'destroy'])->name('admin.contact.delete');
    });


    /*
    |--------------------------------------------------------------------------
    | Categories
    |--------------------------------------------------------------------------
    */

    Route::prefix('category')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('admin.category.index');
        Route::get('/create', [CategoryController::class, 'create'])->name('admin.category.create');
        Route::post('/create', [CategoryController::class, 'store'])->name('admin.category.store');
        Route::get('/show/{category}', [CategoryController::class, 'show'])->name('admin.category.show');
        Route::get('/edit/{category}', [CategoryController::class, 'edit'])->name('admin.category.edit');
        Route::put('/update/{category}', [CategoryController::class, 'update'])->name('admin.category.update');
        Route::delete('/delete/{category}', [CategoryController::class, 'destroy'])->name('admin.category.delete');

        Route::prefix('categoryTranslation')->group(function () {
            Route::get('/', [CategoryTranslationController::class, 'index'])->name('admin.category.translation.index');
            Route::get('/create', [CategoryTranslationController::class, 'create'])->name('admin.category.translation.create');
            Route::post('/create', [CategoryTranslationController::class, 'store'])->name('admin.category.translation.store');
            Route::get('/edit/{categoryTranslation}', [CategoryTranslationController::class, 'edit'])->name('admin.category.translation.edit');
            Route::put('/update/{categoryTranslation}', [CategoryTranslationController::class, 'update'])->name('admin.category.translation.update');
            Route::delete('/delete/{categoryTranslation}', [CategoryTranslationController::class, 'destroy'])->name('admin.category.translation.delete');
        });
    });


    /*
    |--------------------------------------------------------------------------
    | Products
    |--------------------------------------------------------------------------
    */

    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('admin.product.index');
        Route::get('/create', [ProductController::class, 'create'])->name('admin.product.create');
        Route::post('/create', [ProductController::class, 'store'])->name('admin.product.store');
        Route::get('/show/{product}', [ProductController::class, 'show'])->name('admin.product.show');
        Route::get('/edit/{product}', [ProductController::class, 'edit'])->name('admin.product.edit');
        Route::put('/update/{product}', [ProductController::class, 'update'])->name('admin.product.update');
        Route::delete('/delete/{product}', [ProductController::class, 'destroy'])->name('admin.product.delete');

        Route::prefix('{product}/productTranslation')->group(function () {
            Route::get('/', [ProductTranlationController::class, 'index'])->name('admin.product.translation.index');
            Route::get('/create', [ProductTranlationController::class, 'create'])->name('admin.product.translation.create');
            Route::post('/create', [ProductTranlationController::class, 'store'])->name('admin.product.translation.store');
            Route::get('/edit/{translation}', [ProductTranlationController::class, 'edit'])->name('admin.product.translation.edit');
            Route::put('/update/{translation}', [ProductTranlationController::class, 'update'])->name('admin.product.translation.update');
            Route::delete('/delete/{translation}', [ProductTranlationController::class, 'destroy'])->name('admin.product.translation.delete');
        });
    });


    /*
    |--------------------------------------------------------------------------
    | Catalogs
    |--------------------------------------------------------------------------
    */

    Route::prefix('catalogs')->name('admin.catalog.')->group(function () {
        Route::get('/', [CatalogController::class, 'index'])->name('index');
        Route::get('/create', [CatalogController::class, 'create'])->name('create');
        Route::post('/create', [CatalogController::class, 'store'])->name('store');
        Route::get('/{catalog}', [CatalogController::class, 'show'])->name('show');
        Route::get('/{catalog}/edit', [CatalogController::class, 'edit'])->name('edit');
        Route::put('/{catalog}', [CatalogController::class, 'update'])->name('update');
        Route::delete('/{catalog}', [CatalogController::class, 'destroy'])->name('destroy');
        Route::patch('/{catalog}/toggle-status', [CatalogController::class, 'toggleStatus'])->name('toggle-status');
    });

    Route::prefix('{catalog}/catalogTranslation')->group(function () {
        Route::get('/', [CatalogTranslationController::class, 'index'])->name('admin.catalog.translation.index');
        Route::get('/create', [CatalogTranslationController::class, 'create'])->name('admin.catalog.translation.create');
        Route::post('/create', [CatalogTranslationController::class, 'store'])->name('admin.catalog.translation.store');
        Route::get('/edit/{translation}', [CatalogTranslationController::class, 'edit'])->name('admin.catalog.translation.edit');
        Route::put('/update/{translation}', [CatalogTranslationController::class, 'update'])->name('admin.catalog.translation.update');
        Route::delete('/translations/delete/{translation}', [CatalogTranslationController::class, 'destroy'])->name('admin.catalog.translation.delete');
    });


    /*
    |--------------------------------------------------------------------------
    | Gallery
    |--------------------------------------------------------------------------
    */

    Route::prefix('gallery')->group(function () {
        Route::get('/', [GalleryController::class, 'index'])->name('admin.gallery.index');
        Route::get('/create', [GalleryController::class, 'create'])->name('admin.gallery.create');
        Route::post('/', [GalleryController::class, 'store'])->name('admin.gallery.store');
        Route::get('/{gallery}', [GalleryController::class, 'show'])->name('admin.gallery.show');
        Route::get('/{gallery}/edit', [GalleryController::class, 'edit'])->name('admin.gallery.edit');
        Route::put('/{gallery}', [GalleryController::class, 'update'])->name('admin.gallery.update');
        Route::delete('/{gallery}', [GalleryController::class, 'destroy'])->name('admin.gallery.destroy');

        Route::prefix('{gallery}/translations')->group(function () {
            Route::get('/', [GalleryTranslationController::class, 'index'])->name('admin.gallery.translations.index');
            Route::get('/create', [GalleryTranslationController::class, 'create'])->name('admin.gallery.translations.create');
            Route::post('/', [GalleryTranslationController::class, 'store'])->name('admin.gallery.translations.store');
            Route::get('/{galleryTranslation}', [GalleryTranslationController::class, 'show'])->name('admin.gallery.translations.show');
            Route::get('/{galleryTranslation}/edit', [GalleryTranslationController::class, 'edit'])->name('admin.gallery.translations.edit');
            Route::put('/{galleryTranslation}', [GalleryTranslationController::class, 'update'])->name('admin.gallery.translations.update');
            Route::delete('/{galleryTranslation}', [GalleryTranslationController::class, 'destroy'])->name('admin.gallery.translations.destroy');
        });
    });


    /*
    |--------------------------------------------------------------------------
    | Trade Transactions
    |--------------------------------------------------------------------------
    */

    Route::prefix('tradeTransaction')->group(function () {
        Route::get('/', [TradeTransactionController::class, 'index'])->name('admin.trade-transaction.index');
        Route::get('/create', [TradeTransactionController::class, 'create'])->name('admin.trade-transaction.create');
        Route::post('/create', [TradeTransactionController::class, 'store'])->name('admin.trade-transaction.store');
        Route::get('/edit/{tradeTransaction}', [TradeTransactionController::class, 'edit'])->name('admin.trade-transaction.edit');
        Route::put('/update/{tradeTransaction}', [TradeTransactionController::class, 'update'])->name('admin.trade-transaction.update');
        Route::delete('/delete/{tradeTransaction}', [TradeTransactionController::class, 'destroy'])->name('admin.trade-transaction.delete');
    });


    /*
    |--------------------------------------------------------------------------
    | Buyer Requests
    |--------------------------------------------------------------------------
    */

    Route::prefix('buyer')->group(function () {
        Route::get('/', [BuyerController::class, 'index1'])->name('admin.buyer.index');
        Route::get('/show/{buyer}', [BuyerController::class, 'show'])->name('admin.buyer.show');
        Route::get('/edit/{buyer}', [BuyerController::class, 'edit'])->name('admin.buyer.edit');
        Route::put('/update/{buyer}', [BuyerController::class, 'update'])->name('admin.buyer.update');
        Route::patch('/status/{buyer}', [BuyerController::class, 'updateStatus'])->name('admin.buyer.status');
        Route::delete('/delete/{buyer}', [BuyerController::class, 'destroy'])->name('admin.buyer.delete');
    });


    /*
    |--------------------------------------------------------------------------
    | Human Support Chat
    |--------------------------------------------------------------------------
    */

    Route::prefix('chat')->withoutMiddleware(['auth'])->group(function () {
        Route::post('/start', [ChatController::class, 'start'])->name('chat.start');
        Route::get('/{conversation}/messages', [ChatController::class, 'messages'])->name('chat.messages');
        Route::post('/{conversation}/send', [ChatController::class, 'send'])->name('chat.send');
    });

    Route::middleware(['auth'])->prefix('chat')->group(function () {
        Route::post('/{conversation}/transfer-to-agent', [ChatController::class, 'transferToAgent'])->name('chat.transfer');
        Route::post('/{conversation}/close', [ChatController::class, 'close'])->name('chat.close');
    });

    Route::get('/waiting-list', [AgentChatController::class, 'waitingList'])->name('waiting-list');

    Route::middleware(['auth', \App\Http\Middleware\EnsureIsAgent::class])->prefix('admin/chat')->name('admin.chat.')->group(function () {
        Route::get('/', [AgentChatController::class, 'index'])->name('index');
        Route::get('/waiting-list', [AgentChatController::class, 'waitingList'])->name('waiting-list');
        Route::post('/{conversation}/claim', [AgentChatController::class, 'claim'])->name('claim');
        Route::get('/{conversation}/messages', [AgentChatController::class, 'messages'])->name('messages');
        Route::post('/{conversation}/send', [AgentChatController::class, 'send'])->name('send');
        Route::post('/{conversation}/close', [AgentChatController::class, 'close'])->name('close');
    });


    /*
    |--------------------------------------------------------------------------
    | FAQ Management
    |--------------------------------------------------------------------------
    */

    Route::resource('chatbot/faqs', FaqController::class)->names('admin.chatbot.faqs');


    /*
    |--------------------------------------------------------------------------
    | Support Management
    |--------------------------------------------------------------------------
    */

    Route::prefix('support')->name('admin.support.')->group(function () {
        Route::get('/', [SupportController::class, 'index'])->name('index');
        Route::get('/{conversation}', [SupportController::class, 'chat'])->name('chat');
        Route::get('/{conversation}/messages', [SupportController::class, 'messages'])->name('messages');
        Route::post('/{conversation}/reply', [SupportController::class, 'reply'])->name('reply');
        Route::post('/{conversation}/assign-to-me', [SupportController::class, 'assignToMe'])->name('assign');
        Route::patch('/{conversation}/close', [SupportController::class, 'close'])->name('close');
        Route::patch('/{conversation}/reopen', [SupportController::class, 'reopen'])->name('reopen');
    });


    /*
    |--------------------------------------------------------------------------
    | Product Export
    |--------------------------------------------------------------------------
    */

    Route::prefix('productExport')->group(function () {
        Route::get('/', [ProductExportController::class, 'index'])->name('admin.productExport.index');
        Route::get('/create', [ProductExportController::class, 'create'])->name('admin.productExport.create');
        Route::post('/create', [ProductExportController::class, 'store'])->name('admin.productExport.store');
        Route::get('/show/{productExport}', [ProductExportController::class, 'show'])->name('admin.productExport.show');
        Route::get('/edit/{productExport}', [ProductExportController::class, 'edit'])->name('admin.productExport.edit');
        Route::put('/update/{productExport}', [ProductExportController::class, 'update'])->name('admin.productExport.update');
        Route::delete('/delete/{productExport}', [ProductExportController::class, 'destroy'])->name('admin.productExport.delete');
    });


    /*
    |--------------------------------------------------------------------------
    | Shop Management
    |--------------------------------------------------------------------------
    */

    Route::prefix('shop')->group(function () {

        Route::prefix('parentShop')->group(function () {
            Route::get('/', [ParentCategoryController::class, 'index'])->name('admin.parentShop.index');
            Route::get('/create', [ParentCategoryController::class, 'create'])->name('admin.parentShop.create');
            Route::post('/', [ParentCategoryController::class, 'store'])->name('admin.parentShop.store');
            Route::get('/{parentCategory}/edit', [ParentCategoryController::class, 'edit'])->name('admin.parentShop.edit');
            Route::put('/{parentCategory}', [ParentCategoryController::class, 'update'])->name('admin.parentShop.update');
            Route::delete('/{parentCategory}', [ParentCategoryController::class, 'destroy'])->name('admin.parentShop.destroy');
        });

        Route::prefix('categoryShop')->group(function () {
            Route::get('/', [CategoryShopController::class, 'index'])->name('admin.categoryShop.index');
            Route::get('/create', [CategoryShopController::class, 'create'])->name('admin.categoryShop.create');
            Route::post('/store', [CategoryShopController::class, 'store'])->name('admin.categoryShop.store');
            Route::get('/{categoryShop}/edit', [CategoryShopController::class, 'edit'])->name('admin.categoryShop.edit');
            Route::put('/{categoryShop}', [CategoryShopController::class, 'update'])->name('admin.categoryShop.update');
            Route::delete('/{categoryShop}', [CategoryShopController::class, 'destroy'])->name('admin.categoryShop.destroy');
        });

        Route::prefix('productShop')->group(function () {
            Route::get('/', [ProductShopController::class, 'index'])->name('admin.productShop.index');
            Route::get('/create', [ProductShopController::class, 'create'])->name('admin.productShop.create');
            Route::post('/store', [ProductShopController::class, 'store'])->name('admin.productShop.store');
            Route::get('/{productShop}/edit', [ProductShopController::class, 'edit'])->name('admin.productShop.edit');
            Route::put('/{productShop}', [ProductShopController::class, 'update'])->name('admin.productShop.update');
            Route::delete('/{productShop}', [ProductShopController::class, 'destroy'])->name('admin.productShop.destroy');
        });

        Route::prefix('productShopImage')->group(function () {
            Route::get('/', [ProductShopImageController::class, 'index'])->name('admin.productShopImage.index');
            Route::get('/create', [ProductShopImageController::class, 'create'])->name('admin.productShopImage.create');
            Route::post('/', [ProductShopImageController::class, 'store'])->name('admin.productShopImage.store');
            Route::get('/{productShopImage}/edit', [ProductShopImageController::class, 'edit'])->name('admin.productShopImage.edit');
            Route::put('/{productShopImage}', [ProductShopImageController::class, 'update'])->name('admin.productShopImage.update');
            Route::delete('/{productShopImage}', [ProductShopImageController::class, 'destroy'])->name('admin.productShopImage.destroy');
        });
<<<<<<< HEAD
    });

=======
    });
    Route::get('/dashboard', [DashboardPanelController::class, 'index'])->name('admin.dashboard');

    /*
    |----------------------------------------------------------------------
    | Orders
    |----------------------------------------------------------------------
    */
    Route::prefix('orders')->name('admin.orders.')->group(function () {

        // لیست سفارش‌ها
        Route::get('/', [OrderPanelController::class, 'index'])->name('index');

        // خروجی CSV (باید قبل از /{order} تعریف شود تا با آن تداخل نکند)
        Route::get('/export', [OrderPanelController::class, 'export'])->name('export');

        // سفارش‌های حذف‌شده
        Route::get('/trashed', [OrderPanelController::class, 'trashed'])->name('trashed');

        // نمایش جزئیات سفارش
        Route::get('/{order}', [OrderPanelController::class, 'show'])->name('show');

        // فرم ویرایش
        Route::get('/{order}/edit', [OrderPanelController::class, 'edit'])->name('edit');

        // به‌روزرسانی کامل سفارش
        Route::patch('/{order}', [OrderPanelController::class, 'update'])->name('update');

        // تغییر سریع وضعیت (AJAX)
        Route::patch('/{order}/status', [OrderPanelController::class, 'updateStatus'])->name('status');

        // حذف (Soft Delete)
        Route::delete('/{order}', [OrderPanelController::class, 'destroy'])->name('destroy');

        // بازگردانی سفارش حذف‌شده
        Route::post('/{order}/restore', [OrderPanelController::class, 'restore'])->name('restore');

        // حذف دائمی
        Route::delete('/{order}/force-delete', [OrderPanelController::class, 'forceDelete'])->name('forceDelete');
    });

    /*
    |----------------------------------------------------------------------
    | Payments
    |----------------------------------------------------------------------
    */
    Route::prefix('payments')->name('admin.payments.')->group(function () {

        // لیست پرداخت‌ها
        Route::get('/', [PaymentPanelController::class, 'index'])->name('index');

        // نمایش جزئیات پرداخت
        Route::get('/{payment}', [PaymentPanelController::class, 'show'])->name('show');

        // تایید دستی پرداخت
        Route::patch('/{payment}/verify', [PaymentPanelController::class, 'verify'])->name('verify');

        // بازگشت وجه
        Route::post('/{payment}/refund', [PaymentPanelController::class, 'refund'])->name('refund');

        // حذف پرداخت
        Route::delete('/{payment}', [PaymentPanelController::class, 'destroy'])->name('destroy');
    });

>>>>>>> a96f8e3 (complateforCartshoping)
}); // ← پایان گروه panelAdmin


/*
|--------------------------------------------------------------------------
| Cart (بدون locale — برای مهمان و کاربر)
|--------------------------------------------------------------------------
*/

Route::prefix('cart')->middleware('throttle:60,1')->group(function () {
    Route::get('/',                    [CartController::class, 'index'])->name('cart.show');
    Route::post('/add',                [CartController::class, 'add'])->name('cart.add');
    Route::patch('/items/{itemId}',    [CartController::class, 'update'])->name('cart.update');
    Route::delete('/items/{itemId}',   [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/clear',            [CartController::class, 'clear'])->name('cart.clear');
    Route::post('/guest-contact',      [CartController::class, 'setGuestContact'])->name('cart.guest');
});
//Route::prefix('{locale}/checkout')
//    ->middleware(['web'])
//    ->group(function () {
//        Route::get('/',          [CheckoutController::class, 'index'])->name('checkout.index');
//        Route::post('/',         [CheckoutController::class, 'store'])->name('checkout.store');
//        Route::get('/success',   [CheckoutController::class, 'success'])->name('checkout.success');
//    });
/*
|--------------------------------------------------------------------------
| Checkout & Sandbox Payment
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Checkout Routes
|--------------------------------------------------------------------------
*/

Route::prefix('{locale}')
    ->whereIn('locale', ['fa', 'en', 'ar'])
    ->middleware('setLocale')
    ->group(function () {

        // صفحه تسویه حساب
        Route::get('/checkout', [
            CheckoutController::class,
            'index'
        ])->name('checkout.index');

        // ثبت سفارش
        Route::post('/checkout', [
            CheckoutController::class,
            'store'
        ])->name('checkout.store');

        // نتیجه ثبت سفارش
        Route::get('/checkout/success/{order}', [
            CheckoutController::class,
            'success'
        ])->name('checkout.success');
<<<<<<< HEAD
=======
        Route::get('checkout/invoice/{order}', [CheckoutController::class, 'invoice'])
            ->name('checkout.invoice');
        Route::get('/checkout/invoice/{order}/download', [CheckoutController::class, 'downloadInvoice']);
>>>>>>> a96f8e3 (complateforCartshoping)


        /*
        |--------------------------------------------------------------------------
        | Sandbox Payment Gateway
        |--------------------------------------------------------------------------
        */

        // صفحه اصلی درگاه پرداخت
        Route::get('/payment/gateway/{order}', [
            PaymentController::class,
            'show'
        ])->name('payment.gateway');

        // پردازش پرداخت
        Route::post('/payment/gateway/{order}/process', [
            PaymentController::class,
            'process'
        ])->name('payment.process');


        /*
        |--------------------------------------------------------------------------
        | Payment Result Routes
        |--------------------------------------------------------------------------
        */

        // پرداخت موفق
        Route::get('/payment/success/{payment}', [
            PaymentController::class,
            'success'
        ])->name('payment.success');

        // پرداخت ناموفق
        Route::get('/payment/failed/{payment}', [
            PaymentController::class,
            'failed'
        ])->name('payment.failed');

        // انصراف از پرداخت
        Route::get('/payment/canceled/{payment}', [
            PaymentController::class,
            'canceled'
        ])->name('payment.canceled');

    });
/*
|--------------------------------------------------------------------------
| Order Tracking
|--------------------------------------------------------------------------
*/

Route::post('/orders/track', function (Request $request) {
    $validated = $request->validate([
        'tracking_code'  => ['required', 'string'],
        'customer_phone' => ['required', 'string'],
    ]);

    $order = \App\Models\Cart\Order::where('tracking_code', $validated['tracking_code'])
        ->where('customer_phone', $validated['customer_phone'])
        ->with('items')
        ->first();

    if (! $order) {
        return response()->json(['message' => 'سفارشی با این مشخصات یافت نشد.'], 404);
    }

    return response()->json(['data' => $order]);
})->name('orders.track');


/*
|--------------------------------------------------------------------------
| Public Chatbot Routes
|--------------------------------------------------------------------------
*/

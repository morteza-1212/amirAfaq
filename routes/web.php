<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LocalController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AgentChatController;
use App\Http\Controllers\Shop\ParentCategoryController;
use App\Http\Controllers\panelAdmin\ProductGroupController;
use App\Http\Controllers\panelAdmin\ProductGroupTranslationController;
use App\Http\Controllers\panelAdmin\CategoryController;
use App\Http\Controllers\panelAdmin\CategoryTranslationController;
use App\Http\Controllers\panelAdmin\ProductController;
use App\Http\Controllers\panelAdmin\ProductTranlationController;
use App\Http\Controllers\panelAdmin\CatalogController;
use App\Http\Controllers\panelAdmin\CatalogTranslationController;
use App\Http\Controllers\panelAdmin\GalleryController;
use App\Http\Controllers\panelAdmin\GalleryTranslationController;
use App\Http\Controllers\panelAdmin\ProductExportController;
use App\Http\Controllers\panelAdmin\TradeTransactionController;
use App\Http\Controllers\panelAdmin\ContactController;
use App\Http\Controllers\panelAdmin\FaqController;
use App\Http\Controllers\panelAdmin\SupportController;


/*
|--------------------------------------------------------------------------
| Root
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $locale = session('locale', config('app.locale', 'fa'));

    if (!in_array($locale, ['fa', 'en', 'ar'], true)) {
        $locale = 'fa';
    }

    return redirect()->route('home', ['locale' => $locale]);
});


/*
|--------------------------------------------------------------------------
| Language Switch
|--------------------------------------------------------------------------
*/

Route::get('/lang/{locale}', [LocalController::class, 'switch'])->whereIn('locale', ['fa', 'en', 'ar'])->name('locale.switch');


/*
|--------------------------------------------------------------------------
| Localized Routes
|--------------------------------------------------------------------------
*/

Route::prefix('{locale}')->whereIn('locale', ['fa', 'en', 'ar'])->middleware('setLocale')->group(function () {

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
    Route::prefix('chatbot')->name('chatbot.')->middleware('throttle:30,1')->group(function () {
        Route::post('/start', [ChatbotController::class, 'start'])->name('start');
        Route::post('/send', [ChatbotController::class, 'send'])->name('send');
        Route::get('/messages', [ChatbotController::class, 'messages'])->name('messages');
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

Route::prefix('panelAdmin') ->middleware(['admin'])->group(function () {

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
    Route::prefix('productExport')->group(function () {
        Route::get('/', [ProductExportController::class, 'index'])->name('admin.productExport.index');
        Route::get('/create', [ProductExportController::class, 'create'])->name('admin.productExport.create');
        Route::post('/create', [ProductExportController::class, 'store'])->name('admin.productExport.store');
        Route::get('/show/{productExport}', [ProductExportController::class, 'show'])->name('admin.productExport.show');
        Route::get('/edit/{productExport}', [ProductExportController::class, 'edit'])->name('admin.productExport.edit');
        Route::put('/update/{productExport}', [ProductExportController::class, 'update'])->name('admin.productExport.update');
        Route::delete('/delete/{productExport}', [ProductExportController::class, 'destroy'])->name('admin.productExport.delete');
    });
    Route::prefix('parentShop')->group(function (){

        Route::get('/',[ParentCategoryController::class,'index'])->name('admin.parentShop.index');

        Route::get('/create',[ParentCategoryController::class,'create'])->name('admin.parentShop.create');

        Route::post('/',[ParentCategoryController::class,'store'])->name('admin.parentShop.store');

        Route::get('/{parentCategory}/edit',[ParentCategoryController::class,'edit'])->name('admin.parentShop.edit');

        Route::put('/{parentCategory}',[ParentCategoryController::class,'update'])->name('admin.parentShop.update');

        Route::delete('/{parentCategory}',[ParentCategoryController::class,'destroy'])->name('admin.parentShop.destroy');

    });

});


/*
|--------------------------------------------------------------------------
| Public Chatbot Routes
|--------------------------------------------------------------------------
*/



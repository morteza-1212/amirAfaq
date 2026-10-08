<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\panelAdmin\ProductGroupController;
use \App\Http\Controllers\panelAdmin\ProductGroupTranslationController;
use \App\Http\Controllers\panelAdmin\CategoryController;
use \App\Http\Controllers\panelAdmin\CategoryTranslationController;
use \App\Http\Controllers\panelAdmin\ProductController;
use \App\Http\Controllers\panelAdmin\ProductTranlationController;
use \App\Http\Controllers\panelAdmin\CatalogController;
use \App\Http\Controllers\panelAdmin\CatalogTranslationController;

use \App\Http\Controllers\HomeController;





//Route::get('/', function () {
//    return view('index');
//});

Route::get('/', function () {
    return redirect('/fa');
});


/*
|--------------------------------------------------------------------------
| Localized Routes
|--------------------------------------------------------------------------
*/

//Route::prefix('{locale}')
//    ->whereIn('locale', ['fa', 'en', 'ar'])
//    ->middleware(\App\Http\Middleware\SetLocal::class)
//    ->group(function () {
//
//        Route::get('/', [HomeController::class, 'index'])
//            ->name('home');
//        Route::get('/about', [HomeController::class, 'AbouteUs'])
//            ->name('About');
//
//    });
Route::get('/lang/{locale}', [\App\Http\Controllers\LocalController::class, 'switch'])
    ->whereIn('locale', ['fa', 'en', 'ar'])
    ->name('locale.switch');

/*
|--------------------------------------------------------------------------
| Localized Routes
|--------------------------------------------------------------------------
*/
Route::prefix('{locale}')
    ->whereIn('locale', ['fa', 'en', 'ar'])
    ->middleware('setLocale')
    ->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('home');
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


    });

Route::get('/', function () {
    $locale = session('locale', config('app.locale', 'fa'));
    return redirect("/{$locale}");
});

Route::get('/lang/{locale}', [\App\Http\Controllers\LocalController::class, 'switch'])
    ->whereIn('locale', ['fa', 'en', 'ar'])
    ->name('locale.switch');
Route::prefix('panelAdmin')->group(function () {
 Route::prefix('productGroup')->group(function(){
     Route::get('/', [ProductGroupController::class, 'index'])->name('admin.productGroup.index');
     Route::get('/create', [ProductGroupController::class, 'create'])->name('admin.productGroup.create');
     Route::post('/create', [ProductGroupController::class, 'store'])->name('admin.productGroup.store');
     Route::get('/edit/{productGroup}', [ProductGroupController::class, 'edit'])->name('admin.productGroup.edit');
     Route::put('/update/{productGroup}', [ProductGroupController::class, 'update'])->name('admin.productGroup.update');
     Route::delete('/delete/{productGroup}', [ProductGroupController::class, 'destroy'])->name('admin.productGroup.delete');
     Route::prefix('productGroupTranslation')->group(function (){
         Route::get('/{productGroup}/translations', [
             ProductGroupTranslationController::class,
             'index'
         ])->name('admin.productGroup.translations.index');


         Route::get('/{productGroup}/translations/create', [
             ProductGroupTranslationController::class,
             'create'
         ])->name('admin.productGroup.translations.create');


         Route::post('/{productGroup}/translations/create', [
             ProductGroupTranslationController::class,
             'store'
         ])->name('admin.productGroup.translations.store');


         Route::get('/{productGroup}/translations/{translation}', [
             ProductGroupTranslationController::class,
             'show'
         ])->name('admin.productGroup.translations.show');


         Route::get('/{productGroup}/translations/{translation}/edit', [
             ProductGroupTranslationController::class,
             'edit'
         ])->name('admin.productGroup.translations.edit');


         Route::put('/{productGroup}/translations/{translation}/update', [
             ProductGroupTranslationController::class,
             'update'
         ])->name('admin.productGroup.translations.update');


         Route::delete('/{productGroup}/translations/{translation}/delete', [
             ProductGroupTranslationController::class,
             'destroy'
         ])->name('admin.productGroup.translations.delete');
     });

 });
    Route::prefix('category')->group(function(){
        Route::get('/',[CategoryController::class,'index'])->name('admin.category.index');
        Route::get('/create',[CategoryController::class,'create'])->name('admin.category.create');
        Route::post('/create',[CategoryController::class,'store'])->name('admin.category.store');
        Route::get('/edit/{category}',[CategoryController::class,'edit'])->name('admin.category.edit');
        Route::put('/update/{category}',[CategoryController::class,'update'])->name('admin.category.update');
        Route::delete('/delete/{category}',[CategoryController::class,'destroy'])->name('admin.category.delete');

        Route::prefix('categoryTranslation')->group(function(){
            Route::get('/',[CategoryTranslationController::class,'index'])->name('admin.category.translation.index');
            Route::get('/create',[CategoryTranslationController::class,'create'])->name('admin.category.translation.create');
            Route::post('/create',[CategoryTranslationController::class,'store'])->name('admin.category.translation.store');
            Route::get('/edit/{categoryTranslation}',[CategoryTranslationController::class,'edit'])->name('admin.category.translation.edit');
            Route::put('/update/{categoryTranslation}',[CategoryTranslationController::class,'update'])->name('admin.category.translation.update');
            Route::delete('/delete/{categoryTranslation}',[CategoryTranslationController::class,'destroy'])->name('admin.category.translation.delete');
        });
    });

    Route::prefix('products')->group(function () {

        Route::get('/', [ProductController::class, 'index'])->name('admin.product.index');
        Route::get('/create', [ProductController::class, 'create'])->name('admin.product.create');
        Route::post('/create', [ProductController::class, 'store'])->name('admin.product.store');
        Route::get('/edit/{product}', [ProductController::class, 'edit'])->name('admin.product.edit');
        Route::put('/update/{product}', [ProductController::class, 'update'])->name('admin.product.update');
        Route::delete('/delete/{product}', [ProductController::class, 'destroy'])->name('admin.product.delete');

        // ✅ اصلاح‌شده: پارامتر {product} اضافه شد
        Route::prefix('{product}/productTranslation')->group(function () {

            Route::get('/', [ProductTranlationController::class, 'index'])
                ->name('admin.product.translation.index');

            Route::get('/create', [ProductTranlationController::class, 'create'])
                ->name('admin.product.translation.create');

            Route::post('/create', [ProductTranlationController::class, 'store'])
                ->name('admin.product.translation.store');

            Route::get('/edit/{translation}', [ProductTranlationController::class, 'edit'])
                ->name('admin.product.translation.edit');

            Route::put('/update/{translation}', [ProductTranlationController::class, 'update'])
                ->name('admin.product.translation.update');

            // ⚠️ نکته: delete باید DELETE باشد، نه GET
            Route::delete('/delete/{translation}', [ProductTranlationController::class, 'destroy'])
                ->name('admin.product.translation.delete');
        });

    });

    Route::prefix('catalogs')->name('admin.catalog.')->group(function () {

        // لیست کاتالوگ‌ها
        Route::get('/', [CatalogController::class, 'index'])
            ->name('index');

        // فرم ایجاد
        Route::get('/create', [CatalogController::class, 'create'])
            ->name('create');

        // ذخیره کاتالوگ جدید
        Route::post('/create', [CatalogController::class, 'store'])
            ->name('store');

        // نمایش یک کاتالوگ (بر اساس slug)
        Route::get('/{catalog}', [CatalogController::class, 'show'])
            ->name('show');

        // فرم ویرایش
        Route::get('/{catalog}/edit', [CatalogController::class, 'edit'])
            ->name('edit');

        // به‌روزرسانی
        Route::put('/{catalog}', [CatalogController::class, 'update'])
            ->name('update');

        // حذف
        Route::delete('/{catalog}', [CatalogController::class, 'destroy'])
            ->name('destroy');

        // تغییر وضعیت فعال/غیرفعال (اختیاری)
        Route::patch('/{catalog}/toggle-status', [CatalogController::class, 'toggleStatus'])
            ->name('toggle-status');


    });

    Route::prefix('{catalog}/catalogTranslation')->group(function () {

        // لیست ترجمه‌های کاتالوگ
        Route::get(
            '/',
            [CatalogTranslationController::class, 'index']
        )->name('admin.catalog.translation.index');

        // فرم ایجاد ترجمه
        Route::get(
            '/create',
            [CatalogTranslationController::class, 'create']
        )->name('admin.catalog.translation.create');

        // ذخیره ترجمه
        Route::post(
            '/create',
            [CatalogTranslationController::class, 'store']
        )->name('admin.catalog.translation.store');

        // فرم ویرایش ترجمه
        Route::get(
            '/edit/{translation}',
            [CatalogTranslationController::class, 'edit']
        )->name('admin.catalog.translation.edit');

        // بروزرسانی ترجمه
        Route::put(
            '/update/{translation}',
            [CatalogTranslationController::class, 'update']
        )->name('admin.catalog.translation.update');

        Route::delete(
            '/translations/delete/{translation}',
            [CatalogTranslationController::class, 'destroy']
        )->name('admin.catalog.translation.delete');

    });
});

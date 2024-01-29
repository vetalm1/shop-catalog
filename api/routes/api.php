<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\HeaderController;
use App\Http\Controllers\MainPageController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Sync1sController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/
Route::group([
    'prefix' => 'auth',
], function () {
    Route::post('/login', [AuthController::class, 'login']);

    Route::group([
        'middleware' => 'auth:sanctum',
    ], function () {
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});

/*
|--------------------------------------------------------------------------
| Main page / main data
|--------------------------------------------------------------------------
*/
Route::get('/main-page', [MainPageController::class, 'index']);
Route::get('/header-footer', [HeaderController::class, 'getHeaderFooterData']);

/*
|--------------------------------------------------------------------------
| Catalog / product /brand
|--------------------------------------------------------------------------
*/
Route::group([
    'prefix' => 'products',
], function () {
    Route::get('/catalog/main', [CatalogController::class, 'lvlFirst']);
    Route::get('/catalog/second/{category}', [CatalogController::class, 'lvlSecond']);
    Route::get('/catalog/download-price/{slug?}', [CatalogController::class, 'getPrice']);
    Route::get('/filters/{category}', [CatalogController::class, 'filters']);

    Route::get('/brands', [BrandController::class, 'getBrands']);
    Route::get('/brands/{brand}', [BrandController::class, 'getBrand']);

    Route::get('/search', [SearchController::class, 'search']);

    Route::get('/{slug?}', [ProductController::class, 'getProduct']);
});

/*
|--------------------------------------------------------------------------
| Static pages (sections)
|--------------------------------------------------------------------------
*/
Route::get('/about', [PagesController::class, 'getAboutPage']);
Route::get('/faq', [PagesController::class, 'getFaqPage']);
Route::get('/vacancy', [PagesController::class, 'getVacancyPage']);
Route::get('/contacts', [PagesController::class, 'getContactPage']);
Route::get('/delivery', [PagesController::class, 'getDeliveryPage']);
Route::get('/template-page/{slug}', [PagesController::class, 'getTemplatePage']);


/*
|--------------------------------------------------------------------------
| Forms
|--------------------------------------------------------------------------
*/
Route::group([
    'prefix' => 'form',
    'middleware' => 'throttle:30,3',
], function () {
    Route::post('/order', [FormController::class, 'storeOrder']);
    Route::post('/question', [FormController::class, 'storeQuestion']);
});

/*
|--------------------------------------------------------------------------
| Sync 1s
|--------------------------------------------------------------------------
*/
Route::group([
    'prefix' => 'sync',
    'middleware' => 'sync1s',
], function () {
    Route::match(['get', 'post'], '/1c-sync', [Sync1sController::class, 'sync']);
});

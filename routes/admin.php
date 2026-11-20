<?php

use Illuminate\Support\Facades\Route;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Ecom\AuthController;
use App\Http\Controllers\Ecom\DashboardController;
use App\Http\Controllers\Ecom\CategoryController;
use App\Http\Controllers\Ecom\UnitController;
use App\Http\Controllers\Ecom\ColorController;
use App\Http\Controllers\Ecom\ProductController;
use App\Http\Controllers\Ecom\OfferController;
use App\Http\Controllers\Ecom\EcomWebMasterController;
use App\Http\Controllers\Ecom\ShippingMethodController;
use App\Http\Controllers\Ecom\PaymentMethodController;
use App\Http\Controllers\Ecom\ContactReqController;
use App\Http\Controllers\Ecom\TemplateController;
use App\Http\Controllers\Ecom\AdvertisementController;
use App\Http\Controllers\Ecom\OrderController;
use App\Http\Controllers\Ecom\CustomerController;
use App\Http\Controllers\Ecom\BlogController;
use App\Http\Controllers\Ecom\BlogCtargoryController;
use App\Http\Controllers\Ecom\PaymentController;
use App\Http\Controllers\Ecom\NewsLetterController;
use App\Http\Controllers\Ecom\PermissionController;
use App\Http\Controllers\Ecom\RoleController;
use App\Http\Controllers\Ecom\EmployeeController;
use App\Http\Controllers\Ecom\PostController;
use App\Http\Controllers\Ecom\ProductExportController;


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
|
| Prefix: admin
*/

Route::get('ecom-logout', [AuthController::class, 'ecomLogout'])->name('ecomLogout');
Route::get('ecom-logout-all', [AuthController::class, 'ecomLogoutAll'])->name('ecomLogoutAll');
Route::get('go-to-salon', [DashboardController::class, 'goToSalon'])->name('goToSalon');
Route::get('go-to-ecommerce', [AuthController::class, 'goToEcom'])->name('goToEcom');
Route::post('post/contactus', [ContactReqController::class, 'store'])->name('post.contactus');

// guest routes
Route::middleware(['ecomadmin.guest'])->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('ecomLogin');
    Route::post('login', [AuthController::class, 'login'])->name('ecomLoginPost');
});

// auth routes
Route::name('ecomadmin.')->middleware(['auth:ecomadmin'])->group(function () {
    Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::resource('contact-request', ContactReqController::class);
    Route::resource('advertisement', AdvertisementController::class);
    Route::resource('news-letters', NewsLetterController::class);
    Route::resource('employees', EmployeeController::class);
    Route::resource('posts', PostController::class);
    Route::post('post-status-update', [PostController::class, 'updateStatus'])->name('posts.updateStatus');

    Route::resource('orders', OrderController::class);
    Route::post('order-status-update', [OrderController::class, 'updateStatus'])->name('updateStatus');
    Route::get('order-invoice/{id}', [OrderController::class, 'invoice'])->name('invoice');
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/refund-payment/{orderId}', [PaymentController::class, 'sendRefundRequest'])->name('payments.refund');

    Route::resource('offers', OfferController::class);
    Route::resource('customers', CustomerController::class);
    Route::get('offer-products', [OfferController::class, 'getProducts'])->name('getProducts');

    // Products
    Route::name('prod.')->group(function () {
        Route::resource('categories', CategoryController::class);
        Route::resource('units', UnitController::class);
        Route::resource('colors', ColorController::class);
        Route::resource('products', ProductController::class);
        Route::resource('product-export', ProductExportController::class);
        Route::get('/stocks', [ProductController::class, 'stocks'])->name('stocks');
        Route::get('/new-stock/{id}', [ProductController::class, 'addStock'])->name('new-stock');
        Route::post('/store-stock', [ProductController::class, 'storeNewStock'])->name('store-stock');
        Route::get('/export-stock/{id}', [ProductController::class, 'ExportStockForm'])->name('export-stock');
        Route::get('/stock-detail/{id}', [ProductController::class, 'StockDetail'])->name('stock-detail');
        Route::delete('/stock-delete/{id}', [ProductController::class, 'destroyTransaction'])->name('stock-delete');
    });

    // Blog
    Route::name('blog.')->group(function () {
        Route::resource('blogs', BlogController::class);
        Route::resource('blog-category', BlogCtargoryController::class);
    });

    // authorization
    Route::name('authorization.')->group(function () {
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);
    });

    Route::name('setting.')->group(function () {
        Route::resource('web-master', EcomWebMasterController::class);
        Route::resource('shipping-methods', ShippingMethodController::class);
        Route::resource('payment-methods', PaymentMethodController::class);
    });

    Route::name('template.')->group(function () {
        Route::get('message-reply', [TemplateController::class, 'messageReply'])->name('messageReply');
    });

    // Route::post('/news-letter', [NewsLetterController::class, 'store'])->name('news-letter');
});

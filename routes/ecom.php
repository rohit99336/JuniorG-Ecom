<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Ecom\PageController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Ecom\CartController;
use App\Http\Controllers\Ecom\GoogleController;
use App\Http\Controllers\Ecom\NewsLetterController;
use App\Http\Controllers\Ecom\CustomerController as Customer;
use App\Http\Controllers\Ecom\OrderController;
use App\Http\Controllers\Ecom\PaymentController;
use App\Http\Controllers\Ecom\ReviewController;
use App\Http\Controllers\Ecom\BlogCommentController;
use App\Http\Controllers\Ecom\PostController;

/*
|--------------------------------------------------------------------------
| Ecom Routes
|--------------------------------------------------------------------------
|
| Here is where you can register ecom routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "ecom" middleware group. Now create something great!
|
|// Prefix: shop
*/

Route::group(['prefix' => 'filemanager'], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

Route::get('/', [PageController::class, 'index'])->name('shop.index');
Route::get('/privacy', [PageController::class, 'privacy'])->name('shop.privacy');
Route::get('/about-us', [PageController::class, 'aboutUs'])->name('shop.aboutUs');
Route::get('/terms', [PageController::class, 'terms'])->name('shop.terms');
Route::get('/shipingpolicy', [PageController::class, 'shipingpolicy'])->name('shop.shipingpolicy');
Route::get('/returnpolicy', [PageController::class, 'returnpolicy'])->name('shop.returnpolicy');
Route::get('/products', [PageController::class, 'products'])->name('shop.products');
Route::get('/product/{slug}', [PageController::class, 'productDetails'])->name('shop.product');
Route::get('/contact-us', [PageController::class, 'contactUs'])->name('shop.contactus');
Route::get('/posts', [PageController::class, 'post'])->name('shop.posts');
Route::get('/new-post', [PostController::class, 'create'])->name('shop.new-post');
Route::post('/post', [PostController::class, 'store'])->name('shop.post-store');
Route::post('/comment', [PostController::class, 'storeComment'])->name('shop.post-comment');


Route::get('add-to-cart', [CartController::class, 'addToCart'])->name('addToCart');
Route::get('cart', [CartController::class, 'goToCart'])->name('shop.cart');
Route::get('cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
route::put('cart/update/{id}', [CartController::class, 'updateCart'])->name('cart.update');
Route::get('/checkout', [CartController::class, 'checkout'])->name('shop.checkout');
// Route::get('/checkout/payment', [PageController::class, 'checkoutPayment'])->name('shop.checkoutPayment');
Route::post('/news-letter', [NewsLetterController::class, 'store'])->name('news-letter');
Route::get('/blogs', [PageController::class, 'blog'])->name('shop.blog');
Route::get('/blog/{id}', [PageController::class, 'blogDetail'])->name('shop.blog-detail');
Route::post('/blog/comment', [BlogCommentController::class, 'store'])->name('shop.blog.comment');

//========================================= Authentication ======================================/=/
//===============================================================================================/=/

// guest routes
Route::middleware(['customer.guest'])->group(function () {
    Route::get('login', [CustomerController::class, 'showLoginForm'])->name('shop.login');
    Route::post('login', [CustomerController::class, 'login'])->name('shop.postLogin');
    Route::post('login-otp', [CustomerController::class, 'loginWithOtp'])->name('shop.loginWithOtp');

    // login with google
    Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('shop.auth.google');
    Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
});

Route::get('/register', [CustomerController::class, 'registerForm'])->name('shop.registerform');
Route::post('/register', [CustomerController::class, 'register'])->name('shop.register');
Route::get('/logout', [CustomerController::class, 'ecomLogout'])->name('shop.logout');
Route::get('/forgot-password', [CustomerController::class, 'showForgotPasswordForm'])->name('shop.forgotpassword');
Route::post('/forgot-password', [CustomerController::class, 'forgotPassword'])->name('shop.postforgotpassword');
Route::get('/reset-password/{token}', [CustomerController::class, 'showResetPasswordForm'])->name('shop.resetpassword');
Route::post('/reset-password', [CustomerController::class, 'resetPassword'])->name('shop.postresetpassword');
Route::get('/customer/{phone}', [CustomerController::class, 'findUserByPhone'])->name('shop.findCustomerByPhone');



Route::group(['middleware' => ['customer']], function () {
    Route::get('/my-profile', [Customer::class, 'profile'])->name('shop.myprofile');
    Route::put('/update-profile/{id}', [Customer::class, 'update'])->name('shop.updateprofile');

    Route::post('order', [OrderController::class, 'store'])->name('shop.order');
    Route::get('order-detail/{id}', [Customer::class, 'orderDetail'])->name('shop.orderdetail');

    Route::get('payment/{order_id}', [PaymentController::class, 'paymentPage'])->name('shop.paymentpage');
    Route::post('cod', [PaymentController::class, 'cod'])->name('shop.payment.cod');
    Route::post('razorpay', [PaymentController::class, 'razorpay'])->name('shop.payment.razorpay');
    Route::post('cashfree', [PaymentController::class, 'cashFree'])->name('shop.payment.cashfree');
    Route::post('change_password', [Customer::class, 'changePassword'])->name('shop.changePassword');
    Route::get('thank-you', [PaymentController::class, 'thankyou'])->name('shop.thankyou');

    Route::post('review', [ReviewController::class, 'store'])->name('shop.review');
    // Route::get('review', [ReviewController::class, 'index'])->name('shop.review');
    // Route::get('review/{id}', [ReviewController::class, 'show'])->name('shop.review.show');

});

Route::get('/test', function () {
    return "Testing route";
    // return view('ecom.auth.reset-mail');
    // return view('ecom.web.payments');
    // return view('ecom.views.index');
})->name('testing');

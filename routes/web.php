<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Master\TemplateController;
use App\Http\Controllers\Master\MessageController;
use App\Http\Controllers\MasterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Auth::routes();

// // Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::middleware(['auth'])->group(function () {

//     Route::resource('messages', MessageController::class);
//     Route::resource('templates', TemplateController::class);
//     Route::get('/get-templates', [TemplateController::class, 'getTemplates'])->name('get-templates');
//     Route::get('/get-message', [TemplateController::class, 'getTemplateMessage'])->name('get-message');
// });

Route::get('/states', [MasterController::class, 'getStates'])->name('states');
Route::get('/cities', [MasterController::class, 'getCities'])->name('cities');

// clear
Route::get('clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    Artisan::call('optimize:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    return "Cleared!";
});

// clear config
Route::get('config-clear', function () {
    Artisan::call('config:clear');
    return "Cleared!";
});

// register redirect to login
Route::get('register', function () {
    return redirect()->route('login');
});


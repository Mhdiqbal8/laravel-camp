<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\HomeController;
use Laravel\Socialite\Facades\Socialite;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');



Route::middleware(['auth'])->group(function(){
    // checkout routes
    Route::get('checkout/success',[CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('checkout/{camp:slug}',[CheckoutController::class, 'create'])->name('checkout.create');
    Route::POST('checkout/store/{camp}',[CheckoutController::class, 'store'])->name('checkout.store');

    // user dashboard
    Route::get('dashboard',[HomeController::class, 'dashboard'])->name('dashboard');
});

// Socialite Routes

Route::get('auth/redirect', [UserController::class, 'redirectToGoogle'])->name('user.login.google');
Route::get('auth/google/callback', [UserController::class, 'handleGoogleCallback']);

require __DIR__.'/auth.php';

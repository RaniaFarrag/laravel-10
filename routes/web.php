<?php

use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Payment\PayPalController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::prefix('auth')->group(function (){
   Route::get('redirect/facebook', [SocialiteController::class, 'redirectToFacebook'])
            ->name('redirect_to_facebook');

   Route::get('redirect/google', [SocialiteController::class, 'redirectToGoogle'])
            ->name('redirect_to_google');

   Route::get('facebook/callback', [SocialiteController::class, 'retrieveFacebookCallback']);
   Route::get('google/callback', [SocialiteController::class, 'retrieveGoogleCallback']);

});

Route::prefix('paypal')->middleware('auth')->group(function (){
    Route::get('/', [PayPalController::class, 'index'])->name('paypal');
    Route::get('/payment', [PayPalController::class, 'payment'])->name('paypal.payment');
    Route::get('/payment/success', [PayPalController::class, 'paymentSuccess'])->name('paypal.payment.success');
    Route::get('/payment/cancel', [PayPalController::class, 'paymentCancel'])->name('paypal.payment.cancel');
});



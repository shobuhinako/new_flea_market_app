<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\StripeController;


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

Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('show.register');
Route::post('/register', [RegisterController::class, 'create'])->name('register');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('show.login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/', [ItemController::class, 'index'])->name('index');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/detail/{id}', [ItemController::class, 'show'])->name('item.detail');
Route::get('/search', [ItemController::class, 'search'])->name('search');


Route::middleware('auth')->group(function(){
    Route::get('/mypage', [UserController::class, 'showMypage'])->name('show.mypage');
    Route::get('/mypage/profile_change', [UserController::class, 'showProfile'])->name('show.profile');
    Route::put('/mypage/profile_change', [UserController::class, 'editProfile'])->name('edit.profile');
    Route::get('/display_item', [ItemController::class, 'showDisplayItem'])->name('show.display');
    Route::post('/display_item', [ItemController::class, 'store'])->name('create.item');
    Route::post('/detail/{id}', [ItemController::class, 'favorite'])->name('favorite');
    Route::get('/detail/comment/{item_id}', [ItemController::class, 'showComment'])->name('show.comment');
    Route::post('/detail/comment/{item_id}', [ItemController::class, 'create'])->name('create.comment');
    Route::delete('/detail/comment/{item_id}/{comment_id}', [ItemController::class, 'destroy'])->name('delete.comment');
    Route::get('/confirm_purchase/{item_id}', [ItemController::class, 'showPurchaseForm'])->name('show.purchase');
    Route::post('/confirm_purchase/{item_id}', [StripeController::class, 'charge'])->name('charge');
    // Route::post('/change-payment', [StripeController::class, 'changePayment'])->name('change.payment');
    // Route::post('/update-payment', [StripeController::class, 'updatePayment'])->name('update.payment');
    Route::get('/address__change', [UserController::class, 'address'])->name('show.address');
    Route::post('/create-payment-intent', [StripeController::class, 'createPaymentIntent'])->name('create.payment.intent');
    Route::post('/address__change', [UserController::class, 'updateAddress'])->name('update.address');
    Route::get('/payment-form', [StripeController::class, 'showPaymentForm'])->name('show.payment.form');
    Route::post('/charge', [StripeController::class, 'charge'])->name('stripe.charge');
    Route::get('/payment_completion', [StripeController::class, 'success'])->name('payment.complete');
    Route::post('/payment/send-bank-transfer-info', [StripeController::class, 'sendBankTransferInfo'])->name('payment.sendBankTransferInfo');
    Route::post('/webhook/stripe', [StripeController::class, 'handleWebhook'])->name('webhook.stripe');
});
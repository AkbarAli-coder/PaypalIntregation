<?php

use App\Http\Controllers\PaymentController;
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


Route::post('ajax/payment',[PaymentController::class,'payment'])->name('ajax.payment');



// // pay pal payment
// Route::get('handle-payment', [PaymentController::class,'handlePayment'])->name('make.payment');
// Route::get('payment-success', [PaymentController::class,'paymentSuccess'])->name('success.payment');
// Route::get('payment-success', [PaymentController::class,'paymentSuccess'])->name('success.payment');

<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [App\Http\Controllers\FrontController::class,'index'])->name('/');
Route::get('/payment-success', [App\Http\Controllers\FrontController::class,'paymentsuccess'])->name('paymentsuccess');
Route::get('/payment-cancel', [App\Http\Controllers\FrontController::class,'paymentcancel'])->name('paymentcancel');
Route::post('/submitresponse', [App\Http\Controllers\PaymentController::class,'submitresponse'])->name('submitresponse');
Route::get('/payment-history', [App\Http\Controllers\PaymentController::class,'index'])->name('paymenthistory');
Route::post('/payment-history', [App\Http\Controllers\PaymentController::class,'index'])->name('paymenthistorySearch');
Route::any('/response', [App\Http\Controllers\PaymentController::class,'response'])->name('response');
Route::get('/refund/{id}', [App\Http\Controllers\PaymentController::class,'refund'])->name('refund');
<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


});


Route::get('/payment', [FrontController::class,'index'])->middleware(['auth', 'verified'])->name('payment');
Route::get('/payment-success', [FrontController::class,'paymentsuccess'])->middleware(['auth', 'verified'])->name('paymentsuccess');
Route::get('/payment-cancel', [FrontController::class,'paymentcancel'])->middleware(['auth', 'verified'])->name('paymentcancel');
Route::post('/submitresponse', [PaymentController::class,'submitresponse'])->middleware(['auth', 'verified'])->name('submitresponse');
Route::get('/payment-history', [PaymentController::class,'index'])->middleware(['auth', 'verified'])->name('paymenthistory');
Route::post('/payment-history', [PaymentController::class,'index'])->middleware(['auth', 'verified'])->name('paymenthistorySearch');
Route::any('/response', [PaymentController::class,'response'])->middleware(['auth', 'verified'])->name('response');
Route::get('/refund/{id}', [PaymentController::class,'refund'])->middleware(['auth', 'verified'])->name('refund');


require __DIR__.'/auth.php';

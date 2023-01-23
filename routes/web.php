<?php

use App\Http\Controllers\PaymentsController;
use App\Http\Middleware\PaymentPrivacy;
use App\Models\Payments;
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

Route::get('/',[PaymentsController::class,'index'])->name('index');
Route::post('/',[PaymentsController::class,'establishPayment'])->name('establish.payment');
Route::get('/payment/{Payments:token}',[PaymentsController::class,'showPayment'])->name('show.payment')->missing(function (){
    abort(403);
});
Route::post('/payment',[PaymentsController::class,'finalizePayment'])->name('finalize.payment');
Route::post('/payment/cancel',[PaymentsController::class,'cancelPayment'])->name('cancel.payment');



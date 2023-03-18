<?php

use App\Http\Controllers\Payment;
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

//Route::get('/', function () {
//    return view('admin.index');
//});
Route::get('/payments/pay',[Payment::class,'pay']);
Route::get('/payments/verify/{payment?}',[Payment::class,'payment_verify'])->name('payment-verify');

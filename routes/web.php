<?php

use App\Http\Controllers\Api\Payment;
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
Route::get('/payments/verify/{payment?}',[Payment::class,'payment_verify'])->name('payment-verify');


//get all terms by season_id
Route::get('terms/season/{id}',[\App\Http\Controllers\Admin\TermController::class,'getAllTermsBySeason'])->middleware('auth:admin');

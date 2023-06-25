<?php

use App\Http\Controllers\Api\Payment;
use Carbon\Carbon;
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
Route::get('/payments/payWithFawry',[Payment::class,'payWithFawry'])->name('payment-verify');


//get all terms by season_id
Route::get('terms/season/{id}',[\App\Http\Controllers\Admin\TermController::class,'getAllTermsBySeason'])->middleware('auth:admin');

Route::get('get-minutes', function (){

    $video_part_time = \App\Models\VideoParts::query()
        ->find(1)->video_part_time;

    $total_watch = \App\Models\VideoOpened::query()
        ->find(29)->total_watch;

    $timeDifference = Carbon::parse($total_watch)->diffInSeconds(Carbon::parse($video_part_time));
    $total = $timeDifference;


    return $total;

});
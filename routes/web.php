<?php

use App\Http\Controllers\Admin\TermController;
use App\Http\Controllers\Admin\VideoPartController;
use App\Http\Controllers\Api\Payment;
use App\Models\Lesson;
use App\Models\SubjectClass;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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



Route::get('terms/season/{id}',[TermController::class,'getAllTermsBySeason'])->middleware('auth:admin');
Route::get('getAllSubjectClassesBySeasonAndTerm',[VideoPartController::class,'getAllSubjectClassesBySeasonAndTerm']);
Route::get('getAllLessonsBySubjectClass', [VideoPartController::class,'getAllLessonsBySubjectClass']);




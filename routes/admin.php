<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\Admin\SeasonController;
use App\Http\Controllers\Admin\SubjectClassController;
use App\Http\Controllers\Admin\TermController;
use App\Http\Controllers\Admin\AudioController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\VideoPartController;
use App\Http\Controllers\Admin\PdfFileUploadController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\MonthlyPlanController;
use App\Http\Controllers\Admin\SuggestionController;

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


Route::group(['prefix' => 'admin'], function () {
    Route::get('login', [AuthController::class, 'index'])->name('admin.dologin');
    Route::POST('login', [AuthController::class, 'login'])->name('admin.login');
});


Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function () {
    Route::get('/', [MainController::class, 'index'])->name('adminHome');


    #### Country ####
    Route::resource('countries', CountryController::class);

    #### Users ####
    Route::resource('users', UserController::class);
    Route::post('subscr_renew', [UserController::class, 'subscr_renew'])->name('subscr_renew');

    #### Season ####
    Route::resource('seasons', SeasonController::class);

    #### Term ####
    Route::resource('terms', TermController::class);

    #### Subject Class ####
    Route::resource('subjectsClasses', SubjectClassController::class);

    #### Lesson ####
    Route::resource('lessons', LessonController::class);

    #### Notification ####
    Route::resource('notifications', NotificationController::class);

    ##### Video Parts #####
    Route::resource('videosParts', VideoPartController::class);

    #### Audio ####
    Route::resource('audio', AudioController::class);

    #### Monthly Plans ####
    Route::resource('monthlyPlans', MonthlyPlanController::class);

    #### Suggestion ####
    Route::resource('suggestions', SuggestionController::class);

    #### Pdf ####
    Route::resource('pdf', PdfFileUploadController::class);

    #### Question ####
    Route::resource('questions', QuestionController::class);
    Route::get('examble_type', [QuestionController::class, 'examble_type'])->name('examble_type');
    Route::get('answer/{id}', [QuestionController::class, 'answer'])->name('answer');
    Route::post('addAnswer/{id}', [QuestionController::class, 'addAnswer'])->name('addAnswer');

    #### Auth ####
    Route::get('logout', [AuthController::class, 'logout'])->name('admin.logout');
});



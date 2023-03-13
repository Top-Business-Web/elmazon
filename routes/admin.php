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
use App\Http\Controllers\Admin\OnlineExamController;
use App\Http\Controllers\Admin\PhoneCommunicationController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\SettingController;

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
    Route::get('activate/{id}', [TermController::class, 'activate'])->name('activate');

    #### Subject Class ####
    Route::resource('subjectsClasses', SubjectClassController::class);

    #### Lesson ####
    Route::resource('lessons', LessonController::class);
    Route::get('showUnit', [LessonController::class, 'showUnit'])->name('showUnit');

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

    #### Online Exam ####
    Route::resource('onlineExam', OnlineExamController::class);
    Route::get('examble_type', [OnlineExamController::class, 'examble_type'])->name('examble_type');
    Route::get('indexQuestion/{id}', [OnlineExamController::class, 'indexQuestion'])->name('indexQuestion');
    Route::post('addQuestion', [OnlineExamController::class, 'addQuestion'])->name('addQuestion');
    Route::post('deleteQuestion', [OnlineExamController::class, 'deleteQuestion'])->name('deleteQuestion');

    #### Phone Communications ####
    Route::resource('phoneCommunications', PhoneCommunicationController::class);

    #### Slider ####
    Route::resource('slider', SliderController::class);

    #### Pdf ####
    Route::resource('pdf', PdfFileUploadController::class);

    #### Section ####
    Route::resource('section', SectionController::class);

    #### Setting ####
    Route::resource('setting', SettingController::class);

    #### Question ####
    Route::resource('questions', QuestionController::class);
    Route::get('examble_type', [QuestionController::class, 'examble_type'])->name('examble_type');
    Route::get('answer/{id}', [QuestionController::class, 'answer'])->name('answer');
    Route::post('addAnswer/{id}', [QuestionController::class, 'addAnswer'])->name('addAnswer');

    #### Auth ####
    Route::get('logout', [AuthController::class, 'logout'])->name('admin.logout');
});



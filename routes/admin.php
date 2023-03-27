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
use App\Http\Controllers\Admin\GuideController;
use App\Http\Controllers\Admin\AllExamController;
use App\Http\Controllers\Admin\ContactUsController;
use App\Http\Controllers\Admin\SubscribeController;
use App\Http\Controllers\Admin\AdsController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\TextExamUserController;

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
    Route::get('subscrView/{user}/view', [UserController::class, 'subscrView'])->name('subscrView');

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
    Route::get('/itemView', array('as'=> 'front.home', 'uses' => [VideoPartController::class, 'itemView']))->name('itemView');
    Route::post('/update-items', array('as'=> 'update.items', 'uses' => [VideoPartController::class, 'updateItems']))->name('updateItems');

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
    Route::get('usersExam/{id}', [OnlineExamController::class, 'usersExam'])->name('usersExam');
    Route::post('addQuestion', [OnlineExamController::class, 'addQuestion'])->name('addQuestion');
    Route::post('deleteQuestion', [OnlineExamController::class, 'deleteQuestion'])->name('deleteQuestion');
    Route::get('paperExam/{id}', [OnlineExamController::class, 'paperExam'])->name('paperExam');
    Route::post('storeExamPaper', [OnlineExamController::class, 'storeExamPaper'])->name('storeExamPaper');

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

    #### guide ####
    Route::resource('guide', GuideController::class);
    Route::get('item', [GuideController::class, 'item'])->name('item');
    Route::get('indexItem/{id}', [GuideController::class, 'indexItem'])->name('indexItem');
    Route::post('addItem', [GuideController::class, 'addItem'])->name('addItem');
    Route::post('updateItem/{id}', [GuideController::class, 'updateItem'])->name('updateItem');
    Route::post('destroyItem/{id}', [GuideController::class, 'destroyItem'])->name('destroyItem');

    #### All Exam ####
    Route::resource('allExam', AllExamController::class);

    #### Contact Us ####
    Route::resource('contactUs', ContactUsController::class);

    #### Subscribe ####
    Route::resource('subscribe', SubscribeController::class);

    #### Question ####
    Route::resource('questions', QuestionController::class);
    Route::get('examble_type', [QuestionController::class, 'examble_type'])->name('examble_type');
    Route::get('answer/{id}', [QuestionController::class, 'answer'])->name('answer');
    Route::post('addAnswer/{id}', [QuestionController::class, 'addAnswer'])->name('addAnswer');

    #### Ads ####
    Route::resource('ads', adsController::class);
    Route::get('activateAds/{id}', [adsController::class, 'activateAds'])->name('activateAds');

    #### Comment ####
    Route::resource('comment', CommentController::class);
    Route::get('replyComment/{id}', [CommentController::class, 'replyComment'])->name('replyComment');
    Route::post('replyCommentDelete/{id}', [CommentController::class, 'replyCommentDelete'])->name('replyCommentDelete');

    #### Feedback ####
    Route::resource('feedback', FeedbackController::class);
    Route::get('indexFeedback/{id}', [FeedbackController::class, 'indexFeedback'])->name('indexFeedback');
    Route::post('addFeedback', [FeedbackController::class, 'addFeedback'])->name('addFeedback');


    #### Auth ####
    Route::get('logout', [AuthController::class, 'logout'])->name('admin.logout');
});



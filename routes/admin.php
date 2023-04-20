<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\Admin\OnBoardingController;
use App\Http\Controllers\Admin\RoleController;
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
use App\Http\Controllers\Admin\LifeExamController;
use App\Http\Controllers\Admin\PapelSheetExamController;
use App\Http\Controllers\Admin\VideoBasicController;
use App\Http\Controllers\Admin\VideoResourceController;
use App\Http\Controllers\Admin\VideoBasicPdfController;
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

    #### Admins ####
//    Route::group(['middleware' => 'permission:الادمن'], function () {
        Route::resource('admins', AdminController::class);
        Route::POST('delete_admin', [AdminController::class, 'delete'])->name('delete_admin');
//    });
    Route::get('my_profile', [AdminController::class, 'myProfile'])->name('myProfile');

    Route::get('/', [MainController::class, 'index'])->name('adminHome')->middleware('permission:الرئيسية');


    #### Country ####
    Route::resource('countries', CountryController::class)->middleware('permission:المدن');

    #### Users ####
    Route::group(['middleware' => 'permission:الطلاب'], function () {
        Route::resource('users', UserController::class);
        Route::post('subscr_renew', [UserController::class, 'subscr_renew'])->name('subscr_renew');
        Route::get('print/{id}', [UserController::class, 'printReport'])->name('printReport');
        Route::get('priceMonth', [UserController::class, 'priceMonth'])->name('priceMonth');
        Route::get('subscrView/{user}/view', [UserController::class, 'subscrView'])->name('subscrView');
    });

    #### Season ####
    Route::resource('seasons', SeasonController::class)->middleware('permission:الصفوف الدراسيه');

    #### Season Term
    Route::group(['middleware' => 'permission:الترم'], function () {
        Route::get('seasons/{id}/term', [SeasonController::class, 'seasonTerm'])->name('seasonTerm');
        Route::get('seasons/term/create/{id}', [SeasonController::class, 'seasonTermCreate'])->name('seasonTermCreate');
        Route::post('seasons/{id}/term/store', [SeasonController::class, 'seasonTermStore'])->name('seasonTermStore');
        Route::get('seasons/{id}/term/edit', [SeasonController::class, 'seasonTermEdit'])->name('seasonTermEdit');
        Route::put('seasons/term/update/{term}', [SeasonController::class, 'seasonTermUpdate'])->name('seasonTermUpdate');
        Route::delete('seasons/{id}/term/delete', [SeasonController::class, 'seasonTermDelete'])->name('seasonTermDelete');
    });

    #### Term Subject ####
    Route::group(['middleware' => 'permission:الوحدات'], function () {
        Route::get('term/{id}/subjectClass', [SeasonController::class, 'termSubjectClass'])->name('termSubjectClass');
        Route::get('term/subjectClass/create/{id}', [SeasonController::class, 'termSubjectClassCreate'])->name('termSubjectClassCreate');
        Route::post('seasons/{id}/term/store', [SeasonController::class, 'termSubjectClassStore'])->name('termSubjectClassStore');
        Route::get('seasons/{id}/term/edit', [SeasonController::class, 'termSubjectClassEdit'])->name('termSubjectClassEdit');
        Route::put('seasons/term/update/{term}', [SeasonController::class, 'termSubjectClassUpdate'])->name('termSubjectClassUpdate');
        Route::delete('seasons/{id}/term/delete', [SeasonController::class, 'termSubjectClassDelete'])->name('termSubjectClassDelete');
    });

    #### SubjectClass Lesson ####

    Route::get('subjectClass/{id}/lesson', [SeasonController::class, 'subjectClassLesson'])->name('subjectClassLesson')->middleware('permission:الدروس');

    #### Lesson Video Part

    Route::get('lesson/{id}/VideoParts', [SeasonController::class, 'lessonVideoPart'])->name('lessonVideoPart')->middleware('permission:اقسام الفيديوهات');

    #### Video Part Comment ####

    Route::get('VideoParts/{id}/comment', [SeasonController::class, 'videoPartComment'])->name('videoPartComment')->middleware('permission:التعليقات');

    #### Comment Reply Comment ####

    Route::get('comment/{id}/replyComment', [SeasonController::class, 'commentReplayComment'])->name('commentReplayComment')->middleware('permission:التعليقات');;

    #### Term ####
    Route::group(['middleware' => 'permission:الترم'], function () {
        Route::resource('terms', TermController::class);
        Route::get('activate/{id}', [TermController::class, 'activate'])->name('activate');
        Route::post('/term/filter', [TermController::class, 'filterTerm'])->name('term.filter');
    });

    #### Subject Class ####
    Route::group(['middleware' => 'permission:الوحدات'], function () {
        Route::resource('subjectsClasses', SubjectClassController::class);
        Route::get('term/seasonSort', [SubjectClassController::class, 'seasonSort'])->name('subjectClassSort');
        Route::get('season/term', [SubjectClassController::class, 'seasonTerm'])->name('seasonTerm');
    });

    #### Lesson ####
    Route::group(['middleware' => 'permission:الدروس'], function () {
        Route::resource('lessons', LessonController::class);
        Route::get('showUnit', [LessonController::class, 'showUnit'])->name('showUnit');
        Route::get('/lesson/seasonSort', [LessonController::class, 'seasonSort'])->name('seasonSort');
    });

    #### Notification ####
    Route::resource('notifications', NotificationController::class)->middleware('permission:الاشعارات');

    ##### Video Parts #####
    Route::group(['middleware' => 'permission:اقسام الفيديوهات'], function () {
        Route::resource('videosParts', VideoPartController::class);
        Route::get('/itemView', array('as' => 'front.home', 'uses' => [VideoPartController::class, 'itemView']))->name('itemView');
        Route::post('/update-items', array('as' => 'update.items', 'uses' => [VideoPartController::class, 'updateItems']))->name('updateItems');
    });

    #### Audio ####
    Route::resource('audio', AudioController::class)->middleware('permission:اقسام الفيديوهات');

    #### Monthly Plans ####
    Route::resource('monthlyPlans', MonthlyPlanController::class)->middleware('permission:الخطة الشهرية');

    #### Suggestion ####
    Route::resource('suggestions', SuggestionController::class)->middleware('permission:الاقتراحات');

    #### Online Exam ####
    Route::group(['middleware' => 'permission:امتحانات الاونلاين'], function () {
        Route::resource('onlineExam', OnlineExamController::class);
        Route::get('selectTerm', [OnlineExamController::class, 'selectTerm'])->name('selectTerm');
        Route::get('examble_type', [OnlineExamController::class, 'examble_type'])->name('examble_type');
        Route::get('indexQuestion/{id}', [OnlineExamController::class, 'indexQuestion'])->name('indexQuestion');
        Route::get('usersExam/{id}', [OnlineExamController::class, 'usersExam'])->name('usersExam');
        Route::post('addQuestion', [OnlineExamController::class, 'addQuestion'])->name('addQuestion');
        Route::post('deleteQuestion', [OnlineExamController::class, 'deleteQuestion'])->name('deleteQuestion');
        Route::get('paper-exam/{user_id}/{exam_id}', [OnlineExamController::class, 'paperExam'])->name('paperExam');///????????
        Route::post('exam-depends/{user_id}/{exam_id}', [OnlineExamController::class, 'exam_depends'])->name('exam-depends');///????????
        Route::post('storeExamPaper', [OnlineExamController::class, 'storeExamPaper'])->name('storeExamPaper');
    });


    //added by Islam
    Route::post('add-degree-to-text-exam', [OnlineExamController::class, 'addDegreeForTextExam'])
        ->name('add-degree-to-text-exam')->middleware('permission:امتحانات الاونلاين');


    #### Life Exam ####
    Route::resource('lifeExam', LifeExamController::class)->middleware('permission:امتحانات اللايف');

    #### Papel Sheet Exam ####
    Route::group(['middleware' => 'permission:امتحانات الورقية'], function () {
        Route::resource('papelSheetExam', PapelSheetExamController::class);
        Route::get('usersExamPapel/{id}', [PapelSheetExamController::class, 'usersExamPapel'])->name('usersExamPapel');
        Route::get('paperExamSheet/{id}', [PapelSheetExamController::class, 'paperExamSheet'])->name('paperExamSheet');
        Route::post('paperExamSheetStore/{id}', [PapelSheetExamController::class, 'paperExamSheetStore'])->name('paperExamSheetStore');
    });

    #### Phone Communications ####
    Route::resource('phoneCommunications', PhoneCommunicationController::class)
        ->middleware('permission:الاتصالات الهاتفية');

    #### Slider ####
    Route::group(['middleware' => 'permission:سلايدر'], function () {
        Route::resource('slider', SliderController::class);
    });
    Route::resource('onBoarding', OnBoardingController::class)
        ->middleware('permission:الشاشات الافتتاحيه');

    #### Pdf ####
    Route::resource('pdf', PdfFileUploadController::class)
        ->middleware('permission:ملفات ورقية');

    #### Section ####
    Route::resource('section', SectionController::class)
        ->middleware('permission:القاعات');

    #### Setting ####
    Route::resource('setting', SettingController::class)
        ->middleware('permission:الاعدادات');

    #### guide ####
    Route::group(['middleware' => 'permission:الدليل'], function () {
        Route::resource('guide', GuideController::class);
        Route::get('item', [GuideController::class, 'item'])->name('item');
        Route::get('indexItem/{id}', [GuideController::class, 'indexItem'])->name('indexItem');
        Route::post('addItem', [GuideController::class, 'addItem'])->name('addItem');
        Route::post('updateItem/{id}', [GuideController::class, 'updateItem'])->name('updateItem');
        Route::post('destroyItem/{id}', [GuideController::class, 'destroyItem'])->name('destroyItem');
    });

    #### All Exam ####
    Route::resource('allExam', AllExamController::class)->middleware('permission:كل الامتحانات');

    #### Contact Us ####
//    Route::resource('contactUs', ContactUsController::class);

    #### Subscribe ####
    Route::resource('subscribe', SubscribeController::class)->middleware('permission:الباقات');

    #### Question ####
    Route::group(['middleware' => 'permission:بنك الأسئلة'], function () {
        Route::resource('questions', QuestionController::class);
        Route::get('examble_type', [QuestionController::class, 'examble_type'])->name('examble_type');
        Route::get('answer/{id}', [QuestionController::class, 'answer'])->name('answer');
        Route::post('addAnswer/{id}', [QuestionController::class, 'addAnswer'])->name('addAnswer');
    });

    #### Ads ####
    Route::group(['middleware' => 'permission:الاعلانات'], function () {
        Route::resource('ads', adsController::class);
        Route::get('activateAds/{id}', [adsController::class, 'activateAds'])->name('activateAds');
    });

    #### Comment ####
    Route::group(['middleware' => 'permission:التعليقات'], function () {
        Route::resource('comment', CommentController::class);
        Route::get('replyComment/{id}', [CommentController::class, 'replyComment'])->name('replyComment');
        Route::post('replyCommentDelete/{id}', [CommentController::class, 'replyCommentDelete'])->name('replyCommentDelete');
    });


    #### Video Basic ####

    Route::resource('videoBasic', VideoBasicController::class);
    Route::get('videoBasic/comment/{id}', [VideoBasicController::class, 'indexComment'])->name('indexComment');
    Route::get('videoBasic/commentReply/{id}', [VideoBasicController::class, 'indexCommentReply'])->name('indexCommentReply');
    Route::get('videoBasic/comment/create', [VideoBasicController::class, 'indexCommentCreate'])->name('indexComment.create');
    Route::post('videoBasic/comment/reply', [VideoBasicController::class, 'storeReply'])->name('storeReply');
    Route::delete('videoBasic/commentReply/delete/{id}', [VideoBasicController::class, 'deleteCommentReply'])->name('deleteCommentReply');

    #### Video Resource ####
    Route::group(['middleware' => 'permission:مصادر الفيديوهات'], function () {
        Route::resource('videoResource', VideoResourceController::class);
        Route::get('videoResource/Sort', [VideoResourceController::class, 'videoResourceSort'])->name('videoResourceSort');
    });

    #### Video Basic Pdf ####
    Route::resource('videoBasicPdf', VideoBasicPdfController::class)->middleware('permission:الفيديوهات الاساسية ملفات ورقية');


    #### roles ####
    Route::group(['middleware' => 'permission:الادوار و الصلاحيات'], function () {
        Route::resource('roles', RoleController::class);
        Route::POST('delete_roles', [RoleController::class, 'delete'])->name('delete_roles');
    });


    #### Auth ####
    Route::get('logout', [AuthController::class, 'logout'])->name('admin.logout');
});



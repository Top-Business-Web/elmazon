<?php

use App\Http\Controllers\Api\AdsController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Comment\CommentController;
use App\Http\Controllers\Api\Degree\DegreeController;
use App\Http\Controllers\Api\DegreeOfExamsDetails\DegreeExamsDetailsController;
use App\Http\Controllers\Api\ExamYourselfTest\TestYourselfExamsController;
use App\Http\Controllers\Api\Favorites\FavoriteController;
use App\Http\Controllers\Api\FullExams\FullExamController;
use App\Http\Controllers\Api\Guides\GuideController;
use App\Http\Controllers\Api\Instruction\InstructionController;
use App\Http\Controllers\Api\LessonController;
use App\Http\Controllers\Api\LessonDetails\LessonDetailsController;
use App\Http\Controllers\Api\LifeExam\LifeExamController;
use App\Http\Controllers\Api\LiveExam\LiveExamController;
use App\Http\Controllers\Api\MonthlyPlan\MonthlyPlanController;
use App\Http\Controllers\Api\AllExamsUsersDegreeController;
use App\Http\Controllers\Api\Notes\NoteController;
use App\Http\Controllers\Api\OnBoardingController;
use App\Http\Controllers\Api\Payment;
use App\Http\Controllers\Api\ExamEntry\ExamEntryController;
use App\Http\Controllers\Api\StudentReport\ReportController;
use App\Http\Controllers\Api\Report\ReportController as ReportStudentController;
use App\Http\Controllers\Api\SubjectClass\SubjectClassController;
use App\Http\Controllers\Api\SubscribeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['middleware' => 'lang'], function (){


    Route::post('add-notification',[AuthController::class,'add_notification']);
    Route::get('teacher/about-me',[\App\Http\Controllers\Api\AboutMe\AboutMeController::class,'about_me'])->middleware('jwt');

    Route::group(['prefix' => 'auth'], function (){

    Route::post('login',[AuthController::class,'login']);
    Route::get('communication',[AuthController::class,'communication']);

    Route::middleware('jwt')->group(function (){
        Route::post('logout',[AuthController::class,'logout']);
        Route::get('getProfile',[AuthController::class,'getProfile']);
        Route::post('add-suggest',[AuthController::class,'addSuggest']);
        Route::get('all-notifications',[AuthController::class,'allNotifications']);
        Route::post('add-device-token',[AuthController::class,'add_device_token']);
        Route::post('papel-sheet-exam/user/{id}',[AuthController::class,'paper_sheet_exam']);
        Route::get('papel-sheet-exam/show',[AuthController::class,'paper_sheet_exam_show']);
        Route::get('paper-sheet-exam/register-with-student-check-before',[AuthController::class,'paperSheetExamForStudentDetails']);
        Route::delete('paper-sheet-exam/latest-paper-exam-delete',[AuthController::class,'latestPaperExamDelete']);
        Route::post('update-profile',[AuthController::class,'updateProfile']);
        Route::get('home-page',[AuthController::class,'home_page']);
        Route::get('home-page/all-classes',[AuthController::class,'allClasses']);
        Route::get('home-page/all-exams',[AuthController::class,'all_exams']);
        Route::get('home-page/start-your-journey',[AuthController::class,'startYourJourney']);
        Route::get('home-page/start-your-journey/findExamByClassById/{id}',[AuthController::class,'findExamByClassById']);
        Route::get('home-page/videos-resources',[AuthController::class,'videosResources']);
        Route::get('all-subscribes',[SubscribeController::class,'all']);
        Route::post('/payments/pay',[Payment::class,'pay']);
        Route::post('/payments/paymob____',[Payment::class,'pay_']);
        Route::post('user-add-screenshot',[AuthController::class,'user_add_screenshot']);
    });
  });

    Route::group(['prefix' => 'classes','middleware' => ['jwt']], function (){
        Route::get('all',[SubjectClassController::class,'allClasses']);
        Route::get('lessonsByClassId/{id}',[SubjectClassController::class,'lessonsByClassId']);
    });

    Route::group(['prefix' => 'fullExams','middleware' => ['jwt']], function (){
        Route::get('all',[FullExamController::class,'fullExams']);
        Route::get('instructionByFullExamId/{id}',[FullExamController::class,'instructionByFullExamId']);
    });

    Route::group(['prefix' => 'lesson','middleware' => ['jwt']], function (){
        Route::get('videos/{id}',[LessonController::class,'allVideos']);

        //video details
        Route::get('video/details/{id}',[LessonController::class,'videoDetails']);
        Route::get('video/comments/{id}',[LessonController::class,'videoComments']);
        Route::post('video/add-comment',[CommentController::class,'videoAddComment']);
        Route::post('comment/add-replay/{id}',[CommentController::class,'commentAddReplay']);


        //access videos
        Route::post('{id}',[LessonController::class,'accessFirstVideo']);
        Route::post('access-next-video/{id}',[LessonController::class,'accessNextVideo']);

    });

    Route::group(['prefix' => 'plans','middleware' => ['jwt']], function (){
        Route::get('all',[MonthlyPlanController::class,'all_plans']);

    });

    Route::group(['prefix' => 'guide','middleware' => ['jwt']], function (){
        Route::get('sources_references/all',[GuideController::class,'index']);
        Route::get('sources_references/by-lesson/{id}/{lesson_id}',[GuideController::class,'itemsByLesson']);

    });

    Route::group(['prefix' => 'video','middleware' => 'jwt'], function (){
        //update and delete comment and replay
        Route::post('comment/update/{id}',[CommentController::class,'updateComment']);
        Route::delete('comment/delete/{id}',[CommentController::class,'deleteComment']);
        Route::post('replay/update/{id}',[CommentController::class,'updateReplay']);
        Route::delete('replay/delete/{id}',[CommentController::class,'deleteReplay']);
    });

    Route::group(['prefix' => 'ExamEntry','middleware' => ['jwt']], function (){
        Route::get('all-of-questions/{id}',[ExamEntryController::class,'all_questions_by_online_exam']);
    });


    //start Exam entry controller
    Route::group(['prefix' => 'ExamEntry','middleware' => ['jwt']], function (){

        Route::post('exam/{id}',[ExamEntryController::class,'online_exam_by_user']);
         Route::get('exam-degree-depends-with-student/{id}',[ExamEntryController::class,'degreesDependsWithStudent']);
    });


    Route::group(['prefix' => 'degrees','middleware' => ['jwt']], function (){

        Route::get('all-exams-degrees',[DegreeController::class,'degrees']);
//        Route::get('depends/exam/{id}',[DegreeController::class,'degrees_depends']);

        });

    Route::get('ads',[AdsController::class,'index'])->middleware('jwt');
    Route::get('on-boarding',[OnBoardingController::class,'index']);
    //exam details

    Route::middleware('jwt')->group(function (){
        Route::get('exam-degree/details',[AllExamsUsersDegreeController::class,'all_exams_details']);
        Route::get('exam-degree/heroes',[AllExamsUsersDegreeController::class,'all_exams_heroes']);
        Route::post('access-end-time/exam/{id}',[ExamEntryController::class,'access_end_time_for_exam']);

    });

    Route::middleware('jwt')->group(function (){
        Route::get('life-exam/access-first-question/{id}',[LifeExamController::class,'access_first_question']);
        Route::get('live-exam/{id}',[LifeExamController::class,'access_live_exam']);
        Route::post('life-exam/add-life-exam/{id}',[LifeExamController::class,'add_life_exam_with_student']);
        Route::post('live-exam/add-live-exam/{id}',[LifeExamController::class,'solve_live_exam_with_student']);

    });

    Route::post('access-end-time/exam/{id}',[ExamEntryController::class,'access_end_time_for_exam'])->middleware('jwt');
    Route::get('reports/student-report',[ReportController::class,'student_report'])->middleware('jwt');
    Route::post('user-rate-video/{id}',[App\Http\Controllers\Api\VideoRate\VideoRateController::class,'user_rate_video'])->middleware('jwt');


    //Added by eng islam mohammed
    Route::group(['prefix' => 'report','middleware' => 'jwt'], function (){

        Route::post('student-add-report',[ReportStudentController::class,'studentAddReport']);
        Route::get('all-by-student',[ReportStudentController::class,'allByStudent']);
        Route::delete('delete/{id}',[ReportStudentController::class,'delete']);

    });

    Route::group(['prefix' => 'favorite','middleware' => 'jwt'], function (){

        Route::post('exam-add-favorite',[FavoriteController::class,'examAddFavorite']);
        Route::post('video-add-favorite',[FavoriteController::class,'videoAddFavorite']);
        Route::get('all',[FavoriteController::class,'favoriteAll']);
    });


    Route::get('instruction/exam/{id}',[InstructionController::class,'instructionExamDetails']);


    //start lesson details
    Route::group(['prefix' => 'lesson','middleware' => 'jwt'], function (){
        Route::get('all-video-by-lessonId/{id}',[LessonDetailsController::class,'allVideoByLessonId']);
        Route::get('all-pdf-by-videoId/{id}',[LessonDetailsController::class,'allPdfByVideoId']);
        Route::get('all-audios-by-videoId/{id}',[LessonDetailsController::class,'allAudiosByVideoId']);
        Route::get('all-exams-by-videoId/{id}',[LessonDetailsController::class,'allExamsByVideoId']);
        Route::get('all-exams-by-lessonId/{id}',[LessonDetailsController::class,'allExamsByLessonId']);
        Route::get('exam-details-by-examId/{id}',[LessonDetailsController::class,'examDetailsByExamId']);

    });


    //start exams degree details
    Route::group(['prefix' => 'degree-details','middleware' => 'jwt'], function (){
        Route::get('all-exams',[DegreeExamsDetailsController::class,'allExamsDegreeDetails']);
        Route::get('class/{id}',[DegreeExamsDetailsController::class,'classDegreeDetails']);
        Route::get('videos-by-lesson/{id}',[DegreeExamsDetailsController::class,'videosByLessonDegreeDetails']);
        Route::get('lesson/{id}',[DegreeExamsDetailsController::class,'lessonDegreeDetails']);

    });


    //start note add and note details
    Route::group(['prefix' => 'notes','middleware' => 'jwt'], function (){
        Route::post('note-add-by-student',[NoteController::class,'noteAddByStudent']);
        Route::get('note-all-by-date',[NoteController::class,'noteAllByDate']);
        Route::delete('note-delete/{id}',[NoteController::class,'noteDelete']);

    });

    //start test-yourself-exams
    Route::group(['prefix' => 'test-yourself-exams','middleware' => 'jwt'], function (){
        Route::post('make-exam',[TestYourselfExamsController::class,'makeExam']);
        Route::get('exam-questions/{id}',[TestYourselfExamsController::class,'examQuestions']);
        Route::post('solve-exam/{id}',[TestYourselfExamsController::class,'solveExam']);
        Route::get('all-classes-with-lessons',[TestYourselfExamsController::class,'allClassesWithLessons']);

    });



    //start live exam
    Route::group(['prefix' => 'live-exam','middleware' => 'jwt'], function (){
        Route::get('all-of-questions/{id}',[LiveExamController::class,'allOfQuestions']);
        Route::post('add-exam-by-student/{id}',[LiveExamController::class,'addLiveExamByStudent']);
        Route::get('heroes/{id}',[LiveExamController::class,'allOfExamHeroes']);
        Route::get('result/{id}',[LiveExamController::class,'resultOfLiveExam']);
    });

        Route::get('live-exam-all',[LiveExamController::class,'allOfLiveExamsStudent'])->middleware('jwt');

});

    Route::post('/payments/pay',[Payment::class,'pay']);
    Route::get('/payments/pay_callback',[Payment::class,'pay_callback']);
    Route::get('/checkout',[Payment::class,'checkout']);
   // Route::get('/payment/{}',[Payment::class,'payment']);


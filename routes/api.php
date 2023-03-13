<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Comment\CommentController;
use App\Http\Controllers\Api\FullExams\FullExamController;
use App\Http\Controllers\Api\LessonController;
use App\Http\Controllers\Api\SubjectClass\SubjectClassController;
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

Route::group(['prefix' => 'auth'], function (){

    Route::post('login',[AuthController::class,'login']);
    Route::get('communication',[AuthController::class,'communication']);

    Route::middleware('jwt')->group(function (){
        Route::post('logout',[AuthController::class,'logout']);
        Route::get('getProfile',[AuthController::class,'getProfile']);
        Route::post('add-suggest',[AuthController::class,'addSuggest']);
        Route::get('all-notifications',[AuthController::class,'allNotifications']);
        Route::post('papel-sheet-exam/user/{id}',[AuthController::class,'papel_sheet_exam']);
        Route::get('papel-sheet-exam/show',[AuthController::class,'papel_sheet_exam_show']);
        Route::post('update-profile',[AuthController::class,'updateProfile']);
        Route::get('home-page',[AuthController::class,'home_page']);

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
        Route::get('pdf/{id}',[LessonController::class,'allPdf']);
        Route::get('audios/{id}',[LessonController::class,'allAudios']);

        //video details
        Route::get('video/details/{id}',[LessonController::class,'videoDetails']);
        Route::get('video/comments/{id}',[LessonController::class,'videoComments']);
        Route::post('video/add-comment/{id}',[CommentController::class,'videoAddComment']);
        Route::post('comment/add-replay/{id}',[CommentController::class,'commentAddReplay']);


        //access videos
        Route::post('{id}',[LessonController::class,'accessFirstVideo']);
        Route::post('access-next-video/{id}',[LessonController::class,'accessNextVideo']);

    });

    Route::group(['prefix' => 'plans','middleware' => ['jwt']], function (){
        Route::get('all',[\App\Http\Controllers\Api\MonthlyPlan\MonthlyPlanController::class,'all_plans']);
        Route::get('oneDay',[\App\Http\Controllers\Api\MonthlyPlan\MonthlyPlanController::class,'plan_today']);

    });

    Route::group(['prefix' => 'video','middleware' => 'jwt'], function (){

        //update and delete comment and replay
        Route::post('comment/update/{id}',[CommentController::class,'updateComment']);
        Route::delete('comment/delete/{id}',[CommentController::class,'deleteComment']);
        Route::post('replay/update/{id}',[CommentController::class,'updateReplay']);
        Route::delete('replay/delete/{id}',[CommentController::class,'deleteReplay']);
    });

    Route::group(['prefix' => 'video','middleware' => ['jwt']], function (){
        Route::get('onlineExam/{id}/questions',[\App\Http\Controllers\Api\Question\QuestionController::class,'all_questions_by_online_exam']);
        Route::post('onlineExam/{id}/exam',[\App\Http\Controllers\Api\Question\QuestionController::class,'online_exam_by_user']);

    });

});


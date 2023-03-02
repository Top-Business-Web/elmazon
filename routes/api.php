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


});


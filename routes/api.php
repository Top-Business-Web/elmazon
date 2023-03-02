<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\FullExams\FullExamController;
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
        Route::post('add-suggest',[App\Http\Controllers\Api\Auth\AuthController::class,'addSuggest']);
        Route::get('all-notifications',[App\Http\Controllers\Api\Auth\AuthController::class,'allNotifications']);
        Route::post('papel-sheet-exam/user/{id}',[App\Http\Controllers\Api\Auth\AuthController::class,'papel_sheet_exam']);

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

        Route::get('videos/{id}',[\App\Http\Controllers\Api\LessonController::class,'allVideos']);
        Route::get('pdf/{id}',[\App\Http\Controllers\Api\LessonController::class,'allPdf']);
        Route::get('audios/{id}',[\App\Http\Controllers\Api\LessonController::class,'allAudios']);

        //video details
        Route::get('video/details/{id}',[\App\Http\Controllers\Api\LessonController::class,'videoDetails']);
        Route::get('video/comments/{id}',[\App\Http\Controllers\Api\LessonController::class,'videoComments']);
        Route::post('video/add-comment/{id}',[\App\Http\Controllers\Api\Comment\CommentController::class,'videoAddComment']);
        Route::post('comment/add-replay/{id}',[\App\Http\Controllers\Api\Comment\CommentController::class,'commentAddReplay']);

        //access videos
        Route::post('{id}',[\App\Http\Controllers\Api\LessonController::class,'accessFirstVideo']);
        Route::post('access-next-video/{id}',[\App\Http\Controllers\Api\LessonController::class,'accessNextVideo']);



    });


});


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
    Route::post('logout',[AuthController::class,'logout'])->middleware('jwt');
    Route::get('getProfile',[AuthController::class,'getProfile'])->middleware('jwt');

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


    });


});


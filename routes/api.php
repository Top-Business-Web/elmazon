<?php

use App\Http\Controllers\Api\Auth\AuthController;
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

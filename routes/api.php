<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AttendanceController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['cors'])->group(function(){

    Route::post('/members/add',[MemberController::class,'add']);
    Route::get('/members/get',[MemberController::class,'get']);
    Route::post('/members/delete',[MemberController::class,'delete']);
    Route::post('/members/update',[MemberController::class,'update']);
   
    Route::post('/events/add',[EventController::class,'add']);
    Route::get('/events/get',[EventController::class,'get']);
    Route::post('/events/delete',[EventController::class,'delete']);
    Route::post('/events/update',[EventController::class,'update']);

    Route::get('/attendance/getDefaultAttendances',[AttendanceController::class,'getDefaultAttendances']);
    Route::post('/attendance/changeStatus',[AttendanceController::class,'changeStatus']);
});

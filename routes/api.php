<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentSettingController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});     
Route::post('/updatestudinfo',[StudentSettingController::class,'storegeneral'])->name('updatestudentgeneralinfo');
Route::post('/upload', [StudentSettingController::class, 'upload'])->name('upload');
Route::get('/studsetting/{id}',[StudentSettingController::class,'get'])->name('viewstudentinfo');
ROute::put('/changepass',[StudentSettingController::class,'updatepass'])->name('changepassword');
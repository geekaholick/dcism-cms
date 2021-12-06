<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
<<<<<<< Updated upstream
});
=======
});     
Route::post('/updatestudinfo',[StudentSettingController::class,'storegeneral'])->name('updatessz    swsqtudentgeneralinfo');
Route::post('/upload', [StudentSettingController::class, 'upload'])->name('upload');
Route::get('/studsetting/{id}',[StudentSettingController::class,'get'])->name('viewstudentinfo');
Route::put('/changepass',[StudentSettingController::class,'updatepass'])->name('changepassword');
Route::put('/checkpass',[StudentSettingController::class,'passchecker'])->name('passwordchecker');
>>>>>>> Stashed changes

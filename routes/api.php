<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FacultySettingController;

use App\Http\Controllers\AnnouncementController;

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

// ANNOUNCEMENT ROUTES
Route::get('/get-all-announcements', [AnnouncementController::class, 'getAllAnnouncements']);
Route::get('/get-all-announcements-count', [AnnouncementController::class, 'getAnnouncementCount']);




Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/facultysetting', [FacultySettingController::class,'retrievepassword']);

Route::post('/changepassword', [FacultySettingController::class,'update']);
Route::post('/updatefacultyinfo',[FacultySettingController::class,'storegeneralinfo'])->name('updatefacultygeneralinfo');
Route::post('/upload', [FacultySettingController::class, 'uploadpic'])->name('upload');
Route::get('/facultygeneralinfo/{id}',[FacultySettingController::class,'get'])->name('viewfacultyinfo');
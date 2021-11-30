<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::post('/bookmark-announcement', [AnnouncementController::class, 'bookmarkAnnouncement']);
Route::post('/unbookmark-announcement', [AnnouncementController::class, 'unbookmarkAnnouncement']);
Route::get('/get-all-bookmarks', [AnnouncementController::class, 'getAllBookmarks']);
Route::get('/get-all-bookmarks-count', [AnnouncementController::class, 'getAllBookmarksCount']);


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AuthController;

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

// LOG IN ROUTES
Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);

    // Send and handle reset password mail
    // Route::post('reset-password', [AuthController::class, 'sendPasswordResetLink']);
    // Route::post('reset/password', [AuthController::class, 'callResetPassword']);

    Route::group(['middleware' => 'auth:api'], function() {
      Route::get('logout', [AuthController::class, 'logout']);
      Route::get('user', [AuthController::class, 'user']);
    });
});

//FORGOT PASSWORD ROUTES
Route::post('send-token', [AuthController::class, 'sendToken']);
Route::post('reset-password', [AuthController::class, 'resetPassword']);




// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

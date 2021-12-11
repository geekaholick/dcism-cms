<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\PrivilegeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserRolePrivilegeController;

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

//User Role and Privilege Management Routes//
Route::get('/roles', [RoleController::class, 'index']);
Route::get('/privileges', [PrivilegeController::class, 'index']);
Route::get('/user-roles-privileges', [UserRolePrivilegeController::class, 'index']);

Route::prefix('/role')->group( function() {
    Route::post('/store', [RoleController::class, 'store']);
    Route::put('/{id}', [RoleController::class, 'update']);
    Route::delete('/{id}', [RoleController::class, 'destroy']);
});

Route::prefix('/privilege')->group( function() {
    Route::post('/store', [PrivilegeController::class, 'store']);
    Route::put('/{id}', [PrivilegeController::class, 'update']);
    Route::delete('/{id}', [PrivilegeController::class, 'destroy']);
});

Route::prefix('/user-role-privilege')->group( function() {
    Route::post('/store', [UserRolePrivilegeController::class, 'store']);
    Route::put('/{id}', [UserRolePrivilegeController::class, 'update']);
    Route::delete('/{id}', [UserRolePrivilegeController::class, 'destroy']);
});
//User Role and Privilege Management Routes//




Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

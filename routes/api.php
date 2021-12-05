<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\HTTP\Controllers\FacultyUserController;
use App\HTTP\Controllers\StudentUserController;

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

Route::middleware('auth:api')->get('/User', function (Request $request) {
    return $request->user();
});
//Faculty APIs
Route::get('/FacultyUsers', [FacultyUserController::class, 'index']);
Route::prefix('/FacultyUser')->group( function () {
    Route::post('/store', [FacultyUserController::class, 'store']);
    Route::put('/{id}', [FacultyUserController::class, 'update']);
    Route::delete('/{id}', [FacultyUserController::class, 'destroy']);
    }
);
//Student APIs
Route::get('/StudentUsers', [StudentUserController::class, 'index']);
Route::prefix('/StudentUser')->group( function () {
    Route::post('/store', [StudentUserController::class, 'store']);
    Route::put('/{id}', [StudentUserController::class, 'update']);
    Route::delete('/{id}', [StudentUserController::class, 'destroy']);
    }
);

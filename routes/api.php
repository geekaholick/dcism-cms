<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\MemoResource;

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

//Retrieves all memos in data record
Route::get('/memos', 'MemoController@index');

//Retrieves specific memo in data record
Route::get('/memos/show/{id}', 'MemoController@show');

//Stores a new memo
Route::post('/memos', 'MemoController@store');

//Delete a memo
Route::delete('/memos/show/{id}', 'MemoController@destroy');

//Updates a memo
Route::post('/memos/edit/{id}', 'MemoController@update');





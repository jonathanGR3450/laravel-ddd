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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::resource('users', 'UserController');
Route::post('users', 'User\CreateUserController');
Route::put('users/{id}', 'User\UpdateUserController');
Route::get('users/{id}', 'User\ShowUserController');
Route::delete('users/{id}', 'User\DestroyUserController');
Route::get('users', 'User\IndexUserController');
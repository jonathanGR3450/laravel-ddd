<?php

use App\UserInterface\Controller\Auth\AuthController;
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

# auth routes
Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');

});

Route::post('user','Auth\AuthController@getAuthenticatedUser');
Route::middleware(['jwt.verify'])->group(function ()
{

    Route::post('users', 'User\CreateUserController');
    Route::put('users/{id}', 'User\UpdateUserController');
    Route::get('users/{id}', 'User\ShowUserController');
    Route::delete('users/{id}', 'User\DestroyUserController');
    Route::get('users', 'User\IndexUserController');
});

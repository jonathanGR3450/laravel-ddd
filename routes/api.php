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
    Route::post('login', 'login')->name('login');
    Route::post('register', 'register')->name('register');
    Route::post('logout', 'logout')->name('logout');
    Route::post('refresh', 'refresh')->name('refresh');

});

Route::post('user','Auth\AuthController@getAuthenticatedUser');
Route::middleware(['jwt.verify', 'user.business'])->group(function ()
{

    Route::post('users', 'User\CreateUserController')->name('users.store');
    Route::put('users/{id}', 'User\UpdateUserController')->name('users.update');
    Route::get('users/{id}', 'User\ShowUserController')->name('users.show');
    Route::delete('users/{id}', 'User\DestroyUserController')->name('users.destroy');
    Route::get('users', 'User\IndexUserController')->name('users.index');

    # vinculation
    Route::post('vinculations/file/upload', 'Vinculation\UploadFileSupplierController')->name('vinculation.upload');
    Route::post('vinculation/approved/factor', 'Vinculation\UploadFileFactorOrFiduciaryController')->name('vinculation.approved.factor');
});

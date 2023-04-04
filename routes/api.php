<?php

use App\Http\Controllers\API\UserController;
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
});

Route::post('/register', [UserController::class, 'register'])->name('register');
Route::post('/login', [UserController::class, 'login'])->name('login');
Route::get('/login', [UserController::class, 'login'])->name('login');

Route::middleware(['auth:api'])->group(function () {
    Route::middleware(['onlyAdmin'])->group(function () {
        Route::apiResource('news', NewsController::class);
        // Route::get('news', [NewsController::class, 'index']);
        Route::post('news/comment', [NewsController::class, 'comment']);
    });
});

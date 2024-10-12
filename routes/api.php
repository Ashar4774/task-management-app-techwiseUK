<?php

use App\Http\Controllers\API\CommentController;
use App\Http\Controllers\API\FeedbackController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\TaskController;
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

Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);
// Route::post('logout', [UserController::class, 'logout'])->middleware('auth:api');
Route::middleware('auth:api')->group(function(){
    Route::get('/auth-user', [UserController::class, 'AuthUser'])->name('auth-user');
    Route::post('logout', [UserController::class, 'logout']);

    Route::group(['prefix' => 'task'], function () {
        Route::get('/task_list', [TaskController::class, 'index']);
        Route::post('/task_store', [TaskController::class, 'store']);
        Route::get('/task_show/{task}', [TaskController::class, 'show']);
        Route::put('/task_update/{task}', [TaskController::class, 'update']);
        Route::delete('/task_destroy/{task}', [TaskController::class, 'destroy']);
    });
});


Route::get('/migrate', function () {
    if (!defined('STDIN')) {
        define('STDIN', fopen('php://stdin', 'r'));
    }

    Artisan::call('migrate');
    return 'migrated successfully';
});

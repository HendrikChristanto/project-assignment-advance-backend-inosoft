<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'prefix' => 'auth'
], function() {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::group([
        'middleware' => 'auth:api'
    ], function() {
        Route::post('logout', [AuthController::class, 'logout']);
    });
});

Route::group([
    'middleware' => 'auth:api'
], function() {
    Route::get('tasks', [TaskController::class, 'getTasks']);  // Can be filtered : http://127.0.0.1:8000/api/tasks?title=assignment&is_done=false
    Route::get('task/{id}', [TaskController::class, 'getTask']);
    Route::post('task', [TaskController::class, 'createTask']);
    Route::put('task', [TaskController::class, 'updateTask']);
    Route::patch('doTask/{id}', [TaskController::class, 'doTask']);
    Route::patch('undoTask/{id}', [TaskController::class, 'undoTask']);
    Route::delete('task/{id}', [TaskController::class, 'deleteTask']);
});

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskProgressController;

Route::post('/user-register', [AuthController::class, 'registerUser']);
Route::post('/user-login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum', 'role:user_admin'])->group(function () {
    Route::get('/tasks', [TaskController::class, 'index']);
    Route::post('/tasks', [TaskController::class, 'store']);
    Route::put('/tasks/{task}', [TaskController::class, 'update']);
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy']);
    Route::delete('/tasks/{task}/remove-user', [TaskController::class, 'removeUserFromTask']);
});

Route::get('/standard-users', [TaskController::class, 'getStandardUsers']);
Route::middleware('auth:sanctum')->get('/user', [AuthController::class, 'getAuthenticatedUser']);

Route::middleware(['auth:sanctum', 'role:user_standard'])->group(function () {
    Route::put('/tasks/{task}/progress', [TaskProgressController::class, 'updateProgress']);
    Route::get('/assigned-tasks', [TaskProgressController::class, 'getAssignedTasks']);
    Route::put('/tasks/{task}/edit-basic', [TaskController::class, 'updateBasic']);
});

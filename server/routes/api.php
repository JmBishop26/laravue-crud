<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/tasks', [TaskController::class, "getAllTasks"]);
Route::get('/tasks/{id}', [TaskController::class, "getTask"]);
Route::post('/create', [TaskController::class, "createTask"]);
Route::delete('/delete/{id}', [TaskController::class, "deleteTask"]);
Route::put('/tasks/edit/{id}', [TaskController::class, "editTask"]);

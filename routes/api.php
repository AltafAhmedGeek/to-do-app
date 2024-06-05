<?php

use App\Http\Controllers\TaskController;
use App\Models\TaskModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return TaskModel::all();
});

Route::post('/post/store/', [TaskController::class, 'store'])->name('task.store');
Route::post('/post/completed/', [TaskController::class, 'completed'])->name('task.complete');
Route::post('/post/delete/', [TaskController::class, 'destroy'])->name('task.delete');

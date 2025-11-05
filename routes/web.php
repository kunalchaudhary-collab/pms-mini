<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
//  index
Route::get('/', function () {
    return redirect()->route('login');
});
// Auth
Route::get('/register',[AuthController::class,'showRegister'])->name('register');
Route::post('/register',[AuthController::class,'register']);
Route::get('/login',[AuthController::class,'showLogin'])->name('login');
Route::post('/login',[AuthController::class,'login']);
Route::post('/logout',[AuthController::class,'logout'])->name('logout');

// Protected routes
Route::middleware('auth')->group(function(){
    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');

    Route::resource('projects', ProjectController::class);
    Route::resource('tasks', TaskController::class)->except(['show','create','store']); // we'll add create/store manually
    // For task create/store we used dedicated routes in controller but we left resource for edit/update/destroy

    // If you want full task resource (use these instead):
    Route::get('/tasks',[TaskController::class,'index'])->name('tasks.index');
    Route::get('/tasks/create',[TaskController::class,'create'])->name('tasks.create');
    Route::post('/tasks',[TaskController::class,'store'])->name('tasks.store');
    Route::get('/tasks/{task}/edit',[TaskController::class,'edit'])->name('tasks.edit');
    Route::put('/tasks/{task}',[TaskController::class,'update'])->name('tasks.update');
    Route::delete('/tasks/{task}',[TaskController::class,'destroy'])->name('tasks.destroy');

    // AJAX endpoints
    Route::post('/tasks/{task}/status',[TaskController::class,'updateStatus'])->name('tasks.status');

    // Comments
    Route::post('/comment',[CommentController::class,'store'])->name('comment.store');
    Route::get('/comment-list',[CommentController::class,'commentList'])->name('comments.list');

    // Activity logs
    Route::get('/activity',[ActivityLogController::class,'index'])->name('activity.index');
});
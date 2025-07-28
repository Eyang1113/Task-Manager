<?php

use App\Http\Controllers\AuditController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Dashboard control
    Route::get('/dashboard', [DashboardController::class, 'dashboardView'])->name('dashboard');

    //Task control
    Route::get('/addTask', [TaskController::class, 'addTask'])->name('addTask');
    Route::post('/create-task', [TaskController::class, 'createTask'])->name('create.task');
    Route::get('/editTask/{task}', [TaskController::class, 'editTask'])->name('edit.task');
    Route::put('/updateTask/{task}', [TaskController::class, 'updateTask'])->name('update.task');
    Route::get('/deleteTask/{task}', [TaskController::class, 'deleteTask'])->name('delete.task');
    Route::get('/deleteFile/{file}', [TaskController::class, 'deleteFile'])->name('delete.file');

    //Reminder control
    Route::get('/reminder', [ReminderController::class, 'getTask'])->name('reminder');

    //AuditLog control
    Route::get('/auditLog', [AuditController::class, 'auditTable'])->name('auditLog');
});

require __DIR__.'/auth.php';

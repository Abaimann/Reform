<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {

    // Dashboard
    // Route dashboard berada di luar group karena
    // sudah memiliki middleware auth + verified.

    // Tasks
    Route::resource('tasks', TaskController::class);

    // Schedule
    Route::resource('schedules', ScheduleController::class);
    Route::patch(
        '/schedules/{schedule}/status',
        [ScheduleController::class, 'updateStatus']
    )->name('schedules.update-status');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';
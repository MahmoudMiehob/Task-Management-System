<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;


Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    } else {
        return redirect()->route('login');
    }
});

Route::get('/dashboard', function () {
    if (Auth::user()->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    } elseif (Auth::user()->hasRole('user')) {
        return redirect()->route('user.dashboard');
    }
    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// User Dashboard
Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/user/dashboard', [TaskController::class, 'userDashboard'])->name('user.dashboard');


    Route::post('/user/tasks/{task}/update-status', [TaskController::class, 'updateStatus'])->name('user.tasks.updateStatus');
});

// Admin Dashboard
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [TaskController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::resource('admin/tasks', TaskController::class)->except(['show']);
});




require __DIR__.'/auth.php';

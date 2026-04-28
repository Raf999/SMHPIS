<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MLController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PredictionController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/teacher/dashboard', [DashboardController::class, 'index'])->name('teacher.dashboard');
    Route::get('/student/dashboard', [DashboardController::class, 'index'])->name('student.dashboard');

    // User Management
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');

    // Prediction Logs
    Route::get('/logs', [PredictionController::class, 'index'])->name('predictions.index');
    Route::get('/logs/download', [PredictionController::class, 'downloadCsv'])->name('predictions.download');
    
    // Student Prediction routes
    Route::get('/student/predict', [MLController::class, 'showPredictForm'])->name('student.predict');
    Route::post('/student/predict', [MLController::class, 'submitPredict'])->name('student.predict.submit');
    Route::get('/student/result/{id}', [MLController::class, 'showResult'])->name('student.result');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');


});
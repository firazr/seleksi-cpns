<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\TestCpnsController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ChatbotController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// News/Berita Routes
Route::get('/berita', [NewsController::class, 'index'])->name('berita.index');
Route::get('/berita/hasil-test', [NewsController::class, 'getHasilTest'])->name('berita.hasil-test');
Route::get('/berita/{news}', [NewsController::class, 'show'])->name('berita.show');

// Chatbot Route
Route::post('/chatbot', [ChatbotController::class, 'chat'])->name('chatbot.send');

// Profil Routes
Route::get('/profil', [ProfileController::class, 'index'])->name('profil.index');
Route::get('/profil/results', [ProfileController::class, 'getResults'])->name('profil.results');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // Password Reset Routes
    Route::get('/forgot-password', [PasswordResetController::class, 'showForgotForm'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.update');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Email Verification Routes
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', [OtpController::class, 'showVerifyForm'])->name('verification.notice');
    Route::post('/email/verify', [OtpController::class, 'verify'])->name('verification.verify');
    Route::post('/email/resend', [OtpController::class, 'resend'])->name('verification.resend');
});

// Protected Routes - Peserta Only (requires email verification)
Route::middleware(['auth', 'peserta', 'verified'])->group(function () {
    // Test CPNS
    Route::get('/test-cpns', [TestCpnsController::class, 'index'])->name('test-cpns.index');
    Route::post('/test-cpns/start', [TestCpnsController::class, 'start'])->name('test-cpns.start');
    
    // Quiz
    Route::get('/quiz/{session}', [QuizController::class, 'show'])->name('quiz.show');
    Route::post('/quiz/{session}/answer', [QuizController::class, 'saveAnswer'])->name('quiz.answer');
    Route::post('/quiz/{session}/submit', [QuizController::class, 'submit'])->name('quiz.submit');
    Route::get('/quiz/{session}/result', [QuizController::class, 'result'])->name('quiz.result');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/admin/create', [DashboardController::class, 'storeAdmin'])->name('store-admin');
    
    // News Management
    Route::post('/berita', [NewsController::class, 'store'])->name('berita.store');
    Route::put('/berita/{news}', [NewsController::class, 'update'])->name('berita.update');
    Route::delete('/berita/{news}', [NewsController::class, 'destroy'])->name('berita.destroy');
    
    // Question Management
    Route::get('/questions', [QuestionController::class, 'index'])->name('questions.index');
    Route::post('/questions', [QuestionController::class, 'store'])->name('questions.store');
    Route::put('/questions/{question}', [QuestionController::class, 'update'])->name('questions.update');
    Route::delete('/questions/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');
});

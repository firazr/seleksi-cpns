<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TestCpnsController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\Admin\QuestionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// News/Berita Routes
Route::get('/berita', [NewsController::class, 'index'])->name('berita.index');
Route::get('/berita/{news}', [NewsController::class, 'show'])->name('berita.show');

// Profil Routes
Route::get('/profil', [ProfileController::class, 'index'])->name('profil.index');
Route::get('/profil/results', [ProfileController::class, 'getResults'])->name('profil.results');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Protected Routes - Peserta & Admin
Route::middleware('auth')->group(function () {
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

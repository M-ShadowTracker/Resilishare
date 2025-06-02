<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\URLTestController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Welcome Page
Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login');
    Route::get('/register', 'showRegistrationForm')->name('register');
    Route::post('/register', 'register');
    Route::post('/logout', 'logout')->name('logout');
    
    // Password Reset Routes
    Route::get('/forgot-password', 'showForgotPasswordForm')->name('password.request');
    Route::post('/forgot-password', 'sendResetLinkEmail')->name('password.email');
    Route::get('/reset-password/{token}', 'showResetPasswordForm')->name('password.reset');
    Route::post('/reset-password', 'resetPassword')->name('password.update');

    
});

// Admin Routes
Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::middleware(['auth', 'is_admin'])->group(function () {
    
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
});
    // Quiz Management
    Route::get('/quizzes', [AdminController::class, 'manageQuizzes'])->name('admin.manage.quizzes');
    Route::post('/quizzes/add', [AdminController::class, 'addQuiz'])->name('admin.quizzes.add');
    Route::post('/quizzes/{quizId}/add-question', [AdminController::class, 'addQuestion'])->name('admin.quizzes.add-question');
    
    // File Management
    Route::get('/files', [AdminController::class, 'manageFiles'])->name('admin.manage.files');
    Route::delete('/files/{fileId}', [AdminController::class, 'deleteFile'])->name('admin.files.delete');
});

// User Routes
Route::middleware('auth')->prefix('user')->group(function () {
    // Dashboard
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::post('/profile/update', [UserController::class, 'updateProfile'])->name('user.profile.update');
    Route::post('/password/change', [UserController::class, 'changePassword'])->name('user.password.change');
    
    // Quiz
    Route::get('/quiz', [QuizController::class, 'showQuizSelection'])->name('user.quiz');
    Route::get('/quiz/{quizId}/start', [QuizController::class, 'startQuiz'])->name('user.quiz.start');
    Route::post('/quiz/{quizId}/attempt/{attemptId}', [QuizController::class, 'submitQuiz'])->name('user.quiz.submit');
    Route::get('/quiz/results/{attemptId}', [QuizController::class, 'viewResults'])->name('user.quiz.results');
    
    // File Sharing
    Route::get('/file/upload', [FileController::class, 'showUploadForm'])->name('user.file.upload');
    Route::post('/file/upload', [FileController::class, 'uploadFile']);
    Route::delete('/file/{fileId}', [FileController::class, 'deleteFile'])->name('user.file.delete');
    
    // URL Test
    Route::get('/url-test', [URLTestController::class, 'showTestForm'])->name('user.url-test');
    Route::post('/url-test', [URLTestController::class, 'testURL']);

     Route::post('/password/change', [UserController::class, 'changePassword'])
        ->name('user.password.change');
});

// Public File Download Route
Route::get('/file/download/{code}', [FileController::class, 'downloadFile'])->name('file.download');
Route::post('/quiz/{quizId}/attempt/{attemptId}/submit', [QuizController::class, 'submitQuiz'])->name('quiz.submit');


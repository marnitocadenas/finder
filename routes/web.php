<?php

use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ClaimController as AdminClaimController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\FoundItemController as AdminFoundItemController;
use App\Http\Controllers\Admin\LostItemController as AdminLostItemController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Staff\ClaimController as StaffClaimController;
use App\Http\Controllers\Staff\DashboardController as StaffDashboardController;
use App\Http\Controllers\Staff\FoundItemController as StaffFoundItemController;
use App\Http\Controllers\Staff\LostReportController;
use App\Http\Controllers\Student\BrowseController;
use App\Http\Controllers\Student\ClaimController as StudentClaimController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\LostItemController as StudentLostItemController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicController::class, 'index'])->name('home');
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendOtp'])->name('password.email');
    Route::get('/verify-password-otp', [ForgotPasswordController::class, 'showOtpForm'])->name('password.otp');
    Route::post('/verify-password-otp', [ForgotPasswordController::class, 'verifyOtp'])->name('password.otp.verify');
    Route::get('/reset-password', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');
});
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class);
    Route::put('users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
    Route::resource('categories', CategoryController::class)->except('show');
    Route::resource('lost-items', AdminLostItemController::class)->only(['index', 'show', 'edit', 'update', 'destroy']);
    Route::put('lost-items/{id}/restore', [AdminLostItemController::class, 'restore'])->name('lost-items.restore');
    Route::resource('found-items', AdminFoundItemController::class)->only(['index', 'show', 'edit', 'update', 'destroy']);
    Route::put('found-items/{id}/restore', [AdminFoundItemController::class, 'restore'])->name('found-items.restore');
    Route::resource('claims', AdminClaimController::class)->only(['index', 'show', 'update']);
    Route::get('/logs', [ActivityLogController::class, 'index'])->name('logs');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports');
});
Route::middleware(['auth', 'role:staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', [StaffDashboardController::class, 'index'])->name('dashboard');
    Route::resource('found-items', StaffFoundItemController::class);
    Route::resource('claims', StaffClaimController::class)->only(['index', 'show', 'update']);
    Route::get('/lost-reports', [LostReportController::class, 'index'])->name('lost-reports.index');
    Route::get('/lost-reports/{lostReport}', [LostReportController::class, 'show'])->name('lost-reports.show');
});
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
    Route::resource('lost-items', StudentLostItemController::class);
    Route::get('/browse', [BrowseController::class, 'index'])->name('browse');
    Route::resource('claims', StudentClaimController::class)->only(['index', 'create', 'store', 'show']);
});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'password'])->name('profile.password');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.readAll');
    Route::get('/notifications/count', [NotificationController::class, 'count'])->name('notifications.count');
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PsuSubmissionController;
    
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MasterDataController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use Illuminate\Support\Facades\Auth;

Route::get('/', [PageController::class, 'index']);
Route::get('/template-data-teknis', function() {
    return redirect('/download#Template-PSU');
});
Route::get('/download', [PageController::class, 'downloadCenter']);
Route::get('/galeri/{category?}', [PageController::class, 'galeri'])->name('public.galeri');
Route::get('/data-perumahan', [PageController::class, 'dataPerumahan'])->name('public.psu-housing');
Route::get('/data-jalan', [PageController::class, 'dataJalan'])->name('public.data-jalan');

// Authentication Routes
Auth::routes();

// Google Socialite Routes
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('redirect.google');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// Authenticated User Routes (PSU Submission & Dashboard)
Route::middleware(['auth', 'verified.custom'])->group(function () {
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    
    // OTP Verification Routes
    Route::get('/auth/verify-otp', [App\Http\Controllers\Auth\VerificationController::class, 'showOtpForm'])->name('auth.verify-otp');
    Route::post('/auth/verify-otp', [App\Http\Controllers\Auth\VerificationController::class, 'verifyOtp'])->name('auth.verify-otp.post');
    Route::post('/auth/resend-otp', [App\Http\Controllers\Auth\VerificationController::class, 'resendOtp'])->name('auth.resend-otp');
    
    // PSU Submission Routes for authenticated users
    Route::get('/permohonan-psu', [PsuSubmissionController::class, 'index']);
    Route::post('/permohonan-psu', [PsuSubmissionController::class, 'store']);
    Route::get('/permohonan-psu/{no_registrasi}/edit', [PsuSubmissionController::class, 'edit']);
    Route::put('/permohonan-psu/{no_registrasi}', [PsuSubmissionController::class, 'update']);
    
    // User Account Management Routes
    Route::get('/user/profile', [App\Http\Controllers\User\ProfileController::class, 'index'])->name('user.profile');
    Route::put('/user/profile', [App\Http\Controllers\User\ProfileController::class, 'updateProfile'])->name('user.profile.update');
    Route::get('/user/email', [App\Http\Controllers\User\ProfileController::class, 'showEmailForm'])->name('user.email');
    Route::put('/user/email', [App\Http\Controllers\User\ProfileController::class, 'updateEmail'])->name('user.email.update');
    Route::get('/user/password', [App\Http\Controllers\User\ProfileController::class, 'showPasswordForm'])->name('user.password');
    Route::put('/user/password', [App\Http\Controllers\User\ProfileController::class, 'updatePassword'])->name('user.password.update');
    
    // OTP Verification for Account Updates
    Route::get('/user/account/verify-otp', [App\Http\Controllers\User\ProfileController::class, 'showVerifyOtpForm'])->name('user.account.verify-otp');
    Route::post('/user/account/verify-otp', [App\Http\Controllers\User\ProfileController::class, 'verifyAccountUpdate'])->name('user.account.verify-otp.post');

    // Notifications Routes
    Route::get('/user/notifications', [App\Http\Controllers\User\NotificationController::class, 'index'])->name('user.notifications.index');
    Route::post('/user/notifications/{id}/read', [App\Http\Controllers\User\NotificationController::class, 'markAsRead'])->name('user.notifications.read');
    Route::post('/user/notifications/mark-all-read', [App\Http\Controllers\User\NotificationController::class, 'markAllAsRead'])->name('user.notifications.mark-all-read');
});

// Dynamic redirect for /dashboard based on user role
Route::get('/dashboard', function () {
    if (auth()->user()->is_admin) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('user.dashboard');
})->middleware(['auth']);

// Admin Web Routes (Controllers returning Views)
Route::middleware(['auth', 'role:superadmin,kepala', 'verified.custom'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('galeri-kegiatan', App\Http\Controllers\Admin\GaleriKegiatanController::class)->names('admin.galeri-kegiatan');
    Route::delete('galeri-kegiatan/image/{image}', [App\Http\Controllers\Admin\GaleriKegiatanController::class, 'destroyImage'])->name('admin.galeri-kegiatan.destroy-image');
    Route::resource('psu-submissions', App\Http\Controllers\Admin\PsuSubmissionController::class)->only(['index', 'show', 'edit', 'update', 'destroy'])->names('admin.psu-submissions');

    Route::resource('public-downloads', App\Http\Controllers\Admin\PublicDownloadController::class)->names('admin.public-downloads');

    Route::resource('psu-housing', App\Http\Controllers\Admin\PsuHousingController::class)->names('admin.psu-housing');
    Route::resource('data-jalan', App\Http\Controllers\Admin\DataJalanController::class)->names('admin.data-jalan');
    Route::patch('data-jalan/{id}/toggle-public', [App\Http\Controllers\Admin\DataJalanController::class, 'togglePublic'])->name('admin.data-jalan.toggle-public');

    // Account Management, Logs & Master Data (Super Admin only)
    Route::middleware(['role:superadmin'])->group(function () {
        Route::resource('users', App\Http\Controllers\Admin\UserController::class)->names('admin.users');
        Route::get('activity-log', [App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('admin.activity-log.index');

        // Master Data Routes
        Route::prefix('master')->name('admin.master.')->group(function () {
            Route::get('housing-conditions', [MasterDataController::class, 'psuConditionIndex'])->name('housing-conditions.index');
            Route::post('housing-conditions', [MasterDataController::class, 'psuConditionStore'])->name('housing-conditions.store');
            Route::put('housing-conditions/{id}', [MasterDataController::class, 'psuConditionUpdate'])->name('housing-conditions.update');
            Route::delete('housing-conditions/{id}', [MasterDataController::class, 'psuConditionDestroy'])->name('housing-conditions.destroy');
        });
    });
});



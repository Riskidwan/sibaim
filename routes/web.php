<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoadController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PsuSubmissionController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoadController as AdminRoadController;

Route::get('/', [PageController::class, 'index']);
Route::get('/peta', [PageController::class, 'peta']);
Route::get('/kondisi-jalan-tahunan', [PageController::class, 'kondisiTahunan']);
Route::get('/sk-jalan-lingkungan', [PageController::class, 'skJalanLingkungan']);
Route::get('/template-data-teknis', [PageController::class, 'psuTemplates']);
Route::get('/permohonan-psu', [PsuSubmissionController::class, 'index']);
Route::post('/permohonan-psu', [PsuSubmissionController::class, 'store']);
Route::get('/cek-status-psu', [PsuSubmissionController::class, 'checkStatusView'])->name('psu.check_status');
Route::post('/cek-status-psu', [PsuSubmissionController::class, 'checkStatus']);
Route::get('/permohonan-psu/{no_registrasi}/edit', [PsuSubmissionController::class, 'edit']);
Route::put('/permohonan-psu/{no_registrasi}', [PsuSubmissionController::class, 'update']);
Route::post('/cari-registrasi-psu', [PsuSubmissionController::class, 'findRegistrationId']);
Route::redirect('/dashboard', '/admin/dashboard');

// Admin Web Routes (Controllers returning Views)
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('roads', AdminRoadController::class)->names('admin.roads');
    Route::resource('reports', App\Http\Controllers\Admin\RoadConditionReportController::class)->except(['show'])->names('admin.reports');
    Route::resource('sk-jalan-lingkungan', App\Http\Controllers\Admin\SkJalanLingkunganController::class)->except(['show'])->names('admin.sk-jalan-lingkungan');
    Route::resource('psu-submissions', App\Http\Controllers\Admin\PsuSubmissionController::class)->only(['index', 'show', 'update'])->names('admin.psu-submissions');
    Route::resource('psu-templates', App\Http\Controllers\Admin\PsuTemplateController::class)->except(['show'])->names('admin.psu-templates');
});

// API Routes for JSON (Kept for public map compatibility and leaflet)
Route::get('/api/roads', [RoadController::class, 'index']);
Route::post('/api/roads', [RoadController::class, 'store']);
Route::put('/api/roads/{id}', [RoadController::class, 'update']);
Route::delete('/api/roads/{id}', [RoadController::class, 'destroy']);

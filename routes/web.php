<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoadController;
use App\Http\Controllers\PageController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoadController as AdminRoadController;

Route::get('/', [PageController::class, 'index']);
Route::get('/peta', [PageController::class, 'peta']);
Route::get('/kondisi-jalan-tahunan', [PageController::class, 'kondisiTahunan']);
Route::redirect('/dashboard', '/admin/dashboard');

// Admin Web Routes (Controllers returning Views)
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('roads', AdminRoadController::class)->names('admin.roads');
    Route::resource('reports', App\Http\Controllers\Admin\RoadConditionReportController::class)->except(['show'])->names('admin.reports');
});

// API Routes for JSON (Kept for public map compatibility and leaflet)
Route::get('/api/roads', [RoadController::class, 'index']);
Route::post('/api/roads', [RoadController::class, 'store']);
Route::put('/api/roads/{id}', [RoadController::class, 'update']);
Route::delete('/api/roads/{id}', [RoadController::class, 'destroy']);

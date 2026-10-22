<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminComplaintController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\AdminReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Admin auth
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])
    ->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])
    ->name('admin.login.post');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])
    ->name('admin.logout');

// Admin dashboard (protected)
Route::middleware('admin')->prefix('admin')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::get('/complaints', [AdminComplaintController::class, 'index'])
        ->name('admin.complaints.index');
    Route::get('/complaints/{complaint}', [AdminComplaintController::class, 'show'])
        ->name('admin.complaints.show');
    Route::post('/complaints/{complaint}', [AdminComplaintController::class, 'update'])
        ->name('admin.complaints.update');

    Route::get('/settings/commission', [AdminSettingController::class, 'editCommission'])
        ->name('admin.settings.commission');
    Route::post('/settings/commission', [AdminSettingController::class, 'updateCommission'])
        ->name('admin.settings.commission.update');

    Route::get('/reports/sales', [AdminReportController::class, 'sales'])
        ->name('admin.reports.sales');
});

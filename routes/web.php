<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\BeneficiaryController;
use App\Http\Controllers\TariffController;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Providers
    Route::resource('providers', ProviderController::class);

    // Beneficiaries
    Route::resource('beneficiaries', BeneficiaryController::class);

    // Tariffs
    Route::resource('tariffs', TariffController::class);
    Route::get('/tariffs/get-details', [TariffController::class, 'getTariffDetails'])->name('tariffs.get-details');

    // Claims
    Route::resource('claims', ClaimController::class);
    Route::patch('/claims/{claim}/status', [ClaimController::class, 'updateStatus'])->name('claims.update-status');
    Route::get('/claims/{claim}/export-pdf', [ClaimController::class, 'exportPdf'])->name('claims.export-pdf');
    Route::get('/claims/{claim}/export-csv', [ClaimController::class, 'exportCsv'])->name('claims.export-csv');

    // Attachments
    Route::post('/claims/{claim}/attachments', [AttachmentController::class, 'store'])->name('attachments.store');
    Route::get('/attachments/{attachment}/download', [AttachmentController::class, 'download'])->name('attachments.download');
    Route::delete('/attachments/{attachment}', [AttachmentController::class, 'destroy'])->name('attachments.destroy');

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/claims-summary', [ReportController::class, 'claimsSummary'])->name('reports.claims-summary');
    Route::get('/reports/provider-performance', [ReportController::class, 'providerPerformance'])->name('reports.provider-performance');
    Route::get('/reports/beneficiary-utilization', [ReportController::class, 'beneficiaryUtilization'])->name('reports.beneficiary-utilization');
    Route::get('/reports/claims-summary/export-pdf', [ReportController::class, 'exportClaimsSummaryPdf'])->name('reports.claims-summary.export-pdf');
    Route::get('/reports/claims-summary/export-csv', [ReportController::class, 'exportClaimsSummaryCsv'])->name('reports.claims-summary.export-csv');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

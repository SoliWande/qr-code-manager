<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductScanController;
use App\Http\Controllers\ScanLogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CaseFileController;
use App\Http\Controllers\EvidenceController;
use App\Http\Controllers\EvidenceStorageController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/scan', [ProductScanController::class, 'index'])
        ->name('products.scan');

    Route::get('/api/products/qr/{code}', [ProductScanController::class, 'findByQrCode'])
        ->name('products.find-by-qr');
});

Route::middleware(['auth', 'role:scene_officer,commander'])->group(function () {
    Route::get('/case-files', [CaseFileController::class, 'index'])
        ->name('case_files.index');

    Route::get('/case-files/create', [CaseFileController::class, 'create'])
        ->name('case_files.create');

    Route::post('/case-files', [CaseFileController::class, 'store'])
        ->name('case_files.store');

    Route::get('/case-files/{caseFile}', [CaseFileController::class, 'show'])
        ->name('case_files.show');

    Route::get('/case-files/{caseFile}/evidences/create', [EvidenceController::class, 'create'])
        ->name('evidences.create');

    Route::post('/case-files/{caseFile}/evidences', [EvidenceController::class, 'store'])
        ->name('evidences.store');
});

Route::middleware(['auth', 'role:storage_keeper,commander'])->group(function () {
    Route::get('/evidence-storage', [EvidenceStorageController::class, 'index'])
        ->name('evidence_storage.index');

    Route::get('/scan-logs', [ScanLogController::class, 'index'])
        ->name('scan_logs.index');
});

Route::middleware(['auth', 'role:scene_officer,storage_keeper,commander'])->group(function () {
    Route::get('/products/qrcodes', [ProductScanController::class, 'qrCodes'])
        ->name('products.qrcodes');
});

require __DIR__.'/auth.php';

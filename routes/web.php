<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductScanController;
use App\Http\Controllers\ScanLogController;

Route::get('/scan', [ProductScanController::class, 'index'])
    ->name('products.scan');

Route::get('/api/products/qr/{code}', [ProductScanController::class, 'findByQrCode'])
    ->name('products.find-by-qr');

Route::get('/scan-logs', [ScanLogController::class, 'index'])
    ->name('scan_logs.index');

Route::get('/products/qrcodes', [ProductScanController::class, 'qrCodes'])
    ->name('products.qrcodes');

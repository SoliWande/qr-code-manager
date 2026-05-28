<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ScanLog;

class DashboardController extends Controller
{
    public function index()
    {
        $recentLogs = ScanLog::with(['product', 'user'])
            ->latest()
            ->limit(20)
            ->get();

        $totalProducts = Product::count();

        $totalScansToday = ScanLog::whereDate('created_at', today())->count();

        $totalImportToday = ScanLog::whereDate('created_at', today())
            ->where('action', ScanLog::ACTION_IMPORT_STOCK)
            ->count();

        $totalExportToday = ScanLog::whereDate('created_at', today())
            ->where('action', ScanLog::ACTION_EXPORT_STOCK)
            ->count();

        $totalCaseFiles = \App\Models\CaseFile::count();
        $totalEvidences = \App\Models\Product::count();
        $totalInStorage = \App\Models\Product::where('storage_status', 'in_storage')->count();
        $totalCheckedOut = \App\Models\Product::where('storage_status', 'checked_out')->count();

        return view('dashboard', compact(
            'recentLogs',
            'totalProducts',
            'totalScansToday',
            'totalImportToday',
            'totalExportToday'
        ));
    }
}

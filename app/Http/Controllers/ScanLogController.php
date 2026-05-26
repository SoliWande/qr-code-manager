<?php

namespace App\Http\Controllers;

use App\Models\ScanLog;

class ScanLogController extends Controller
{
    public function index()
    {
        $logs = ScanLog::with(['product', 'user'])
            ->latest()
            ->paginate(30);

        return view('scan_logs.index', compact('logs'));
    }
}

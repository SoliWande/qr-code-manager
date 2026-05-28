<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ScanLog;

class EvidenceStorageController extends Controller
{
    public function index()
    {
        $evidences = Product::with(['caseFile', 'storage'])
            ->latest()
            ->paginate(30);

        $recentLogs = ScanLog::with(['product.caseFile', 'user'])
            ->latest()
            ->limit(30)
            ->get();

        return view('evidence_storage.index', compact('evidences', 'recentLogs'));
    }
}

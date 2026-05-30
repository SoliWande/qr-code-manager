<?php

namespace App\Http\Controllers;

use App\Models\EvidenceStorage;
use App\Models\Product;
use App\Models\ScanLog;
use Illuminate\Http\Request;

class EvidenceStorageController extends Controller
{
    public function index()
    {
        $storages = EvidenceStorage::withCount([
            'products',
            'products as in_storage_count' => function ($query) {
                $query->where('storage_status', Product::STORAGE_STATUS_IN_STORAGE);
            },
            'products as assessment_count' => function ($query) {
                $query->where('storage_status', Product::STORAGE_STATUS_ASSESSMENT);
            },
            'products as returned_count' => function ($query) {
                $query->where('storage_status', Product::STORAGE_STATUS_RETURNED);
            },
            'products as destroyed_count' => function ($query) {
                $query->where('storage_status', Product::STORAGE_STATUS_DESTROYED);
            },
        ])
            ->orderBy('storage_code')
            ->paginate(20);

        return view('evidence_storage.index', compact('storages'));
    }

    public function create()
    {
        return view('evidence_storage.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'storage_code' => ['required', 'string', 'max:191', 'unique:evidence_storages,storage_code'],
            'name' => ['required', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        EvidenceStorage::create([
            'storage_code' => $request->storage_code,
            'name' => $request->name,
            'location' => $request->location,
            'description' => $request->description,
        ]);

        return redirect()
            ->route('evidence_storage.index')
            ->with('success', 'Đã tạo kho vật chứng.');
    }

    public function show(EvidenceStorage $evidenceStorage)
    {
        $evidenceStorage->loadCount([
            'products',
            'products as in_storage_count' => function ($query) {
                $query->where('storage_status', Product::STORAGE_STATUS_IN_STORAGE);
            },
            'products as assessment_count' => function ($query) {
                $query->where('storage_status', Product::STORAGE_STATUS_ASSESSMENT);
            },
            'products as returned_count' => function ($query) {
                $query->where('storage_status', Product::STORAGE_STATUS_RETURNED);
            },
            'products as destroyed_count' => function ($query) {
                $query->where('storage_status', Product::STORAGE_STATUS_DESTROYED);
            },
        ]);

        $products = Product::with(['caseFile', 'storage'])
            ->where('evidence_storage_id', $evidenceStorage->id)
            ->orderByDesc('updated_at')
            ->paginate(30);

        $recentLogs = ScanLog::with(['product.caseFile', 'user'])
            ->whereHas('product', function ($query) use ($evidenceStorage) {
                $query->where('evidence_storage_id', $evidenceStorage->id);
            })
            ->latest()
            ->limit(20)
            ->get();

        return view('evidence_storage.show', compact(
            'evidenceStorage',
            'products',
            'recentLogs'
        ));
    }
}

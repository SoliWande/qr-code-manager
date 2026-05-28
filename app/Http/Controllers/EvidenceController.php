<?php

namespace App\Http\Controllers;

use App\Models\CaseFile;
use App\Models\Product;
use Illuminate\Http\Request;

class EvidenceController extends Controller
{
    public function create(CaseFile $caseFile)
    {
        return view('evidences.create', compact('caseFile'));
    }

    public function store(Request $request, CaseFile $caseFile)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'integer'],
            'sku' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $evidence = Product::create([
            'case_file_id' => $caseFile->id,
            'qr_code' => $this->generateEvidenceCode($caseFile),
            'type' => $request->type,
            'name' => $request->name,
            'sku' => $request->sku,
            'price' => 0,
            'stock' => 1,
            'location' => $request->location,
            'description' => $request->description,
        ]);

        return redirect()
            ->route('case_files.show', $caseFile)
            ->with('success', 'Đã thêm mẫu vật chứng.');
    }

    private function generateEvidenceCode(CaseFile $caseFile): string
    {
        $count = Product::where('case_file_id', $caseFile->id)->count() + 1;

        return $caseFile->case_code . '-VC' . str_pad($count, 3, '0', STR_PAD_LEFT);
    }
}

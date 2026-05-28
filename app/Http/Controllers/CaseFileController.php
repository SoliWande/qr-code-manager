<?php

namespace App\Http\Controllers;

use App\Models\CaseFile;
use Illuminate\Http\Request;

class CaseFileController extends Controller
{
    public function index()
    {
        $caseFiles = CaseFile::latest()->paginate(20);

        return view('case_files.index', compact('caseFiles'));
    }

    public function create()
    {
        return view('case_files.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'scene_location' => ['nullable', 'string', 'max:255'],
            'officer_name' => ['nullable', 'string', 'max:255'],
            'case_date' => ['nullable', 'date'],
            'description' => ['nullable', 'string'],
        ]);

        $caseFile = CaseFile::create([
            'case_code' => $this->generateCaseCode(),
            'title' => $request->title,
            'scene_location' => $request->scene_location,
            'officer_name' => $request->officer_name,
            'case_date' => $request->case_date,
            'description' => $request->description,
            'status' => 'open',
        ]);

        return redirect()
            ->route('case_files.show', $caseFile)
            ->with('success', 'Đã tạo hồ sơ thành công.');
    }

    public function show(CaseFile $caseFile)
    {
        $caseFile->load(['products']);

        return view('case_files.show', compact('caseFile'));
    }

    private function generateCaseCode(): string
    {
        $lastCaseFile = CaseFile::orderByDesc('id')->first();

        $nextNumber = $lastCaseFile ? $lastCaseFile->id + 1 : 1;

        return 'HS' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\CaseFile;
use Illuminate\Http\Request;
use App\Models\User;

class CaseFileController extends Controller
{
    public function index()
    {
        $caseFiles = CaseFile::latest()->paginate(20);

        return view('case_files.index', compact('caseFiles'));
    }

    public function create()
    {
        $users = User::orderBy('name')->get();

        return view('case_files.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'scene_location' => ['nullable', 'string', 'max:255'],
            'officer_user_id' => ['nullable', 'exists:users,id'],
            'case_date' => ['nullable', 'date'],
            'description' => ['nullable', 'string'],
        ]);

        $officer = null;

        if ($request->filled('officer_user_id')) {
            $officer = User::find($request->officer_user_id);
        }

        $caseFile = CaseFile::create([
            'case_code' => $this->generateCaseCode(),
            'title' => $request->title,
            'scene_location' => $request->scene_location,
            'officer_user_id' => $request->officer_user_id,
            'officer_name' => $officer ? $officer->name : null,
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

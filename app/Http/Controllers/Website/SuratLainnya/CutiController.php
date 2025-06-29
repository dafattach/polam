<?php

namespace App\Http\Controllers\Website\SuratLainnya;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Employee\Employee;
use App\Models\Guide;

class CutiController extends Controller
{
    function index() {
        $guide = Guide::where('type', Submission::TYPES[5])->first();
        $data = Submission::where('user_id', Auth::id())->where('type', Submission::TYPES[5])->with('user')->orderBy('created_at', 'desc')->paginate(10);
        return view('website.surat-lainnya.cuti.index', compact('data', 'guide'));
    }

    function store(Request $request) {
        $request->validate([
            'name' => ['required', 'string'],
            'registration_number' => ['required', 'string'],
            'department' => ['required', 'string'],
            'semester' => ['required', 'string'],
            'academic_year' => ['required', 'string'],
            'parent_name' => ['required', 'string'],
            'excuse' => ['required', 'string'],
            'supporting_documents' => ['required', 'file', 'mimes:pdf', 'max:2048'],
        ]);

        // upload pdf dulu
        if ($request->file('supporting_documents')->isValid()) {
            $path = $request->supporting_documents->store('surat-lainnya/cuti');
            if ($path) {
                $request->merge(['supporting_documents_path' => $path]);
            } else {
                return redirect()->route('surat-lainnya.cuti.index')->with([
                    'status' => 'error',
                    'message' => 'Gagal upload berkas pendukung',
                ]);
            }
        }

        $create = Submission::create([
            'user_id' => Auth::id(),
            'type' => Submission::TYPES[5],
            'data' => json_encode($request->except('_token')),
        ]);

        if ($create) {
            return redirect()->route('surat-lainnya.cuti.index')->with([
                'status' => 'success',
                'message' => 'Ajuan berhasil disimpan',
            ]);
        }

        return redirect()->route('surat-lainnya.cuti.index')->with([
            'status' => 'error',
            'message' => 'Ajuan gagal disimpan',
        ]);
    }

    function preview(Request $request, Submission $submission) {
        // lazy load relasinya biar ringan
        $submission->load('user.department', 'approvedByEmployee');

        // get data tambahan
        $dekan = Employee::whereHas('position', function ($query) {
            $query->where('code', 'dekan');
        })->latest()->first();

        // Prepare PDF nya
        $file = view('pdf.surat-lainnya.cuti.index', compact('submission', 'dekan'))->render();

        return Pdf::loadHTML($file)->setPaper('a4', 'potrait')->setWarnings(false)->stream();
    }
}

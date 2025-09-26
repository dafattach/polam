<?php

namespace App\Http\Controllers\Admin\SuratPengantar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\SubmissionOrderingService;

class PenelitianMatkulController extends Controller
{
    function index(Request $request) {
        $query = Submission::where('type', Submission::TYPES[2]);
        $submissionType = SubmissionOrderingService::getSubmissionTypeString(2);
        $submissions = SubmissionOrderingService::applyOrdering($query, $submissionType)->paginate(10);
        return view('admin.surat-pengantar.penelitian-matkul.index', compact('submissions'));
    }

    function show(Request $request, Submission $submission) {
        return view('admin.surat-pengantar.penelitian-matkul.show', compact('submission'));
    }

    function update(Request $request, Submission $submission) {
        $request->validate([
            'type' => ['required', 'in:verified,approved,rejected'],
            'note' => ['required_if:type,rejected'],
        ]);

        // handle proses penolakan
        if ($request->type == 'rejected') {
            $submission->update([
                'rejected_at' => Carbon::now(),
                'rejected_by' => Auth::guard('employee')->id(),
                'rejected_note' => $request->note,
            ]);
        }

        // handle proses verifikasi
        else if ($request->type == 'verified') {
            $submission->update([
                'verified_at' => Carbon::now(),
                'verified_by' => Auth::guard('employee')->id(),
                'verified_note' => $request->note,
            ]);
        }

        // handle proses approval
        else {
            $letterNumber = $submission->nextLetterNumber();

            $submission->update([
                'approved_at' => Carbon::now(),
                'approved_by' => Auth::guard('employee')->id(),
                'approved_note' => $request->note,
                'letter_number' => $letterNumber,
            ]);
        }

        return redirect()->route('admin.surat-pengantar.penelitian-matkul.index')->with([
            'status' => 'success',
            'message' => 'Ajuan berhasil diproses',
        ]);
    }

    public function preview(Request $request, Submission $submission)
    {
        // lazy load relasinya biar ringan
        $submission->load('user.department', 'approvedByEmployee');

        // Prepare PDF nya
        $file = view('pdf.surat-pengantar.penelitian-matkul.index', compact('submission'))->render();
        return Pdf::loadHTML($file)->setPaper('a4', 'potrait')->setWarnings(false)->stream();
    }
}

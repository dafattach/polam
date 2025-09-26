<?php

namespace App\Http\Controllers\Admin\SuratRekomendasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\SubmissionOrderingService;

class MbkmController extends Controller
{
    function index(Request $request) {
        $query = Submission::where('type', Submission::TYPES[10]);
        $submissionType = SubmissionOrderingService::getSubmissionTypeString(10);
        $submissions = SubmissionOrderingService::applyOrdering($query, $submissionType)->paginate(10);
        return view('admin.surat-rekomendasi.mbkm.index', compact('submissions'));
    }

    function show(Request $request, Submission $submission) {
        return view('admin.surat-rekomendasi.mbkm.show', compact('submission'));
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

        return redirect()->route('admin.surat-rekomendasi.mbkm.index')->with([
            'status' => 'success',
            'message' => 'Ajuan berhasil diproses',
        ]);
    }

    public function preview(Request $request, Submission $submission)
    {
        // prepare tahun ajaran
        $createdAt = Carbon::parse($submission->created_at);
        $yearStart = $createdAt->year;
        $yearEnd = $createdAt->year;

        if ($createdAt->month <= 7) { // genap, februari sampai juli atau ganjil tahun lalu
            $yearStart -= 1;
        } else {
            $yearEnd += 1;
        }

        // gabung tahun ajarannya
        $academicYear = $yearStart . '-' . $yearEnd;

        // lazy load relasinya biar ringan
        $submission->load('user.department', 'approvedByEmployee');

        // Prepare PDF nya
        $file = view('pdf.surat-rekomendasi.mbkm.index', compact('submission', 'academicYear'))->render();
        return Pdf::loadHTML($file)->setPaper('a4', 'potrait')->setWarnings(false)->stream();
    }
}

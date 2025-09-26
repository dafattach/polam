<?php

namespace App\Http\Controllers\Admin\SuratLainnya;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Services\SubmissionOrderingService;

class TranskripController extends Controller
{
    function index(Request $request) {
        $query = Submission::where('type', Submission::TYPES[8]);
        $submissionType = SubmissionOrderingService::getSubmissionTypeString(8);
        $submissions = SubmissionOrderingService::applyOrdering($query, $submissionType)->paginate(10);
        return view('admin.surat-lainnya.transkrip.index', compact('submissions'));
    }

    function show(Request $request, Submission $submission) {
        return view('admin.surat-lainnya.transkrip.show', compact('submission'));
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
            $request->validate([
                'transkrip_file' => ['required', 'file', 'mimes:pdf', 'max:2048'],
            ]);

            // upload pdf dulu
            $additional = [];
            if ($request->file('transkrip_file')->isValid()) {
                $path = $request->transkrip_file->store('surat-lainnya/transkrip');
                if ($path) {
                    // update json data
                    $data = json_decode($submission->data);
                    $data->transkrip_file_path = $path;
                    $additional = ['data' => json_encode($data)];
                } else {
                    return redirect()->route('admin.surat-lainnya.transkrip.index')->with([
                        'status' => 'error',
                        'message' => 'Gagal upload berkas transkrip',
                    ]);
                }
            }

            $submission->update([
                'verified_at' => Carbon::now(),
                'verified_by' => Auth::guard('employee')->id(),
                'verified_note' => $request->note,
            ] + $additional);
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

        return redirect()->route('admin.surat-lainnya.transkrip.index')->with([
            'status' => 'success',
            'message' => 'Ajuan berhasil diproses',
        ]);
    }
}

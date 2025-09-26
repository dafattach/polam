<?php

namespace App\Http\Controllers\Website\SuratLainnya;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Employee\Employee;
use Carbon\Carbon;
use App\Models\Guide;

class TranskripController extends Controller
{
    function index() {
        $guide = Guide::where('type', Submission::TYPES[8])->first();
        $data = Submission::where('user_id', Auth::id())->where('type', Submission::TYPES[8])->with('user')->orderBy('created_at', 'desc')->paginate(10);
        return view('website.surat-lainnya.transkrip.index', compact('data', 'guide'));
    }

    function store(Request $request) {
        $request->validate([
            'name' => ['required', 'string'],
            'registration_number' => ['required', 'string'],
            'department' => ['required', 'string'],
            'purpose' => ['required', 'string', 'in:Semhas,Beasiswa,KKN,PKL,Banding UKT,Lain-Lain'],
        ]);

        $now = Carbon::now();

        // Determine current semester based on current date
        // Even semester (genap): February 1st to July 31st (same year)
        // Odd semester (ganjil): August 1st to January 31st (next year)

        if ($now->month >= 2 && $now->month <= 7) {
            // Even semester (genap): February 1st to July 31st
            $startSemester = Carbon::now()->startOfMonth()->setMonth(2); // 1 Februari Tahun Ini
            $endSemester = Carbon::now()->startOfMonth()->setMonth(7)->endOfMonth(); // 31 Juli Tahun Ini
        } else {
            // Odd semester (ganjil): August 1st to January 31st (next year)
            if ($now->month >= 8) {
                // August to December - current year to next year
                $startSemester = Carbon::now()->startOfMonth()->setMonth(8); // 1 Agustus Tahun Ini
                $endSemester = Carbon::now()->startOfMonth()->setMonth(1)->endOfMonth()->addYears(1); // 31 Januari Tahun Depan
            } else {
                // January - this is part of previous year's odd semester
                $startSemester = Carbon::now()->startOfMonth()->setMonth(8)->subYears(1); // 1 Agustus Tahun Lalu
                $endSemester = Carbon::now()->startOfMonth()->setMonth(1)->endOfMonth(); // 31 Januari Tahun Ini
            }
        }

        // Count existing transcript requests in current semester
        $existingRequestsCount = Submission::where('user_id', Auth::id())
            ->where('type', Submission::TYPES[8])
            ->where(function ($query) use ($startSemester, $endSemester) {
                // Count pending requests (not yet approved/rejected)
                $query->whereNull('approved_at')->whereNull('rejected_at')
                ->whereDate('created_at', '>=', $startSemester)->whereDate('created_at', '<=', $endSemester);
            })
            ->orWhere(function ($query) use ($startSemester, $endSemester) {
                // Count approved requests in current semester
                $query->whereDate('approved_at', '>=', $startSemester)->whereDate('approved_at', '<=', $endSemester);
            })
            ->count();

        // Check if user has already reached the limit of 2 requests per semester
        if ($existingRequestsCount >= 2) {
            return redirect()->route('surat-lainnya.transkrip.index')->with([
                'status' => 'error',
                'message' => 'Sudah mencapai batas maksimal 2 kali pengajuan dalam kurun waktu 1 semester',
            ]);
        }

        $create = Submission::create([
            'user_id' => Auth::id(),
            'type' => Submission::TYPES[8],
            'data' => json_encode($request->except('_token')),
        ]);

        if ($create) {
            return redirect()->route('surat-lainnya.transkrip.index')->with([
                'status' => 'success',
                'message' => 'Ajuan berhasil disimpan',
            ]);
        }

        return redirect()->route('surat-lainnya.transkrip.index')->with([
            'status' => 'error',
            'message' => 'Ajuan gagal disimpan',
        ]);
    }
}

@extends('website.layout')

@section('content')
<!-- ======= Breadcrumbs ======= -->
<section class="breadcrumbs">
  <div class="container">
    <ol>
      <li><a href="{{ route('index') }}">Beranda</a></li>
      <li>Surat Lainnya</li>
      <li>Transkrip</li>
    </ol>
    <h2>Transkrip</h2>
  </div>
</section><!-- End Breadcrumbs -->

<section class="inner-page">
  <div class="container">
    <header class="section-header">
      <h2>Surat Lainnya Transkrip</h2>
      <p>Riwayat Pengajuan</p>
    </header>

    @if ($guide && $guide->fileUrl)
      <div class="d-flex align-items-center gap-2 mb-2">
        <span>Unduh panduan pengajuan Transkrip</span>
        <a href="{{ $guide->fileUrl }}" target="_blank" class="btn btn-secondary">Unduh</a>
      </div>
    @endif

    <table class="table table-striped">
      <thead class="table-dark text-center">
        <tr>
          <th>No.</th>
          <th>Nama</th>
          <th>Tanggal Pengajuan</th>
          <th>Status Pengajuan</th>
          <th>Periksa Dokumen</th>
        </tr>
      </thead>
      <tbody class="text-center align-middle">
        @foreach ($data as $key => $datum)
        <tr>
          <td>{{ $key+1 }}.</td>
          <td>{{ $datum->user->name }}</td>
          <td>{{ $datum->formattedCreatedAt }}</td>
          <td>
            <div class="badge badge-{{ $datum->StatusBadge }}">
              {{ $datum->status }}
            </div>
          </td>
          <td>
            @if($datum->approved_at)
              @php
                $pdf = json_decode($datum->data);
              @endphp
              <a href="{{ asset('storage/' . $pdf->transkrip_file_path ?? '') }}" target="_blank" class="btn btn-primary {{ $pdf->transkrip_file_path ?? null ? '':'disabled' }}">Buka</a>
            @elseif($datum->rejected_at)
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#rejectionModal{{ $datum->id }}">
                    Alasan Ditolak
                </button>

                <!-- Modal -->
                <div class="modal fade" id="rejectionModal{{ $datum->id }}" tabindex="-1" aria-labelledby="rejectionModalLabel{{ $datum->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="rejectionModalLabel{{ $datum->id }}">Alasan Penolakan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="preserve-whitespace">{!! $datum->rejected_note !!}</div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <div class="blog pt-1">
      {{ $data->onEachSide(1)->links('vendor.pagination.website') }}
    </div>

    <div class="mt-5">
      <header class="section-header">
        <h2>Surat Lainnya Transkrip</h2>
        <p>Form Pengajuan</p>
      </header>
      <form action="{{ route('surat-lainnya.transkrip.store') }}" method="post">
        @csrf
        @if ($errors->any())
          <div class="alert alert-danger">
            <ul class="mb-0">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <div class="row mb-3">
          <h5 class="fw-bold">Informasi Mahasiswa</h5>
          <div class="col">
            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ Auth::user()->name }}" readonly>
            @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="col">
            <label class="form-label">NPM Mahasiswa <span class="text-danger">*</span></label>
            <input type="text" name="registration_number" class="form-control @error('registration_number') is-invalid @enderror" value="{{ Auth::user()->registration_number }}" readonly>
            @error('registration_number')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="col">
            <label class="form-label">Program Studi <span class="text-danger">*</span></label>
            <input type="text" name="department" class="form-control @error('department') is-invalid @enderror" value="{{ Auth::user()->department->name }}" readonly>
            @error('department')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-4">
            <label class="form-label">Keperluan <span class="text-danger">*</span></label>
            <select name="purpose" class="form-control @error('purpose') is-invalid @enderror" required>
              <option value="" disabled selected>Pilih Keperluan</option>
              <option value="Semhas">Semhas</option>
              <option value="Beasiswa">Beasiswa</option>
              <option value="KKN">KKN</option>
              <option value="PKL">PKL</option>
              <option value="Banding UKT">Banding UKT</option>
              <option value="Lain-Lain">Lain-Lain</option>
            </select>
            @error('purpose')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="d-grid d-md-flex justify-content-md-end">
          <button type="submit" class="btn btn-primary btn-lg">Ajukan</button>
        </div>
      </form>
    </div>
  </div>
</section>
@stop
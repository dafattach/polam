@extends('website.layout')

@section('content')
<!-- ======= Breadcrumbs ======= -->
<section class="breadcrumbs">
  <div class="container">
    <ol>
      <li><a href="{{ route('index') }}">Beranda</a></li>
      <li>Surat Pengantar</li>
      <li>Penelitian Skripsi</li>
    </ol>
    <h2>Penelitian Skripsi</h2>
  </div>
</section><!-- End Breadcrumbs -->

<section class="inner-page">
  <div class="container">
    <header class="section-header">
      <h2>Surat Pengantar Penelitian Skripsi</h2>
      <p>Riwayat Pengajuan</p>
    </header>

    @if ($guide && $guide->fileUrl)
      <div class="d-flex align-items-center gap-2 mb-2">
        <span>Unduh panduan pengajuan Surat Pengantar Penelitian Skripsi</span>
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
                <a href="{{ route('surat-pengantar.skripsi.preview', $datum->id) }}" target="_blank" class="btn btn-primary">Buka</a>
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
        <h2>Surat Pengantar Penelitian Skripsi</h2>
        <p>Form Pengajuan</p>
      </header>
      <form action="{{ route('surat-pengantar.skripsi.store') }}" method="post">
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

        <div class="row mb-4">
          <h5 class="fw-bold">Mahasiswa</h5>
          <div class="col">
            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
            <input type="text" name="name[]" class="form-control @error('name.0') is-invalid @enderror" value="{{ Auth::user()->name }}" readonly>
            @error('name.0')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="col">
            <label class="form-label">NPM Mahasiswa <span class="text-danger">*</span></label>
            <input type="text" name="registration_number[]" class="form-control @error('registration_number.0') is-invalid @enderror" value="{{ Auth::user()->registration_number }}" readonly>
            @error('registration_number.0')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="row mb-3">
          <h5 class="fw-bold">Informasi Penelitian</h5>
          <div class="col">
            <label class="form-label">Keperluan Penelitian <span class="text-danger">*</span></label>
            <input type="text" name="research_purpose" class="form-control @error('research_purpose') is-invalid @enderror" value="{{ old('research_purpose') }}" required>
            @error('research_purpose')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="col">
            <label class="form-label">Judul Penelitian <span class="text-danger">*</span></label>
            <input type="text" name="research_title" class="form-control @error('research_title') is-invalid @enderror" value="{{ old('research_title') }}" required>
            @error('research_title')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="row mb-3">
          <h5 class="fw-bold">Informasi Perusahaan</h5>
          <div class="col">
            <label class="form-label">Nama Instansi/Perusahaan <span class="text-danger">*</span></label>
            <input type="text" name="company_name" class="form-control @error('company_name') is-invalid @enderror" value="{{ old('company_name') }}" required>
            <div class="form-text">Contoh: PT. Daily Planet, CV. Alexander Family, dll.</div>
            @error('company_name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="col">
            <label class="form-label">Nama Bagian/Divisi <span class="text-danger">*</span></label>
            <input type="text" name="company_division" class="form-control @error('company_division') is-invalid @enderror" value="{{ old('company_division') }}" required>
            <div class="form-text">Contoh: Bagian Penjualan, Divisi Marketing, Bagian Keuangan, Divisi  Umum, dll.</div>
            @error('company_division')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="row mb-3">
          <div class="col">
            <label class="form-label">Nomor Telepon Perusahaan <span class="text-danger">*</span></label>
            <input type="text" name="company_phone" class="form-control @error('company_phone') is-invalid @enderror" value="{{ old('company_phone') }}" required>
            <div class="form-text">Contoh: 021990990, 031880880, 081234567890 (hanya angka).</div>
            @error('company_phone')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="col">
            <label class="form-label">Tanggal Mulai Penelitian <span class="text-danger">*</span></label>
            <input type="date" name="starting_date" class="form-control @error('starting_date') is-invalid @enderror" value="{{ old('starting_date') }}" required>
            @error('starting_date')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="row mb-4">
          <div class="col">
            <label class="form-label">Alamat Perusahaan <span class="text-danger">*</span></label>
            <input type="text" name="company_address" class="form-control @error('company_address') is-invalid @enderror" value="{{ old('company_address') }}" required>
            <div class="form-text">WAJIB copas alamat lengkap dari google maps.</div>
            @error('company_address')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="row mb-3">
          <h5 class="fw-bold">Catatan Lain</h5>
          <div class="col">
            <label class="form-label">Catatan Khusus Untuk Staff</label>
            <textarea name="note" rows="5" class="form-control @error('note') is-invalid @enderror">{{ old('note') }}</textarea>
            <div class="form-text">Perihal atau keterangan lain yang perlu ditambahkan dalam ajuan. Boleh dikosongkan</div>
            @error('note')
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
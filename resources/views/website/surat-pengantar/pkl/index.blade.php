@extends('website.layout')

@section('content')
<!-- ======= Breadcrumbs ======= -->
<section class="breadcrumbs">
  <div class="container">
    <ol>
      <li><a href="{{ route('index') }}">Beranda</a></li>
      <li>Surat Pengantar</li>
      <li>Praktek Kerja Lapangan</li>
    </ol>
    <h2>Praktek Kerja Lapangan</h2>
  </div>
</section><!-- End Breadcrumbs -->

<section class="inner-page">
  <div class="container">
    <header class="section-header">
      <h2>Surat Pengantar PKL</h2>
      <p>Riwayat Pengajuan</p>
    </header>

    @if ($guide && $guide->fileUrl)
      <div class="d-flex align-items-center gap-2 mb-2">
        <span>Unduh panduan pengajuan Surat Pengantar PKL</span>
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
                <a href="{{ route('surat-pengantar.pkl.preview', $datum->id) }}" target="_blank" class="btn btn-primary">Buka</a>
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
        <h2>Surat Pengantar PKL</h2>
        <p>Form Pengajuan</p>
      </header>
      <form action="{{ route('surat-pengantar.pkl.store') }}" method="post">
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
          <h5 class="fw-bold">Mahasiswa 1</h5>
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

        <div class="row mb-4">
          <h5 class="fw-bold">Mahasiswa 2</h5>
          <div class="col">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="name[]" class="form-control @error('name.1') is-invalid @enderror">
            @error('name.1')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="col">
            <label class="form-label">NPM Mahasiswa</label>
            <input type="text" name="registration_number[]" class="form-control @error('registration_number.1') is-invalid @enderror">
            @error('registration_number.1')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="row mb-4">
          <h5 class="fw-bold">Mahasiswa 3</h5>
          <div class="col">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="name[]" class="form-control @error('name.2') is-invalid @enderror">
            @error('name.2')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="col">
            <label class="form-label">NPM Mahasiswa</label>
            <input type="text" name="registration_number[]" class="form-control @error('registration_number.2') is-invalid @enderror">
            @error('registration_number.2')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="row mb-4">
          <h5 class="fw-bold">Mahasiswa 4</h5>
          <div class="col">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="name[]" class="form-control @error('name.3') is-invalid @enderror">
            @error('name.3')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="col">
            <label class="form-label">NPM Mahasiswa</label>
            <input type="text" name="registration_number[]" class="form-control @error('registration_number.3') is-invalid @enderror">
            @error('registration_number.3')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="row mb-3">
          <h5 class="fw-bold">Informasi Perusahaan</h5>
          <div class="col">
            <label class="form-label">Nama Instansi/Perusahaan <span class="text-danger">*</span></label>
            <input type="text" name="company_name" class="form-control @error('company_name') is-invalid @enderror" required>
            @error('company_name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="col">
            <label class="form-label">Nama Bagian/Divisi <span class="text-danger">*</span></label>
            <input type="text" name="company_division" class="form-control @error('company_division') is-invalid @enderror" required>
            @error('company_division')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="row mb-3">
          <div class="col">
            <label class="form-label">Nomor Telepon Perusahaan <span class="text-danger">*</span></label>
            <input type="text" name="company_phone" class="form-control @error('company_phone') is-invalid @enderror" required>
            @error('company_phone')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="col">
            <label class="form-label">Tanggal Mulai PKL <span class="text-danger">*</span></label>
            <input type="date" name="starting_date" class="form-control @error('starting_date') is-invalid @enderror" required>
            @error('starting_date')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="row mb-4">
          <div class="col">
            <label class="form-label">Alamat Perusahaan <span class="text-danger">*</span></label>
            <input type="text" name="company_address" class="form-control @error('company_address') is-invalid @enderror" required>
            @error('company_address')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="row mb-3">
          <h5 class="fw-bold">Catatan Lain</h5>
          <div class="col">
            <label class="form-label">Catatan Khusus Untuk Staff</label>
            <textarea name="note" rows="5" class="form-control @error('note') is-invalid @enderror"></textarea>
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
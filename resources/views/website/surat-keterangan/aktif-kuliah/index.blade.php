@extends('website.layout')

@section('content')
<!-- ======= Breadcrumbs ======= -->
<section class="breadcrumbs">
  <div class="container">
    <ol>
      <li><a href="{{ route('index') }}">Beranda</a></li>
      <li>Surat Keterangan</li>
      <li>Aktif Kuliah</li>
    </ol>
    <h2>Aktif Kuliah</h2>

  </div>
</section><!-- End Breadcrumbs -->

<section class="inner-page">
  <div class="container">
    <header class="section-header">
      <h2>Surat Keterangan Aktif Kuliah</h2>
      <p>Riwayat Pengajuan</p>
    </header>

    @if ($guide && $guide->fileUrl)
      <div class="d-flex align-items-center gap-2 mb-2">
        <span>Unduh panduan pengajuan Surat Keterangan Aktif Kuliah</span>
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
                <a href="{{ route('surat-keterangan.aktif-kuliah.preview', $datum->id) }}" target="_blank" class="btn btn-primary">Buka</a>
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
        <h2>Surat Keterangan Aktif Kuliah</h2>
        <p>Form Pengajuan</p>
      </header>
      <form action="{{ route('surat-keterangan.aktif-kuliah.store') }}" method="post" enctype="multipart/form-data">
        @foreach($errors->all() as $message)
          {{ $message }}
        @endforeach
        @csrf
        <div class="row mb-3">
          <h5 class="fw-bold">Informasi Mahasiswa</h5>
          <div class="col">
            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}" readonly>
          </div>
          <div class="col">
            <label class="form-label">NPM Mahasiswa <span class="text-danger">*</span></label>
            <input type="text" name="registration_number" class="form-control" value="{{ Auth::user()->registration_number }}" readonly>
          </div>
        </div>
        <div class="row mb-4">
          <div class="col">
            <label class="form-label">Program Studi <span class="text-danger">*</span></label>
            <input type="text" name="department" class="form-control" value="{{ Auth::user()->department->name }}" readonly>
          </div>
          <div class="col">
            <label class="form-label">Tahun Akademik <span class="text-danger">*</span></label>
            <input type="text" name="academic_year" class="form-control" value="{{ Auth::user()->getAcademicYear() }}" readonly>
          </div>
          <div class="col">
            <label class="form-label">Semester <span class="text-danger">*</span></label>
            <input type="number" min="1" max="14" name="semester" class="form-control" required>
          </div>
        </div>

        <div class="row mb-3">
          <h5 class="fw-bold">Informasi Orang Tua/Wali</h5>
          <div class="col">
            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
            <input type="text" name="parent_name" class="form-control" required>
          </div>
          <div class="col">
            <label class="form-label">Nama Instansi/Pekerjaan <span class="text-danger">*</span></label>
            <input type="text" name="parent_company_name" class="form-control" required>
          </div>
        </div>

        <div class="row mb-4">
          <div class="col">
            <label class="form-label">Nomor Pegawai</label>
            <input type="text" name="parent_employee_number" class="form-control">
            <div class="form-text">Boleh dikosongkan.</div>
          </div>
          <div class="col">
            <label class="form-label">Pangkat/Golongan</label>
            <input type="text" name="parent_employee_position" class="form-control">
            <div class="form-text">Boleh dikosongkan.</div>
          </div>
        </div>

        <div class="row mb-3">
          <h5 class="fw-bold">Informasi Data Pendukung</h5>
          <div class="col">
            <label class="form-label">Keperluan <span class="text-danger">*</span></label>
            <input type="text" name="used_for" class="form-control" required>
          </div>
          <div class="col">
            <label class="form-label">Bukti Re-Registrasi <span class="text-danger">*</span></label>
            <input type="file" name="proof_re_registration" class="form-control" required>
            <div class="form-text">Format file berupa PDF, maksimal 2MB.</div>
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

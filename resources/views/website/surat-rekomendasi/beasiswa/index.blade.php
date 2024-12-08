@extends('website.layout')

@section('content')
<!-- ======= Breadcrumbs ======= -->
<section class="breadcrumbs">
  <div class="container">
    <ol>
      <li><a href="{{ route('index') }}">Beranda</a></li>
      <li>Surat Rekomendasi</li>
      <li>Beasiswa</li>
    </ol>
    <h2>Surat Rekomendasi Beasiswa</h2>

  </div>
</section><!-- End Breadcrumbs -->

<section class="inner-page">
  <div class="container">
    <header class="section-header">
      <h2>Surat Rekomendasi Beasiswa</h2>
      <p>Riwayat Pengajuan</p>
    </header>

    <div class="d-flex align-items-center gap-2 mb-2">
      <span>Unduh panduan pengajuan Surat Rekomendasi Beasiswa</span>
      <button class="btn btn-secondary">Unduh</button>
    </div>

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
                <a href="{{ route('surat-rekomendasi.beasiswa.preview', $datum->id) }}" target="_blank" class="btn btn-primary">Buka</a>
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <div class="mt-5">
      <header class="section-header">
        <h2>Surat Rekomendasi Beasiswa</h2>
        <p>Form Pengajuan</p>
      </header>
      <form action="{{ route('surat-rekomendasi.beasiswa.store') }}" method="post">
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
            <label class="form-label">Semester <span class="text-danger">*</span></label>
            <select name="semester" class="form-control" required>
                <option value="">Pilih Semester...</option>
                <option value="genap">Genap</option>
                <option value="ganjil">Ganjil</option>
            </select>
          </div>
          <div class="col">
            <label class="form-label">IPK <span class="text-danger">*</span></label>
            <input type="text" name="ipk" class="form-control" required>
          </div>
        </div>

        <div class="row mb-4">
          <h5 class="fw-bold">Informasi Beasiswa</h5>
          <div class="col">
            <label class="form-label">Nama Penyelenggara Beasiswa <span class="text-danger">*</span></label>
            <input type="text" name="scholarship_provider" class="form-control" required>
            <div class="form-text">Nama program beasiswa atau nama instansi pemberi beasiswa.</div>
          </div>
          <div class="col-2">
            <label class="form-label">Tahun <span class="text-danger">*</span></label>
            <input type="number" name="year" class="form-control" required>
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

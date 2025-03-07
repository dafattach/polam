@extends('website.layout')

@section('content')
<!-- ======= Breadcrumbs ======= -->
<section class="breadcrumbs">
  <div class="container">
    <ol>
      <li><a href="{{ route('index') }}">Beranda</a></li>
      <li>Profil</li>
    </ol>
    <h2>Profil Mahasiswa</h2>
  </div>
</section><!-- End Breadcrumbs -->

<section class="inner-page">
  <div class="container">
    <form action="{{ route('profile.update') }}" method="post">
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
          <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ Auth::user()->name }}" required>
          @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="col">
          <label class="form-label">Email <span class="text-danger">*</span></label>
          <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ Auth::user()->email }}" readonly>
          @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>
      <div class="row mb-4">
        <div class="col">
          <label class="form-label">Program Studi <span class="text-danger">*</span></label>
          <select name="department_id" class="form-control @error('department_id') is-invalid @enderror" required>
            <option value="" selected disabled>Pilih Program Studi...</option>
            @foreach($departments as $department)
              <option value="{{ $department->id }}" {{ $department->id == Auth::user()->department_id ? 'selected' : '' }}>{{ ucwords($department->name) }}</option>
            @endforeach
          </select>
          @error('department_id')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="col">
          <label class="form-label">NPM Mahasiswa <span class="text-danger">*</span></label>
          <input type="text" name="registration_number" class="form-control @error('registration_number') is-invalid @enderror" value="{{ Auth::user()->registration_number }}" required>
          @error('registration_number')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>
      <div class="row mb-4">
        <div class="col">
          <label class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
          <input type="text" name="birth_place" class="form-control @error('birth_place') is-invalid @enderror" value="{{ Auth::user()->birth_place }}" required>
          @error('birth_place')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="col">
          <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
          <input type="date" name="birth_date" class="form-control @error('birth_date') is-invalid @enderror" value="{{ Auth::user()->birth_date }}" required>
          @error('birth_date')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>
      <div class="row mb-4">
        <div class="col">
          <label class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
          <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" value="{{ Auth::user()->address }}" required>
          @error('address')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>

      <div class="d-grid d-md-flex justify-content-md-end">
        <button type="submit" class="btn btn-primary btn-lg">Simpan</button>
      </div>
    </form>
  </div>
</section>
@stop
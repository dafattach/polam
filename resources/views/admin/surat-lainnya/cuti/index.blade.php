@extends('admin.layout')

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Surat Lainnya</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('admin.index') }}">Dashboard</a></div>
      <div class="breadcrumb-item"><a href="javascript:void(0)">Surat Lainnya</a></div>
      <div class="breadcrumb-item">Cuti</div>
    </div>
  </div>

  <div class="section-body">
    <div class="row">
      <div class="col">
        <div class="card">
          <div class="card-header">
            <h4>Cuti</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th>#</th>
                  <th>Nama Mahasiswa</th>
                  <th>Tanggal Pengajuan</th>
                  <th>Status Pengajuan</th>
                  <th class="text-center">Berkas Pendukung</th>
                  <th>Action</th>
                </tr>
                @foreach($submissions as $key => $submission)
                <tr>
                  <td>{{ $key+1 }}</td>
                  <td>{{ $submission->user->name }}</td>
                  <td>{{ $submission->formattedCreatedAt }}</td>
                  <td><div class="badge badge-{{ $submission->StatusBadge }}">{{ $submission->status }}</div></td>
                  <td class="text-center">
                    @if(json_decode($submission->data)->supporting_documents_path ?? false)
                      <a href="{{ asset('storage/' . json_decode($submission->data)->supporting_documents_path) }}" class="btn btn-warning" target="_blank">Preview</a>
                    @else
                      -
                    @endif
                  </td>
                  <td>
                    <a href="{{ route('admin.surat-lainnya.cuti.preview', $submission->id) }}" target="_blank" class="btn btn-warning">Preview</a>
                    <a href="{{ route('admin.surat-lainnya.cuti.show', $submission->id) }}" class="btn btn-primary">Detail</a>
                  </td>
                </tr>
                @endforeach
              </table>
            </div>
          </div>
          <div class="card-footer text-right">
            {{ $submissions->onEachSide(1)->links('vendor.pagination.admin') }}
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@stop

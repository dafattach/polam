<ul class="sidebar-menu">
  <li class="menu-header">Dashboard</li>
  <li>
    <a class="nav-link" href="{{ route('admin.index') }}"><i class="fas fa-box"></i> <span>Dashboard</span></a>
  </li>
  <li>
    <a class="nav-link" href="{{ route('admin.guide.index') }}"><i class="fas fa-sticky-note"></i> <span>Panduan</span></a>
  </li>
  @if(Auth::guard('employee')->user()->position->level == 0)
    <li>
      <a class="nav-link" href="{{ route('admin.department.index') }}"><i class="fas fa-building"></i> <span>Prodi</span></a>
    </li>
  @endif

  <li class="menu-header">Pengajuan</li>
  <li class="nav-item dropdown">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
      <i class="far fa-file-powerpoint"></i>
      <span>Surat Pengantar</span>
      @if(isset($submissionCounts['surat-pengantar']['total']) && $submissionCounts['surat-pengantar']['total'] > 0)
        <span class="badge badge-danger">{{ $submissionCounts['surat-pengantar']['total'] }}</span>
      @endif
    </a>
    <ul class="dropdown-menu">
      <li>
        <a class="nav-link" href="{{ route('admin.surat-pengantar.pkl.index') }}">
          Praktek Kerja Lapangan
          @if(isset($submissionCounts['surat-pengantar']['types']['pkl']) && $submissionCounts['surat-pengantar']['types']['pkl'] > 0)
            <span class="badge badge-danger">{{ $submissionCounts['surat-pengantar']['types']['pkl'] }}</span>
          @endif
        </a>
      </li>
      <li>
        <a class="nav-link" href="{{ route('admin.surat-pengantar.skripsi.index') }}">
          Penelitian Skripsi
          @if(isset($submissionCounts['surat-pengantar']['types']['skripsi']) && $submissionCounts['surat-pengantar']['types']['skripsi'] > 0)
            <span class="badge badge-danger">{{ $submissionCounts['surat-pengantar']['types']['skripsi'] }}</span>
          @endif
        </a>
      </li>
      <li>
        <a class="nav-link" href="{{ route('admin.surat-pengantar.penelitian-matkul.index') }}">
          Penelitian Mata Kuliah
          @if(isset($submissionCounts['surat-pengantar']['types']['penelitian-matkul']) && $submissionCounts['surat-pengantar']['types']['penelitian-matkul'] > 0)
            <span class="badge badge-danger">{{ $submissionCounts['surat-pengantar']['types']['penelitian-matkul'] }}</span>
          @endif
        </a>
      </li>
    </ul>
  </li>

  <li class="nav-item dropdown">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
      <i class="fas fa-file-signature"></i>
      <span>Surat Keterangan</span>
      @if(isset($submissionCounts['surat-keterangan']['total']) && $submissionCounts['surat-keterangan']['total'] > 0)
        <span class="badge badge-danger">{{ $submissionCounts['surat-keterangan']['total'] }}</span>
      @endif
    </a>
    <ul class="dropdown-menu">
      <li>
        <a class="nav-link" href="{{ route('admin.surat-keterangan.aktif-kuliah.index') }}">
          Aktif Kuliah
          @if(isset($submissionCounts['surat-keterangan']['types']['aktif-kuliah']) && $submissionCounts['surat-keterangan']['types']['aktif-kuliah'] > 0)
            <span class="badge badge-danger">{{ $submissionCounts['surat-keterangan']['types']['aktif-kuliah'] }}</span>
          @endif
        </a>
      </li>
      <li>
        <a class="nav-link" href="{{ route('admin.surat-keterangan.bebas-sanksi-akademik.index') }}">
          Bebas Sanksi Akademik
          @if(isset($submissionCounts['surat-keterangan']['types']['bebas-sanksi-akademik']) && $submissionCounts['surat-keterangan']['types']['bebas-sanksi-akademik'] > 0)
            <span class="badge badge-danger">{{ $submissionCounts['surat-keterangan']['types']['bebas-sanksi-akademik'] }}</span>
          @endif
        </a>
      </li>
    </ul>
  </li>

  <li class="nav-item dropdown">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
      <i class="fas fa-award"></i>
      <span>Surat Rekomendasi</span>
      @if(isset($submissionCounts['surat-rekomendasi']['total']) && $submissionCounts['surat-rekomendasi']['total'] > 0)
        <span class="badge badge-danger">{{ $submissionCounts['surat-rekomendasi']['total'] }}</span>
      @endif
    </a>
    <ul class="dropdown-menu">
      <li>
        <a class="nav-link" href="{{ route('admin.surat-rekomendasi.beasiswa.index') }}">
          Beasiswa
          @if(isset($submissionCounts['surat-rekomendasi']['types']['beasiswa']) && $submissionCounts['surat-rekomendasi']['types']['beasiswa'] > 0)
            <span class="badge badge-danger">{{ $submissionCounts['surat-rekomendasi']['types']['beasiswa'] }}</span>
          @endif
        </a>
      </li>
      <li>
        <a class="nav-link" href="{{ route('admin.surat-rekomendasi.mbkm.index') }}">
          MBKM
          @if(isset($submissionCounts['surat-rekomendasi']['types']['mbkm']) && $submissionCounts['surat-rekomendasi']['types']['mbkm'] > 0)
            <span class="badge badge-danger">{{ $submissionCounts['surat-rekomendasi']['types']['mbkm'] }}</span>
          @endif
        </a>
      </li>
      <li>
        <a class="nav-link" href="{{ route('admin.surat-rekomendasi.non-mbkm.index') }}">
          Non-MBKM
          @if(isset($submissionCounts['surat-rekomendasi']['types']['non-mbkm']) && $submissionCounts['surat-rekomendasi']['types']['non-mbkm'] > 0)
            <span class="badge badge-danger">{{ $submissionCounts['surat-rekomendasi']['types']['non-mbkm'] }}</span>
          @endif
        </a>
      </li>
    </ul>
  </li>

  <li class="nav-item dropdown">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
      <i class="far fa-file-alt"></i>
      <span>Surat Lainnya</span>
      @if(isset($submissionCounts['surat-lainnya']['total']) && $submissionCounts['surat-lainnya']['total'] > 0)
        <span class="badge badge-danger">{{ $submissionCounts['surat-lainnya']['total'] }}</span>
      @endif
    </a>
    <ul class="dropdown-menu">
      <li>
        <a class="nav-link" href="{{ route('admin.surat-lainnya.transkrip.index') }}">
          Transkrip
          @if(isset($submissionCounts['surat-lainnya']['types']['transkrip']) && $submissionCounts['surat-lainnya']['types']['transkrip'] > 0)
            <span class="badge badge-danger">{{ $submissionCounts['surat-lainnya']['types']['transkrip'] }}</span>
          @endif
        </a>
      </li>
      <li>
        <a class="nav-link" href="{{ route('admin.surat-lainnya.cuti.index') }}">
          Cuti
          @if(isset($submissionCounts['surat-lainnya']['types']['cuti']) && $submissionCounts['surat-lainnya']['types']['cuti'] > 0)
            <span class="badge badge-danger">{{ $submissionCounts['surat-lainnya']['types']['cuti'] }}</span>
          @endif
        </a>
      </li>
      <li>
        <a class="nav-link" href="{{ route('admin.surat-lainnya.transfer.index') }}">
          Transfer
          @if(isset($submissionCounts['surat-lainnya']['types']['transfer']) && $submissionCounts['surat-lainnya']['types']['transfer'] > 0)
            <span class="badge badge-danger">{{ $submissionCounts['surat-lainnya']['types']['transfer'] }}</span>
          @endif
        </a>
      </li>
      <li>
        <a class="nav-link" href="{{ route('admin.surat-lainnya.pengunduran-diri.index') }}">
          Pengunduran Diri
          @if(isset($submissionCounts['surat-lainnya']['types']['pengunduran-diri']) && $submissionCounts['surat-lainnya']['types']['pengunduran-diri'] > 0)
            <span class="badge badge-danger">{{ $submissionCounts['surat-lainnya']['types']['pengunduran-diri'] }}</span>
          @endif
        </a>
      </li>
    </ul>
  </li>

  <li class="menu-header">Pengaturan</li>
  @if(Auth::guard('employee')->user()->position->level == 0)
    <li>
      <a class="nav-link" href="{{ route('admin.account.index') }}"><i class="fas fa-users"></i> <span>Akun Admin</span></a>
    </li>
  @endif
  <li>
    <a class="nav-link" href="{{ route('admin.profile.index') }}"><i class="fas fa-user-cog"></i> <span>Profil</span></a>
  </li>
  <li>
    <a class="nav-link" href="{{ route('admin.change-password.index') }}"><i class="fas fa-user-shield"></i> <span>Ubah Password</span></a>
  </li>
</ul>

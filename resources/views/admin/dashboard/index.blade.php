@extends('admin.layout')

@section('styles')
<style>
.card {
    border: 1px solid #e9ecef;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    transition: box-shadow 0.15s ease-in-out;
}

.card:hover {
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.section-title {
    font-weight: 600;
    color: #495057;
    margin-bottom: 1.5rem;
    font-size: 1.25rem;
}

.card-statistic-1 .card-body {
    font-size: 1.75rem;
    font-weight: 700;
    color: #212529;
}

.card-statistic-1 .card-header h4 {
    font-size: 0.875rem;
    font-weight: 500;
    color: #6c757d;
    margin-bottom: 0;
}

.card-icon {
    border-radius: 6px;
}

/* Vertical card styling for 5 cards */
.card-statistic-1 {
    margin-bottom: 1.5rem;
    text-align: center;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    transition: box-shadow 0.15s ease-in-out;
    position: relative;
    overflow: hidden;
}

.card-statistic-1:hover {
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

/* Vertical layout structure */
.card-statistic-1 .card-icon {
    width: 60px;
    height: 60px;
    line-height: 60px;
    font-size: 1.5rem;
    border-radius: 50%;
    margin: 1rem auto 0.75rem auto;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.card-statistic-1 .card-header {
    padding: 0 0.5rem;
    margin-bottom: 0.5rem;
}

.card-statistic-1 .card-header h4 {
    font-size: 0.8rem;
    font-weight: 600;
    color: #6c757d;
    margin-bottom: 0;
    line-height: 1.3;
    text-align: center;
}

.card-statistic-1 .card-body {
    font-size: 1.6rem;
    font-weight: 700;
    color: #212529;
    padding: 0 0.5rem 1rem 0.5rem;
    text-align: center;
}

/* Remove the old card-wrap structure */
.card-statistic-1 .card-wrap {
    padding: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
}

/* Ensure single row layout */
.stats-row {
    display: flex;
    flex-wrap: nowrap;
}

.stats-row .col-stats {
    flex: 1;
    min-width: 0;
    padding: 0 0.25rem;
}

/* Responsive adjustments for vertical single row */
@media (min-width: 1200px) {
    .card-statistic-1 .card-icon {
        width: 70px;
        height: 70px;
        line-height: 70px;
        font-size: 1.7rem;
        margin: 1.2rem auto 0.8rem auto;
    }

    .card-statistic-1 .card-header h4 {
        font-size: 0.85rem;
    }

    .card-statistic-1 .card-body {
        font-size: 1.8rem;
    }
}

@media (max-width: 991.98px) {
    .card-statistic-1 .card-icon {
        width: 55px;
        height: 55px;
        line-height: 55px;
        font-size: 1.3rem;
        margin: 1rem auto 0.6rem auto;
    }

    .card-statistic-1 .card-header h4 {
        font-size: 0.75rem;
    }

    .card-statistic-1 .card-body {
        font-size: 1.4rem;
    }
}

@media (max-width: 767.98px) {
    .stats-row {
        flex-wrap: wrap;
    }

    .stats-row .col-stats {
        flex: 0 0 50%;
        max-width: 50%;
        padding: 0 0.5rem;
        margin-bottom: 1rem;
    }

    .card-statistic-1 .card-icon {
        width: 60px;
        height: 60px;
        line-height: 60px;
        font-size: 1.4rem;
        margin: 1rem auto 0.7rem auto;
    }

    .card-statistic-1 .card-header h4 {
        font-size: 0.8rem;
    }

    .card-statistic-1 .card-body {
        font-size: 1.5rem;
    }
}

@media (max-width: 575.98px) {
    .stats-row .col-stats {
        flex: 0 0 100%;
        max-width: 100%;
    }

    .card-statistic-1 .card-icon {
        width: 70px;
        height: 70px;
        line-height: 70px;
        font-size: 1.6rem;
        margin: 1.2rem auto 0.8rem auto;
    }

    .card-statistic-1 .card-header h4 {
        font-size: 0.9rem;
    }

    .card-statistic-1 .card-body {
        font-size: 1.7rem;
    }
}
</style>
@endsection

@php
// Use consistent colors that cycle through for visual variety
function getSubmissionTypeColor($index) {
    $colors = ['primary', 'success', 'info', 'warning'];
    return $colors[$index % count($colors)];
}
@endphp

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Dashboard</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('admin.index') }}">Dashboard</a></div>
    </div>
  </div>

  <div class="section-body">
    <!-- Overall Statistics Row -->
    <div class="row">
      <div class="col-12 mb-3">
        <h4 class="section-title">Statistik Keseluruhan</h4>
      </div>
    </div>
    <div class="row stats-row">
      <div class="col-stats">
        <div class="card card-statistic-1">
          <div class="card-icon bg-primary">
            <i class="fas fa-file-alt"></i>
          </div>
          <div class="card-header">
            <h4>Total Pengajuan</h4>
          </div>
          <div class="card-body">
            {{ number_format($totalSubmissions) }}
          </div>
        </div>
      </div>
      <div class="col-stats">
        <div class="card card-statistic-1">
          <div class="card-icon bg-secondary">
            <i class="fas fa-hourglass-start"></i>
          </div>
          <div class="card-header">
            <h4>Belum Diproses</h4>
          </div>
          <div class="card-body">
            {{ number_format($totalUnprocessed) }}
          </div>
        </div>
      </div>
      <div class="col-stats">
        <div class="card card-statistic-1">
          <div class="card-icon bg-warning">
            <i class="fas fa-clock"></i>
          </div>
          <div class="card-header">
            <h4>Menunggu Persetujuan</h4>
          </div>
          <div class="card-body">
            {{ number_format($totalVerifiedPending) }}
          </div>
        </div>
      </div>
      <div class="col-stats">
        <div class="card card-statistic-1">
          <div class="card-icon bg-success">
            <i class="fas fa-check"></i>
          </div>
          <div class="card-header">
            <h4>Telah Disetujui</h4>
          </div>
          <div class="card-body">
            {{ number_format($totalApproved) }}
          </div>
        </div>
      </div>
      <div class="col-stats">
        <div class="card card-statistic-1">
          <div class="card-icon bg-danger">
            <i class="fas fa-times"></i>
          </div>
          <div class="card-header">
            <h4>Ditolak</h4>
          </div>
          <div class="card-body">
            {{ number_format($totalRejected) }}
          </div>
        </div>
      </div>
    </div>

    <!-- Today's Statistics Row -->
    <div class="row mt-4">
      <div class="col-12 mb-3">
        <h4 class="section-title">Statistik Hari Ini</h4>
      </div>
    </div>
    <div class="row stats-row">
      <div class="col-stats">
        <div class="card card-statistic-1">
          <div class="card-icon bg-info">
            <i class="fas fa-file-alt"></i>
          </div>
          <div class="card-header">
            <h4>Pengajuan Hari Ini</h4>
          </div>
          <div class="card-body">
            {{ number_format($todaySubmissions) }}
          </div>
        </div>
      </div>
      <div class="col-stats">
        <div class="card card-statistic-1">
          <div class="card-icon bg-secondary">
            <i class="fas fa-hourglass-start"></i>
          </div>
          <div class="card-header">
            <h4>Belum Diproses</h4>
          </div>
          <div class="card-body">
            {{ number_format($todayUnprocessed) }}
          </div>
        </div>
      </div>
      <div class="col-stats">
        <div class="card card-statistic-1">
          <div class="card-icon bg-warning">
            <i class="fas fa-clock"></i>
          </div>
          <div class="card-header">
            <h4>Menunggu Persetujuan</h4>
          </div>
          <div class="card-body">
            {{ number_format($todayVerifiedPending) }}
          </div>
        </div>
      </div>
      <div class="col-stats">
        <div class="card card-statistic-1">
          <div class="card-icon bg-success">
            <i class="fas fa-check"></i>
          </div>
          <div class="card-header">
            <h4>Disetujui Hari Ini</h4>
          </div>
          <div class="card-body">
            {{ number_format($todayApproved) }}
          </div>
        </div>
      </div>
      <div class="col-stats">
        <div class="card card-statistic-1">
          <div class="card-icon bg-danger">
            <i class="fas fa-times"></i>
          </div>
          <div class="card-header">
            <h4>Ditolak Hari Ini</h4>
          </div>
          <div class="card-body">
            {{ number_format($todayRejected) }}
          </div>
        </div>
      </div>
    </div>

    <!-- Statistics by Submission Type -->
    @foreach($typeStatistics as $type => $stats)
      @php $index = array_search($type, array_keys($typeStatistics)); @endphp
      <div class="row mt-4">
        <div class="col-12 mb-3">
          <h4 class="section-title">{{ ucwords(str_replace('-', ' ', $type)) }}</h4>
        </div>
      </div>
      <div class="row stats-row">
        <div class="col-stats">
          <div class="card card-statistic-1">
            <div class="card-icon bg-{{ getSubmissionTypeColor($index) }}">
              <i class="fas fa-file-alt"></i>
            </div>
            <div class="card-header">
              <h4>Total</h4>
            </div>
            <div class="card-body">
              {{ number_format($stats['total']) }}
            </div>
          </div>
        </div>
        <div class="col-stats">
          <div class="card card-statistic-1">
            <div class="card-icon bg-secondary">
              <i class="fas fa-hourglass-start"></i>
            </div>
            <div class="card-header">
              <h4>Belum Diproses</h4>
            </div>
            <div class="card-body">
              {{ number_format($stats['unprocessed']) }}
            </div>
          </div>
        </div>
        <div class="col-stats">
          <div class="card card-statistic-1">
            <div class="card-icon bg-warning">
              <i class="fas fa-clock"></i>
            </div>
            <div class="card-header">
              <h4>Menunggu Persetujuan</h4>
            </div>
            <div class="card-body">
              {{ number_format($stats['verified_pending']) }}
            </div>
          </div>
        </div>
        <div class="col-stats">
          <div class="card card-statistic-1">
            <div class="card-icon bg-success">
              <i class="fas fa-check"></i>
            </div>
            <div class="card-header">
              <h4>Disetujui</h4>
            </div>
            <div class="card-body">
              {{ number_format($stats['approved']) }}
            </div>
          </div>
        </div>
        <div class="col-stats">
          <div class="card card-statistic-1">
            <div class="card-icon bg-danger">
              <i class="fas fa-times"></i>
            </div>
            <div class="card-header">
              <h4>Ditolak</h4>
            </div>
            <div class="card-body">
              {{ number_format($stats['rejected']) }}
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</section>
@stop

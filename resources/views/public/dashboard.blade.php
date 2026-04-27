@extends('public.layouts.app')
@section('title', 'Dashboard Pemohon')

@push('styles')
<style>
    body { padding-top: 100px; background: #f8fafc; color: #1e293b; }
    
    /* Header Section */
    .dashboard-page-header { margin-bottom: 35px; }
    .dashboard-page-header h1 { font-size: 2.2rem; font-weight: 800; color: #0f172a; margin-bottom: 5px; }
    .dashboard-page-header p { font-size: 1.1rem; color: #64748b; }

    /* Stat Cards */
    .stat-card {
        background: white;
        border-radius: 20px;
        padding: 20px 25px;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 20px;
        transition: all 0.2s ease;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        height: 100%;
    }
    .stat-card:hover { transform: translateY(-3px); box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05); }
    
    .stat-icon-circle {
        width: 54px; height: 54px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        font-weight: 800;
        flex-shrink: 0;
    }
    
    .stat-info .stat-label { font-size: 0.95rem; font-weight: 700; opacity: 0.9; }
    
    .theme-blue { color: #2563eb; background: rgba(37, 99, 235, 0.08); border-color: rgba(37, 99, 235, 0.2); }
    .theme-yellow { color: #d97706; background: rgba(217, 119, 6, 0.08); border-color: rgba(217, 119, 6, 0.2); }
    .theme-green { color: #059669; background: rgba(5, 150, 105, 0.08); border-color: rgba(5, 150, 105, 0.2); }
    .theme-red { color: #dc2626; background: rgba(220, 38, 38, 0.08); border-color: rgba(220, 38, 38, 0.2); }

    .theme-blue .stat-icon-circle { background: white; box-shadow: 0 0 15px rgba(37, 99, 235, 0.1); }
    .theme-yellow .stat-icon-circle { background: white; box-shadow: 0 0 15px rgba(217, 119, 6, 0.1); }
    .theme-green .stat-icon-circle { background: white; box-shadow: 0 0 15px rgba(5, 150, 105, 0.1); }
    .theme-red .stat-icon-circle { background: white; box-shadow: 0 0 15px rgba(220, 38, 38, 0.1); }

    /* Filter Bar */
    .filter-wrapper {
        background: transparent;
        margin-top: 40px;
        margin-bottom: 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
    }
    
    .filter-controls { display: flex; gap: 12px; flex: 1; min-width: 300px; align-items: center; }
    
    .search-input-group { position: relative; flex-grow: 1; min-width: 250px; }
    .search-input-group .search-btn { 
        position: absolute; 
        right: 8px; 
        top: 50%; 
        transform: translateY(-50%); 
        background: #f1f5f9; 
        border: none; 
        width: 34px; 
        height: 34px; 
        border-radius: 10px; 
        color: #64748b; 
        display: flex; 
        align-items: center; 
        justify-content: center;
        transition: all 0.2s;
        z-index: 5;
    }
    .search-input-group .search-btn:hover { background: #e2e8f0; color: #0f172a; }
    .search-input-group .form-control {
        border-radius: 14px;
        border: 1.5px solid #e2e8f0;
        padding: 11px 50px 11px 18px;
        font-size: 0.95rem;
        background: white;
        transition: all 0.2s;
        box-shadow: 0 1px 2px rgba(0,0,0,0.03);
    }
    .search-input-group .form-control:focus { 
        border-color: #0ea5e9; 
        box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1); 
    }
    
    .filter-select {
        border-radius: 14px;
        border: 1.5px solid #e2e8f0;
        padding: 11px 18px;
        font-size: 0.95rem;
        width: 240px;
        flex-shrink: 0;
        color: #475569;
        background-color: white;
        box-shadow: 0 1px 2px rgba(0,0,0,0.03);
        cursor: pointer;
        transition: all 0.2s;
    }
    .filter-select:focus {
        border-color: #0ea5e9;
        box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
        outline: none;
    }
    
    .btn-add-submission {
        background: #0ea5e9;
        color: white;
        border: none;
        border-radius: 12px;
        padding: 12px 25px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: all 0.2s;
        box-shadow: 0 4px 6px -1px rgba(14, 165, 233, 0.2);
    }
    .btn-add-submission:hover { background: #0284c7; color: white; transform: translateY(-1px); box-shadow: 0 10px 15px -3px rgba(14, 165, 233, 0.3); }

    /* Table Section */
    .main-table-card {
        background: white;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);
    }
    
    .simbg-table { width: 100%; border-collapse: collapse; }
    .simbg-table thead th {
        background: #f1f5f9;
        color: #475569;
        font-weight: 700;
        font-size: 0.85rem;
        padding: 18px 20px;
        text-transform: none;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .simbg-table tbody td {
        padding: 18px 20px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.92rem;
        color: #334155;
    }
    
    .status-badge {
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 0.78rem;
        font-weight: 700;
        display: inline-block;
    }
    
    .badge-verifikasi { background: #fef3c7; color: #b45309; }
    .badge-perbaikan { background: #fee2e2; color: #b91c1c; }
    .badge-penugasan { background: #e0f2fe; color: #0369a1; }
    .badge-selesai { background: #dcfce7; color: #15803d; }

    .btn-table-action {
        width: 34px; height: 34px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e2e8f0;
        color: #475569;
        transition: all 0.2s;
    }
    .btn-table-action:hover { background: #f8fafc; color: #0f172a; border-color: #cbd5e1; }
    
    .pagination-container {
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: white;
        border-top: 1px solid #f1f5f9;
    }
</style>
@endpush

@section('content')
<div class="container mb-5">
    
    <!-- DASHBOARD HEADER -->
    <div class="dashboard-page-header">
        <h1>Daftar Permohonan</h1>
        <p>Data Permohonan PSU Anda</p>
    </div>

    <!-- STAT CARDS -->
    <div class="row g-4">
        <div class="col-md-3">
            <div class="stat-card theme-blue">
                <div class="stat-icon-circle">{{ $totalCount }}</div>
                <div class="stat-info">
                    <div class="stat-label">Total Permohonan</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card theme-yellow">
                <div class="stat-icon-circle">{{ $runningCount }}</div>
                <div class="stat-info">
                    <div class="stat-label">Permohonan Berjalan</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card theme-green">
                <div class="stat-icon-circle">{{ $finishedCount }}</div>
                <div class="stat-info">
                    <div class="stat-label">Permohonan Selesai</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card theme-red">
                <div class="stat-icon-circle">{{ $cancelledCount }}</div>
                <div class="stat-info">
                    <div class="stat-label">Permohonan Dibatalkan</div>
                </div>
            </div>
        </div>
    </div>

    <!-- FILTER BAR -->
    <form action="{{ route('user.dashboard') }}" method="GET" id="filterForm">
        <div class="filter-wrapper">
            <div class="filter-controls">
                <select name="status" class="form-select filter-select" onchange="this.form.submit()">
                    <option value="">Status Permohonan</option>
                    <option value="verifikasi dokumen" {{ request('status') == 'verifikasi dokumen' ? 'selected' : '' }}>Verifikasi Dokumen</option>
                    <option value="perbaikan dokumen" {{ request('status') == 'perbaikan dokumen' ? 'selected' : '' }}>Perbaikan Dokumen</option>
                    <option value="penugasan tim verifikasi" {{ request('status') == 'penugasan tim verifikasi' ? 'selected' : '' }}>Penugasan Tim Verifikasi</option>
                    <option value="BA terima terbit" {{ request('status') == 'BA terima terbit' ? 'selected' : '' }}>BA Terima Terbit</option>
                </select>
                
                <div class="search-input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari permohonan..." value="{{ request('search') }}">
                    <button type="submit" class="search-btn" title="Cari">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            
            <a href="/permohonan-psu" class="btn-add-submission">
                <i class="fas fa-plus"></i> Tambah Permohonan
            </a>
        </div>
    </form>

    <!-- TABLE SECTION -->
    <div class="main-table-card">
        <div class="table-responsive">
            <table class="simbg-table">
                <thead>
                    <tr>
                        <th style="width: 70px; text-align: center;">No.</th>
                        <th>No. Registrasi</th>
                        <th>Lokasi Pembangunan</th>
                        <th style="width: 150px;">Tanggal</th>
                        <th style="width: 250px; text-align: center;">Status Permohonan</th>
                        <th style="width: 80px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($submissions as $sub)
                    <tr>
                        <td style="text-align: center; font-weight: 600; color: #94a3b8;">{{ ($submissions->currentPage()-1) * $submissions->perPage() + $loop->iteration }}</td>
                        <td class="fw-bold" style="color: #0ea5e9;">{{ $sub->no_registrasi }}</td>
                        <td style="line-height: 1.4;">
                            <div class="fw-semibold">{{ \Illuminate\Support\Str::limit($sub->lokasi_pembangunan, 60) }}</div>
                        </td>
                        <td>{{ $sub->created_at->format('d/m/Y') }}</td>
                        <td style="text-align: center;">
                            @if($sub->status === 'verifikasi dokumen')
                                <span class="status-badge badge-verifikasi">Verifikasi Dokumen</span>
                            @elseif($sub->status === 'perbaikan dokumen')
                                <span class="status-badge badge-perbaikan">Perbaikan Dokumen</span>
                            @elseif($sub->status === 'penugasan tim verifikasi')
                                <span class="status-badge badge-penugasan">Penugasan Tim Verifikasi</span>
                            @elseif($sub->status === 'BA terima terbit')
                                <span class="status-badge badge-selesai">BA Terima Terbit</span>
                            @else
                                <span class="status-badge badge-selesai">Selesai</span>
                            @endif

                            @if($sub->status === 'perbaikan dokumen' && $sub->catatan_perbaikan)
                                <div class="mt-1 small text-danger fw-600" style="font-size: 0.72rem;">
                                    <i class="fas fa-exclamation-circle me-1"></i> Perlu Perbaikan
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex justify-content-center">
                                @if($sub->status === 'perbaikan dokumen')
                                    <a href="/permohonan-psu/{{ $sub->no_registrasi }}/edit" class="btn-table-action" title="Perbaiki Dokumen">
                                        <i class="fas fa-edit text-danger"></i>
                                    </a>
                                @elseif($sub->status === 'BA terima terbit' && $sub->file_ba_terbit)
                                    <a href="{{ route('psu.file.serve', ['submission' => $sub->id, 'field' => 'file_ba_terbit']) }}" target="_blank" class="btn-table-action" title="Unduh BA">
                                        <i class="fas fa-download text-success"></i>
                                    </a>
                                @else
                                    <div class="btn-table-action opacity-50" style="cursor: not-allowed;" title="Menunggu Proses">
                                        <i class="fas fa-lock"></i>
                                    </div>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-5 text-center text-secondary">
                            <i class="fas fa-folder-open fa-3x opacity-20 mb-3"></i>
                            <p class="mb-0">Belum ada permohonan yang diajukan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($submissions->hasPages())
        <div class="pagination-container">
            <div class="small text-muted">
                Menampilkan {{ $submissions->firstItem() }} - {{ $submissions->lastItem() }} dari {{ $submissions->total() }} Permohonan
            </div>
            <div>
                {{ $submissions->appends(request()->input())->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

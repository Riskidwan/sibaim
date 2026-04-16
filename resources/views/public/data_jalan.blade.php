@extends('public.layouts.app')
@section('title', 'Data Jalan')

@push('styles')
<style>
    body { padding-top: 100px; background: #f8fafc; }
    
    .jalan-main-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        overflow: hidden;
        margin-bottom: 50px;
        border: 1px solid #e2e8f0;
    }

    .filter-bar {
        background: #fff;
        padding: 15px 25px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
    }

    .search-wrapper { position: relative; flex: 1; min-width: 300px; }
    .search-wrapper i { position: absolute; left: 15px; top: 52%; transform: translateY(-50%); color: #94a3b8; pointer-events: none; }
    
    .search-input {
        padding: 12px 15px 12px 42px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        width: 100%;
        font-size: 0.9rem;
        transition: all 0.2s;
        background: #fdfdfd;
    }
    .search-input:focus { border-color: #435ebe; outline: none; box-shadow: 0 0 0 3px rgba(67, 94, 190, 0.1); background: #fff; }

    /* Table Styling */
    .premium-table { width: 100%; border-collapse: collapse; }
    .premium-table th {
        background: #f1f5f9;
        padding: 15px 20px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        color: #475569;
        text-align: left;
    }
    .premium-table td {
        padding: 15px 20px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.85rem;
    }
    .premium-table tr:hover td { background: #f8fafc; }

    .stat-card {
        background: #fff;
        border-radius: 16px;
        padding: 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        height: 100%;
        transition: transform 0.2s;
    }
    .stat-card:hover { transform: translateY(-3px); }
    .stat-icon {
        width: 50px; height: 50px;
        background: #eef2ff;
        color: #435ebe;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 15px;
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="section-header text-center mb-5">
        <h2 class="fw-bold text-dark mb-1">Daftar Inventaris Data Jalan</h2>
        <p class="text-secondary small">Informasi Basis Data Jalan Kabupaten Pemalang</p>
    </div>

    <!-- Stats Row -->
    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <div class="stat-card d-flex align-items-center">
                <div class="stat-icon me-3 mb-0">
                    <i class="fas fa-road"></i>
                </div>
                <div>
                    <h3 class="fw-bold mb-0 text-dark">{{ number_format($totalJalan) }}</h3>
                    <p class="text-secondary small mb-0 fw-600">Total Ruas Jalan</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="stat-card d-flex align-items-center">
                <div class="stat-icon me-3 mb-0 text-success" style="background: #ecfdf5;">
                    <i class="fas fa-map-marked-alt text-success"></i>
                </div>
                <div>
                    <h3 class="fw-bold mb-0 text-dark">{{ number_format($totalKecamatan) }}</h3>
                    <p class="text-secondary small mb-0 fw-600">Total Kecamatan</p>
                </div>
            </div>
        </div>
    </div>

    <div class="jalan-main-card">
        <!-- FILTER BAR -->
        <div class="filter-bar">
            <div class="search-wrapper">
                <form action="{{ route('public.data-jalan') }}" method="GET">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" class="search-input" placeholder="Cari nama jalan, kecamatan, atau kelurahan..." value="{{ request('search') }}">
                </form>
            </div>
            @if(request('search'))
                <a href="{{ route('public.data-jalan') }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center px-3" style="border-radius: 10px;"><i class="fas fa-undo me-2"></i> Reset Filter</a>
            @endif
        </div>

        <!-- TABLE -->
        <div class="table-responsive">
            <table class="premium-table">
                <thead>
                    <tr>
                        <th style="width: 70px; text-align: center;">No</th>
                        <th>Kecamatan</th>
                        <th>Kelurahan / Desa</th>
                        <th>Nama Jalan</th>
                        <th style="text-align: right;">Panjang Jalan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jalans as $item)
                    <tr>
                        <td style="text-align: center; color: #94a3b8; font-weight: 600;">{{ $jalans->firstItem() + $loop->index }}</td>
                        <td>
                            <div class="fw-semibold text-dark">{{ $item->kecamatan }}</div>
                        </td>
                        <td>
                            <div class="text-secondary">{{ $item->kelurahan }}</div>
                        </td>
                        <td>
                            <div class="fw-bold text-dark text-uppercase" style="letter-spacing: 0.5px;">{{ $item->nama_jalan }}</div>
                        </td>
                        <td style="text-align: right;">
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill fw-bold">
                                {{ number_format($item->panjang_jalan, 2, ',', '.') }} m
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-5 text-center text-secondary">
                            <i class="fas fa-info-circle fa-2x opacity-25 mb-3"></i>
                            <p class="mb-0">Data jalan belum tersedia atau tidak ditemukan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-4 py-3 border-top d-flex justify-content-between align-items-center">
            <div class="text-secondary small">
                Menampilkan <strong>{{ $jalans->firstItem() ?? 0 }}</strong> - <strong>{{ $jalans->lastItem() ?? 0 }}</strong> dari <strong>{{ $jalans->total() }}</strong> Jalan
            </div>
            <div>
                {{ $jalans->appends(request()->input())->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection

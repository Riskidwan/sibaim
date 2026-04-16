@extends('admin.layouts.app')
@section('title', 'Dashboard')

@php
/** @var int $psuTotalCount */
/** @var int $psuPendingCount */
/** @var int $housingCount */
/** @var int $roadCount */
/** @var \Illuminate\Support\Collection $recentPsu */
/** @var \Illuminate\Support\Collection $recentActivity */
@endphp

@section('content')

{{-- WELCOME BANNER --}}
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold mb-0">Selamat datang, {{ Auth::user()->name }} 👋</h4>
        <small class="text-muted">{{ now()->translatedFormat('l, d F Y') }}</small>
    </div>
    @if(Auth::user()->isSuperAdmin())
    <a href="{{ route('admin.users.index') }}" class="btn btn-primary btn-sm fw-semibold">
        <i class="bi bi-people-fill me-1"></i> Manajemen Akun
    </a>
    @endif
</div>

{{-- STAT CARDS --}}
<div class="row g-3 mb-4">
    {{-- Total Permohonan PSU --}}
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #4361ee !important;">
            <div class="card-body d-flex align-items-center gap-3 p-4">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                     style="width:52px;height:52px;background:rgba(67,97,238,0.12);">
                    <i class="bi bi-folder2-open fs-4 text-primary"></i>
                </div>
                <div>
                    <p class="text-muted small mb-1 fw-semibold text-uppercase" style="letter-spacing:.5px;">Total Permohonan PSU</p>
                    <h2 class="fw-extrabold mb-0 lh-1">{{ $psuTotalCount }}</h2>
                </div>
            </div>
        </div>
    </div>

    {{-- Menunggu Verifikasi --}}
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #f77f00 !important;">
            <div class="card-body d-flex align-items-center gap-3 p-4">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                     style="width:52px;height:52px;background:rgba(247,127,0,0.12);">
                    <i class="bi bi-hourglass-split fs-4" style="color:#f77f00;"></i>
                </div>
                <div>
                    <p class="text-muted small mb-1 fw-semibold text-uppercase" style="letter-spacing:.5px;">Menunggu Verifikasi</p>
                    <h2 class="fw-extrabold mb-0 lh-1">{{ $psuPendingCount }}</h2>
                </div>
            </div>
        </div>
    </div>

    {{-- Total Perumahan --}}
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #2dc653 !important;">
            <div class="card-body d-flex align-items-center gap-3 p-4">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                     style="width:52px;height:52px;background:rgba(45,198,83,0.12);">
                    <i class="bi bi-houses-fill fs-4 text-success"></i>
                </div>
                <div>
                    <p class="text-muted small mb-1 fw-semibold text-uppercase" style="letter-spacing:.5px;">Total Perumahan</p>
                    <h2 class="fw-extrabold mb-0 lh-1">{{ $housingCount }}</h2>
                </div>
            </div>
        </div>
    </div>

    {{-- Total Data Jalan --}}
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #e5383b !important;">
            <div class="card-body d-flex align-items-center gap-3 p-4">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                     style="width:52px;height:52px;background:rgba(229,56,59,0.12);">
                    <i class="bi bi-signpost-split-fill fs-4 text-danger"></i>
                </div>
                <div>
                    <p class="text-muted small mb-1 fw-semibold text-uppercase" style="letter-spacing:.5px;">Total Data Jalan</p>
                    <h2 class="fw-extrabold mb-0 lh-1">{{ $roadCount }}</h2>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- QUICK ACTION BANNER --}}
@if($psuPendingCount > 0)
<div class="alert d-flex align-items-center gap-3 border-0 mb-4 px-4 py-3 rounded-3 shadow-sm"
     style="background: linear-gradient(135deg, #fff3cd, #ffeeba); border-left: 5px solid #f77f00 !important;">
    <i class="bi bi-exclamation-triangle-fill fs-5" style="color:#f77f00;"></i>
    <div class="flex-grow-1">
        <strong>{{ $psuPendingCount }} permohonan</strong> sedang menunggu verifikasi dokumen.
    </div>
    <a href="{{ route('admin.psu-submissions.index') }}" class="btn btn-sm btn-warning fw-semibold text-dark text-nowrap">
        <i class="bi bi-arrow-right-circle me-1"></i> Periksa Sekarang
    </a>
</div>
@endif

{{-- CONTENT AREA --}}
<div class="row g-4">
    {{-- AKTIVITAS TERBARU --}}
    <div class="col-lg-7">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex align-items-center justify-content-between">
                <h5 class="fw-bold mb-0">
                    <i class="bi bi-activity me-2 text-primary"></i>Aktivitas Terbaru Sistem
                </h5>
                <a href="{{ route('admin.activity-log.index') }}" class="text-primary small fw-semibold text-decoration-none">
                    Lihat semua <i class="bi bi-chevron-right"></i>
                </a>
            </div>
            <div class="card-body px-4 py-3">
                @forelse($recentActivity as $act)
                <div class="d-flex align-items-start py-3 {{ !$loop->last ? 'border-bottom border-light' : '' }}">
                    <div class="me-3 mt-1 flex-shrink-0">
                        @php
                            $dotColor = $act['color'] == 'success' ? '#2dc653' : ($act['color'] == 'primary' ? '#4361ee' : '#e5383b');
                        @endphp
                        <span style="display:inline-block;width:10px;height:10px;background:{{ $dotColor }};border-radius:50%;"></span>
                    </div>
                    <div class="flex-grow-1">
                        <p class="mb-0 fw-semibold text-body" style="font-size:.9rem;">{{ $act['title'] }}</p>
                        <div class="d-flex justify-content-between align-items-center mt-1">
                            <small class="text-muted">{{ $act['user'] }}</small>
                            <small class="text-muted opacity-75">{{ $act['time'] }}</small>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-5">
                    <i class="bi bi-clock-history fs-2 text-muted mb-3 d-block"></i>
                    <p class="text-muted mb-0">Belum ada aktivitas terekam.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- PERMOHONAN TERBARU + PROFIL --}}
    <div class="col-lg-5 d-flex flex-column gap-4">
        {{-- PROFIL ADMIN --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3 p-4">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                     style="width:52px;height:52px;background:rgba(67,97,238,0.15);">
                    <i class="bi bi-person-fill fs-4 text-primary"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-0">{{ Auth::user()->name }}</h6>
                    <small class="text-muted text-capitalize">{{ Auth::user()->role }}</small>
                </div>
            </div>
        </div>

        {{-- PERMOHONAN TERBARU --}}
        <div class="card border-0 shadow-sm flex-grow-1">
            <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                <h5 class="fw-bold mb-0">
                    <i class="bi bi-clock-history me-2 text-warning" style="color:#f77f00 !important;"></i>Permohonan Terbaru
                </h5>
            </div>
            <div class="card-body px-4 py-3">
                @forelse($recentPsu as $psu)
                <div class="d-flex align-items-center py-2 {{ !$loop->last ? 'border-bottom border-light' : '' }}">
                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0"
                         style="width:38px;height:38px;background:rgba(102,16,242,0.1);">
                        <i class="bi bi-file-earmark-text-fill" style="color:#6610f2;font-size:1rem;"></i>
                    </div>
                    <div class="flex-grow-1" style="min-width:0;">
                        <p class="mb-0 fw-semibold text-body text-truncate" style="font-size:.88rem;">
                            {{ $psu->nama_pemohon ?? 'Pemohon' }}
                        </p>
                        @php
                            $statusStyles = [
                                'verifikasi dokumen'       => ['bg' => 'rgba(67,97,238,0.15)',  'color' => '#4361ee', 'border' => '#4361ee'],
                                'perbaikan dokumen'        => ['bg' => 'rgba(229,56,59,0.15)',  'color' => '#e5383b', 'border' => '#e5383b'],
                                'penugasan tim verifikasi' => ['bg' => 'rgba(247,127,0,0.15)',  'color' => '#f77f00', 'border' => '#f77f00'],
                                'BA terima terbit'         => ['bg' => 'rgba(45,198,83,0.15)',  'color' => '#2dc653', 'border' => '#2dc653'],
                            ];
                            $ss = $statusStyles[$psu->status] ?? ['bg' => 'rgba(150,150,150,0.15)', 'color' => '#999', 'border' => '#999'];
                        @endphp
                        <span class="badge rounded-pill"
                              style="font-size:.68rem; background:{{ $ss['bg'] }}; color:{{ $ss['color'] }}; border:1px solid {{ $ss['border'] }}40; font-weight:600; letter-spacing:.3px;">{{ $psu->status }}</span>
                    </div>
                </div>
                @empty
                <div class="text-center py-4">
                    <i class="bi bi-inbox fs-3 text-muted d-block mb-2"></i>
                    <p class="text-muted small mb-0">Tidak ada permohonan terbaru.</p>
                </div>
                @endforelse
            </div>
            <div class="card-footer bg-transparent border-0 px-4 pb-4 pt-2">
                <a href="{{ route('admin.psu-submissions.index') }}" class="btn btn-outline-primary w-100 fw-semibold btn-sm">
                    Kelola Semua Permohonan
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

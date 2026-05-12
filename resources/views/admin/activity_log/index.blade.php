@extends('admin.layouts.app')

@section('title',   'Log Aktivitas Sistem')

@section('content')
<section class="section">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title">Seluruh Riwayat Aktivitas</h4>
            <div class="d-flex align-items-center gap-3">
                <span class="badge bg-primary">{{ $activities->total() }} Total Kegiatan</span>
                @if($activities->total() > 0)
                    <form action="{{ route('admin.activity-log.clear') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus SEMUA riwayat aktivitas? Tindakan ini tidak dapat dibatalkan.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            <i class="bi bi-trash-fill me-1"></i> Bersihkan Log
                        </button>
                    </form>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-lg" id="table-activity">
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>Pengguna</th>
                            <th>Aksi</th>
                            <th>Deskripsi Pelaksanaan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activities as $log)
                            @php
                                $eventColor = [
                                    'created' => 'success',
                                    'updated' => 'info',
                                    'deleted' => 'danger'
                                ][$log->event] ?? 'secondary';
                                
                                $eventIcon = [
                                    'created' => 'bi-plus-circle',
                                    'updated' => 'bi-pencil-square',
                                    'deleted' => 'bi-trash'
                                ][$log->event] ?? 'bi-info-circle';
                            @endphp
                            <tr>
                                <td class="text-nowrap">
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold">{{ $log->created_at->format('d M Y') }}</span>
                                        <small class="text-muted">{{ $log->created_at->format('H:i') }} ({{ $log->created_at->diffForHumans() }})</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-md me-3">
                                            <div class="stats-icon blue" style="width: 2.2rem; height: 2.2rem;">
                                                <i class="bi bi-person"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="font-bold mb-0">{{ $log->user->name ?? 'System' }}</p>
                                            <p class="text-muted mb-0 small">{{ $log->user->role ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light-{{ $eventColor }} text-{{ $eventColor }} text-capitalize">
                                        <i class="bi {{ $eventIcon }} me-1"></i> {{ $log->event }}
                                    </span>
                                </td>
                                <td>
                                    <p class="mb-0 fw-medium">{{ $log->description }}</p>
                                    @if($log->event === 'updated' && !empty($log->properties['attributes']))
                                        <div class="mt-2">
                                            <button class="btn btn-sm btn-outline-info py-0 px-2" type="button" data-bs-toggle="collapse" data-bs-target="#log-{{ $log->id }}">
                                                <small>Lihat Perubahan</small>
                                            </button>
                                            <div class="collapse mt-2" id="log-{{ $log->id }}">
                                                <div class="log-detail-box p-3 border-0">
                                                    <table class="table table-sm mb-0 small">
                                                        <thead>
                                                            <tr>
                                                                <th>Kolom</th>
                                                                <th>Lama</th>
                                                                <th>Baru</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($log->properties['attributes'] as $key => $new)
                                                                @php $old = $log->properties['old'][$key] ?? '-'; @endphp
                                                                @if($key !== 'updated_at')
                                                                <tr>
                                                                    <td class="fw-bold">{{ $key }}</td>
                                                                    <td class="text-danger text-decoration-line-through">{{ is_array($old) ? json_encode($old) : $old }}</td>
                                                                    <td class="text-success">{{ is_array($new) ? json_encode($new) : $new }}</td>
                                                                </tr>
                                                                @endif
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="bi bi-clock-history fs-2 mb-3 d-block"></i>
                                    Belum ada rekaman aktivitas sistem.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $activities->links() }}
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .bg-light-success { background-color: #e8fadf !important; }
    .bg-light-info { background-color: #e0f4ff !important; }
    .bg-light-danger { background-color: #ffe5e5 !important; }
    .table-lg td { padding: 1.2rem 1rem !important; }
    .pagination { justify-content: center; }

    .log-detail-box {
        background-color: rgba(0, 0, 0, 0.05);
        border-radius: 0.75rem;
    }
    
    html.dark .log-detail-box {
        background-color: rgba(255, 255, 255, 0.05);
    }

    .log-detail-box table {
        background: transparent !important;
    }
</style>
@endpush

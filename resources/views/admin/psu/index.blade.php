@extends('admin.layouts.app')
@section('title', 'Manajemen Permohonan PSU')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="card-title">Daftar Permohonan Serah Terima PSU</h5>
        <p class="text-subtitle text-muted">Monitoring pengajuan Prasarana, Sarana, dan Utilitas</p>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>No Registrasi</th>
                        <th>Nama Pemohon</th>
                        <th>Tgl Masuk</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($submissions as $index => $sub)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="text-bold-500">{{ $sub->no_registrasi }}</td>
                            <td>{{ $sub->nama_pemohon }}</td>
                            <td>
                                <span class="text-muted small">
                                    <i class="bi bi-calendar3 me-1"></i> {{ $sub->created_at->format('d M Y') }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $badgeColor = 'bg-secondary';
                                    if($sub->status === 'verifikasi dokumen') $badgeColor = 'bg-info';
                                    if($sub->status === 'perbaikan dokumen') $badgeColor = 'bg-warning';
                                    if($sub->status === 'penugasan tim verifikasi') $badgeColor = 'bg-primary';
                                    if($sub->status === 'BA terima terbit') $badgeColor = 'bg-success';
                                    if($sub->status === 'terima') $badgeColor = 'bg-success';
                                    if($sub->status === 'tolak') $badgeColor = 'bg-danger';
                                @endphp
                                <span class="badge {{ $badgeColor }}">{{ $sub->status }}</span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="{{ route('admin.psu-submissions.show', $sub->id) }}" class="btn btn-sm btn-outline-primary" title="Detail & Verifikasi">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                    @if(!Auth::user()->isKepala())
                                    <a href="{{ route('admin.psu-submissions.edit', $sub->id) }}" class="btn btn-sm btn-outline-warning" title="Edit Data">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    @endif
                                    @if(!Auth::user()->isKepala())
                                    <form action="{{ route('admin.psu-submissions.destroy', $sub->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus permohonan ini? Semua berkas terkait juga akan dihapus.');" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <div class="empty-state">
                                    <div class="empty-icon text-muted mb-2"><i class="bi bi-envelope" style="font-size: 2rem;"></i></div>
                                    <h6>Belum ada permohonan</h6>
                                    <p class="text-muted small">Permohonan yang masuk akan muncul di sini</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@extends('admin.layouts.app')
@section('title', 'Data Jalan')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <form action="{{ route('admin.data-jalan.index') }}" method="GET" class="d-flex gap-2">
                <div class="form-group mb-0">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari jalan, kecamatan..." value="{{ request('search') }}">
                </div>
                @if(request('search'))
                    <a href="{{ route('admin.data-jalan.index') }}" class="btn btn-secondary btn-sm" title="Reset Filter">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                @endif
                <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-search"></i></button>
            </form>
        </div>
        @if(!Auth::user()->isKepala())
        <div>
            <a href="{{ route('admin.data-jalan.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus"></i> Tambah Data Jalan
            </a>
        </div>
        @endif
    </div>
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 0.9rem;">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Kecamatan</th>
                        <th>Kelurahan/Desa</th>
                        <th>Nama Jalan</th>
                        <th>Panjang (m)</th>
                        <th>Status Publik</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jalans as $index => $item)
                        <tr>
                            <td class="ps-3 small">{{ $jalans->firstItem() + $index }}</td>
                            <td class="small">{{ $item->kecamatan }}</td>
                            <td class="small">{{ $item->kelurahan }}</td>
                            <td class="fw-bold">{{ $item->nama_jalan }}</td>
                            <td class="small">{{ number_format($item->panjang_jalan, 2, ',', '.') }} m</td>
                            <td>
                                @if($item->is_public)
                                    <span class="badge bg-success small">Public</span>
                                @else
                                    <span class="badge bg-secondary small">Tidak Public</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <form action="{{ route('admin.data-jalan.toggle-public', $item->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-outline-{{ $item->is_public ? 'secondary' : 'success' }}" title="{{ $item->is_public ? 'Set Tidak Public' : 'Set Public' }}">
                                            <i class="bi bi-{{ $item->is_public ? 'eye-slash' : 'eye' }}"></i>
                                        </button>
                                    </form>
                                    @if(!Auth::user()->isKepala())
                                    <a href="{{ route('admin.data-jalan.edit', $item->id) }}" class="btn btn-outline-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.data-jalan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus data jalan ini?')" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="empty-state py-4">
                                    <div class="empty-icon text-muted mb-3 opacity-25"><i class="bi bi-signpost-split" style="font-size: 4rem;"></i></div>
                                    <h6 class="text-muted">Data jalan tidak ditemukan</h6>
                                    @if(request('search'))
                                        <p class="text-secondary small">Hasil pencarian untuk "{{ request('search') }}" nihil.</p>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-between align-items-center mt-3">
            <span class="text-muted small">Menampilkan {{ $jalans->firstItem() ?? 0 }}–{{ $jalans->lastItem() ?? 0 }} dari {{ $jalans->total() }} data</span>
            <nav>
                {{ $jalans->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
            </nav>
        </div>
    </div>
</div>
@endsection

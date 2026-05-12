@extends('admin.layouts.app')
@section('title', 'Data Perumahan (PSU)')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <form action="{{ route('admin.psu-housing.index') }}" method="GET" class="d-flex gap-2 flex-wrap">
                <div class="form-group mb-0">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari perumahan..." value="{{ request('search') }}">
                </div>
                <div class="form-group mb-0">
                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">-- Semua Status --</option>
                        <option value="Belum Serah Terima" {{ request('status') == 'Belum Serah Terima' ? 'selected' : '' }}>Belum Terima</option>
                        <option value="Sudah Serah Terima" {{ request('status') == 'Sudah Serah Terima' ? 'selected' : '' }}>Sudah Terima</option>
                    </select>
                </div>
                @if(request('search') || request('status'))
                    <a href="{{ route('admin.psu-housing.index') }}" class="btn btn-secondary btn-sm" title="Reset Filter">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                @endif
                <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-search"></i></button>
            </form>
        </div>
        @if(!Auth::user()->isKepala())
        <div>
            <a href="{{ route('admin.psu-housing.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus"></i> Tambah Data
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
                        <th>Perumahan</th>
                        <th>Lokasi / Alamat</th>
                        <th>Pengembang</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($housings as $index => $item)
                        <tr>
                            <td class="ps-3 small">{{ $housings->firstItem() + $index }}</td>
                            <td>
                                <div class="fw-bold">{{ $item->nama_perumahan }}</div>
                                <div class="text-muted small">{{ $item->no_ba_serah_terima ?: '-' }}</div>
                            </td>
                            <td>
                                <div class="small">{{ Str::limit($item->alamat, 45) }}</div>
                            </td>
                            <td class="small">{{ $item->nama_pengembang }}</td>
                            <td>
                                @if($item->status_serah_terima === 'Sudah Serah Terima')
                                    <span class="badge bg-success small">Sudah Terima</span>
                                @else
                                    <span class="badge bg-secondary small">Belum Terima</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.psu-housing.show', $item->id) }}" class="btn btn-outline-primary" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @if(!Auth::user()->isKepala())
                                    <a href="{{ route('admin.psu-housing.edit', $item->id) }}" class="btn btn-outline-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.psu-housing.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?')" style="display:inline;">
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
                            <td colspan="6" class="text-center py-5">
                                <div class="empty-state py-4">
                                    <div class="empty-icon text-muted mb-3 opacity-25"><i class="bi bi-house-door" style="font-size: 4rem;"></i></div>
                                    <h6 class="text-muted">Data perumahan tidak ditemukan</h6>
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
            <span class="text-muted small">Menampilkan {{ $housings->firstItem() ?? 0 }}–{{ $housings->lastItem() ?? 0 }} dari {{ $housings->total() }} data</span>
            <nav>
                {{ $housings->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
            </nav>
        </div>
    </div>
</div>
@endsection

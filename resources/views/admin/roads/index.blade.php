@extends('admin.layouts.app')
@section('title', 'Manajemen Data Jalan')

@section('content')
<div class="road-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <div class="road-filters" style="display: flex; gap: 10px;">
        <form action="{{ route('admin.roads.index') }}" method="GET" style="display: flex; gap: 10px;">
            <input type="text" name="search" class="form-input" placeholder="Cari nama jalan..." value="{{ request('search') }}" />
            <select name="kondisi" class="form-select">
                <option value="">Semua Kondisi</option>
                <option value="Baik" {{ request('kondisi') == 'Baik' ? 'selected' : '' }}>Baik</option>
                <option value="Sedang" {{ request('kondisi') == 'Sedang' ? 'selected' : '' }}>Sedang</option>
                <option value="Rusak Ringan" {{ request('kondisi') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                <option value="Rusak Berat" {{ request('kondisi') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
            </select>
            <select name="per_page" class="form-select" onchange="this.form.submit()">
                <option value="5" {{ request('per_page') == '5' ? 'selected' : '' }}>5 Baris</option>
                <option value="10" {{ request('per_page', 10) == '10' ? 'selected' : '' }}>10 Baris</option>
                <option value="25" {{ request('per_page') == '25' ? 'selected' : '' }}>25 Baris</option>
                <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100 Baris</option>
            </select>
            <button type="submit" class="btn btn-secondary">Set Filter</button>
            @if(request('search') || request('kondisi'))
                <a href="{{ route('admin.roads.index') }}" class="btn btn-secondary" style="background: transparent; color: inherit; border: 1px solid #ccc; text-decoration: none; padding: 0.5rem 1rem; border-radius: 6px;">Reset</a>
            @endif
        </form>
    </div>
    <a href="{{ route('admin.roads.create') }}" class="btn btn-primary" style="text-decoration:none;">
        <i class="fas fa-plus"></i> Tambah Jalan
    </a>
</div>

<div class="table-container">
    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Jalan</th>
                <th>Panjang</th>
                <th>Lebar</th>
                <th>Perkerasan</th>
                <th>Kondisi</th>
                <th>Kecamatan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($roads as $index => $road)
            <tr>
                <td style="font-weight:600;">{{ $roads->firstItem() + $index }}</td>
                <td style="font-weight:500;">{{ $road->nama }}</td>
                <td>{{ number_format($road->panjang, 1) }} km</td>
                <td>{{ number_format($road->lebar, 1) }} m</td>
                <td>{{ $road->jenis_perkerasan }}</td>
                <td>
                    @php
                        $badgeClass = '';
                        if($road->kondisi == 'Baik') $badgeClass = 'baik';
                        if($road->kondisi == 'Sedang') $badgeClass = 'sedang';
                        if($road->kondisi == 'Rusak Ringan') $badgeClass = 'rusak-ringan';
                        if($road->kondisi == 'Rusak Berat') $badgeClass = 'rusak-berat';
                    @endphp
                    <span class="kondisi-badge {{ $badgeClass }}">{{ $road->kondisi }}</span>
                </td>
                <td>{{ $road->kecamatan }}</td>
                <td>
                    <div class="table-actions" style="display:flex; gap:8px;">
                        <a href="{{ route('admin.roads.show', $road->id) }}" class="btn-icon btn-primary" title="Lihat Peta" style="padding:4px 8px; border-radius:4px; text-decoration:none; background-color:#e0f2fe; color:#0284c7;">
                            <i class="fas fa-map-marker-alt"></i>
                        </a>
                        <a href="{{ route('admin.roads.edit', $road->id) }}" class="btn-icon btn-secondary" title="Edit" style="padding:4px 8px; border-radius:4px; text-decoration:none;">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.roads.destroy', $road->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jalan ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-icon btn-danger" title="Hapus" style="padding:4px 8px; border-radius:4px; border:none; background:none; cursor:pointer;">
                                <i class="fas fa-trash" style="color:red;"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align:center; padding:40px;">
                    <div class="empty-state">
                        <i class="fas fa-road" style="font-size:2rem; color:#ccc;"></i>
                        <p style="margin-top:10px; color:#888;">Belum ada data jalan</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div style="margin-top: 20px;">
        {{ $roads->links() }}
    </div>
</div>
@endsection

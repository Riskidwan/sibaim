@extends('admin.layouts.app')
@section('title', 'Manajemen SK Jalan Lingkungan')

@section('content')
<div class="road-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <div class="road-filters" style="display: flex; gap: 10px;">
        <h2 style="font-size: 1.5rem; margin: 0; color: #333;">Daftar SK Jalan Lingkungan</h2>
    </div>
    <a href="{{ route('admin.sk-jalan-lingkungan.create') }}" class="btn btn-primary" style="text-decoration:none;">
        <i class="fas fa-plus"></i> Upload SK Baru
    </a>
</div>

<div class="table-container">
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 50px;">No</th>
                <th>Tahun</th>
                <th>Judul SK</th>
                <th>File PDF</th>
                <th>Tgl Upload</th>
                <th style="width: 120px; text-align: center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($sk_items as $index => $sk)
                <tr>
                    <td style="font-weight:600;">{{ $index + 1 }}</td>
                    <td style="font-weight: bold; color: #1e40af;">{{ $sk->year }}</td>
                    <td>{{ $sk->title }}</td>
                    <td>
                        <a href="{{ asset('storage/' . $sk->file_path) }}" target="_blank" class="btn btn-secondary" style="font-size: 0.8rem; padding: 4px 10px; text-decoration: none;">
                            <i class="fas fa-file-pdf" style="color:#ef4444;"></i> Lihat PDF
                        </a>
                    </td>
                    <td><span style="color: #666; font-size: 0.9em;"><i class="far fa-calendar-alt"></i> {{ $sk->created_at->format('d M Y') }}</span></td>
                    <td>
                        <div class="table-actions" style="display:flex; justify-content: center; gap:8px;">
                            <a href="{{ route('admin.sk-jalan-lingkungan.edit', $sk->id) }}" class="btn-icon btn-secondary" title="Edit Data" style="padding:4px 8px; border-radius:4px; text-decoration:none;">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.sk-jalan-lingkungan.destroy', $sk->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus SK ini?');">
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
                    <td colspan="6" style="text-align:center; padding:50px;">
                        <div class="empty-state">
                            <i class="fas fa-folder-open" style="font-size:2rem; color:#ccc;"></i>
                            <p style="margin-top:10px; color:#888;">Belum ada SK yang diunggah.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

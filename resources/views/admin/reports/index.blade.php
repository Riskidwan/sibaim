@extends('admin.layouts.app')
@section('title', 'Manajemen Laporan Tahunan')

@section('content')
<div class="road-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <div class="road-filters" style="display: flex; gap: 10px;">
        <h2 style="font-size: 1.5rem; margin: 0; color: #333;">Daftar Dokumen Laporan Peta Jalan</h2>
    </div>
    <a href="{{ route('admin.reports.create') }}" class="btn btn-primary" style="text-decoration:none;">
        <i class="fas fa-plus"></i> Upload Laporan Baru
    </a>
</div>

<div class="table-container">
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 50px;">No</th>
                <th>Tahun</th>
                <th>Judul Laporan</th>
                <th>File PDF</th>
                <th>Tgl Upload</th>
                <th style="width: 120px; text-align: center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($reports as $index => $report)
                <tr>
                    <td style="font-weight:600;">{{ $index + 1 }}</td>
                    <td style="font-weight: bold; color: #1e40af;">{{ $report->year }}</td>
                    <td>{{ $report->title }}</td>
                    <td>
                        <a href="{{ asset('storage/' . $report->file_path) }}" target="_blank" class="btn btn-secondary" style="font-size: 0.8rem; padding: 4px 10px; text-decoration: none;">
                            <i class="fas fa-file-pdf" style="color:#ef4444;"></i> Lihat PDF
                        </a>
                    </td>
                    <td><span style="color: #666; font-size: 0.9em;"><i class="far fa-calendar-alt"></i> {{ $report->created_at->format('d M Y') }}</span></td>
                    <td>
                        <div class="table-actions" style="display:flex; justify-content: center; gap:8px;">
                            <a href="{{ route('admin.reports.edit', $report->id) }}" class="btn-icon btn-secondary" title="Edit Data" style="padding:4px 8px; border-radius:4px; text-decoration:none;">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.reports.destroy', $report->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumen laporan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon btn-danger" title="Hapus Dokumen" style="padding:4px 8px; border-radius:4px; border:none; background:none; cursor:pointer;">
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
                            <p style="margin-top:10px; color:#888;">Belum ada file dokumen laporan yang diunggah.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

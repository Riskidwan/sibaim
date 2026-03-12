@extends('admin.layouts.app')
@section('title', 'Manajemen Permohonan PSU')

@section('content')
<div class="road-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="font-size: 1.5rem; margin: 0; color: #333;">Daftar Permohonan Serah Terima PSU</h2>
</div>

<div class="table-container">
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 50px;">No</th>
                <th>No Registrasi</th>
                <th>Nama Pemohon</th>
                <th>Tgl Masuk</th>
                <th>Status</th>
                <th style="width: 100px; text-align: center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($submissions as $index => $sub)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td style="font-weight: 600;">{{ $sub->no_registrasi }}</td>
                    <td>{{ $sub->nama_pemohon }}</td>
                    <td>{{ $sub->created_at->format('d M Y') }}</td>
                    <td>
                        @if($sub->status === 'verifikasi dokumen')
                            <span class="badge" style="background-color: #fef0c7; color: #915d0a; padding: 4px 10px; border-radius: 999px; font-size: 12px; font-weight: 500;">{{ $sub->status }}</span>
                        @elseif($sub->status === 'perbaikan dokumen')
                            <span class="badge" style="background-color: #fee4e2; color: #b42318; padding: 4px 10px; border-radius: 999px; font-size: 12px; font-weight: 500;">{{ $sub->status }}</span>
                        @else
                            <span class="badge" style="background-color: #ecfdf3; color: #027a48; padding: 4px 10px; border-radius: 999px; font-size: 12px; font-weight: 500;">{{ $sub->status }}</span>
                        @endif
                    </td>
                    <td style="text-align: center;">
                        <a href="{{ route('admin.psu-submissions.show', $sub->id) }}" class="btn-icon btn-secondary" title="Detail & Verifikasi" style="padding:4px 8px; border-radius:4px; text-decoration:none;">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 50px;">
                        <div class="empty-state">
                            <i class="fas fa-inbox" style="font-size: 2rem; color: #ccc;"></i>
                            <p style="margin-top: 10px; color: #888;">Belum ada permohonan psu yang masuk.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

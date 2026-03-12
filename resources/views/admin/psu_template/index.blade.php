@extends('admin.layouts.app')
@section('title', 'Template Data Teknis')

@section('content')
<div class="road-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="font-size: 1.5rem; margin: 0; color: #333;">Manajemen Template Data Teknis</h2>
    <a href="{{ route('admin.psu-templates.create') }}" class="btn btn-primary" style="text-decoration:none;">
        <i class="fas fa-plus"></i> Tambah Template
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success" style="padding: 15px; background-color: #ecfdf3; color: #027a48; border: 1px solid #d1fadf; border-radius: 8px; margin-bottom: 20px;">
        {{ session('success') }}
    </div>
@endif

<div class="table-container">
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 50px;">No</th>
                <th>Nama Template</th>
                <th>Deskripsi</th>
                <th>File</th>
                <th style="width: 150px; text-align: center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($templates as $index => $tpl)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td style="font-weight: 600;">{{ $tpl->title }}</td>
                    <td>{{ Str::limit($tpl->description, 50) }}</td>
                    <td>
                        <a href="{{ asset('storage/' . $tpl->file_path) }}" target="_blank" style="color: #2563eb; text-decoration: none;">
                            <i class="fas fa-download"></i> Unduh
                        </a>
                    </td>
                    <td style="text-align: center;">
                        <div style="display: flex; justify-content: center; gap: 8px;">
                            <a href="{{ route('admin.psu-templates.edit', $tpl->id) }}" class="btn-icon btn-secondary" title="Edit" style="padding:4px 8px; border-radius:4px; text-decoration:none;">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.psu-templates.destroy', $tpl->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus template ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon btn-danger" style="padding:4px 8px; border-radius:4px; border:none; cursor:pointer;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 50px;">
                        <div class="empty-state">
                            <i class="fas fa-file-alt" style="font-size: 2rem; color: #ccc;"></i>
                            <p style="margin-top: 10px; color: #888;">Belum ada template yang diunggah.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

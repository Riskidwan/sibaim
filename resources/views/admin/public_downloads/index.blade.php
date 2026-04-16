@extends('admin.layouts.app')
@section('title', 'Pusat Unduhan')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Daftar File Pusat Unduhan</h4>
                @if(Auth::user()->isSuperAdmin())
                <a href="{{ route('admin.public-downloads.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus"></i> Tambah File
                </a>
                @endif
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kategori</th>
                                <th>Nama File</th>
                                <th>Deskripsi</th>
                                <th>Tanggal</th>
                                <th>File</th>
                                @if(Auth::user()->isSuperAdmin())
                                <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($downloads as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><span class="badge bg-secondary">{{ $item->kategori }}</span></td>
                                    <td>{{ $item->title }}</td>
                                    <td>{{ \Illuminate\Support\Str::limit($item->description, 50) }}</td>
                                    <td>{{ $item->tanggal ? $item->tanggal->format('d/m/Y') : '-' }}</td>
                                    <td>
                                        <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-download"></i> Unduh
                                        </a>
                                    </td>
                                    @if(Auth::user()->isSuperAdmin())
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.public-downloads.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.public-downloads.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus file ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Belum ada file unduhan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('admin.layouts.app')
@section('title', 'Manajemen Galeri Kegiatan')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h5 class="card-title">Galeri Kegiatan</h5>
            <p class="text-subtitle text-muted">Kelola dokumentasi foto kegiatan sesuai kategori</p>
        </div>
        @if(!Auth::user()->isKepala())
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createModal">
            <i class="bi bi-cloud-arrow-up"></i> Unggah Foto
        </button>
        @endif
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Pratinjau Foto</th>
                        <th>Judul Dokumentasi</th>
                        <th>Kategori</th>
                        <th>Status Publikasi</th>
                        @if(!Auth::user()->isKepala())
                        <th class="text-center">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if($data->isEmpty())
                        <tr>
                            <td colspan="{{ Auth::user()->isKepala() ? 5 : 6 }}" class="text-center py-4">
                                <div class="empty-state">
                                    <div class="empty-icon text-muted mb-2"><i class="bi bi-images" style="font-size: 2rem;"></i></div>
                                    <h6>Belum ada foto galeri</h6>
                                </div>
                            </td>
                        </tr>
                    @else
                        @foreach($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <img src="{{ asset('storage/' . $item->file_path) }}" alt="{{ $item->judul }}" class="rounded shadow-sm" style="height: 60px; width: 60px; object-fit: cover; border: 1px solid #ddd;">
                            </td>
                            <td class="text-bold-500">{{ $item->judul }}</td>
                            <td>
                                @php
                                    $kategoriLabels = [
                                        'berita' => ['label' => 'Berita Teks/Gambar', 'color' => 'bg-light-primary'],
                                        'kunjungan' => ['label' => 'Kunjungan Kerja', 'color' => 'bg-light-info'],
                                        'rapat' => ['label' => 'Rapat Koordinasi', 'color' => 'bg-light-warning'],
                                        'sosialisasi' => ['label' => 'Sosialisasi', 'color' => 'bg-light-success']
                                    ];
                                    $cat = $kategoriLabels[$item->kategori];
                                @endphp
                                <span class="badge {{ $cat['color'] }}">{{ $cat['label'] }}</span>
                            </td>
                            <td>
                                @if($item->is_active)
                                    <span class="badge bg-light-success"><i class="bi bi-eye"></i> Tampil</span>
                                @else
                                    <span class="badge bg-light-secondary"><i class="bi bi-eye-slash"></i> Sembunyi</span>
                                @endif
                            </td>
                            @if(!Auth::user()->isKepala())
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <form action="{{ route('admin.galeri.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus foto ini dari galeri?')" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                            @endif
                        </tr>

                        <!-- Edit Modal -->
                        @if(!Auth::user()->isKepala())
                        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form action="{{ route('admin.galeri.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Foto Galeri</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="text-center mb-3">
                                                <img src="{{ asset('storage/' . $item->file_path) }}" alt="{{ $item->judul }}" class="img-thumbnail rounded" style="height: 150px; object-fit: cover;">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Judul/Deskripsi <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="judul" value="{{ $item->judul }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Kategori Kegiatan <span class="text-danger">*</span></label>
                                                <select class="form-select" name="kategori" required>
                                                    <option value="berita" {{ $item->kategori == 'berita' ? 'selected' : '' }}>Berita dalam Gambar</option>
                                                    <option value="kunjungan" {{ $item->kategori == 'kunjungan' ? 'selected' : '' }}>Kunjungan Kerja</option>
                                                    <option value="rapat" {{ $item->kategori == 'rapat' ? 'selected' : '' }}>Rapat Koordinasi</option>
                                                    <option value="sosialisasi" {{ $item->kategori == 'sosialisasi' ? 'selected' : '' }}>Sosialisasi</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Ganti Foto Baru (Opsional)</label>
                                                <input type="file" class="form-control" name="foto" accept="image/*">
                                                <small class="text-muted">Format: JPG, PNG. Maksimal 5MB.</small>
                                            </div>
                                            <div class="form-check form-switch mt-3">
                                                <input class="form-check-input" type="checkbox" name="is_active" id="isActiveEdit{{ $item->id }}" {{ $item->is_active ? 'checked' : '' }}>
                                                <label class="form-check-label" for="isActiveEdit{{ $item->id }}">Tampilkan di Halaman Publik</label>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create Modal -->
@if(!Auth::user()->isKepala())
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Unggah Foto Galeri Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Judul/Deskripsi Singkat <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="judul" required placeholder="Contoh: Rapat Koordinasi Evaluasi Jalan Tahun 2026">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori Kegiatan <span class="text-danger">*</span></label>
                        <select class="form-select" name="kategori" required>
                            <option value="" disabled selected>Pilih Kategori...</option>
                            <option value="berita">Berita dalam Gambar</option>
                            <option value="kunjungan">Kunjungan Kerja</option>
                            <option value="rapat">Rapat Koordinasi</option>
                            <option value="sosialisasi">Sosialisasi</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Unggah Foto <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="foto" accept="image/*" required>
                        <small class="text-danger d-block mt-1">Format: JPG, PNG, GIF. Maksimal 5MB.</small>
                    </div>
                    <div class="form-check form-switch mt-3">
                        <input class="form-check-input" type="checkbox" name="is_active" id="isActiveCreate" checked>
                        <label class="form-check-label" for="isActiveCreate">Tampilkan di Halaman Publik</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan & Unggah</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection

@extends('admin.layouts.app')
@section('title', 'Manajemen Galeri Kegiatan')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h5 class="card-title">Galeri Kegiatan (Album)</h5>
            <p class="text-subtitle text-muted">Kelola dokumentasi foto kegiatan secara berkelompok</p>
        </div>
        @if(!Auth::user()->isKepala())
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createModal">
            <i class="bi bi-plus-lg"></i> Tambah Kegiatan Baru
        </button>
        @endif
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Judul Kegiatan</th>
                        <th>Kategori</th>
                        <th>Tanggal</th>
                        <th>Jumlah Foto</th>
                        <th>Status</th>
                        @if(!Auth::user()->isKepala())
                        <th class="text-center">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if($data->isEmpty())
                        <tr>
                            <td colspan="{{ Auth::user()->isKepala() ? 6 : 7 }}" class="text-center py-4">
                                <div class="empty-state">
                                    <div class="empty-icon text-muted mb-2"><i class="bi bi-images" style="font-size: 2rem;"></i></div>
                                    <h6>Belum ada data kegiatan galeri</h6>
                                </div>
                            </td>
                        </tr>
                    @else
                        @foreach($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-bold-500">{{ $item->judul }}</td>
                            <td>
                                @php
                                    $kategoriLabels = [
                                        'berita' => ['label' => 'Berita Bergambar', 'color' => 'bg-light-primary'],
                                        'kunjungan' => ['label' => 'Kunjungan Kerja', 'color' => 'bg-light-info'],
                                        'rapat' => ['label' => 'Rapat Koordinasi', 'color' => 'bg-light-warning'],
                                        'sosialisasi' => ['label' => 'Sosialisasi', 'color' => 'bg-light-success']
                                    ];
                                    $cat = $kategoriLabels[$item->kategori];
                                @endphp
                                <span class="badge {{ $cat['color'] }}">{{ $cat['label'] }}</span>
                            </td>
                            <td>{{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') : '-' }}</td>
                            <td>
                                <span class="badge bg-secondary">{{ $item->images->count() }} Foto</span>
                            </td>
                            <td>
                                @if($item->is_active)
                                    <span class="badge bg-light-success">Aktif</span>
                                @else
                                    <span class="badge bg-light-secondary">Sembunyi</span>
                                @endif
                            </td>
                            @if(!Auth::user()->isKepala())
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#viewModal{{ $item->id }}" title="Lihat Foto">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <form action="{{ route('admin.galeri-kegiatan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus seluruh kegiatan dan foto di dalamnya?')" style="display:inline;">
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

                        <!-- View/Manage Photos Modal -->
                        <div class="modal fade" id="viewModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Foto Kegiatan: {{ $item->judul }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row g-2">
                                            @foreach($item->images as $img)
                                            <div class="col-6 col-md-3">
                                                <div class="position-relative border rounded overflow-hidden" style="height: 120px;">
                                                    <img src="{{ asset('storage/' . $img->file_path) }}" class="w-100 h-100" style="object-fit: cover;">
                                                    @if(!Auth::user()->isKepala())
                                                    <form action="{{ route('admin.galeri-kegiatan.destroy-image', $img->id) }}" method="POST" class="position-absolute top-0 end-0 p-1">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm p-0 px-1" title="Hapus Foto" onclick="return confirm('Hapus foto ini?')">
                                                            <i class="bi bi-x"></i>
                                                        </button>
                                                    </form>
                                                    @endif
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Modal -->
                        @if(!Auth::user()->isKepala())
                        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form action="{{ route('admin.galeri-kegiatan.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Kegiatan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Judul Kegiatan <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="judul" value="{{ $item->judul }}" required>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Kategori <span class="text-danger">*</span></label>
                                                    <select class="form-select" name="kategori" required>
                                                        <option value="berita" {{ $item->kategori == 'berita' ? 'selected' : '' }}>Berita Bergambar</option>
                                                        <option value="kunjungan" {{ $item->kategori == 'kunjungan' ? 'selected' : '' }}>Kunjungan Kerja</option>
                                                        <option value="rapat" {{ $item->kategori == 'rapat' ? 'selected' : '' }}>Rapat Koordinasi</option>
                                                        <option value="sosialisasi" {{ $item->kategori == 'sosialisasi' ? 'selected' : '' }}>Sosialisasi</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Tanggal</label>
                                                    <input type="date" class="form-control" name="tanggal" value="{{ $item->tanggal }}">
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Deskripsi (Opsional)</label>
                                                <textarea class="form-control" name="deskripsi" rows="2">{{ $item->deskripsi }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Tambah Foto Baru</label>
                                                <input type="file" class="form-control" name="new_images[]" multiple accept="image/*">
                                                <small class="text-muted">Bisa pilih banyak file sekaligus.</small>
                                            </div>
                                            <div class="form-check form-switch mt-3">
                                                <input class="form-check-input" type="checkbox" name="is_active" id="isActiveEdit{{ $item->id }}" {{ $item->is_active ? 'checked' : '' }}>
                                                <label class="form-check-label" for="isActiveEdit{{ $item->id }}">Aktif/Tampil di Publik</label>
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
<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.galeri-kegiatan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kegiatan Galeri Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Judul Kegiatan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="judul" required placeholder="Contoh: Peresmian Serah Terima PSU Perumahan">
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select" name="kategori" required>
                                <option value="" disabled selected>Pilih Kategori...</option>
                                <option value="berita">Berita Bergambar</option>
                                <option value="kunjungan">Kunjungan Kerja</option>
                                <option value="rapat">Rapat Koordinasi</option>
                                <option value="sosialisasi">Sosialisasi</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal</label>
                            <input type="date" class="form-control" name="tanggal" value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi (Opsional)</label>
                        <textarea class="form-control" name="deskripsi" rows="2" placeholder="Keterangan singkat kegiatan..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Unggah Foto (Bisa pilih banyak) <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="images[]" multiple accept="image/*" required>
                        <small class="text-muted">Pilih satu atau lebih file foto. Maksimal 5MB/file.</small>
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

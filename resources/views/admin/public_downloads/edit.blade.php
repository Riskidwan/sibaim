@extends('admin.layouts.app')
@section('title', 'Edit File Pusat Unduhan')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title">Edit File Unduhan</h4>
        <a href="{{ route('admin.public-downloads.index') }}" class="btn btn-outline-secondary btn-sm">Batal</a>
    </div>

    <div class="card-body">
        <form id="formEditFile" action="{{ route('admin.public-downloads.update', $download->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                    <select id="kategori" name="kategori" class="form-select @error('kategori') is-invalid @enderror" required>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ old('kategori', $download->kategori) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                    @error('kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label for="title" class="form-label">Nama File <span class="text-danger">*</span></label>
                    <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $download->title) }}" required placeholder="Masukkan nama dokumen/file">
                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" rows="3" placeholder="Masukkan deskripsi file">{{ old('description', $download->description) }}</textarea>
                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" id="tanggal" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal', $download->tanggal ? $download->tanggal->format('Y-m-d') : '') }}">
                    @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="file" class="form-label">Upload File Baru (Opsional)</label>
                    <input type="file" id="file" name="file" class="form-control @error('file') is-invalid @enderror">
                    <small class="text-muted">Biarkan kosong jika tidak ingin mengganti file. Format: PDF, DOCX, XLSX, ZIP, RAR. Maksimal 20MB.</small>
                    @error('file') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    
                    @if($download->file_path)
                    <div class="mt-2">
                        <a href="{{ asset('storage/' . $download->file_path) }}" target="_blank" class="btn btn-sm btn-info text-white">
                            <i class="bi bi-file-earmark-text"></i> Lihat File Saat Ini
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12 d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.public-downloads.index') }}" class="btn btn-light-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save me-2"></i>Perbarui File</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection


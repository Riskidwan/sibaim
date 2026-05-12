@extends('admin.layouts.app')
@section('title', 'Tambah File Pusat Unduhan')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title">Tambah File Unduhan</h4>
        <a href="{{ route('admin.public-downloads.index') }}" class="btn btn-outline-secondary btn-sm">Batal</a>
    </div>

    <div class="card-body">
        <form id="formSimpanFile" action="{{ route('admin.public-downloads.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                    <select id="kategori" name="kategori" class="form-select @error('kategori') is-invalid @enderror" required>
                        <option value="" disabled selected>-- Pilih Kategori --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ old('kategori') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                    @error('kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label for="title" class="form-label">Nama File <span class="text-danger">*</span></label>
                    <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required placeholder="Masukkan nama dokumen/file">
                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label for="description" class="form-label">Deskripsi (Opsional)</label>
                    <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" rows="3" placeholder="Masukkan deskripsi file">{{ old('description') }}</textarea>
                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" id="tanggal" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal') }}">
                    @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="file" class="form-label">Upload File <span class="text-danger">*</span></label>
                    <input type="file" id="file" name="file" class="form-control @error('file') is-invalid @enderror" required>
                    <small class="text-muted">Format yang diizinkan: PDF, DOC, DOCX, XLS, XLSX, ZIP, RAR. Maksimal: 20MB.</small>
                    @error('file') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12 d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.public-downloads.index') }}" class="btn btn-light-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save me-2"></i>Simpan File</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection


@extends('admin.layouts.app')
@section('title', 'Tambah Data Jalan')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Tambah Data Jalan</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.data-jalan.store') }}" method="POST">
                    @csrf
                    
                    <div class="form-group mb-3">
                        <label for="kecamatan" class="form-label">Kecamatan <span class="text-danger">*</span></label>
                        <input type="text" name="kecamatan" id="kecamatan" class="form-control @error('kecamatan') is-invalid @enderror" value="{{ old('kecamatan') }}" required>
                        @error('kecamatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="kelurahan" class="form-label">Kelurahan/Desa <span class="text-danger">*</span></label>
                        <input type="text" name="kelurahan" id="kelurahan" class="form-control @error('kelurahan') is-invalid @enderror" value="{{ old('kelurahan') }}" required>
                        @error('kelurahan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="nama_jalan" class="form-label">Nama Jalan <span class="text-danger">*</span></label>
                        <input type="text" name="nama_jalan" id="nama_jalan" class="form-control @error('nama_jalan') is-invalid @enderror" value="{{ old('nama_jalan') }}" required>
                        @error('nama_jalan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="panjang_jalan" class="form-label">Panjang Jalan (meter)</label>
                        <input type="number" step="0.01" name="panjang_jalan" id="panjang_jalan" class="form-control @error('panjang_jalan') is-invalid @enderror" value="{{ old('panjang_jalan') }}">
                        @error('panjang_jalan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-check form-switch mb-4">
                        <input class="form-check-input" type="checkbox" name="is_public" id="is_public" value="1" {{ old('is_public') ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold" for="is_public">Publikasikan Langsung</label>
                        <div class="form-text">Jika aktif, data jalan akan langsung tampil di halaman publik website.</div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.data-jalan.index') }}" class="btn btn-light-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary px-4">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

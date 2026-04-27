@extends('admin.layouts.app')
@section('title', 'Edit Permohonan PSU')

@php /** @var \App\Models\PsuSubmission $submission */ @endphp

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Edit Data Permohonan: {{ $submission->no_registrasi }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.psu-submissions.update', $submission->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Basic Information -->
                        <div class="col-md-6">
                            <h6 class="mb-3 text-primary">Informasi Dasar</h6>
                            <div class="form-group mb-3">
                                <label for="nama_pemohon" class="form-label">Nama Pemohon</label>
                                <input type="text" name="nama_pemohon" id="nama_pemohon" class="form-control" value="{{ old('nama_pemohon', $submission->nama_pemohon) }}" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="lokasi_pembangunan" class="form-label">Lokasi Pembangunan</label>
                                <textarea name="lokasi_pembangunan" id="lokasi_pembangunan" class="form-control" rows="3" required>{{ old('lokasi_pembangunan', $submission->lokasi_pembangunan) }}</textarea>
                            </div>
                        </div>

                        <!-- Verification Status -->
                        <div class="col-md-6">
                            <h6 class="mb-3 text-primary">Status & Verifikasi</h6>
                            <div class="form-group mb-3">
                                <label for="status-select" class="form-label">Status Permohonan</label>
                                <select name="status" id="status-select" class="form-select" required>
                                    <option value="verifikasi dokumen" {{ $submission->status === 'verifikasi dokumen' ? 'selected' : '' }}>Verifikasi Dokumen</option>
                                    <option value="perbaikan dokumen" {{ $submission->status === 'perbaikan dokumen' ? 'selected' : '' }}>Perbaikan Dokumen</option>
                                    <option value="penugasan tim verifikasi" {{ $submission->status === 'penugasan tim verifikasi' ? 'selected' : '' }}>Penugasan Tim Verifikasi</option>
                                    <option value="BA terima terbit" {{ $submission->status === 'BA terima terbit' ? 'selected' : '' }}>BA Terima Terbit</option>
                                </select>
                            </div>

                            <div id="note-section" class="form-group mb-3" style="display: {{ $submission->status === 'perbaikan dokumen' ? 'block' : 'none' }};">
                                <label for="catatan_perbaikan" class="form-label">Catatan Perbaikan</label>
                                <textarea name="catatan_perbaikan" id="catatan_perbaikan" class="form-control" rows="3">{{ old('catatan_perbaikan', $submission->catatan_perbaikan) }}</textarea>
                            </div>

                            <div id="ba-section" style="display: {{ $submission->status === 'BA terima terbit' ? 'block' : 'none' }};">
                                <div class="form-group mb-3">
                                    <label for="nomor_surat_ba" class="form-label">Nomor Surat BA Terima</label>
                                    <input type="text" name="nomor_surat_ba" id="nomor_surat_ba" class="form-control" value="{{ old('nomor_surat_ba', $submission->nomor_surat_ba) }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="file_ba_terbit" class="form-label">Update File BA Terima (PDF/Gambar)</label>
                                    <input type="file" name="file_ba_terbit" id="file_ba_terbit" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                    @if($submission->file_ba_terbit)
                                        <div class="mt-1 small text-muted">File saat ini: <a href="{{ route('psu.file.serve', ['submission' => $submission->id, 'field' => 'file_ba_terbit']) }}" target="_blank">Lihat Berkas</a></div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mt-4">
                            <h6 class="mb-3 text-primary">Berkas Lampiran (Upload ulang jika ingin mengganti)</h6>
                            <div class="row">
                                @php
                                    $docs = [
                                        'file_template_diisi' => 'Template Data Teknis',
                                        'fc_ktp' => 'FC KTP',
                                        'fc_akta_pendirian' => 'FC Akta Pendirian',
                                        'fc_sertifikat_tanah' => 'FC Sertifikat Tanah',
                                        'siteplan' => 'Siteplan',
                                        'daftar_psu_nilai' => 'Daftar PSU & Nilai',
                                        'fc_imb_pbg' => 'FC IMB/PBG'
                                    ];
                                @endphp
                                @foreach($docs as $key => $label)
                                    <div class="col-md-4 mb-3">
                                        <label for="{{ $key }}" class="form-label small fw-bold">{{ $label }}</label>
                                        <input type="file" name="{{ $key }}" id="{{ $key }}" class="form-control form-control-sm">
                                        @if($submission->$key)
                                            <div class="mt-1 d-flex align-items-center justify-content-between" id="file-container-{{ $key }}">
                                                <a href="{{ route('psu.file.serve', ['submission' => $submission->id, 'field' => $key]) }}" target="_blank" class="text-info small"><i class="bi bi-file-earmark-check"></i> Lihat Berkas Saat Ini</a>
                                                <button type="button" class="btn btn-link text-danger p-0 ms-2" onclick="markFileForDeletion('{{ $key }}', '{{ $label }}')" title="Tolak/Hapus Berkas ini">
                                                    <i class="bi bi-x-circle-fill"></i>
                                                </button>
                                                <input type="hidden" name="delete_files[]" id="delete-input-{{ $key }}" value="" disabled>
                                            </div>
                                            <div id="status-{{ $key }}" class="mt-1 small text-danger fw-bold" style="display: none;">
                                                <i class="bi bi-trash"></i> Akan dihapus (User harus upload ulang)
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.psu-submissions.index') }}" class="btn btn-light-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('status-select').addEventListener('change', function() {
        const noteSection = document.getElementById('note-section');
        const baSection = document.getElementById('ba-section');
        
        noteSection.style.display = (this.value === 'perbaikan dokumen') ? 'block' : 'none';
        baSection.style.display = (this.value === 'BA terima terbit') ? 'block' : 'none';
    });

    function markFileForDeletion(key, label) {
        if (confirm(`Apakah Anda yakin ingin menolak berkas ${label}? File akan dihapus dan user wajib upload ulang.`)) {
            document.getElementById('file-container-' + key).style.display = 'none';
            document.getElementById('status-' + key).style.display = 'block';
            const input = document.getElementById('delete-input-' + key);
            input.value = key;
            input.disabled = false;
        }
    }
</script>
@endpush
@endsection

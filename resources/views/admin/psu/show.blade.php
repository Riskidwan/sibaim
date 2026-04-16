@extends('admin.layouts.app')
@section('title', 'Detail Permohonan PSU')

@php /** @var \App\Models\PsuSubmission $submission */ @endphp

@section('content')
<div class="row">
    <!-- LEFT: Details Card -->
    <div class="col-md-7 col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-start">
                <div>
                    <h4 class="card-title">{{ $submission->no_registrasi }}</h4>
                    <p class="text-subtitle text-muted mb-0"><i class="bi bi-calendar-event me-1"></i> Pengajuan: {{ $submission->created_at->format('d M Y, H:i') }}</p>
                </div>
                @php
                    $statusClass = 'bg-light-secondary';
                    if($submission->status === 'verifikasi dokumen') $statusClass = 'bg-light-info';
                    if($submission->status === 'perbaikan dokumen') $statusClass = 'bg-light-warning';
                    if($submission->status === 'penugasan tim verifikasi') $statusClass = 'bg-light-primary';
                    if($submission->status === 'terima' || $submission->status === 'BA terima terbit') $statusClass = 'bg-light-success';
                @endphp
                <span class="badge {{ $statusClass }} px-3 py-2">
                    <i class="bi bi-circle-fill me-1" style="font-size: 0.5rem; vertical-align: middle;"></i>
                    {{ $submission->status }}
                </span>
            </div>

            <div class="card-body">
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <label class="text-muted small text-uppercase fw-bold d-block mb-1">Nama Pemohon</label>
                        <div class="fw-bold">{{ $submission->nama_pemohon }}</div>
                        <div class="small text-muted mt-1"><i class="bi bi-envelope me-1"></i>{{ $submission->user->email ?? '-' }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small text-uppercase fw-bold d-block mb-1">Jenis Permohonan</label>
                        <div class="fw-bold">{{ $submission->jenis_permohonan }}</div>
                    </div>
                    <div class="col-12">
                        <label class="text-muted small text-uppercase fw-bold d-block mb-1">Lokasi Pembangunan</label>
                        <div class="fw-bold">{{ $submission->lokasi_pembangunan }}</div>
                    </div>
                </div>

                <div class="divider divider-left mt-5 mb-4">
                    <div class="divider-text fw-bold text-primary">Berkas Persyaratan</div>
                </div>
                
                <div class="row g-3">
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
                        @php
                            $ext = pathinfo($submission->$key, PATHINFO_EXTENSION);
                            $iconClass = 'bi-file-earmark';
                            $iconColor = 'text-muted';
                            
                            if ($ext === 'pdf') { $iconClass = 'bi-file-earmark-pdf'; $iconColor = 'text-danger'; }
                            elseif (in_array($ext, ['doc', 'docx'])) { $iconClass = 'bi-file-earmark-word'; $iconColor = 'text-primary'; }
                            elseif (in_array($ext, ['xls', 'xlsx'])) { $iconClass = 'bi-file-earmark-excel'; $iconColor = 'text-success'; }
                        @endphp
                        <div class="col-md-6">
                            <a href="{{ asset('storage/' . $submission->$key) }}" target="_blank" class="d-flex align-items-center gap-3 p-3 border rounded-3 bg-light text-decoration-none transition-hover">
                                <i class="bi {{ $iconClass }} fs-4 {{ $iconColor }}"></i>
                                <span class="flex-grow-1 small fw-bold">{{ $label }}</span>
                                <i class="bi bi-box-arrow-up-right text-muted small"></i>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- RIGHT: Verification Card -->
    <div class="col-md-5 col-lg-4">
        @if(!Auth::user()->isKepala())
        <div class="card shadow-sm border-primary border-top border-4">
            <div class="card-header">
                <h5 class="card-title d-flex align-items-center"><i class="bi bi-patch-check me-2 text-primary"></i> Verifikasi</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.psu-submissions.update', $submission->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group mb-3">
                        <label for="status-select" class="form-label">Ubah Status</label>
                        <select name="status" id="status-select" class="form-select shadow-sm" required>
                            <option value="verifikasi dokumen" {{ $submission->status === 'verifikasi dokumen' ? 'selected' : '' }}>Verifikasi Dokumen</option>
                            <option value="perbaikan dokumen" {{ $submission->status === 'perbaikan dokumen' ? 'selected' : '' }}>Perbaikan Dokumen</option>
                            <option value="penugasan tim verifikasi" {{ $submission->status === 'penugasan tim verifikasi' ? 'selected' : '' }}>Penugasan Tim Verifikasi</option>
                            <option value="BA terima terbit" {{ $submission->status === 'BA terima terbit' ? 'selected' : '' }}>BA Terima Terbit</option>
                        </select>
                    </div>

                    <div id="note-section" class="form-group mb-4" style="display: {{ $submission->status === 'perbaikan dokumen' ? 'block' : 'none' }};">
                        <label class="form-label">Catatan Perbaikan</label>
                        <textarea name="catatan_perbaikan" class="form-control" placeholder="Berikan alasan atau daftar berkas yang perlu diperbaiki..." style="min-height: 120px;">{{ $submission->catatan_perbaikan }}</textarea>
                    </div>

                    <div id="ba-section" class="form-group mb-4" style="display: {{ $submission->status === 'BA terima terbit' ? 'block' : 'none' }};">
                        <label class="form-label">Nomor Surat BA Terima</label>
                        <input type="text" name="nomor_surat_ba" class="form-control mb-3" placeholder="Masukkan Nomor Surat..." value="{{ $submission->nomor_surat_ba }}">
                        
                        <label class="form-label">File BA Terima (PDF/Gambar)</label>
                        @if($submission->file_ba_terbit)
                            <div class="mb-2">
                                <a href="{{ asset('storage/' . $submission->file_ba_terbit) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                    <i class="bi bi-file-earmark-pdf"></i> Lihat File Saat Ini
                                </a>
                            </div>
                        @endif
                        <input type="file" name="file_ba_terbit" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                        <small class="text-muted">Maksimal 5MB. Format: PDF, JPG, PNG.</small>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg shadow">
                            <i class="bi bi-save me-2"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.psu-submissions.index') }}" class="btn btn-light-secondary mt-1">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
        @else
        <div class="card">
            <div class="card-header">
                <h5 class="card-title d-flex align-items-center"><i class="bi bi-info-circle me-2 text-info"></i> Informasi</h5>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <label class="text-muted small text-uppercase d-block mb-1">Status Saat Ini</label>
                    <div class="fw-bold p-3 bg-light rounded-3 border-start border-3 border-info">{{ $submission->status }}</div>
                </div>
                @if($submission->catatan_perbaikan)
                <div class="mb-4">
                    <label class="text-muted small text-uppercase d-block mb-1">Catatan</label>
                    <div class="small p-3 bg-light rounded-3 text-secondary">{{ $submission->catatan_perbaikan }}</div>
                </div>
                @endif
                @if($submission->nomor_surat_ba)
                <div class="mb-4">
                    <label class="text-muted small text-uppercase d-block mb-1">Nomor Surat BA</label>
                    <div class="fw-bold p-3 bg-light rounded-3 border-start border-3 border-success">{{ $submission->nomor_surat_ba }}</div>
                    @if($submission->file_ba_terbit)
                        <div class="mt-2 text-center">
                            <a href="{{ asset('storage/' . $submission->file_ba_terbit) }}" target="_blank" class="btn btn-sm btn-success w-100">
                                <i class="bi bi-download me-1"></i> Unduh Berkas BA
                            </a>
                        </div>
                    @endif
                </div>
                @endif
                <div class="d-grid mt-4">
                    <a href="{{ route('admin.psu-submissions.index') }}" class="btn btn-outline-secondary w-100">Kembali</a>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('status-select').addEventListener('change', function() {
        const noteSection = document.getElementById('note-section');
        const baSection = document.getElementById('ba-section');
        
        if (this.value === 'perbaikan dokumen') {
            noteSection.style.display = 'block';
        } else {
            noteSection.style.display = 'none';
        }

        if (this.value === 'BA terima terbit') {
            baSection.style.display = 'block';
        } else {
            baSection.style.display = 'none';
        }
    });
</script>
@endpush
@endsection

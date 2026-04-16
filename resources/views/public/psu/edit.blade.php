@extends('public.layouts.app')
@section('title', 'Perbaikan Permohonan PSU')

@push('styles')
<style>
    .form-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        padding: 40px;
        margin-bottom: 50px;
    }
    .form-control {
        border-radius: 8px;
        padding: 12px;
        border: 1px solid #ddd;
    }
    .btn-submit {
        background: #2563eb;
        color: white;
        padding: 12px 30px;
        border-radius: 8px;
        border: none;
        font-weight: 600;
        transition: all 0.3s;
        width: 100%;
        margin-top: 20px;
    }
    .btn-submit:hover {
        background: #1e40af;
        transform: translateY(-2px);
    }
    .feedback-note {
        background: #fff1f2;
        border-left: 4px solid #e11d48;
        padding: 15px;
        border-radius: 4px;
        margin-bottom: 30px;
    }
    .file-hint {
        font-size: 0.8rem;
        color: #64748b;
        margin-top: 4px;
    }
    .current-file {
        font-size: 0.85rem;
        color: #027a48;
        margin-bottom: 8px;
        display: block;
    }
    body { padding-top: 80px; background: #f4f7fb; }
</style>
<link rel="stylesheet" href="{{ asset('css/public.css') }}?v=4">
@endpush

@php /** @var \App\Models\PsuSubmission $submission */ @endphp

@section('content')
<!-- ***** Spacer for Header ***** -->
<div style="height: 100px; background: #f7f7f7;"></div>

<section class="section" style="background: #f7f7f7; padding-top: 30px; min-height: 80vh;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading text-center" style="margin-bottom: 40px;">
                    <h2>Perbaikan Permohonan PSU</h2>
                    <p style="margin-top: 15px; font-size: 15px; color: #666;">
                        No. Registrasi: <span style="font-weight: 700; color: #1e3a8a;">{{ $submission->no_registrasi }}</span>
                    </p>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="form-card">
                    @if($submission->catatan_perbaikan)
                        <div class="feedback-note">
                            <h6 style="color: #9f1239; margin-bottom: 8px;"><i class="fas fa-info-circle"></i> Catatan dari Admin:</h6>
                            <p style="margin: 0; color: #444;">{{ $submission->catatan_perbaikan }}</p>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger" style="border-radius: 8px; margin-bottom: 25px;">
                            <ul style="margin: 0; padding-left: 20px;">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ url('/permohonan-psu/' . $submission->no_registrasi) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <div class="col-md-12 mb-4">
                                <label style="font-weight: 600;">Nama Pemohon</label>
                                <input type="text" name="nama_pemohon" class="form-control" value="{{ old('nama_pemohon', $submission->nama_pemohon) }}" required>
                            </div>
                            <div class="col-md-12 mb-4">
                                <label style="font-weight: 600;">Lokasi Pembangunan</label>
                                <textarea name="lokasi_pembangunan" class="form-control" rows="3" required>{{ old('lokasi_pembangunan', $submission->lokasi_pembangunan) }}</textarea>
                            </div>
                        </div>

                        <hr style="margin: 30px 0;">
                        <h5 style="margin-bottom: 20px; color: #1e3a8a;">Pembaruan Dokumen</h5>
                        <p style="font-size: 0.9rem; color: #666; margin-bottom: 20px;">Silakan unggah kembali dokumen yang perlu diperbaiki. Biarkan kosong jika dokumen sudah sesuai.</p>

                        @php
                            $docs = [
                                'file_template_diisi' => 'Template Data Teknis Terisi',
                                'fc_ktp' => 'FC KTP',
                                'fc_akta_pendirian' => 'FC Akta Pendirian',
                                'fc_sertifikat_tanah' => 'FC Sertifikat Tanah',
                                'siteplan' => 'Siteplan',
                                'daftar_psu_nilai' => 'Daftar PSU & Nilai',
                                'fc_imb_pbg' => 'FC IMB/PBG'
                            ];
                        @endphp

                        <div class="row">
                            @foreach($docs as $key => $label)
                                <div class="col-md-6 mb-4">
                                    <label style="font-weight: 600;">{{ $label }}</label>
                                    @if($submission->$key)
                                        <span class="current-file"><i class="fas fa-check-circle"></i> File sudah ada</span>
                                    @else
                                        <span class="current-file" style="color: #e11d48;"><i class="fas fa-times-circle"></i> Belum ada file</span>
                                    @endif
                                    <input type="file" name="{{ $key }}" class="form-control-file" {{ $key === 'file_template_diisi' ? 'accept=".pdf,.doc,.docx,.xls,.xlsx,.zip"' : 'accept=".pdf,.jpg,.jpeg,.png"' }}>
                                    @if($key === 'file_template_diisi')
                                        <p class="file-hint">Format: Document/Excel/Zip. Max 10MB.</p>
                                    @else
                                        <p class="file-hint">Format: PDF/JPG/PNG. Max 5MB.</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <div style="margin-top: 30px; display: flex; gap: 15px;">
                            <a href="{{ url('/user/dashboard') }}" class="btn btn-secondary" style="flex: 1; padding: 12px; border-radius: 8px;">Batal</a>
                            <button type="submit" class="btn-submit" style="flex: 2; margin: 0;">Simpan Perubahan & Kirim Verifikasi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection


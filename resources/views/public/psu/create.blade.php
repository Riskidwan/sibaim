@extends('public.layouts.app')
@section('title', 'Permohonan Serah Terima PSU')

@push('styles')
<style>
    .form-section {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        padding: 40px;
        margin-bottom: 50px;
    }
    .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-control {
        border-radius: 8px;
        padding: 12px;
        border: 1px solid #ddd;
    }
    .form-control:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }
    .alert {
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 25px;
    }
    .btn-submit {
        background: #2563eb;
        color: white;
        padding: 12px 30px;
        border-radius: 8px;
        border: none;
        font-weight: 600;
        transition: all 0.3s;
    }
    .btn-submit:hover {
        background: #1e40af;
        transform: translateY(-2px);
    }
    .upload-hint {
        font-size: 0.85rem;
        color: #666;
        margin-top: 4px;
    }
</style>
@endpush

@section('content')
<!-- ***** Spacer for Header ***** -->
<div style="height: 100px; background: #f7f7f7;"></div>

<section class="section" id="permohonan-psu" style="background: #f7f7f7; padding-top: 30px; min-height: 80vh;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading text-center" style="margin-bottom: 40px;">
                    <h2>Permohonan Serah Terima PSU</h2>
                    <p style="margin-top: 15px; font-size: 15px; color: #666; max-width: 800px; margin-left: auto; margin-right: auto;">
                        Silakan lengkapi formulir di bawah ini untuk mengajukan permohonan serah terima Prasarana, Sarana, dan Utilitas (PSU). 
                        Pastikan semua dokumen diunggah dalam format yang benar.
                    </p>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="form-section">
                    @if(session('success'))
                        <div class="alert alert-success" style="background-color: #ecfdf3; color: #027a48; border: 1px solid #a6f4c5;">
                            <i class="fas fa-check-circle"></i> {!! session('success') !!}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger" style="background-color: #fef3f2; color: #b42318; border: 1px solid #fecdca;">
                            <i class="fas fa-exclamation-circle"></i> <strong>Peringatan!</strong> Mohon periksa kembali form Anda:
                            <ul style="margin-top: 10px;">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ url('/permohonan-psu') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <h5 style="margin-bottom: 20px; color: #2563eb; border-bottom: 2px solid #eef2ff; padding-bottom: 10px;">
                            <i class="fas fa-user-edit"></i> Data Pemohon & Lokasi
                        </h5>
                        
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="form-label" for="nama_pemohon">Nama Pemohon <span style="color: red">*</span></label>
                                <input type="text" id="nama_pemohon" name="nama_pemohon" class="form-control" value="{{ old('nama_pemohon') }}" placeholder="Masukkan nama lengkap" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form-label">Jenis Permohonan</label>
                                <input type="text" class="form-control" value="Serah Terima PSU" disabled style="background-color: #f8fafc;">
                            </div>
                            <div class="col-12 form-group">
                                <label class="form-label" for="lokasi_pembangunan">Lokasi Pembangunan (Alamat Lengkap) <span style="color: red">*</span></label>
                                <textarea id="lokasi_pembangunan" name="lokasi_pembangunan" class="form-control" rows="3" placeholder="Contoh: Perumahan Indah, Jl. Melati No. 1, Kel. Timur, Kec. Barat" required>{{ old('lokasi_pembangunan') }}</textarea>
                            </div>
                        </div>

                        <h5 style="margin-bottom: 20px; margin-top: 20px; color: #2563eb; border-bottom: 2px solid #eef2ff; padding-bottom: 10px;">
                            <i class="fas fa-file-upload"></i> Unggah Dokumen Teknis
                        </h5>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="form-label">FC KTP <span style="color: red">*</span></label>
                                <input type="file" name="fc_ktp" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                                <div class="upload-hint">Format: PDF, JPG, PNG (Maks 5MB)</div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form-label">FC Akta Pendirian <span style="color: red">*</span></label>
                                <input type="file" name="fc_akta_pendirian" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                                <div class="upload-hint">Termasuk Akta Perubahan (Maks 5MB)</div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form-label">FC Sertifikat Tanah <span style="color: red">*</span></label>
                                <input type="file" name="fc_sertifikat_tanah" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                                <div class="upload-hint">Atas nama pengembang untuk PSU (Maks 5MB)</div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form-label">Siteplan <span style="color: red">*</span></label>
                                <input type="file" name="siteplan" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                                <div class="upload-hint">Menjelaskan lokasi, jenis, dan ukuran (Maks 5MB)</div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form-label">Daftar PSU & Nilai Perolehan <span style="color: red">*</span></label>
                                <input type="file" name="daftar_psu_nilai" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                                <div class="upload-hint">Format PDF/Gambar (Maks 5MB)</div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form-label">FC IMB / PBG Perumahan <span style="color: red">*</span></label>
                                <input type="file" name="fc_imb_pbg" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                                <div class="upload-hint">Izin Mendirikan Bangunan (Maks 5MB)</div>
                            </div>
                        </div>

                        <div class="text-center" style="margin-top: 30px;">
                            <button type="submit" class="btn-submit">
                                <i class="fas fa-paper-plane"></i> Kirim Permohonan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

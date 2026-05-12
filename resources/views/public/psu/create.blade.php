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
    body { padding-top: 80px; background: #f4f7fb; }
</style>
<link rel="stylesheet" href="{{ asset('css/public.css') }}?v=4">
@endpush

@section('content')
<section class="section layout_padding" id="permohonan-psu" style="background: #f7f7f7; min-height: 80vh;">
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
                
                <!-- TEMPLATE DOWNLOAD SECTION -->
                @if(isset($templates) && $templates->count() > 0)
                <div style="background: white; border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); padding: 30px; margin-bottom: 30px; border-left: 4px solid #2563eb;">
                    <h5 style="margin-bottom: 15px; color: #1e3c72; font-weight: 700;">
                        <i class="fas fa-file-download" style="margin-right: 8px;"></i> Template Data Teknis (Unduh Dahulu)
                    </h5>
                    <p style="font-size: 0.9rem; color: #555; margin-bottom: 20px;">
                        Silakan unduh template di bawah, isi sesuai data perumahan Anda, lalu unggah kembali pada form di bawah.
                    </p>
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 15px;">
                        @foreach($templates as $template)
                            @php
                                $ext = pathinfo($template->file_path, PATHINFO_EXTENSION);
                                $icon = 'fa-file';
                                $color = '#6b7280';
                                
                                if (in_array($ext, ['pdf'])) {
                                    $icon = 'fa-file-pdf';
                                    $color = '#ef4444';
                                } elseif (in_array($ext, ['doc', 'docx'])) {
                                    $icon = 'fa-file-word';
                                    $color = '#2563eb';
                                } elseif (in_array($ext, ['xls', 'xlsx'])) {
                                    $icon = 'fa-file-excel';
                                    $color = '#10b981';
                                } elseif (in_array($ext, ['zip', 'rar'])) {
                                    $icon = 'fa-file-archive';
                                    $color = '#f59e0b';
                                }
                            @endphp
                            <a href="{{ asset('storage/' . $template->file_path) }}" target="_blank" style="display: flex; align-items: center; padding: 12px 15px; border: 1px solid #e1e5eb; border-radius: 8px; text-decoration: none; color: #333; transition: all 0.2s;">
                                <i class="fas {{ $icon }}" style="font-size: 24px; color: {{ $color }}; margin-right: 15px;"></i>
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; font-size: 0.9rem; margin-bottom: 4px;">{{ $template->title }}</div>
                                    <div style="font-size: 0.75rem; color: #6b7280;">{{ $template->description ?? 'Format Template' }}</div>
                                </div>
                                <i class="fas fa-download" style="color: #6b7280;"></i>
                            </a>
                        @endforeach
                    </div>
                </div>
                @endif

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
                            <i class="fas fa-file-pdf"></i> Unggah Dokumen Administrasi / Pendukung
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
                            <div class="form-group mb-0">
                                <label class="form-label">Unggah Template yang sudah Anda isi <span style="color: red">*</span></label>
                                <input type="file" name="file_template_diisi" class="form-control" accept=".pdf,.doc,.docx,.xls,.xlsx,.zip" required>
                                <div class="upload-hint">Format Document/Excel/Zip (Maks 10MB)</div>
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

@push('scripts')
<script>
// REC-03: File Preview Feedback untuk setiap field upload
(function() {
    const fileFields = [
        'fc_ktp', 'fc_akta_pendirian', 'fc_sertifikat_tanah',
        'siteplan', 'daftar_psu_nilai', 'fc_imb_pbg', 'file_template_diisi'
    ];

    const maxSizes = {
        'file_template_diisi': 10, // 10MB
    };

    fileFields.forEach(function(fieldName) {
        const input = document.querySelector('input[name="' + fieldName + '"]');
        if (!input) return;

        // Create preview element
        const preview = document.createElement('div');
        preview.id = 'preview-' + fieldName;
        preview.style.cssText = 'margin-top:6px;padding:8px 12px;border-radius:6px;font-size:12px;display:none;';
        input.parentNode.insertBefore(preview, input.nextSibling.nextSibling);

        input.addEventListener('change', function() {
            if (!this.files || !this.files[0]) {
                preview.style.display = 'none';
                return;
            }

            const file = this.files[0];
            const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
            const maxMB = maxSizes[fieldName] || 5;
            const isTooBig = parseFloat(sizeMB) > maxMB;

            if (isTooBig) {
                preview.style.background = '#fef2f2';
                preview.style.border = '1px solid #fecaca';
                preview.style.color = '#dc2626';
                preview.innerHTML = '⚠️ <strong>' + file.name + '</strong> (' + sizeMB + ' MB) — Melebihi batas ' + maxMB + 'MB!';
            } else {
                preview.style.background = '#f0fdf4';
                preview.style.border = '1px solid #bbf7d0';
                preview.style.color = '#16a34a';
                preview.innerHTML = '✅ <strong>' + file.name + '</strong> (' + sizeMB + ' MB) — Siap diunggah';
            }
            preview.style.display = 'block';
        });
    });
})();
</script>
@endpush

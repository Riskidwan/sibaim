@extends('admin.layouts.app')
@section('title', 'Edit Laporan Tahunan')

@section('content')
<div class="modal" style="width: 100%; max-width: 800px; margin: 0 auto; box-shadow: none;">
    <div class="modal-body" style="padding: 0;">
        @if ($errors->any())
            <div style="padding: 1rem; margin-bottom: 1rem; background-color: #fef3f2; color: #b42318; border-radius: 8px; border: 1px solid #fecdca;">
                <i class="fas fa-exclamation-circle" style="margin-right: 8px;"></i>
                Terdapat Kesalahan:
                <ul style="margin-top: 5px; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.reports.update', $report->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-grid">
                <div class="form-group full-width">
                    <label for="year">Tahun Laporan <span style="color: #ef4444">*</span></label>
                    <input type="number" id="year" name="year" class="form-input @error('year') error @enderror" value="{{ old('year', $report->year) }}" required autofocus />
                </div>

                <div class="form-group full-width">
                    <label for="title">Judul Dokumen (Opsional)</label>
                    <input type="text" id="title" name="title" class="form-input @error('title') error @enderror" value="{{ old('title', $report->title) }}" placeholder="Contoh: Dokumen Kondisi Jalan Kab. Pemalang 2024" />
                </div>

                <div class="form-group full-width" style="margin-top: 15px;">
                    <label>Dokumen PDF Saat Ini:</label>
                    <div style="margin-bottom: 15px; padding: 10px; border: 1px solid #e2e8f0; border-radius: 6px; background: #f8fafc;">
                        <a href="{{ asset('storage/' . $report->file_path) }}" target="_blank" style="text-decoration: none; color: #0284c7; font-weight: 500;">
                            <i class="fas fa-file-pdf" style="color: #ef4444; margin-right: 5px;"></i> Buka File PDF Asli
                        </a>
                    </div>

                    <label for="pdf_file">Ganti File Laporan PDF (Kosongkan jika tidak ingin diubah)</label>
                    <input type="file" id="pdf_file" name="pdf_file" class="form-input" accept=".pdf" style="padding: 10px;" />
                    <div class="form-hint" style="margin-top: 4px; color: #b42318;"><i class="fas fa-info-circle"></i> Maksimal ukuran dokumen adalah 10 MB.</div>
                </div>
            </div>
            
            <div style="margin-top:20px; text-align:right;">
                <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary" style="margin-left: 10px;"><i class="fas fa-save"></i> Perbarui Laporan</button>
            </div>
        </form>
    </div>
</div>
@endsection

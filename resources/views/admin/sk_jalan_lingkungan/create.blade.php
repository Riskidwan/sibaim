@extends('admin.layouts.app')
@section('title', 'Upload SK Jalan Lingkungan')

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

        <form action="{{ route('admin.sk-jalan-lingkungan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-grid">
                <div class="form-group full-width">
                    <label for="year">Tahun SK <span style="color: #ef4444">*</span></label>
                    <input type="number" id="year" name="year" class="form-input @error('year') error @enderror" value="{{ old('year', date('Y')) }}" required autofocus />
                </div>

                <div class="form-group full-width">
                    <label for="title">Judul SK <span style="color: #ef4444">*</span></label>
                    <input type="text" id="title" name="title" class="form-input @error('title') error @enderror" value="{{ old('title') }}" placeholder="Contoh: SK Jalan Lingkungan Kabupaten Pemalang Tahun 2024" required />
                </div>

                <div class="form-group full-width">
                    <label for="pdf_file">Pilih File SK (Format PDF) <span style="color: #ef4444">*</span></label>
                    <input type="file" id="pdf_file" name="pdf_file" class="form-input" accept=".pdf" required style="padding: 10px;" />
                    <div class="form-hint" style="margin-top: 4px; color: #b42318;"><i class="fas fa-info-circle"></i> Maksimal ukuran dokumen adalah 10 MB.</div>
                </div>
            </div>
            
            <div style="margin-top:20px; text-align:right;">
                <a href="{{ route('admin.sk-jalan-lingkungan.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary" style="margin-left: 10px;"><i class="fas fa-cloud-upload-alt"></i> Simpan SK</button>
            </div>
        </form>
    </div>
</div>
@endsection

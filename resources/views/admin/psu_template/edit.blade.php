@extends('admin.layouts.app')
@section('title', 'Edit Template')

@section('content')
<div class="road-header" style="margin-bottom: 20px;">
    <h2 style="font-size: 1.5rem; margin: 0; color: #333;">Edit Template Data Teknis</h2>
</div>

<div class="card" style="background: white; border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); max-width: 600px;">
    @if ($errors->any())
        <div class="alert alert-danger" style="margin-bottom: 20px;">
            <ul style="margin: 0;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.psu-templates.update', $template->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div style="margin-bottom: 20px;">
            <label style="display: block; font-weight: 500; margin-bottom: 8px;">Judul Template</label>
            <input type="text" name="title" class="form-input" value="{{ old('title', $template->title) }}" required style="width: 100%;">
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-weight: 500; margin-bottom: 8px;">Deskripsi (Opsional)</label>
            <textarea name="description" class="form-input" style="width: 100%; min-height: 100px;">{{ old('description', $template->description) }}</textarea>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-weight: 500; margin-bottom: 8px;">Ubah File (Biarkan kosong jika tidak ingin diganti)</label>
            <div style="margin-bottom: 8px; font-size: 0.85rem; color: #027a48;">
                <i class="fas fa-file"></i> File saat ini: {{ basename($template->file_path) }}
            </div>
            <input type="file" name="file" class="form-input" style="width: 100%;">
            <p style="font-size: 0.8rem; color: #64748b; margin-top: 4px;">Max 10MB (PDF/DOC/XLS/ZIP)</p>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 30px;">
            <a href="{{ route('admin.psu-templates.index') }}" class="btn btn-secondary" style="flex: 1; text-align: center; text-decoration: none;">Batal</a>
            <button type="submit" class="btn btn-primary" style="flex: 2;">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection

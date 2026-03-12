@extends('public.layouts.app')
@section('title', 'Template Data Teknis')

@push('styles')
<style>
    .template-card {
        background: #fff;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        height: 100%;
        display: flex;
        flex-direction: column;
        transition: transform 0.3s;
    }
    .template-card:hover {
        transform: translateY(-5px);
    }
    .file-icon {
        font-size: 3rem;
        color: #2563eb;
        margin-bottom: 20px;
    }
    .btn-download {
        margin-top: auto;
        background: #2563eb;
        color: white;
        text-align: center;
        padding: 10px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 600;
        transition: background 0.3s;
    }
    .btn-download:hover {
        background: #1e40af;
        color: white;
    }
</style>
@endpush

@section('content')
<!-- ***** Spacer for Header ***** -->
<div style="height: 100px; background: #f7f7f7;"></div>

<section class="section" id="templates" style="background: #f7f7f7; padding-top: 30px; min-height: 80vh;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading text-center">
                    <h2>Template Data Teknis</h2>
                    <p style="margin-top: 15px; font-size: 15px; color: #666; max-width: 800px; margin-left: auto; margin-right: auto;">
                        Unduh format dokumen teknis di bawah ini untuk membantu Anda melengkapi persyaratan administrasi permohonan serah terima PSU.
                    </p>
                </div>
            </div>
        </div>

        <div class="row" style="margin-top: 40px;">
            @forelse($templates as $tpl)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="template-card">
                        <div class="file-icon text-center">
                            @php
                                $ext = pathinfo($tpl->file_path, PATHINFO_EXTENSION);
                                $icon = 'fa-file-alt';
                                if($ext == 'pdf') $icon = 'fa-file-pdf';
                                if(in_array($ext, ['doc', 'docx'])) $icon = 'fa-file-word';
                                if(in_array($ext, ['xls', 'xlsx'])) $icon = 'fa-file-excel';
                                if($ext == 'zip') $icon = 'fa-file-archive';
                            @endphp
                            <i class="fas {{ $icon }}"></i>
                        </div>
                        <h4 style="font-size: 1.25rem; color: #1e3a8a; margin-bottom: 15px; text-align: center;">{{ $tpl->title }}</h4>
                        <p style="color: #666; font-size: 0.9rem; margin-bottom: 25px; text-align: center;">
                            {{ $tpl->description ?: 'Format dokumen teknis untuk kelengkapan permohonan.' }}
                        </p>
                        <a href="{{ asset('storage/' . $tpl->file_path) }}" class="btn-download" download>
                            <i class="fas fa-download"></i> Unduh File
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center" style="padding: 100px 0;">
                    <i class="fas fa-search" style="font-size: 3rem; color: #ccc;"></i>
                    <p style="margin-top: 20px; color: #888;">Maaf, belum ada template yang tersedia saat ini.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection

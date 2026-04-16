@extends('public.layouts.app')
@section('title', $title)

@push('styles')
<!-- GLightbox CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />

<style>
    body { padding-top: 80px; background: #fff; }
    
    .page-header {
        background: #f8fafc;
        padding: 60px 30px;
        margin-bottom: 50px;
        text-align: center;
        border-radius: 0 0 50px 50px;
    }
    
    .category-filter {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-bottom: 60px;
        flex-wrap: wrap;
    }
    .filter-link {
        padding: 10px 25px;
        border-radius: 12px;
        background: #f1f5f9;
        color: #475569;
        text-decoration: none;
        font-weight: 700;
        transition: all 0.3s ease;
    }
    .filter-link.active {
        background: #0f172a;
        color: white;
    }
    
    .kegiatan-section {
        margin-bottom: 80px;
    }
    .kegiatan-title {
        font-weight: 900;
        text-align: center;
        font-size: 2.2rem;
        color: #0f172a;
        margin-bottom: 10px;
    }
    .kegiatan-meta {
        text-align: center;
        color: #64748b;
        margin-bottom: 30px;
        font-weight: 600;
    }

    /* Grid Styling */
    .photo-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    .photo-card {
        border-radius: 16px;
        overflow: hidden;
        height: 250px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        transition: all 0.4s ease;
        background: #eee;
    }
    .photo-card:hover {
        transform: scale(1.02) translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }
    .photo-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .kegiatan-desc {
        text-align: center;
        max-width: 800px;
        margin: 0 auto;
        font-size: 1.1rem;
        color: #475569;
        line-height: 1.8;
    }
    
    @media (max-width: 768px) {
        .kegiatan-title { font-size: 1.6rem; }
        .photo-grid { grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 10px; }
        .photo-card { height: 150px; }
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-lg-5" style="min-height: 80vh; margin-top: 40px; margin-bottom: 100px;">
    
    <div class="page-header">
        <h1 style="font-weight: 900; color: #0f172a; font-size: 3rem;">{{ $title }}</h1>
        <p class="mt-3 text-muted fs-5">Opsi 2: Tampilan Grid Modern & Lightbox</p>
    </div>

    <!-- FILTER -->
    <div class="category-filter">
        <a href="{{ route('public.galeri') }}" class="filter-link {{ !$category ? 'active' : '' }}">Semua</a>
        <a href="{{ route('public.galeri', 'berita') }}" class="filter-link {{ $category == 'berita' ? 'active' : '' }}">Berita</a>
        <a href="{{ route('public.galeri', 'kunjungan') }}" class="filter-link {{ $category == 'kunjungan' ? 'active' : '' }}">Kunjungan</a>
        <a href="{{ route('public.galeri', 'rapat') }}" class="filter-link {{ $category == 'rapat' ? 'active' : '' }}">Rapat</a>
        <a href="{{ route('public.galeri', 'sosialisasi') }}" class="filter-link {{ $category == 'sosialisasi' ? 'active' : '' }}">Sosialisasi</a>
    </div>

    <div class="container">
        @forelse($galleries as $kegiatan)
            <div class="kegiatan-section">
                <h2 class="kegiatan-title">{{ $kegiatan->judul }}</h2>
                <div class="kegiatan-meta">
                    <span class="text-uppercase tracking-wider">{{ $kegiatan->kategori }}</span> &bull; 
                    {{ $kegiatan->tanggal ? \Carbon\Carbon::parse($kegiatan->tanggal)->translatedFormat('d F Y') : $kegiatan->created_at->translatedFormat('d F Y') }}
                </div>

                <div class="photo-grid">
                    @foreach($kegiatan->images as $img)
                    <a href="{{ asset('storage/' . $img->file_path) }}" class="glightbox photo-card" data-gallery="gallery-{{ $kegiatan->id }}">
                        <img src="{{ asset('storage/' . $img->file_path) }}" alt="{{ $kegiatan->judul }}" loading="lazy">
                    </a>
                    @endforeach
                </div>

                @if($kegiatan->deskripsi)
                <div class="kegiatan-desc">
                    {{ $kegiatan->deskripsi }}
                </div>
                @endif
            </div>
            <hr class="my-5 opacity-25">
        @empty
            <div class="text-center py-5">
                <h4 class="text-muted">Belum ada data untuk kategori ini.</h4>
            </div>
        @endforelse
    </div>
</div>

@push('scripts')
<!-- GLightbox JS -->
<script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js"></script>
<script>
    const lightbox = GLightbox({
        selector: '.glightbox',
        touchNavigation: true,
        loop: true,
        autoplayVideos: true
    });
</script>
@endpush
@endsection

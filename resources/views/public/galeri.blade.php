@extends('public.layouts.app')
@section('title', $title)

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800;900&display=swap" rel="stylesheet">

<style>
    :root {
        --primary-color: #10b981;
        --dark-slate: #1e293b;
    }

    body { 
        padding-top: 100px; 
        background-color: #ffffff; 
        font-family: 'Outfit', sans-serif;
    }

    .kegiatan-card {
        padding: 50px 0;
        border-bottom: 1px solid #f1f5f9;
        position: relative;
    }

    .kegiatan-title {
        font-weight: 800;
        text-align: center;
        text-transform: uppercase;
        color: var(--dark-slate);
        margin-bottom: 30px;
    }

    .gallery-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        padding: 0 10px;
    }

    .horizontal-gallery {
        display: flex;
        overflow-x: auto;
        gap: 20px;
        padding: 15px 5px;
        scroll-behavior: smooth;
        scrollbar-width: none; 
        -webkit-overflow-scrolling: touch;
        width: 100%;
        /* Snap agar berhenti pas di tengah foto */
        scroll-snap-type: x mandatory; 
    }

    .horizontal-gallery::-webkit-scrollbar { display: none; }

    .gallery-item {
        flex: 0 0 calc(25% - 15px); /* Tampil 4 foto */
        scroll-snap-align: start;
        transition: transform 0.3s ease;
    }

    .img-wrapper img {
        width: 100%;
        height: auto;
        display: block;
        object-fit: contain;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.06);
        background: #fff;
    }

    /* Navigasi Panah */
    .nav-cursor {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 40px;
        height: 40px;
        background: white;
        color: var(--dark-slate);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 10;
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
        border: 1px solid #eee;
        transition: 0.3s;
        opacity: 0;
    }

    .gallery-wrapper:hover .nav-cursor { opacity: 1; }
    .nav-cursor:hover { background: var(--primary-color); color: white; }

    .cursor-left { left: -15px; }
    .cursor-right { right: -15px; }

    @media (max-width: 1024px) {
        .gallery-item { flex: 0 0 calc(50% - 10px); } 
        .nav-cursor { display: none; }
    }
    @media (max-width: 768px) {
        .gallery-item { flex: 0 0 calc(80% - 10px); }
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="text-center mb-5">
        <h1 style="font-weight: 900; font-size: 2.8rem; color: #1e293b;">{{ $title }}</h1>
        <div style="width: 40px; height: 4px; background: var(--primary-color); margin: 15px auto 30px;"></div>
        
        <!-- Category Filter -->
        <div style="display: flex; justify-content: center; gap: 10px; margin-bottom: 50px; flex-wrap: wrap;">
            <a href="{{ route('public.galeri') }}" style="padding: 10px 24px; border-radius: 50px; text-decoration: none; font-weight: 600; font-size: 0.9rem; transition: 0.3s; {{ !$category ? 'background: var(--primary-color); color: white;' : 'background: #f1f5f9; color: #475569;' }}">Semua</a>
            <a href="{{ route('public.galeri', 'berita') }}" style="padding: 10px 24px; border-radius: 50px; text-decoration: none; font-weight: 600; font-size: 0.9rem; transition: 0.3s; {{ $category == 'berita' ? 'background: var(--primary-color); color: white;' : 'background: #f1f5f9; color: #475569;' }}">Berita</a>
            <a href="{{ route('public.galeri', 'kunjungan') }}" style="padding: 10px 24px; border-radius: 50px; text-decoration: none; font-weight: 600; font-size: 0.9rem; transition: 0.3s; {{ $category == 'kunjungan' ? 'background: var(--primary-color); color: white;' : 'background: #f1f5f9; color: #475569;' }}">Kunjungan</a>
            <a href="{{ route('public.galeri', 'rapat') }}" style="padding: 10px 24px; border-radius: 50px; text-decoration: none; font-weight: 600; font-size: 0.9rem; transition: 0.3s; {{ $category == 'rapat' ? 'background: var(--primary-color); color: white;' : 'background: #f1f5f9; color: #475569;' }}">Rapat</a>
            <a href="{{ route('public.galeri', 'sosialisasi') }}" style="padding: 10px 24px; border-radius: 50px; text-decoration: none; font-weight: 600; font-size: 0.9rem; transition: 0.3s; {{ $category == 'sosialisasi' ? 'background: var(--primary-color); color: white;' : 'background: #f1f5f9; color: #475569;' }}">Sosialisasi</a>
        </div>
    </div>

    @forelse($galleries as $kegiatan)
        <div class="kegiatan-card">
            <div class="text-center mb-3">
                <h3 class="kegiatan-title" style="margin-bottom: 8px; font-weight: 900;">{{ $kegiatan->judul }}</h3>
                <div style="font-size: 0.95rem; color: #64748b; margin-bottom: 20px; display: flex; justify-content: center; align-items: center; gap: 10px;">
                    <span style="background: #ecfdf5; color: #059669; padding: 4px 12px; border-radius: 100px; font-size: 0.75rem; font-weight: 800; text-transform: uppercase;">
                        {{ $kegiatan->kategori }}
                    </span>
                    <span>&bull;</span>
                    <span><i class="far fa-calendar-alt me-1"></i> {{ $kegiatan->tanggal ? \Carbon\Carbon::parse($kegiatan->tanggal)->translatedFormat('d F Y') : $kegiatan->created_at->translatedFormat('d F Y') }}</span>
                </div>
                @if($kegiatan->deskripsi)
                <div style="max-width: 900px; margin: 0 auto; color: #334155; line-height: 1.7; font-size: 1.1rem; background: #f8fafc; padding: 20px 30px; border-radius: 15px; border: 1px solid #f1f5f9; font-weight: 500;">
                    {{ $kegiatan->deskripsi }}
                </div>
                @endif
            </div>

            <div class="gallery-wrapper" style="margin-top: 10px;" onmouseenter="stopAuto('{{ $kegiatan->id }}')" onmouseleave="startAuto('{{ $kegiatan->id }}')">
                <div class="nav-cursor cursor-left" onclick="slideOne('{{ $kegiatan->id }}', 'left')">
                    <i class="fas fa-chevron-left"></i>
                </div>

                <div class="horizontal-gallery" id="gallery-{{ $kegiatan->id }}">
                    @foreach($kegiatan->images as $img)
                    <div class="gallery-item">
                        <div class="img-wrapper">
                            <a href="{{ asset('storage/' . $img->file_path) }}" data-fancybox="gallery-{{ $kegiatan->id }}">
                                <img src="{{ asset('storage/' . $img->file_path) }}" alt="Gallery" loading="lazy">
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="nav-cursor cursor-right" onclick="slideOne('{{ $kegiatan->id }}', 'right')">
                    <i class="fas fa-chevron-right"></i>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-5" style="margin-top: 40px; margin-bottom: 80px;">
            <i class="far fa-images fa-4x mb-3" style="color: #cbd5e1;"></i>
            <h4 style="color: #475569; font-weight: 700;">Galeri Belum Tersedia</h4>
            <p style="color: #64748b; font-size: 1.1rem;">Belum ada dokumentasi kegiatan yang diunggah untuk saat ini.<br>Silakan kunjungi kembali nanti.</p>
        </div>
    @endforelse
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<script>
    Fancybox.bind("[data-fancybox]", { infinite: true });

    const intervals = {};

    function slideOne(id, direction) {
        const container = document.getElementById('gallery-' + id);
        const itemWidth = container.querySelector('.gallery-item').offsetWidth + 20; // Lebar foto + gap
        
        if (direction === 'left') {
            // Jika sudah di paling kiri, putar ke paling kanan
            if (container.scrollLeft <= 0) {
                container.scrollTo({ left: container.scrollWidth, behavior: 'smooth' });
            } else {
                container.scrollBy({ left: -itemWidth, behavior: 'smooth' });
            }
        } else {
            // Jika sudah di paling kanan, balik ke awal
            if (container.scrollLeft + container.offsetWidth >= container.scrollWidth - 10) {
                container.scrollTo({ left: 0, behavior: 'smooth' });
            } else {
                container.scrollBy({ left: itemWidth, behavior: 'smooth' });
            }
        }
    }

    // Fungsi Autoplay
    function startAuto(id) {
        intervals[id] = setInterval(() => {
            slideOne(id, 'right');
        }, 3000); // Berjalan setiap 3 detik
    }

    function stopAuto(id) {
        clearInterval(intervals[id]);
    }

    // Jalankan autoplay saat halaman dimuat
    document.addEventListener("DOMContentLoaded", function() {
        @foreach($galleries as $kegiatan)
            startAuto('{{ $kegiatan->id }}');
        @endforeach
    });
</script>
@endpush
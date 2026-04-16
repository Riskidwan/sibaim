@extends('public.layouts.app')

@section('content')

    <section class="hero" id="beranda">
      <div class="container text-center">
        <div class="row justify-content-center">
          <div class="col-lg-10">
            <!-- LOGO CENTER -->
            <div class="mb-4">
              <img src="{{ asset('img/logoKab.Pemalang.png') }}" width="140" class="img-fluid" alt="Logo Pemalang" />
            </div>

            <!-- TEKS CENTER -->
          <h1 class="hero-title fw-bold mb-3">
          Sistem Informasi Basis Data <br class="d-none d-md-block"> 
          <span>Kawasan Permukiman Pemalang</span>
        </h1>
            <p>
              SIBAIM adalah platform digital untuk pengelolaan basis data 
              kawasan permukiman secara transparan, mudah, dan terintegrasi di Kabupaten Pemalang.
            </p>

            <div class="d-flex flex-wrap justify-content-center gap-3 mt-4">
              <a href="/login" class="btn btn-outline-light btn-lg rounded-pill shadow-sm">
                Pendaftaran PSU
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- PROFIL -->
    <section class="section" id="profil">
      <div class="container">
        <h2 class="text-center mb-5">Profil SIBAIM</h2>

        <div class="row align-items-center">
          <div class="col-md-6">
            <p class="lead fw-medium text-dark mb-4">
              SIBAIM merupakan sistem informasi berbasis web yang digunakan
              untuk memfasilitasi pengelolaan data kawasan permukiman, prasarana,
              sarana, dan utilitas (PSU) perumahan secara digital.
            </p>

            <p class="lead text-muted">
              Sistem ini membantu pemerintah dalam proses monitoring,
              perencanaan serta pengambilan keputusan pembangunan infrastruktur
              yang lebih efektif dan terintegrasi di Kabupaten Pemalang.
            </p>
          </div>

          <div class="col-md-6 text-center">
            <img
              src="{{ asset('img/logoKab.Pemalang.png') }}"
              width="350"
              class="img-fluid"
              alt="Logo Pemalang"
            />
          </div>
        </div>
      </div>
    </section>

    <!-- DATA -->
   <section class="section py-5" id="data">
  <div class="container">
    <h2 class="text-center mb-5 fw-bold">Data Sistem</h2>

    <div class="row text-center justify-content-center g-4">
      
      <div class="col-lg-3 col-md-6">
        <div class="p-4 shadow-sm rounded bg-light border-top border-primary border-4 h-100">
          <h2 class="display-5 fw-bold text-primary">{{ $totalPsuSubmissions }}</h2>
          <p class="mb-0 text-muted text-uppercase fw-semibold small">Sudah Serah Terima</p>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="p-4 shadow-sm rounded bg-light border-top border-warning border-4 h-100">
          <h2 class="display-5 fw-bold text-warning">{{ $totalPsuNotYet }}</h2>
          <p class="mb-0 text-muted text-uppercase fw-semibold small">Belum Serah Terima</p>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="p-4 shadow-sm rounded bg-light border-top border-success border-4 h-100">
          <h2 class="display-5 fw-bold text-success">{{ $totalHousings }}</h2>
          <p class="mb-0 text-muted text-uppercase fw-semibold small">Total Perumahan</p>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="p-4 shadow-sm rounded bg-light border-top border-info border-4 h-100">
          <h2 class="display-5 fw-bold text-info">{{ $totalJalans }}</h2>
          <p class="mb-0 text-muted text-uppercase fw-semibold small">Total Data Jalan</p>
        </div>
      </div>

    </div>
  </div>
</section>

    <!-- GALERI -->
    <section class="section py-5" id="galeri" style="background-color: #f8f9fa;">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="fw-bold">Galeri <span class="text-warning-custom">Kegiatan</span></h2>
      <div class="header-line mx-auto"></div>
    </div>

    @if(isset($recentGalleries) && $recentGalleries->isNotEmpty())
    <div class="row g-4 gallery-wrapper">
      @foreach($recentGalleries->take(4) as $item) {{-- Paksa ambil 4 item saja --}}
      <div class="col-lg-3 col-md-6">
        <div class="card h-100 border-0 shadow-sm gallery-card">
          <div class="position-relative overflow-hidden rounded-top-4">
            <a href="{{ asset('storage/' . $item->file_path) }}" class="glightbox" data-gallery="gallery1">
              <img src="{{ asset('storage/' . $item->file_path) }}" 
                   class="card-img-top gallery-img" 
                   alt="{{ $item->judul }}">
              <div class="gallery-overlay d-flex align-items-center justify-content-center">
                 <i class="fas fa-search-plus fa-2x text-white"></i>
              </div>
            </a>
          </div>
          
          <div class="card-body bg-white text-center p-3">
            <h6 class="fw-bold text-dark mb-2 text-limit">
              {{ Str::limit($item->kegiatan->judul, 40) }}
            </h6>
            <div class="text-muted small">
              <i class="far fa-calendar-alt me-1"></i> 
              {{ $item->created_at->translatedFormat('d F Y') }}
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>

    <div class="text-center mt-5">
      <a href="/galeri" class="btn btn-yellow btn-lg rounded-pill px-5 shadow-sm">
        Lihat Semua Galeri <i class="fas fa-arrow-right ms-2"></i>
      </a>
    </div>
    @else
    <div class="text-center py-5 bg-white rounded-4 shadow-sm border">
      <i class="fas fa-images fa-3x text-light-gray mb-3"></i>
      <p class="text-muted">Belum ada dokumentasi galeri terbaru.</p>
    </div>
    @endif
  </div>
</section>

    <!-- FAQ / Q&A -->
    <section class="section py-5" id="faq">
      <div class="container">
        <div class="text-center mb-5">
          <h2 class="fw-bold">Pertanyaan <span class="text-warning-custom">Umum (FAQ)</span></h2>
          <div class="header-line mx-auto"></div>
          <p class="text-muted mt-3">Temukan jawaban atas pertanyaan yang sering diajukan seputar SIBAIM dan proses permohonan PSU.</p>
        </div>

        <div class="row justify-content-center">
          <div class="col-lg-9">
            <div class="accordion" id="faqAccordion">

              <!-- FAQ 1 -->
              <div class="accordion-item border-0 mb-3 rounded-3 shadow-sm overflow-hidden">
                <h2 class="accordion-header" id="faqHead1">
                  <button class="accordion-button fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faqBody1" aria-expanded="true" aria-controls="faqBody1">
                    <i class="fas fa-question-circle text-warning me-2"></i> Apa itu SIBAIM?
                  </button>
                </h2>
                <div id="faqBody1" class="accordion-collapse collapse show" aria-labelledby="faqHead1" data-bs-parent="#faqAccordion">
                  <div class="accordion-body text-muted">
                    SIBAIM (Sistem Informasi Basis Data Kawasan Permukiman) adalah platform digital yang dikelola oleh Pemerintah Kabupaten Pemalang untuk mengelola data kawasan permukiman, prasarana, sarana, dan utilitas (PSU) secara transparan dan terintegrasi.
                  </div>
                </div>
              </div>

              <!-- FAQ 2 -->
              <div class="accordion-item border-0 mb-3 rounded-3 shadow-sm overflow-hidden">
                <h2 class="accordion-header" id="faqHead2">
                  <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faqBody2" aria-expanded="false" aria-controls="faqBody2">
                    <i class="fas fa-question-circle text-warning me-2"></i> Bagaimana cara mengajukan permohonan serah terima PSU?
                  </button>
                </h2>
                <div id="faqBody2" class="accordion-collapse collapse" aria-labelledby="faqHead2" data-bs-parent="#faqAccordion">
                  <div class="accordion-body text-muted">
                    <ol class="mb-0">
                      <li>Klik tombol <strong>"Pendaftaran PSU"</strong> di halaman utama atau menu navigasi.</li>
                      <li>Login atau daftar akun terlebih dahulu menggunakan email aktif.</li>
                      <li>Isi formulir permohonan dan unggah dokumen persyaratan yang diminta.</li>
                      <li>Kirim permohonan dan tunggu proses verifikasi oleh tim administrasi.</li>
                    </ol>
                  </div>
                </div>
              </div>

              <!-- FAQ 3 -->
              <div class="accordion-item border-0 mb-3 rounded-3 shadow-sm overflow-hidden">
                <h2 class="accordion-header" id="faqHead3">
                  <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faqBody3" aria-expanded="false" aria-controls="faqBody3">
                    <i class="fas fa-question-circle text-warning me-2"></i> Apa itu PSU dalam konteks perumahan?
                  </button>
                </h2>
                <div id="faqBody3" class="accordion-collapse collapse" aria-labelledby="faqHead3" data-bs-parent="#faqAccordion">
                  <div class="accordion-body text-muted">
                    PSU adalah singkatan dari <strong>Prasarana, Sarana, dan Utilitas</strong> yang merupakan fasilitas pendukung di kawasan perumahan. Contohnya meliputi:
                    <ul class="mt-2 mb-0">
                      <li><strong>Prasarana</strong> — Jalan, drainase, dan jaringan air bersih</li>
                      <li><strong>Sarana</strong> — Taman, tempat ibadah, dan fasilitas umum lainnya</li>
                      <li><strong>Utilitas</strong> — Jaringan listrik, penerangan jalan, dan pengelolaan limbah</li>
                    </ul>
                    <p class="mt-2 mb-0">Pengembang perumahan wajib menyerahkan PSU kepada pemerintah daerah setelah pembangunan selesai.</p>
                  </div>
                </div>
              </div>

              <!-- FAQ 4 -->
              <div class="accordion-item border-0 mb-3 rounded-3 shadow-sm overflow-hidden">
                <h2 class="accordion-header" id="faqHead4">
                  <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faqBody4" aria-expanded="false" aria-controls="faqBody4">
                    <i class="fas fa-question-circle text-warning me-2"></i> Berapa lama proses verifikasi permohonan?
                  </button>
                </h2>
                <div id="faqBody4" class="accordion-collapse collapse" aria-labelledby="faqHead4" data-bs-parent="#faqAccordion">
                  <div class="accordion-body text-muted">
                    Proses verifikasi dokumen biasanya memerlukan waktu <strong>7–14 hari kerja</strong> sejak permohonan diterima. Anda akan mendapatkan notifikasi melalui email dan dashboard ketika status permohonan berubah.
                  </div>
                </div>
              </div>

              <!-- FAQ 5 -->
              <div class="accordion-item border-0 mb-3 rounded-3 shadow-sm overflow-hidden">
                <h2 class="accordion-header" id="faqHead5">
                  <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faqBody5" aria-expanded="false" aria-controls="faqBody5">
                    <i class="fas fa-question-circle text-warning me-2"></i> Bagaimana cara memantau status permohonan saya?
                  </button>
                </h2>
                <div id="faqBody5" class="accordion-collapse collapse" aria-labelledby="faqHead5" data-bs-parent="#faqAccordion">
                  <div class="accordion-body text-muted">
                    Setelah login, Anda dapat memantau status permohonan melalui <strong>Dashboard Pengguna</strong>. Di sana akan terlihat status terkini seperti:
                    <ul class="mt-2 mb-0">
                      <li><strong>Verifikasi Dokumen</strong> — Permohonan sedang ditinjau</li>
                      <li><strong>Perbaikan Dokumen</strong> — Ada dokumen yang perlu diperbaiki</li>
                      <li><strong>Penugasan Tim Verifikasi</strong> — Tim sedang melakukan verifikasi lapangan</li>
                      <li><strong>BA Terima Terbit</strong> — Berita Acara serah terima telah diterbitkan</li>
                    </ul>
                  </div>
                </div>
              </div>


            </div>
          </div>
        </div>
      </div>
    </section>

@endsection

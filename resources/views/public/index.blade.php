@extends('public.layouts.app')

@section('content')

  <!-- ***** Main Banner Area Start ***** -->
  <div class="main-banner header-text" id="top">
    <div class="Modern-Slider">
      <!-- Item -->
      <div class="item">
        <div class="img-fill">
          <img src="{{ asset('Template_Halaman/templatemo_543_breezed/assets/images/slide-01.jpg') }}" alt="">
          <div class="text-content">
            <h3>Sistem Informasi Jalan</h3>
            <h5>Kabupaten Pemalang - Berbasis GIS</h5>
            <a href="/peta" class="main-stroked-button">Lihat Peta</a>
            <a href="#contact-us" class="main-filled-button scroll-to-section">Hubungi Kami</a>
          </div>
        </div>
      </div>
      <!-- Item -->
      <div class="item">
        <div class="img-fill">
          <img src="{{ asset('Template_Halaman/templatemo_543_breezed/assets/images/slide-02.jpg') }}" alt="">
          <div class="text-content">
            <h3>Monitoring Kondisi Jalan</h3>
            <h5>Pantau Kondisi Ruas Jalan Secara Real-Time</h5>
            <a href="#statistik" class="main-stroked-button scroll-to-section">Lihat Statistik</a>
            <a href="/admin/dashboard" class="main-filled-button">Login Admin</a>
          </div>
        </div>
      </div>
      <!-- Item -->
      <div class="item">
        <div class="img-fill">
          <img src="{{ asset('Template_Halaman/templatemo_543_breezed/assets/images/slide-03.jpg') }}" alt="">
          <div class="text-content">
            <h3>Peta Interaktif GIS</h3>
            <h5>Visualisasi Data Jalan di Peta Digital</h5>
            <a href="/peta" class="main-stroked-button">Lihat Peta</a>
            <a href="#statistik" class="main-filled-button scroll-to-section">Statistik</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="scroll-down scroll-to-section"><a href="#statistik"><i class="fa fa-arrow-down"></i></a></div>
  <!-- ***** Main Banner Area End ***** -->

  <!-- ***** About Section Start ***** -->
  <section class="section" id="about" style="padding-top: 100px; padding-bottom: 20px;">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 col-md-6 col-xs-12">
          <div class="left-text-content">
            <div class="section-heading">
              <h6>Tentang Aplikasi</h6>
              <h2>Sistem Informasi Geografis (SIG) Jalan Kabupaten Pemalang</h2>
            </div>
            <p style="margin-bottom: 20px; line-height: 1.8; color: #666;">
              Selamat datang di portal Sistem Informasi Geografis (SIG) Jalan Kabupaten Pemalang. Aplikasi berbasis web
              ini dikembangkan untuk mempermudah masyarakat dan instansi pemerintah dalam mengakses informasi terkait
              infrastruktur jalan secara interaktif dan transparan.
            </p>
            <p style="line-height: 1.8; color: #666;">
              Melalui peta digital yang disediakan, Anda dapat memantau secara langsung persebaran data ruas jalan,
              melihat rincian kondisi jalan (baik, sedang, rusak), serta mengetahui data teknis seperti panjang, lebar,
              dan jenis perkerasan jalan di berbagai kecamatan.
            </p>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-xs-12">
          <div class="right-text-content" style="text-align: center; padding: 20px;">
            <img src="{{ asset('Template_Halaman/templatemo_543_breezed/assets/images/about-icon-01.png') }}" alt="About Image"
              style="max-width: 100%; border-radius: 10px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- ***** About Section End ***** -->

  <!-- ***** Statistik Section Start ***** -->
  <section class="section" id="statistik">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="section-heading">
            <h6>Data Ringkasan</h6>
            <h2>Statistik Kondisi Jalan</h2>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-6">
          <div class="stat-card-gis total">
            <div class="stat-icon"><i class="fas fa-road"></i></div>
            <div class="stat-value" id="pub-stat-total">0</div>
            <div class="stat-label">Total Ruas Jalan</div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6">
          <div class="stat-card-gis panjang">
            <div class="stat-icon"><i class="fas fa-ruler-horizontal"></i></div>
            <div class="stat-value" id="pub-stat-panjang">0 km</div>
            <div class="stat-label">Total Panjang Jalan</div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6">
          <div class="stat-card-gis baik">
            <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
            <div class="stat-value" id="pub-stat-baik">0</div>
            <div class="stat-label">Kondisi Baik</div>
            <div class="stat-sub" id="pub-stat-baik-km">0 km</div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6">
          <div class="stat-card-gis sedang">
            <div class="stat-icon"><i class="fas fa-exclamation-triangle"></i></div>
            <div class="stat-value" id="pub-stat-sedang">0</div>
            <div class="stat-label">Kondisi Sedang</div>
            <div class="stat-sub" id="pub-stat-sedang-km">0 km</div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6">
          <div class="stat-card-gis rusak-ringan">
            <div class="stat-icon"><i class="fas fa-exclamation-circle"></i></div>
            <div class="stat-value" id="pub-stat-rusak-ringan">0</div>
            <div class="stat-label">Rusak Ringan</div>
            <div class="stat-sub" id="pub-stat-rusak-ringan-km">0 km</div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6">
          <div class="stat-card-gis rusak-berat">
            <div class="stat-icon"><i class="fas fa-times-circle"></i></div>
            <div class="stat-value" id="pub-stat-rusak-berat">0</div>
            <div class="stat-label">Rusak Berat</div>
            <div class="stat-sub" id="pub-stat-rusak-berat-km">0 km</div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- ***** Statistik Section End ***** -->

  <!-- ***** Features / Fitur Sistem Start ***** -->
  <section class="section" id="features">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12"
          data-scroll-reveal="enter left move 30px over 0.6s after 0.4s">
          <div class="features-item">
            <div class="features-icon">
              <img src="{{ asset('Template_Halaman/templatemo_543_breezed/assets/images/features-icon-1.png') }}" alt="">
            </div>
            <div class="features-content">
              <h4>Peta Interaktif</h4>
              <p>Visualisasi sebaran ruas jalan di peta digital. Klik jalan untuk melihat detail informasi teknis.</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12"
          data-scroll-reveal="enter bottom move 30px over 0.6s after 0.4s">
          <div class="features-item">
            <div class="features-icon">
              <img src="{{ asset('Template_Halaman/templatemo_543_breezed/assets/images/features-icon-1.png') }}" alt="">
            </div>
            <div class="features-content">
              <h4>Data Real-Time</h4>
              <p>Informasi kondisi jalan diperbarui secara berkala. Panjang, lebar, jenis perkerasan, dan kondisi terkini.</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12"
          data-scroll-reveal="enter right move 30px over 0.6s after 0.4s">
          <div class="features-item">
            <div class="features-icon">
              <img src="{{ asset('Template_Halaman/templatemo_543_breezed/assets/images/features-icon-1.png') }}" alt="">
            </div>
            <div class="features-content">
              <h4>Filter &amp; Pencarian</h4>
              <p>Filter berdasarkan kondisi jalan dan kecamatan. Cari nama jalan dengan cepat dan mudah.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- ***** Features End ***** -->

  <!-- ***** Download Section Starts ***** -->
  <section class="section" id="download" style="background: #fff; padding-top: 80px; padding-bottom: 80px;">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="section-heading text-center" style="margin-bottom: 50px;">
            <h6>Pusat Unduhan</h6>
            <h2>Dokumen &amp; Referensi</h2>
          </div>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-12">
          <div class="download-card" style="background: #fdfdfd; border: 1px solid #eaeaea; border-radius: 12px; padding: 40px 30px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.03); transition: transform 0.3s ease;">
            <div class="icon" style="margin-bottom: 25px;">
              <i class="fas fa-file-pdf" style="font-size: 50px; color: #e95420;"></i>
            </div>
            <h4 style="font-size: 1.25rem; font-weight: 700; color: #333; margin-bottom: 15px;">SK Jalan Lingkungan</h4>
            <p style="color: #666; font-size: 0.95rem; margin-bottom: 25px; line-height: 1.6;">
              Unduh dokumen resmi Surat Keputusan (SK) terkait penetapan status dan ruas jalan lingkungan di wilayah Kabupaten Pemalang.
            </p>
            <a href="javascript:;" onclick="alert('File dokumen SK sedang dipersiapkan.')" class="main-filled-button" style="display: inline-block; padding: 12px 30px; background: #2f89fc; color: #fff; border-radius: 25px; font-weight: 600; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 1px; transition: background 0.3s ease;"><i class="fas fa-download" style="margin-right: 8px;"></i> Download PDF</a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- ***** Download Section Ends ***** -->

  <!-- ***** Contact / Info Section Start ***** -->
  <section class="section" id="contact-us" style="background: #f7f7f7;">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-md-4 col-xs-12">
          <div class="left-text-content">
            <div class="section-heading">
              <h6>Informasi</h6>
              <h2>Hubungi Kami untuk Informasi Lebih Lanjut</h2>
            </div>
            <ul class="contact-info">
              <li><img src="{{ asset('Template_Halaman/templatemo_543_breezed/assets/images/contact-info-01.png') }}" alt="">090-080-0760</li>
              <li><img src="{{ asset('Template_Halaman/templatemo_543_breezed/assets/images/contact-info-02.png') }}" alt="">info@sigjalan.pemalang.go.id</li>
              <li><img src="{{ asset('Template_Halaman/templatemo_543_breezed/assets/images/contact-info-03.png') }}" alt="">sigjalan.pemalang.go.id</li>
            </ul>
          </div>
        </div>
        <div class="col-lg-8 col-md-8 col-xs-12">
          <div class="contact-form">
            <form id="contact" action="" method="get">
              <div class="row">
                <div class="col-md-6 col-sm-12">
                  <fieldset>
                    <input name="name" type="text" id="name" placeholder="Nama Anda *" required="">
                  </fieldset>
                </div>
                <div class="col-md-6 col-sm-12">
                  <fieldset>
                    <input name="phone" type="text" id="phone" placeholder="No. Telepon" required="">
                  </fieldset>
                </div>
                <div class="col-md-6 col-sm-12">
                  <fieldset>
                    <input name="email" type="email" id="email" placeholder="Email Anda *" required="">
                  </fieldset>
                </div>
                <div class="col-md-6 col-sm-12">
                  <fieldset>
                    <input name="subject" type="text" id="subject" placeholder="Subjek">
                  </fieldset>
                </div>
                <div class="col-lg-12">
                  <fieldset>
                    <textarea name="message" rows="6" id="message" placeholder="Pesan" required=""></textarea>
                  </fieldset>
                </div>
                <div class="col-lg-12">
                  <fieldset>
                    <button type="submit" id="form-submit" class="main-button-icon">Kirim Pesan <i class="fa fa-arrow-right"></i></button>
                  </fieldset>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- ***** Contact Section End ***** -->

@endsection

@push('scripts')
<!-- Scripts untuk mengambil total angka di Beranda -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Fetch resume data
        fetch('/api/roads/resume')
            .then(res => res.json())
            .then(data => {
                document.getElementById('pub-stat-total').innerText = data.total_ruas;
                document.getElementById('pub-stat-panjang').innerText = data.total_panjang_km + ' km';
                document.getElementById('pub-stat-baik').innerText = data.kondisi_baik;
                document.getElementById('pub-stat-baik-km').innerText = data.kondisi_baik_km + ' km';
                document.getElementById('pub-stat-sedang').innerText = data.kondisi_sedang;
                document.getElementById('pub-stat-sedang-km').innerText = data.kondisi_sedang_km + ' km';
                document.getElementById('pub-stat-rusak-ringan').innerText = data.kondisi_rusak_ringan;
                document.getElementById('pub-stat-rusak-ringan-km').innerText = data.kondisi_rusak_ringan_km + ' km';
                document.getElementById('pub-stat-rusak-berat').innerText = data.kondisi_rusak_berat;
                document.getElementById('pub-stat-rusak-berat-km').innerText = data.kondisi_rusak_berat_km + ' km';
            })
            .catch(err => console.error('Gagal mengambil statistik rute public:', err));
    });
</script>

  <!-- Leaflet JS -->
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

  <!-- GIS Data & App -->
  <script src="{{ asset('js/data.js') }}"></script>
  <script src="{{ asset('js/public-app.js') }}"></script>

</html>
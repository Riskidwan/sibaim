<footer style="background-color: rgb(3, 15, 107); color: #fff !important; padding: 50px 0 0;">
  <div class="container text-start">
    <div class="row">
      <!-- Section 1: Logo & Address -->
      <div class="col-md-4 mb-4 mb-md-0">
        <h5 class="fw-bold mb-3 text-white"><i class="fas fa-home"></i> SIBAIM</h5>
        <p class="mb-2 text-white-50" style="font-size: 14px; line-height: 1.6;">
          <strong class="text-white">ALAMAT:</strong><br>
          Dinas Perhubungan, Perumahan dan Kawasan Permukiman Kabupaten Pemalang
        </p>
        <p class="mb-3 text-white-50" style="font-size: 14px;">
          <strong class="text-white">EMAIL:</strong><br>
          bidangkawasan34@gmail.com
        </p>
        <div class="mt-4">
          <a href="https://web.facebook.com/people/Bidang-Kawasan/61557433287516/#" class="text-white me-3 opacity-75 hover-opacity-100"><i class="fab fa-facebook fa-lg"></i></a>
          <a href="https://youtube.com/@bidangkawasan?si=D9ElqV4C4dADG7Gw" class="text-white me-3 opacity-75 hover-opacity-100"><i class="fab fa-youtube fa-lg"></i></a>
          <a href="https://www.instagram.com/bid.kawasandp2kppml?igsh=dm16a2ZibXY2Z2Zs" class="text-white opacity-75 hover-opacity-100"><i class="fab fa-instagram fa-lg"></i></a>
        </div>
      </div>

      <!-- Section 2: Menu Links -->
      <div class="col-md-3 mb-4 mb-md-0">
        <h6 class="fw-bold mb-3 text-white">Menu Utama</h6>
        <ul class="list-unstyled" style="font-size: 14px;">
          <li class="mb-2"><a href="{{ url('/') }}" class="text-white-50 text-decoration-none hover-link">Beranda</a></li>
          <li class="mb-2"><a href="{{ url('/') }}#profil" class="text-white-50 text-decoration-none hover-link">Profil</a></li>
          <li class="mb-2"><a href="/permohonan-psu" class="text-white-50 text-decoration-none hover-link">Data</a></li>
          <li class="mb-2"><a href="/download" class="text-white-50 text-decoration-none hover-link">Pusat Unduhan</a></li>
        </ul>
      </div>

      <!-- Section 3: Tautan Website -->
      <div class="col-md-5 mb-0">
        <h6 class="fw-bold mb-3 text-white">Tautan Website</h6>
        <div class="row" style="font-size: 14px;">
          <div class="col-6">
            <ul class="list-unstyled">
              <li class="mb-2"><a href="https://pu.go.id/" target="_blank" class="text-white-50 text-decoration-none hover-link">Kementerian PU</a></li>
              <li class="mb-2"><a href="https://pkp.go.id/" target="_blank" class="text-white-50 text-decoration-none hover-link">Kementerian PKP</a></li>
              <li class="mb-2"><a href="https://jatengprov.go.id/" target="_blank" class="text-white-50 text-decoration-none hover-link">Pemprov Jateng</a></li>
              <li class="mb-2"><a href="https://disperakim.jatengprov.go.id/" target="_blank" class="text-white-50 text-decoration-none hover-link">Disperakim Prov Jateng</a></li>
            </ul>
          </div>
          <div class="col-6">
            <ul class="list-unstyled">
              <li class="mb-2"><a href="https://pemalangkab.go.id/" target="_blank" class="text-white-50 text-decoration-none hover-link">Pemkab Pemalang</a></li>
              <li class="mb-2"><a href="https://dishub.pemalangkab.go.id/" target="_blank" class="text-white-50 text-decoration-none hover-link">Dishub Pemalang</a></li>
              <li class="mb-2"><a href="https://spse.inaproc.id/pemalangkab" target="_blank" class="text-white-50 text-decoration-none hover-link">Inaproc Pemalang</a></li>
              <li class="mb-2"><a href="https://bapperida.pemalangkab.go.id/" target="_blank" class="text-white-50 text-decoration-none hover-link">Bapperida Pemalang</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Copyright Section -->
  <div class="mt-5 py-3" style="background-color: #ffff00;">
    <div class="container">
      <p class="text-center mb-0 small" style="color: #000; font-weight: 600;">
        &copy; {{ date('Y') }} SIBAIM - Sistem Informasi Basis Data Kawasan Permukiman Kabupaten Pemalang. All Rights Reserved.
      </p>
    </div>
  </div>
</footer>

<style>
  .text-white-50 { color: rgba(255,255,255,0.7) !important; }
  .text-white-50:hover { color: #fff !important; }
  .hover-link:hover { text-decoration: underline !important; }
  .hover-opacity-100:hover { opacity: 1 !important; }
</style>

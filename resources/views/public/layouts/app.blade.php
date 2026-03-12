<!DOCTYPE html>
<html lang="id">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description"
    content="Sistem Informasi Jalan Kabupaten Pemalang - Peta interaktif dan data kondisi ruas jalan berbasis GIS">
  <meta name="author" content="SIG Jalan Pemalang">
  <link href="https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900&display=swap"
    rel="stylesheet">

  <title>SIG Jalan - @yield('title', 'Beranda')</title>

  <!-- Additional CSS Files -->
  <link rel="stylesheet" type="text/css"
    href="{{ asset('Template_Halaman/templatemo_543_breezed/assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" type="text/css"
    href="{{ asset('Template_Halaman/templatemo_543_breezed/assets/css/font-awesome.css') }}">
  <link rel="stylesheet"
    href="{{ asset('Template_Halaman/templatemo_543_breezed/assets/css/templatemo-breezed.css') }}">
  <link rel="stylesheet" href="{{ asset('Template_Halaman/templatemo_543_breezed/assets/css/owl-carousel.css') }}">
  <link rel="stylesheet" href="{{ asset('Template_Halaman/templatemo_543_breezed/assets/css/lightbox.css') }}">

  <!-- Leaflet CSS (optional per page) -->
  @stack('styles')

  <!-- Font Awesome 6 (for extra icons) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

  <link rel="stylesheet" href="{{ asset('css/public.css') }}">

</head>

<body>

  <!-- ***** Header Area Start ***** -->
  <header class="header-area header-sticky">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <nav class="main-nav">
            <a href="/" class="logo">
              SIG JALAN
            </a>
            <ul class="nav">
              <li class="scroll-to-section"><a href="{{ url('/') }}"
                  class="{{ request()->is('/') ? 'active' : '' }}">Beranda</a></li>
              <li class="scroll-to-section"><a href="{{ url('/#about') }}">Profil</a></li>
              <li class="submenu custom-dropdown">
                <a href="javascript:;" class="menu-data"><span>Program</span></a>
                <ul class="dropdown-menu">
                  <li><a href="javascript:;"><span>Agenda Kerja</span></a></li>
                  <li><a href="javascript:;"><span>Program Kegiatan</span></a></li>
                  <li><a href="javascript:;"><span>Target Capaian Program</span></a></li>
                </ul>
              </li>
              <li class="submenu custom-dropdown">
                <a href="javascript:;" class="menu-data"><span>Data</span></a>
                <ul class="dropdown-menu">
                  <li class="submenu custom-dropdown-level-2">
                    <a href="javascript:;"><span>Jalan Lingkungan</span></a>
                    <ul class="dropdown-menu">
                      <li><a href="/peta" class="{{ request()->is('peta') ? 'active' : '' }}"><span>Peta Jalan
                            (WebGIS)</span></a></li>
                      <li><a href="/kondisi-jalan-tahunan"
                          class="{{ request()->is('kondisi-jalan-tahunan') ? 'active' : '' }}"><span>Kondisi Jalan
                            Tahunan</span></a></li>
                      <li><a href="/sk-jalan-lingkungan"
                          class="{{ request()->is('sk-jalan-lingkungan') ? 'active' : '' }}"><span>SK Jalan Lingkungan</span></a></li>
                    </ul>
                  </li>
                  <li class="submenu custom-dropdown-level-2">
                    <a href="javascript:;"><span>Data PSU</span></a>
                    <ul class="dropdown-menu">
                      <li><a href="/permohonan-psu" class="{{ request()->is('permohonan-psu') ? 'active' : '' }}"><span>Permohonan Serah Terima PSU</span></a></li>
                      <li><a href="/cek-status-psu" class="{{ request()->is('cek-status-psu') ? 'active' : '' }}"><span>Cek Status Permohonan</span></a></li>
                      <li><a href="/template-data-teknis" class="{{ request()->is('template-data-teknis') ? 'active' : '' }}"><span>Template Data teknis</span></a></li>
                      <li><a href="/#download"><span>Statistik Perumahan</span></a></li>
                      <li><a href="/#download"><span>Data Serah Terima PSU</span></a></li>
                    </ul>
                  </li>
                  <li class="submenu custom-dropdown-level-2">
                    <a href="javascript:;"><span>Kawasan Kumuh</span></a>
                    <ul class="dropdown-menu">
                      <li><a href="/peta"><span>SK Penetapan Kawasan Kumuh</span></a></li>
                      <li><a href="/#statistik"><span>Data Intervensi Penanganan</span></a></li>
                      <li><a href="/#download"><span>BA Penanganan kumuh </span></a></li>
                    </ul>
                  </li>
                </ul>
              </li>
              <li class="scroll-to-section"><a href="{{ url('/#statistik') }}">Galeri</a></li>
              <li class="scroll-to-section"><a href="{{ url('/#download') }}">Download</a></li>
              <li class="login-admin-btn">
                <a href="/admin/dashboard" class="btn-login-custom">
                  <i class="fa fa-lock"></i> Login Admin
                </a>
              </li>
            </ul>
            <a class='menu-trigger'>
              <span>Menu</span>
            </a>
          </nav>
        </div>
      </div>
    </div>
  </header>
  <!-- ***** Header Area End ***** -->

  @yield('content')

  <!-- ***** Footer Start ***** -->
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-lg-6 col-xs-12">
          <div class="copyright-text">
            <p>Copyright &copy; 2026 SIG Jalan Kabupaten Pemalang.
              <br>Design modified from: TemplateMo
            </p>
          </div>
        </div>
        <div class="col-lg-6 col-xs-12">
          <div class="right-text-content">
            <ul class="social-icons">
              <li>
                <p>Follow Us</p>
              </li>
              <li><a rel="nofollow" href="#"><i class="fa fa-facebook"></i></a></li>
              <li><a rel="nofollow" href="#"><i class="fa fa-twitter"></i></a></li>
              <li><a rel="nofollow" href="#"><i class="fa fa-instagram"></i></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <!-- jQuery -->
  <script src="{{ asset('Template_Halaman/templatemo_543_breezed/assets/js/jquery-2.1.0.min.js') }}"></script>
  <!-- Bootstrap -->
  <script src="{{ asset('Template_Halaman/templatemo_543_breezed/assets/js/popper.js') }}"></script>
  <script src="{{ asset('Template_Halaman/templatemo_543_breezed/assets/js/bootstrap.min.js') }}"></script>
  <!-- Plugins -->
  <script src="{{ asset('Template_Halaman/templatemo_543_breezed/assets/js/owl-carousel.js') }}"></script>
  <script src="{{ asset('Template_Halaman/templatemo_543_breezed/assets/js/scrollreveal.min.js') }}"></script>
  <script src="{{ asset('Template_Halaman/templatemo_543_breezed/assets/js/waypoints.min.js') }}"></script>
  <script src="{{ asset('Template_Halaman/templatemo_543_breezed/assets/js/jquery.counterup.min.js') }}"></script>
  <script src="{{ asset('Template_Halaman/templatemo_543_breezed/assets/js/imgfix.min.js') }}"></script>
  <script src="{{ asset('Template_Halaman/templatemo_543_breezed/assets/js/slick.js') }}"></script>
  <script src="{{ asset('Template_Halaman/templatemo_543_breezed/assets/js/lightbox.js') }}"></script>
  <script src="{{ asset('Template_Halaman/templatemo_543_breezed/assets/js/isotope.js') }}"></script>

  <!-- Global Init -->
  <script src="{{ asset('Template_Halaman/templatemo_543_breezed/assets/js/custom.js') }}"></script>

  @stack('scripts')
</body>

</html>
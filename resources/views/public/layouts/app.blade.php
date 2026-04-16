<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>SIBAIM - Sistem Informasi Basis Data Kawasan Permukiman</title>

    <!-- Bootstrap -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />

    <!-- Font Awesome -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    />
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}?v=2" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
    <link rel="icon" href="{{ asset('img/logoKab.Pemalang.png') }}" type="image/png">


    <!-- Extra per-page styles -->
    @stack('styles')

    <style>
      .navbar {
        background-color: #ffff00 !important;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1) !important;
      }
      .navbar .nav-link {
        color: #000000 !important;
        font-weight: 600 !important;
      }
      .navbar .navbar-brand {
        color: #000000 !important;
      }
      .navbar .navbar-toggler-icon {
        filter: brightness(0);
      }
      .btn-navbar-login {
        background-color: #115e59 !important;
        color: #ffffff !important;
        border-radius: 50px !important;
        padding: 8px 24px !important;
        font-weight: 600 !important;
        border: none !important;
        transition: 0.3s !important;
      }
      .btn-navbar-login:hover {
        background-color: #0d403d !important;
        transform: scale(1.05);
      }
      /* ── Mobile Navbar Dark Override ── */
      @media (max-width: 991.98px) {
        /* Background menu mobile */
        .navbar-collapse {
          background: #111827 !important;
          border-radius: 12px;
          margin-top: 8px;
          padding: 8px 12px 12px;
        }
        /* Link teks */
        .navbar-nav .nav-link {
          color: #d1d5db !important;
        }
        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link:focus {
          color: #ffffff !important;
        }
        /* Dropdown menu di dalam mobile */
        .navbar-nav .dropdown-menu {
          background: #1f2937 !important;
          border: 1px solid #374151 !important;
          border-radius: 10px;
        }
        .navbar-nav .dropdown-menu .dropdown-item {
          color: #d1d5db !important;
        }
        .navbar-nav .dropdown-menu .dropdown-item:hover {
          background: #374151 !important;
          color: #ffffff !important;
        }
        .navbar-nav .dropdown-menu .dropdown-header {
          color: #6b7280 !important;
        }
        .navbar-nav .dropdown-menu hr.dropdown-divider {
          border-color: #374151 !important;
        }
        /* Sub-dropdown juga */
        .dropdown-submenu .dropdown-menu {
          background: #1f2937 !important;
          border: 1px solid #374151 !important;
        }
      }
    </style>
  </head>

  <body>
    <style>
      /* ── Dashboard Navbar (SIMBG Style - Refined) ── */
      .navbar-dashboard {
        background-color: #ffff00 !important;
        padding: 8px 0 !important;
        box-shadow: 0 1px 15px rgba(0, 0, 0, 0.08) !important;
        border-bottom: 3px solid #115e59;
      }
      .navbar-dashboard .navbar-brand {
        color: #000000 !important;
        font-size: 1.35rem;
        font-weight: 800;
        letter-spacing: -0.5px;
      }
      .navbar-dashboard .brand-subtitle {
        font-size: 0.65rem;
        font-weight: 700;
        line-height: 1.2;
        color: #115e59;
        border-left: 2px solid #115e59;
        padding-left: 15px;
        margin-left: 15px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
      }
      .btn-beranda-simbg {
        background: #115e59 !important;
        color: white !important;
        border-radius: 8px !important;
        padding: 6px 18px !important; /* Smaller padding */
        font-weight: 700 !important;
        text-decoration: none !important;
        font-size: 0.9rem !important;
        margin-left: 20px;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        gap: 8px;
      }
      .btn-beranda-simbg:hover { 
        background: #0d403d !important; 
        box-shadow: 0 4px 6px rgba(17, 94, 89, 0.3);
        transform: translateY(-1px); 
      }
      
      .nav-dashboard-link {
        color: #000000 !important;
        font-weight: 700 !important;
        font-size: 0.95rem !important;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 15px !important;
        transition: all 0.2s;
        border-radius: 8px;
      }
      .nav-dashboard-link:hover { background: rgba(0,0,0,0.04); color: #115e59 !important; }
      .nav-dashboard-link i { font-size: 1.2rem; }

      /* User Dropdown Refinement */
      .user-dropdown-simbg {
        background: white !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 14px !important;
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04) !important;
        padding: 8px !important;
        min-width: 240px !important;
        margin-top: 18px !important;
      }
      .user-dropdown-simbg .dropdown-item {
        padding: 11px 18px !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
        color: #475569 !important;
        display: flex;
        align-items: center;
        gap: 14px;
        font-size: 0.9rem;
      }
      .user-dropdown-simbg .dropdown-item:hover { 
        background: #f1f5f9 !important; 
        color: #115e59 !important; 
      }
      .user-dropdown-simbg .dropdown-item i { 
        width: 20px; 
        color: #64748b; 
        font-size: 1.1rem;
        display: flex;
        justify-content: center;
      }
      .user-dropdown-simbg .dropdown-divider { margin: 8px 10px !important; opacity: 0.1; }

      .navbar-dashboard .navbar-toggler { border: none !important; color: #115e59 !important; padding: 0; }
      .navbar-dashboard .navbar-toggler:focus { box-shadow: none !important; }

      @media (max-width: 991.98px) {
        .navbar-dashboard .navbar-collapse { background: #ffff00 !important; padding: 25px; margin-top: 20px; border-radius: 16px; border: 2px solid #115e59; }
        .btn-beranda-simbg { margin-left: 0; margin-bottom: 20px; width: 100%; justify-content: center; }
      }

      /* Notification Dropdown Popover Style */
      .notification-dropdown {
        width: 320px !important;
        border: none !important;
        border-radius: 12px !important;
        box-shadow: 0 10px 40px rgba(0,0,0,0.15) !important;
        padding: 0 !important;
        margin-top: 15px !important;
        overflow: visible !important;
      }
      .notification-dropdown::before {
        content: "";
        position: absolute;
        top: -8px;
        left: 20px;
        width: 16px;
        height: 16px;
        background: white;
        transform: rotate(45deg);
        z-index: -1;
      }
      .notification-header {
        padding: 12px 16px;
        border-bottom: 1px solid #f1f5f9;
        font-weight: 700;
        font-size: 0.85rem;
        color: #334155;
      }
      .notification-footer {
        padding: 10px;
        text-align: center;
        border-top: 1px solid #f1f5f9;
        background: #f8fafc;
        border-bottom-left-radius: 12px;
        border-bottom-right-radius: 12px;
      }
      .notification-item {
        padding: 12px 16px !important;
        border-bottom: 1px solid #f8fafc;
        transition: all 0.2s;
        white-space: normal !important;
      }
      .notification-item:hover { background: #f1f5f9 !important; }
      .notification-item.unread { background: #eff6ff; }
      .notification-item:last-child { border-bottom: none; }
    </style>
  </head>

  <body>
    <!-- NAVBAR -->
    @php
      $isUserDashboard = Request::is('user/*') || Request::is('permohonan-psu*') || Request::is('auth/verify-otp*');
    @endphp

    @if($isUserDashboard)
      <!-- DASHBOARD NAVBAR (SIMBG LAYOUT - REFINED) -->
      <nav class="navbar navbar-expand-lg navbar-dashboard fixed-top">
        <div class="container">
          <div class="d-flex align-items-center">
            <a class="navbar-brand d-flex align-items-center fw-bold" href="{{ url('/') }}">
              <img src="{{ asset('img/logoKab.Pemalang.png') }}" width="34" class="me-2" alt="Logo">
              SIBAIM
            </a>
            <div class="brand-subtitle d-none d-md-block">
              SISTEM INFORMASI BASIS DATA<br>KAWASAN PERMUKIMAN
            </div>
            <!-- Custom Beranda Button with Logout Logic -->
            <a href="{{ url('/') }}" class="btn-beranda-simbg d-none d-lg-flex" 
               onclick="event.preventDefault(); if(confirm('Apakah Anda ingin keluar dan kembali ke Beranda?')) document.getElementById('logout-form').submit();">
              <i class="fas fa-home"></i> Beranda
            </a>
          </div>

          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#dashboardNav">
            <i class="fas fa-bars fs-2"></i>
          </button>

          <div class="collapse navbar-collapse" id="dashboardNav">
            <ul class="navbar-nav ms-auto align-items-center">
              <li class="nav-item dropdown">
                <a class="nav-dashboard-link position-relative dropdown-toggle" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="fas fa-bell"></i>
                  <span>Pemberitahuan</span>
                  @php
                    $unreadCount = auth()->user()->unreadNotifications->count();
                    $recentNotifications = auth()->user()->notifications()->take(5)->get();
                  @endphp
                  @if($unreadCount > 0)
                    <span class="position-absolute top-10 start-90 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem; padding: 0.35em 0.65em;">
                      {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                    </span>
                  @endif
                </a>
                <div class="dropdown-menu dropdown-menu-start notification-dropdown animate slideIn" aria-labelledby="notifDropdown">
                  <div class="notification-header d-flex justify-content-between align-items-center">
                    <span>PEMBERITAHUAN</span>
                    @if($unreadCount > 0)
                      <span class="badge bg-primary-subtle text-primary rounded-pill" style="font-size: 0.7rem;">{{ $unreadCount }} Baru</span>
                    @endif
                  </div>
                  <div class="notification-body" style="max-height: 350px; overflow-y: auto;">
                    @forelse($recentNotifications as $notification)
                      <a href="{{ route('user.notifications.index') }}" class="dropdown-item notification-item {{ $notification->unread() ? 'unread' : '' }}">
                        <div class="d-flex align-items-start">
                          <div class="flex-grow-1">
                            <div class="fw-bold text-dark small mb-1">Pembaruan Status</div>
                            <div class="text-muted" style="font-size: 0.75rem; line-height: 1.4;">
                                {{ \Illuminate\Support\Str::limit($notification->data['message'], 60) }}
                            </div>
                            <div class="text-primary mt-1 fw-bold" style="font-size: 0.65rem;">
                              <i class="far fa-clock me-1"></i> {{ $notification->created_at->diffForHumans() }}
                            </div>
                          </div>
                          @if($notification->unread())
                            <div class="ms-2">
                              <span class="bg-primary rounded-circle d-block" style="width: 8px; height: 8px;"></span>
                            </div>
                          @endif
                        </div>
                      </a>
                    @empty
                      <div class="py-5 text-center px-3">
                        <i class="fas fa-bell-slash text-muted mb-2 fs-3" style="opacity: 0.3;"></i>
                        <p class="text-muted small mb-0">Belum ada pemberitahuan</p>
                      </div>
                    @endforelse
                  </div>
                  <div class="notification-footer">
                    <a href="{{ route('user.notifications.index') }}" class="text-primary fw-bold text-decoration-none small">Lihat Semua Pemberitahuan</a>
                  </div>
                </div>
              </li>
              
              <li class="nav-item dropdown">
                <a class="nav-dashboard-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                  <i class="fas fa-user-circle"></i>
                  <span>Pemohon</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end user-dropdown-simbg" aria-labelledby="userDropdown">
                  <div class="px-3 py-2 mb-2 bg-light rounded-3 d-flex align-items-center">
                    <div class="bg-primary rounded-circle me-2 d-flex align-items-center justify-content-center text-white" style="width: 35px; height: 35px; font-weight: 700;">
                      {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div style="flex: 1; overflow: hidden;">
                      <div class="fw-bold small text-truncate">{{ Auth::user()->name }}</div>
                      <div class="text-muted" style="font-size: 0.75rem;">Pemohon</div>
                    </div>
                  </div>
                  
                  <a class="dropdown-item" href="{{ route('user.profile') }}"><i class="fas fa-user-edit"></i> Profil Saya</a>
                  <a class="dropdown-item" href="{{ route('user.email') }}"><i class="fas fa-envelope-open-text"></i> Ubah E-mail</a>
                  <a class="dropdown-item" href="{{ route('user.password') }}"><i class="fas fa-fingerprint"></i> Ubah Kata Sandi</a>
                  
                  <hr class="dropdown-divider">
                  
                  <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                     onclick="event.preventDefault(); if(confirm('Apakah Anda ingin keluar atau pindah akun?')) document.getElementById('logout-form').submit();">
                    <i class="fas fa-exchange-alt"></i> {{ __('Ganti Akun / Keluar') }}
                  </a>
                  
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                      @csrf
                  </form>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    @else
      <nav class="navbar navbar-expand-lg navbar-dashboard fixed-top">
        <div class="container">
          <div class="d-flex align-items-center">
            <a class="navbar-brand d-flex align-items-center fw-bold" href="{{ url('/') }}">
              <img src="{{ asset('img/logoKab.Pemalang.png') }}" width="34" class="me-2" alt="Logo">
              SIBAIM
            </a>
            <div class="brand-subtitle d-none d-md-block">
              SISTEM INFORMASI BASIS DATA<br>KAWASAN PERMUKIMAN
            </div>
          </div>

          <button
            class="navbar-toggler"
            data-bs-toggle="collapse"
            data-bs-target="#menu"
          >
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav ms-auto">
              <li class="nav-item">
                <a class="nav-link" href="{{ url('/') }}#beranda">Beranda</a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="{{ url('/') }}#profil">Profil</a>
              </li>

              <li class="nav-item dropdown" id="navData">
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                  Data PSU
                </a>
                <ul class="dropdown-menu" style="min-width: 230px; padding: 6px;">
                  <li>
                    <a class="dropdown-item d-flex justify-content-between align-items-center" href="/permohonan-psu">
                      Serah Terima PSU
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item d-flex justify-content-between align-items-center {{ Request::is('data-perumahan') ? 'active' : '' }}" href="/data-perumahan">
                      Data Jumlah Perumahan
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item d-flex justify-content-between align-items-center {{ Request::is('data-jalan') ? 'active' : '' }}" href="/data-jalan">
                      Data Jalan
                    </a>
                  </li>
                </ul>
              </li>

              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">Galeri</a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="{{ route('public.galeri') }}">Lihat Semua</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="{{ route('public.galeri', 'berita') }}">Berita dalam Gambar</a></li>
                  <li><a class="dropdown-item" href="{{ route('public.galeri', 'kunjungan') }}">Kunjungan Kerja</a></li>
                  <li><a class="dropdown-item" href="{{ route('public.galeri', 'rapat') }}">Rapat Koordinasi</a></li>
                  <li><a class="dropdown-item" href="{{ route('public.galeri', 'sosialisasi') }}">Sosialisasi</a></li>
                </ul>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="{{ url('/download') }}">Download</a>
              </li>

              @guest
              <li class="nav-item ms-3">
                <a class="btn btn-navbar-login" href="{{ route('login') }}">Login</a>
              </li>
              @else
              <li class="nav-item dropdown ms-3">
                  <a id="navbarDropdown" class="nav-link dropdown-toggle btn btn-light" style="padding: 8px 15px; border-radius: 8px;" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                      <i class="fas fa-user-circle" style="margin-right: 5px;"></i> {{ Auth::user()->name }}
                  </a>

                  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item" href="{{ Auth::user()->is_admin ? route('admin.dashboard') : url('/user/dashboard') }}">
                          <i class="fas fa-tachometer-alt" style="margin-right: 8px;"></i> Dashboard
                      </a>
                      <hr class="dropdown-divider">
                      <a class="dropdown-item" href="{{ route('logout') }}"
                         onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                          <i class="fas fa-sign-out-alt" style="margin-right: 8px; color: #dc3545;"></i> {{ __('Logout') }}
                      </a>

                      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                          @csrf
                      </form>
                  </div>
              </li>
              @endguest
            </ul>
          </div>
        </div>
      </nav>
    @endif

    @yield('content')

    <!-- FOOTER -->
    @include('public.layouts.footer')

    <script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
    
    <script>
      const lightbox = GLightbox({
        selector: '.glightbox',
        touchNavigation: true,
        loop: true,
        autoplayVideos: true
      });
      
      document.addEventListener("DOMContentLoaded", function () {
        // Toggle submenu for mobile
        document.querySelectorAll('.dropdown-submenu > a').forEach(function(element){
          element.addEventListener('click', function (e) {
            if(window.innerWidth < 992) {
                e.preventDefault();
                e.stopPropagation();
                
                let submenu = this.parentNode;
                
                // Close other submenus
                let currentOpen = this.closest('.dropdown-menu').querySelectorAll('.dropdown-submenu.show');
                currentOpen.forEach(function(c) {
                  if (c !== submenu) {
                    c.classList.remove('show');
                  }
                });
                
                submenu.classList.toggle('show');
            }
          });
        });
      });
    </script>
  </body>
</html>

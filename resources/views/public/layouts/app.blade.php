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
      /* ── Shared Navbar & Dashboard Style (Yellow Theme) ── */
      .navbar, .navbar-dashboard {
        background-color: #ffff00 !important; /* Brand Yellow */
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
        border-bottom: 3px solid #115e59 !important; /* Brand Contrast Line */
        transition: all 0.3s ease;
        padding: 10px 0 !important;
      }
      
      .navbar .nav-link, .navbar-dashboard .nav-dashboard-link {
        color: #115e59 !important; /* Professional Dark Teal */
        font-weight: 700 !important;
        padding: 10px 8px !important;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 4px;
      }
      
      .navbar .nav-link:hover, .navbar-dashboard .nav-dashboard-link:hover {
        color: #000000 !important;
        transform: translateY(-1px);
      }

      .navbar .navbar-brand, .navbar-dashboard .navbar-brand {
        color: #115e59 !important;
        font-weight: 800 !important;
        display: flex;
        align-items: center;
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

      .navbar .navbar-toggler {
        border-color: #115e59 !important;
        padding: 4px 8px;
        color: #115e59 !important;
      }
      
      .navbar .navbar-toggler-icon {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(17, 94, 89, 1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e") !important;
      }

      .btn-navbar-login {
        background-color: #115e59 !important;
        color: #ffffff !important;
        border-radius: 50px !important;
        padding: 8px 24px !important;
        font-weight: 700 !important;
        border: none !important;
        transition: 0.3s !important;
      }
      
      .btn-navbar-login:hover {
        background-color: #0d403d !important;
        transform: scale(1.05);
      }

      .btn-beranda-simbg {
        background: #115e59 !important;
        color: white !important;
        border-radius: 8px !important;
        padding: 8px 15px !important;
        font-weight: 700 !important;
        text-decoration: none !important;
        font-size: 0.9rem !important;
        margin-left: 15px;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        gap: 8px;
      }

      /* ── Mobile Navbar Correction ── */
      @media (max-width: 991.98px) {
        .navbar-collapse {
          background: #ffff00 !important; /* Keep it yellow */
          border-radius: 16px;
          margin-top: 15px;
          padding: 25px;
          border: 3px solid #115e59 !important;
          box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        
        .navbar-nav .nav-link, .navbar-dashboard .navbar-nav .nav-link {
          color: #115e59 !important; /* High contrast dark teal text */
          padding: 15px !important;
          border-bottom: 1px solid rgba(17, 94, 89, 0.1);
          font-weight: 800 !important;
          font-size: 1.05rem !important;
        }

        .navbar-nav .nav-link:last-child {
          border-bottom: none;
        }
        
        .navbar-nav .nav-link:hover {
          background: rgba(17, 94, 89, 0.05);
          color: #000000 !important;
        }

        .navbar-nav .dropdown-menu {
          background: rgba(17, 94, 89, 0.05) !important;
          border: none !important;
          border-radius: 10px;
          padding: 10px 0 10px 20px;
        }

        .navbar-nav .dropdown-item {
          color: #115e59 !important;
          font-weight: 700;
          padding: 10px 15px !important;
        }

        .btn-beranda-simbg { margin-left: 0; margin-bottom: 20px; width: 100%; justify-content: center; }
      }

      /* User & Notification Dropdowns */
      .user-dropdown-simbg, .notification-dropdown {
        background: white !important;
        border: none !important;
        border-radius: 16px !important;
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04) !important;
        padding: 0 !important;
        overflow: hidden;
      }
      
      .notification-dropdown { width: 340px !important; border: 1px solid #f1f5f9 !important; }

      .notification-header { 
        padding: 16px 20px; 
        background: #f8fafc;
        border-bottom: 1px solid #f1f5f9; 
        font-weight: 800; 
        color: #115e59;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
      }

      .notification-body::-webkit-scrollbar { width: 6px; }
      .notification-body::-webkit-scrollbar-track { background: #f1f5f9; }
      .notification-body::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
      .notification-body::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

      .notification-item { 
        padding: 16px 20px !important; 
        border-bottom: 1px solid #f1f5f9; 
        transition: all 0.2s; 
        white-space: normal !important; 
        position: relative;
      }
      .notification-item:last-child { border-bottom: none; }
      .notification-item:hover { background: #f8fafc !important; }
      .notification-item.unread { background: #f0fdfa !important; }
      .notification-item.unread:hover { background: #ecfdf5 !important; }
      
      .notification-footer {
        padding: 12px;
        text-align: center;
        background: #f8fafc;
        border-top: 1px solid #f1f5f9;
      }
      .notification-footer a {
        display: block;
        color: #115e59;
        font-size: 0.8rem;
        transition: all 0.2s;
      }
      .notification-footer a:hover { color: #0d403d; transform: scale(1.02); }

      /* Modal Login Styles */
      .login-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 2px solid transparent !important;
      }
      .login-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
      }
      
      .login-option {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 2px solid transparent !important;
        cursor: pointer;
      }
      .login-option:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 20px rgba(0,0,0,0.08);
      }
      .login-option.pemohon:hover {
        background-color: #e0f2f1 !important;
        border-color: #115e59 !important;
      }
      .login-option.admin:hover {
        background-color: #fee2e2 !important;
        border-color: #dc3545 !important;
      }
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
        <div class="container-fluid px-lg-1">
          <div class="d-flex align-items-center">
            <a class="navbar-brand d-flex align-items-center fw-bold" href="{{ url('/') }}">
              <img src="{{ asset('img/logoKab.Pemalang.png') }}" width="34" class="me-2" alt="Logo">
              SIBAIM
            </a>
            <div class="brand-subtitle d-none d-md-block">
              SISTEM INFORMASI BASIS DATA<br>KAWASAN PERMUKIMAN
            </div>
          </div>

          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#dashboardNav">
            <i class="fas fa-bars fs-2"></i>
          </button>

          <div class="collapse navbar-collapse" id="dashboardNav">
            <!-- Left Side Navbar -->
            <ul class="navbar-nav me-auto align-items-center">
              <li class="nav-item d-flex align-items-center gap-2">
                <a href="{{ route('user.dashboard') }}" class="btn-beranda-simbg" style="background: #115e59 !important;">
                  <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
              </li>
            </ul>

            <!-- Right Side Navbar -->
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
                    <span class="position-absolute translate-middle badge rounded-pill bg-danger" style="top: 8px; left: 18px; font-size: 0.55rem; padding: 0.4em 0.6em; border: 2px solid #ffff00;">
                      {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                    </span>
                  @endif
                </a>
                <div class="dropdown-menu dropdown-menu-end notification-dropdown animate slideIn" aria-labelledby="notifDropdown">
                  <div class="notification-header d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2">
                      <i class="fas fa-bell text-primary"></i>
                      <span>PEMBERITAHUAN</span>
                    </div>
                    @if($unreadCount > 0)
                      <span class="badge bg-danger rounded-pill" style="font-size: 0.65rem;">{{ $unreadCount }} Baru</span>
                    @endif
                  </div>
                  <div class="notification-body" style="max-height: 400px; overflow-y: auto;">
                    @forelse($recentNotifications as $notification)
                      <a href="{{ route('user.notifications.index') }}" class="dropdown-item notification-item {{ $notification->unread() ? 'unread' : '' }}">
                        <div class="d-flex align-items-start gap-3">
                          <div class="flex-shrink-0 mt-1">
                            @if(isset($notification->data['type']) && $notification->data['type'] == 'status')
                              <div class="bg-info-subtle text-info rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                <i class="fas fa-info-circle fs-6"></i>
                              </div>
                            @else
                              <div class="bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                <i class="fas fa-file-alt fs-6"></i>
                              </div>
                            @endif
                          </div>
                          <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                              <span class="fw-bold text-dark" style="font-size: 0.85rem;">
                                {{ $notification->data['title'] ?? 'Pembaruan Sistem' }}
                              </span>
                              @if($notification->unread())
                                <span class="bg-primary rounded-circle" style="width: 6px; height: 6px;"></span>
                              @endif
                            </div>
                            <div class="text-muted" style="font-size: 0.8rem; line-height: 1.5; color: #64748b !important;">
                                {{ \Illuminate\Support\Str::limit($notification->data['message'], 80) }}
                            </div>
                            <div class="d-flex align-items-center gap-2 mt-2 text-secondary" style="font-size: 0.7rem;">
                              <i class="far fa-clock"></i>
                              <span>{{ $notification->created_at->diffForHumans() }}</span>
                            </div>
                          </div>
                        </div>
                      </a>
                    @empty
                      <div class="py-5 text-center px-4">
                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                          <i class="fas fa-bell-slash text-muted fs-3" style="opacity: 0.4;"></i>
                        </div>
                        <p class="text-dark fw-bold small mb-1">Tidak Ada Notifikasi</p>
                        <p class="text-muted small mb-0">Semua pemberitahuan sudah Anda baca.</p>
                      </div>
                    @endforelse
                  </div>
                  <div class="notification-footer">
                    <a href="{{ route('user.notifications.index') }}" class="fw-bold text-decoration-none">
                      Lihat Semua Pemberitahuan <i class="fas fa-arrow-right ms-1" style="font-size: 0.7rem;"></i>
                    </a>
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
                  
                  <a class="dropdown-item" href="{{ route('user.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
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
        <div class="container-fluid px-lg-1">
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
                  Data
                </a>
                <ul class="dropdown-menu" style="min-width: 230px; padding: 6px;">
                  <li>
                    <a class="dropdown-item d-flex justify-content-between align-items-center" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">
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
                <a class="btn btn-navbar-login" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
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
    
    <!-- LOGIN SELECTION MODAL -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" style="max-width: 450px;">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
          <div class="modal-header border-0 pb-0 pt-4 px-4">
            <h6 class="modal-title fw-bold" style="color: #115e59; letter-spacing: 1px;">PILIH AKSES MASUK</h6>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body p-4">
            <div class="row g-3">
              <!-- Opsi Pemohon -->
              <div class="col-6">
                <a href="{{ route('login') }}" class="text-decoration-none h-100 d-block">
                  <div class="login-option pemohon p-4 rounded-4 text-center h-100 d-flex flex-column align-items-center justify-content-center" style="background-color: #f0fdfa;">
                    <div class="fw-bold mb-1" style="color: #115e59; font-size: 0.9rem;">PEMOHON</div>
                    <div class="text-muted small fw-normal" style="font-size: 0.7rem;">Pendaftaran PSU</div>
                  </div>
                </a>
              </div>
              <!-- Opsi Admin -->
              <div class="col-6">
                <a href="{{ url('/admin/login') }}" class="text-decoration-none h-100 d-block">
                  <div class="login-option admin p-4 rounded-4 text-center h-100 d-flex flex-column align-items-center justify-content-center" style="background-color: #fef2f2;">
                    <div class="fw-bold mb-1" style="color: #dc3545; font-size: 0.9rem;">ADMIN</div>
                    <div class="text-muted small fw-normal" style="font-size: 0.7rem;">Portal Petugas</div>
                  </div>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

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

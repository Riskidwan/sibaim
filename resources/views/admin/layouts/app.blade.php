<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Dashboard Admin - Sistem Informasi Jalan berbasis GIS" />
    <title>Dashboard Admin - SIG Jalan</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!-- Leaflet Draw CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    
    @stack('styles')
</head>
<body class="{{ session('theme', 'light') === 'dark' ? 'dark' : '' }}">
    <div id="app-shell" class="app-container active">
        <!-- Sidebar Overlay (mobile) -->
        <div class="sidebar-overlay"></div>

        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo"><i class="fas fa-map-marked-alt"></i></div>
                <div>
                    <div class="sidebar-title">SIG Jalan</div>
                    <div class="sidebar-subtitle">Road GIS System</div>
                </div>
            </div>

            <nav class="sidebar-nav">
                <div class="nav-section-label">Menu Utama</div>
                <a href="{{ url('admin/dashboard') }}" class="nav-item {{ Request::is('admin/dashboard') ? 'active' : '' }}" style="text-decoration: none; color: inherit;">
                    <i class="fas fa-th-large"></i><span>Dashboard</span>
                </a>
                <a href="{{ url('admin/roads') }}" class="nav-item {{ Request::is('admin/roads*') ? 'active' : '' }}" style="text-decoration: none; color: inherit;">
                    <i class="fas fa-road"></i><span>Data Jalan</span>
                </a>
                <a href="{{ route('admin.reports.index') }}" class="nav-item {{ Request::is('admin/reports*') ? 'active' : '' }}" style="text-decoration: none; color: inherit;">
                    <i class="fas fa-file-pdf"></i><span>Laporan Tahunan</span>
                </a>
                <a href="{{ route('admin.sk-jalan-lingkungan.index') }}" class="nav-item {{ Request::is('admin/sk-jalan-lingkungan*') ? 'active' : '' }}" style="text-decoration: none; color: inherit;">
                    <i class="fas fa-file-signature"></i><span>SK Jalan Lingkungan</span>
                </a>
                <a href="{{ route('admin.psu-submissions.index') }}" class="nav-item {{ Request::is('admin/psu-submissions*') ? 'active' : '' }}" style="text-decoration: none; color: inherit;">
                    <i class="fas fa-hand-holding-heart"></i><span>Permohonan PSU</span>
                </a>
                <a href="{{ route('admin.psu-templates.index') }}" class="nav-item {{ Request::is('admin/psu-templates*') ? 'active' : '' }}" style="text-decoration: none; color: inherit;">
                    <i class="fas fa-file-download"></i><span>Template Data Teknis</span>
                </a>

                <div class="nav-section-label">Lainnya</div>
                <a class="nav-item" href="/" style="text-decoration: none;">
                    <i class="fas fa-globe"></i><span>Halaman Publik</span>
                </a>
            </nav>

            <div class="sidebar-footer">
                <div class="sidebar-user">
                    <div class="user-avatar">A</div>
                    <div class="user-info">
                        <div class="user-name">Admin</div>
                        <div class="user-role">Administrator</div>
                    </div>
                </div>
                <!-- Need a real logout route later but form is better -->
                <button class="logout-btn" onclick="window.location.href='/'">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </button>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Top Header -->
            <header class="main-header">
                <div class="header-left">
                    <button class="sidebar-toggle"><i class="fas fa-bars"></i></button>
                    <h1 class="page-title">@yield('title', 'Dashboard')</h1>
                </div>
                <div class="header-right">
                    <!-- Theme Toggle -->
                    <button id="theme-toggle" class="theme-toggle-btn" title="Toggle Dark Mode">
                        <i class="fas fa-moon dark-hidden"></i>
                        <i class="fas fa-sun light-hidden" style="display: none;"></i>
                    </button>
                </div>
            </header>

            <!-- Page Content -->
            <div class="page-content" style="padding: 24px;">
                @if(session('success'))
                    <div style="padding: 1rem; margin-bottom: 1rem; background-color: #ecfdf3; color: #027a48; border-radius: 8px; border: 1px solid #a6f4c5;">
                        <i class="fas fa-check-circle" style="margin-right: 8px;"></i>
                        {{ session('success') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div style="padding: 1rem; margin-bottom: 1rem; background-color: #fef3f2; color: #b42318; border-radius: 8px; border: 1px solid #fecdca;">
                        <i class="fas fa-exclamation-circle" style="margin-right: 8px;"></i>
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
            <!-- /page-content -->
        </div>
        <!-- /main-content -->
    </div>
    <!-- /app-shell -->

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.js"></script>

    <!-- Basic UI scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile sidebar
            const sidebarToggle = document.querySelector('.sidebar-toggle');
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.querySelector('.sidebar-overlay');

            if(sidebarToggle) {
                sidebarToggle.addEventListener('click', () => {
                    sidebar.classList.toggle('active');
                    if(overlay) overlay.classList.toggle('active');
                });
            }
            if(overlay) {
                overlay.addEventListener('click', () => {
                    sidebar.classList.remove('active');
                    overlay.classList.remove('active');
                });
            }

            // Dark Mode
            const themeToggle = document.getElementById('theme-toggle');
            if(themeToggle) {
                if(localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    document.body.classList.add('dark');
                }
                themeToggle.addEventListener('click', () => {
                    document.body.classList.toggle('dark');
                    localStorage.setItem('theme', document.body.classList.contains('dark') ? 'dark' : 'light');
                });
            }
        });
    </script>

    @stack('scripts')
</body>
</html>

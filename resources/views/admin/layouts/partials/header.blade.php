<header class="mb-0 mb-lg-1 d-flex justify-content-between align-items-center py-2 px-4">
    <div class="header-left">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </div>
    
    <div class="header-right ms-auto">
        <div class="dropdown">
            <a href="#" data-bs-toggle="dropdown" aria-expanded="false" class="text-decoration-none">
                <div class="user-menu d-flex align-items-center py-1 px-2 rounded-3 transition-all hover-bg-light">
                    <div class="user-name text-end me-3 d-none d-sm-block">
                        <h6 class="mb-0 text-gray-600 fw-bold">{{ Auth::user()->name }}</h6>
                        <p class="mb-0 text-muted text-uppercase fw-semibold" style="font-size: 0.65rem; letter-spacing: 0.5px;">{{ Auth::user()->role }}</p>
                    </div>
                    <div class="user-img d-flex align-items-center">
                        <div class="avatar avatar-md border border-2 border-primary shadow-sm" style="width: 40px; height: 40px;">
                            <div class="bg-primary text-white d-flex align-items-center justify-content-center h-100 w-100 rounded-circle fw-bold">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 py-2 mt-2" style="min-width: 200px; border-radius: 12px;">
                <li><h6 class="dropdown-header text-primary fw-bold text-uppercase small" style="letter-spacing: 1px;">Akun Saya</h6></li>
                <li><a class="dropdown-item py-2" href="{{ route('admin.profile') }}"><i class="bi bi-person-circle me-3 text-primary"></i> Profil Saya</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item py-2 text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form-header').submit();">
                        <i class="bi bi-box-arrow-right me-3"></i> Keluar
                    </a>
                    <form id="logout-form-header" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
</header>

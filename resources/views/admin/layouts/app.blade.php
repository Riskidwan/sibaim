<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — SIBAIM Admin</title>

    <link rel="icon" href="{{ asset('assets/static/images/logo/logoKab.Pemalang.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/static/images/logo/logoKab.Pemalang.png') }}" type="image/x-icon">
    
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/iconly.css') }}">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!-- Leaflet Draw CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <style>
        .sidebar-wrapper .menu .sidebar-title {
            padding: 1.5rem 1.5rem 0.5rem;
        }
    </style>

    @stack('styles')
</head>

<body>
    <script src="{{ asset('assets/static/js/initTheme.js') }}"></script>
    <div id="app">
        @include('admin.layouts.partials.sidebar')
        
        <div id="main">
            @include('admin.layouts.partials.header')
            
            <div class="page-heading d-flex justify-content-between align-items-center">
                <h3>@yield('title', 'Dashboard')</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@yield('title', 'Dashboard')</li>
                    </ol>
                </nav>
            </div>

            <div class="page-content">
                @yield('content')
            </div>

            @include('admin.layouts.partials.footer')
        </div>
    </div>

    <!-- Need: Bootstrap + App -->
    <script src="{{ asset('assets/static/js/components/dark.js') }}"></script>
    <script src="{{ asset('assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/compiled/js/app.js') }}"></script>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.js"></script>

    <script>
        // Toast logic (compatible with Mazer aesthetics)
        function showToast(message, type = 'success') {
            // Using a simple alert for now, but Mazer has better options if extensions are included
            // For now let's use a simple div based toast if possible, or browser alert as fallback
            const toastId = 'toast-' + Math.random().toString(36).substr(2, 9);
            const bgColor = type === 'success' ? '#198754' : '#dc3545';
            
            const toastHtml = `
                <div id="${toastId}" class="toast show align-items-center text-white border-0" role="alert" aria-live="assertive" aria-atomic="true" 
                     style="position: fixed; top: 20px; right: 20px; z-index: 9999; background-color: ${bgColor}; min-width: 250px;">
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} me-2"></i>
                            ${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close" onclick="document.getElementById('${toastId}').remove()"></button>
                    </div>
                </div>
            `;
            
            document.body.insertAdjacentHTML('beforeend', toastHtml);
            
            setTimeout(() => {
                const toastElement = document.getElementById(toastId);
                if (toastElement) {
                    toastElement.classList.remove('show');
                    setTimeout(() => toastElement.remove(), 500);
                }
            }, 5000);
        }

        // Handle Laravel flash messages
        window.addEventListener('DOMContentLoaded', () => {
            @if(session('success'))
                showToast("{{ session('success') }}", 'success');
            @endif
            @if(session('error'))
                showToast("{{ session('error') }}", 'error');
            @endif
        });
    </script>

    {{-- ===== GLOBAL ANTI DOUBLE-SUBMIT PROTECTION ===== --}}
    {{-- Applies automatically to ALL forms with submit buttons in the admin panel --}}
    <script>
        (function () {
            'use strict';

            /**
             * Melindungi satu form dari double-submit.
             * - Menyisipkan spinner di tombol submit pertama setelah klik
             * - Men-disable semua button[type=submit] di form tersebut
             * - Menggunakan flag data-submitting agar tidak double-fire
             * @param {HTMLFormElement} form
             */
            function protectForm(form) {
                // Jangan lindungi form hapus (onsubmit confirm) — cukup konfirmasi native
                // Kita tetap melindunginya tapi hanya setelah user confirm (handled by native browser)
                form.addEventListener('submit', function (e) {
                    // Jika sudah dalam proses submit, tolak
                    if (form.dataset.submitting === 'true') {
                        e.preventDefault();
                        e.stopImmediatePropagation();
                        return false;
                    }

                    // Cek validitas form dari sisi browser dahulu
                    if (!form.checkValidity()) {
                        return; // Biarkan browser tampilkan pesan validasi
                    }

                    // Tandai sedang submit
                    form.dataset.submitting = 'true';

                    // Cari semua tombol submit di form ini
                    const submitBtns = form.querySelectorAll('button[type="submit"]');
                    submitBtns.forEach(function (btn) {
                        // Simpan label asli
                        if (!btn.dataset.originalHtml) {
                            btn.dataset.originalHtml = btn.innerHTML;
                        }

                        // Ganti isi button dengan spinner (khusus btn-primary/danger, bukan btn-outline-danger untuk hapus kecil)
                        const isMainSubmit = btn.classList.contains('btn-primary') || 
                                            (btn.classList.contains('btn-danger') && !btn.classList.contains('btn-sm') && !btn.classList.contains('btn-outline-danger'));
                        
                        if (isMainSubmit) {
                            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>Menyimpan...';
                        }

                        btn.disabled = true;
                    });
                });
            }

            /**
             * Daftarkan perlindungan untuk semua form yang ada saat ini.
             * Juga pasang MutationObserver untuk form yang ditambahkan secara dinamis (modal).
             */
            function initAll() {
                // Form statis yang sudah ada saat halaman dimuat
                document.querySelectorAll('form').forEach(protectForm);

                // Form dinamis (contoh: Bootstrap Modal dengan form di dalamnya)
                const observer = new MutationObserver(function (mutations) {
                    mutations.forEach(function (mutation) {
                        mutation.addedNodes.forEach(function (node) {
                            if (node.nodeType !== 1) return; // bukan element
                            if (node.tagName === 'FORM') {
                                protectForm(node);
                            } else {
                                node.querySelectorAll && node.querySelectorAll('form').forEach(protectForm);
                            }
                        });
                    });
                });

                observer.observe(document.body, { childList: true, subtree: true });

                // Reset flag ketika modal Bootstrap ditutup (agar bisa dipakai ulang)
                document.addEventListener('hidden.bs.modal', function (e) {
                    const forms = e.target.querySelectorAll('form');
                    forms.forEach(function (form) {
                        form.dataset.submitting = 'false';
                        // Kembalikan tombol ke kondisi normal
                        const submitBtns = form.querySelectorAll('button[type="submit"]');
                        submitBtns.forEach(function (btn) {
                            btn.disabled = false;
                            if (btn.dataset.originalHtml) {
                                btn.innerHTML = btn.dataset.originalHtml;
                            }
                        });
                        // Reset juga isian form jika form tambah (bukan edit)
                        // Heuristik: form yang tidak punya @method('PUT') atau @method('DELETE')
                        const methodInput = form.querySelector('input[name="_method"]');
                        if (!methodInput || methodInput.value === '') {
                            form.reset();
                        }
                    });
                });
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initAll);
            } else {
                initAll();
            }
        })();
    </script>

    @stack('scripts')
</body>

</html>

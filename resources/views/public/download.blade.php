@extends('public.layouts.app')
@section('title', 'Pusat Unduhan (Download Center)')

@push('styles')
<style>
    body { padding-top: 80px; background: #f8fafc; }
    .page-header {
        background: white;
        padding: 40px 30px;
        border-radius: 16px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        margin-bottom: 30px;
        text-align: center;
        border: 1px solid rgba(0,0,0,0.05);
    }
    
    .search-card {
        background: white;
        border-radius: 16px;
        padding: 25px;
        margin-bottom: 30px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(0,0,0,0.05);
    }

    .search-input-group {
        position: relative;
        max-width: 600px;
        margin: 0 auto;
    }

    .search-input-group i {
        position: absolute;
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 1.1rem;
    }

    .search-control {
        width: 100%;
        padding: 14px 20px 14px 50px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        outline: none;
        font-size: 1rem;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    .search-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
    }

    .download-table-container {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 30px -10px rgba(0,0,0,0.1);
        border: 1px solid rgba(0,0,0,0.05);
    }

    .table { margin-bottom: 0; }
    .table thead th {
        background: #f1f5f9;
        color: #475569;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        padding: 18px 25px;
        border-bottom: none;
    }

    .table tbody td {
        padding: 20px 25px;
        vertical-align: middle;
        color: #334155;
        border-color: #f1f5f9;
    }

    .table tbody tr:last-child td { border-bottom: none; }
    .table tbody tr:hover { background: #f8fafc; }

    .doc-type-badge {
        font-size: 0.7rem;
        font-weight: 800;
        padding: 4px 10px;
        border-radius: 6px;
        text-transform: uppercase;
    }

    .badge-psu { background: #fef9c3; color: #854d0e; }
    .badge-template { background: #f3e8ff; color: #6b21a8; }
    .badge-umum { background: #f1f5f9; color: #475569; }

    .doc-title {
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 4px;
        font-size: 1rem;
    }

    .doc-meta {
        font-size: 0.85rem;
        color: #64748b;
    }

    .btn-download-pro {
        padding: 10px 18px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-download-pro:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    @media (max-width: 768px) {
        .page-header { padding: 30px 20px; }
        .table thead { display: none; }
        .table tbody td {
            display: block;
            padding: 10px 20px;
            border: none;
            text-align: center;
        }
        .table tbody tr {
            padding: 20px 0;
            display: block;
            border-bottom: 1px solid #f1f5f9;
        }
        .btn-download-pro { width: 100%; justify-content: center; }
    }
</style>
@endpush

@section('content')
<div class="container" style="min-height: 80vh; margin-top: 40px; margin-bottom: 60px;">
    <div class="page-header">
        <h2 style="font-weight: 800; color: #0f172a; margin-bottom: 10px;">Pusat Unduhan Terpadu</h2>
        <p style="color: #64748b; font-size: 1.1rem; max-width: 700px; margin: 0 auto;">Cari dan unduh seluruh dokumen kebijakan, teknis, dan surat keputusan secara instan.</p>
    </div>

    <!-- SEARCH BAR -->
    <div class="search-card">
        <div class="search-input-group">
            <i class="fas fa-search"></i>
            <input type="text" id="downloadSearch" class="search-control" placeholder="Cari nama dokumen, tahun, atau nomor SK...">
        </div>
    </div>

    <!-- DATA TABLE -->
    <div class="download-table-container">
        <div class="table-responsive">
            <table class="table" id="downloadTable">
                <thead>
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th width="35%">Nama File & Kategori</th>
                        <th width="35%">Deskripsi</th>
                        <th width="10%">Tahun</th>
                        <th width="15%" class="text-center">File Download</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    
                    {{-- Unified Public Downloads --}}
                    @foreach($publicDownloads as $item)
                    <tr class="download-row">
                        <td class="text-center fw-bold text-muted">{{ $no++ }}</td>
                        <td>
                            <div class="doc-title">{{ $item->title }}</div>
                            @php
                                $badgeClass = match($item->kategori) {
                                    'Template PSU'  => 'badge-template',
                                    'Permohonan PSU' => 'badge-psu',
                                    default         => 'badge-umum'
                                };
                            @endphp
                            <span class="doc-type-badge {{ $badgeClass }}">{{ $item->kategori }}</span>
                        </td>
                        <td>
                            <div class="small text-muted">{{ $item->description ?? '-' }}</div>
                        </td>
                        <td>{{ $item->tanggal ? $item->tanggal->format('Y') : '-' }}</td>
                        <td class="text-center">
                            <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="btn btn-sm btn-primary btn-download-pro text-white">
                                <i class="fas fa-download"></i> Unduh
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div id="noResults" class="p-5 text-center d-none">
            <i class="fas fa-search mb-3" style="font-size: 3rem; color: #e2e8f0;"></i>
            <h5 class="text-muted">Tidak menemukan dokumen yang sesuai dengan kata kunci Anda.</h5>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById('downloadSearch');
    const table = document.getElementById('downloadTable');
    const rows = table.getElementsByClassName('download-row');
    const noResults = document.getElementById('noResults');

    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase();
        let visibleCount = 0;

        Array.from(rows).forEach(row => {
            const text = row.textContent.toLowerCase();
            if (text.includes(query)) {
                row.style.display = '';
                visibleCount++;
                // Re-index No column
                row.querySelector('td:first-child').textContent = visibleCount;
            } else {
                row.style.display = 'none';
            }
        });

        if (visibleCount === 0) {
            table.classList.add('d-none');
            noResults.classList.remove('d-none');
        } else {
            table.classList.remove('d-none');
            noResults.classList.add('d-none');
        }
    });

    // Handle initial hash search if needed
    let hash = window.location.hash.replace('#', '').replace('-', ' ');
    if (hash) {
        searchInput.value = hash;
        searchInput.dispatchEvent(new Event('input'));
    }
});
</script>
@endpush
@endsection

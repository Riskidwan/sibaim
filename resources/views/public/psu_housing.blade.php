@extends('public.layouts.app')
@section('title', 'Daftar Perumahan (PSU)')

@push('styles')
<style>
    body { padding-top: 100px; background: #f8fafc; }
    
    /* Global Compact Style */
    .housing-main-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        overflow: hidden;
        margin-bottom: 50px;
        border: 1px solid #e2e8f0;
    }

    .filter-bar {
        background: #fff;
        padding: 15px 25px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
    }

    .search-wrapper { position: relative; flex: 1; min-width: 300px; }
    .search-wrapper i { position: absolute; left: 15px; top: 52%; transform: translateY(-50%); color: #94a3b8; pointer-events: none; }
    
    .search-input {
        padding: 12px 15px 12px 42px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        width: 100%;
        font-size: 0.9rem;
        transition: all 0.2s;
        background: #fdfdfd;
    }
    .search-input:focus { border-color: #435ebe; outline: none; box-shadow: 0 0 0 3px rgba(67, 94, 190, 0.1); background: #fff; }

    .select-status { border-radius: 12px; font-size: 0.85rem; border: 1px solid #e2e8f0; padding: 11px 15px; cursor: pointer; min-width: 180px; }
    .select-status:focus { border-color: #435ebe; outline: none; }

    /* Table Styling */
    .premium-table { width: 100%; border-collapse: collapse; }
    .premium-table th {
        background: #f1f5f9;
        padding: 12px 20px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        color: #475569;
        text-align: left;
    }
    .premium-table td {
        padding: 12px 20px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.85rem;
    }
    .premium-table tr:hover td { background: #f8fafc; }
    .housing-name { font-weight: 700; color: #1e293b; display: block; }
    
    /* Modal Styling */
    .modal-content { border-radius: 16px; border: none; overflow: hidden; }
    .modal-header-hero { background: #435ebe; padding: 25px; color: #fff; position: relative; }
    .modal-close-custom { position: absolute; right: 15px; top: 15px; background: rgba(255,255,255,0.1); border: none; color: #fff; width: 28px; height: 28px; border-radius: 50%;}
    .modal-table { font-size: 0.9rem; }
    .modal-table th { background: #f8fafc; font-weight: 700; color: #475569; font-size: 0.75rem; text-transform: uppercase; }
    .status-badge-small { font-size: 0.65rem; padding: 2px 7px; border-radius: 4px; font-weight: 700; display: inline-block;}
</style>
@endpush

@section('content')
<div class="container">
    <div class="section-header text-center mb-4">
        <h2 class="fw-bold text-dark mb-1">Daftar Data Perumahan (PSU)</h2>
        <p class="text-secondary small">Informasi Prasarana, Sarana, dan Utilitas Kabupaten Pemalang</p>
    </div>

    <div class="housing-main-card">
        <!-- FILTER BAR -->
        <div class="filter-bar">
            <div class="search-wrapper">
                <form action="{{ route('public.psu-housing') }}" method="GET" id="filterForm">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" class="search-input" placeholder="Cari perumahan, pengembang, atau alamat..." value="{{ request('search') }}">
                    <input type="hidden" name="status" id="statusHidden" value="{{ request('status') }}">
                </form>
            </div>
            <div class="d-flex gap-2">
                <select class="form-select select-status" onchange="document.getElementById('statusHidden').value = this.value; document.getElementById('filterForm').submit();">
                    <option value="">Semua Status</option>
                    <option value="Sudah Serah Terima" {{ request('status') == 'Sudah Serah Terima' ? 'selected' : '' }}>Sudah Serah Terima</option>
                    <option value="Belum Serah Terima" {{ request('status') == 'Belum Serah Terima' ? 'selected' : '' }}>Belum Serah Terima</option>
                </select>
                @if(request('search') || request('status'))
                    <a href="{{ route('public.psu-housing') }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center px-3" style="border-radius: 10px;"><i class="fas fa-undo me-2"></i> Reset</a>
                @endif
            </div>
        </div>

        <!-- TABLE -->
        <div class="table-responsive">
            <table class="premium-table">
                <thead>
                    <tr>
                        <th style="width: 60px; text-align: center;">No</th>
                        <th>Perumahan & Pengembang</th>
                        <th>Lokasi / Alamat</th>
                        <th>No. BA Serah Terima</th>
                        <th>Status</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($housings as $item)
                    <tr>
                        <td style="text-align: center; color: #94a3b8; font-weight: 600;">{{ $housings->firstItem() + $loop->index }}</td>
                        <td>
                            <span class="housing-name">{{ $item->nama_perumahan }}</span>
                            <span class="text-secondary small">{{ $item->nama_pengembang }}</span>
                        </td>
                        <td>
                            <div class="text-dark small">{{ Str::limit($item->alamat, 40) }}</div>
                        </td>
                        <td><small class="text-primary fw-600">{{ $item->no_ba_serah_terima ?: '-' }}</small></td>
                        <td>
                            @if($item->status_serah_terima === 'Sudah Serah Terima')
                                <div class="badge-status badge-sudah">Sudah Terima</div>
                            @else
                                <div class="badge-status badge-belum">Belum Terima</div>
                            @endif
                        </td>
                        <td style="text-align: center;">
                            @if($item->status_serah_terima === 'Sudah Serah Terima')
                                <button type="button" class="btn-detail-trigger" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#housingModal"
                                    data-name="{{ $item->nama_perumahan }}"
                                    data-addr="{{ $item->alamat }}"
                                    data-dev="{{ $item->nama_pengembang }}"
                                    data-ba="{{ $item->no_ba_serah_terima ?: '-' }}"
                                    data-lahan="{{ $item->luas_lahan_m2 ?: '-' }}"
                                    data-total-psu="{{ $item->total_luas_psu ?: '-' }}"
                                    data-rumah="{{ $item->jumlah_rumah ?: '-' }}"
                                    data-prs='@json($item->prasarana ?: [])'
                                    data-srn='@json($item->sarana ?: [])'
                                    data-utl='@json($item->utilitas ?: [])'>
                                    Detail
                                </button>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-5 text-center text-secondary">
                            <i class="fas fa-search fa-2x opacity-25 mb-3"></i>
                            <p class="mb-0">Data perumahan tidak ditemukan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-4 py-3 border-top d-flex justify-content-between align-items-center">
            <div class="text-secondary small">
                Data <strong>{{ $housings->firstItem() ?? 0 }}</strong> - <strong>{{ $housings->lastItem() ?? 0 }}</strong> dari <strong>{{ $housings->total() }}</strong> Hasil
            </div>
            <div>
                {{ $housings->appends(request()->input())->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<!-- SINGLE DYNAMIC MODAL -->
<div class="modal fade" id="housingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header-hero">
                <h6 class="modal-title-small fw-bold opacity-75" style="text-transform: uppercase;">Detail Inventaris PSU</h6>
                <h3 class="fw-bold mb-0" id="m-name">Nama Perumahan</h3>
                <p class="mb-0 mt-2 opacity-90 fw-semibold"><i class="fas fa-map-marker-alt me-1"></i> <span id="m-addr">Alamat</span></p>
                <button type="button" class="modal-close-custom" data-bs-dismiss="modal"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-3 mb-4">
                    <div class="col-md-3 text-center">
                        <div class="p-2 border rounded-3 bg-white shadow-sm overflow-hidden h-100">
                            <div class="text-secondary small fw-bold mb-1" style="font-size: 0.6rem;">LUAS LAHAN</div>
                            <div class="small fw-bold text-dark" id="m-lahan">-</div>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="p-2 border rounded-3 bg-white shadow-sm overflow-hidden h-100">
                            <div class="text-secondary small fw-bold mb-1" style="font-size: 0.6rem;">LUAS PSU</div>
                            <div class="small fw-bold text-dark" id="m-total-psu">-</div>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="p-2 border rounded-3 bg-white shadow-sm overflow-hidden h-100">
                            <div class="text-secondary small fw-bold mb-1" style="font-size: 0.6rem;">JUMLAH RUMAH</div>
                            <div class="small fw-bold text-dark" id="m-rumah">-</div>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="p-2 border rounded-3 bg-white shadow-sm overflow-hidden h-100">
                            <div class="text-secondary small fw-bold mb-1" style="font-size: 0.6rem;">NOMOR BA</div>
                            <div class="small fw-bold text-primary text-truncate px-1" id="m-ba">-</div>
                        </div>
                    </div>
                </div>

                <style>
                    .cls-baik { background: #059669; color: white; }
                    .cls-sedang { background: #d97706; color: white; }
                    .cls-rusak { background: #dc2626; color: white; }
                    .cls-na { background: #64748b; color: white; }
                </style>

                <h6 class="fw-bold mb-3 small text-primary text-uppercase"><i class="fas fa-tools me-2"></i> Rincian Teknis PSU</h6>
                
                <div class="row g-3">
                    <div class="col-md-12">
                        <div class="card border rounded-3 overflow-hidden shadow-sm">
                            <table class="table modal-table mb-0" id="table-psu-combined">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-3 border-0">Item Inventaris PSU</th>
                                        <th style="width:100px" class="border-0">Kondisi</th>
                                        <th style="width:100px" class="border-0">Ukuran</th>
                                        <th class="pe-3 border-0">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('housingModal');
        const psuItemsMapping = {
            'prs': {'jaringan_jalan':'Jaringan Jalan','drainase':'Drainase','jaringan_persampahan':'PTST'},
            'srn': {'peribadatan':'Tempat Ibadah','pertamanan_rth':'Taman/RTH','lainnya':'Lainnya'}
        };

        modal.addEventListener('show.bs.modal', function(event) {
            const btn = event.relatedTarget;
            
            // Set header info
            document.getElementById('m-name').textContent = btn.getAttribute('data-name');
            document.getElementById('m-addr').textContent = btn.getAttribute('data-addr');
            document.getElementById('m-ba').textContent = btn.getAttribute('data-ba');
            document.getElementById('m-lahan').textContent = btn.getAttribute('data-lahan') + ' m²';
            document.getElementById('m-total-psu').textContent = btn.getAttribute('data-total-psu') + ' m²';
            document.getElementById('m-rumah').textContent = btn.getAttribute('data-rumah') + ' Unit';

            function getStatusBadge(st) {
                const cls = st === 'Baik' ? 'cls-baik' : (st === 'Sedang' ? 'cls-sedang' : (st === 'Rusak' ? 'cls-rusak' : 'cls-na'));
                return `<span class="status-badge-small ${cls}">${st}</span>`;
            }

            // Populate Section Data Helper
            function populateCombinedTable(tableId, mapping, btn) {
                const tbody = document.querySelector(`#${tableId} tbody`);
                tbody.innerHTML = '';
                
                // Process both Prasarana and Sarana
                Object.entries(mapping).forEach(([type, itemsMap]) => {
                    const rawDataJson = btn.getAttribute(`data-${type}`);
                    const data = JSON.parse(rawDataJson || '{}');
                    
                    Object.entries(itemsMap).forEach(([key, label]) => {
                        const val = data[key] || {};
                        const st = val.status || 'N/A';
                        const sz = val.ukuran || (typeof val === 'string' ? val : '-');
                        const ket = val.keterangan || '-';
                        tbody.innerHTML += `<tr>
                            <td class="ps-3 fw-bold text-dark">${label}</td>
                            <td>${getStatusBadge(st)}</td>
                            <td class="fw-bold text-dark" style="white-space: pre-line;">${sz}</td>
                            <td class="pe-3 text-dark" style="white-space: pre-line;">${ket}</td>
                        </tr>`;
                    });
                });
            }

            populateCombinedTable('table-psu-combined', psuItemsMapping, btn);
        });
    });
</script>
@endpush

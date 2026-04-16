@extends('admin.layouts.app')
@section('title', 'Edit Data Perumahan')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h4 class="card-title">Edit Data: {{ $housing->nama_perumahan }}</h4>
            <p class="text-subtitle text-muted">Perbarui data teknis dan informasi penyerahan PSU</p>
        </div>
        <a href="{{ route('admin.psu-housing.index') }}" class="btn btn-outline-secondary btn-sm">Batal</a>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.psu-housing.update', $housing->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- SECTION 1: Identitas Perumahan -->
            <div class="divider divider-left mt-3 mb-4">
                <div class="divider-text fw-bold text-uppercase small text-primary">
                    <i class="bi bi-house-door me-2"></i> Identitas Perumahan
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group mb-3">
                        <label for="nama_perumahan" class="form-label fw-semibold text-muted text-uppercase small">Nama Perumahan <span class="text-danger">*</span></label>
                        <input type="text" id="nama_perumahan" name="nama_perumahan" class="form-control" value="{{ old('nama_perumahan', $housing->nama_perumahan) }}" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group mb-3">
                        <label class="form-label fw-semibold text-muted text-uppercase small">Alamat Lengkap <span class="text-danger">*</span></label>
                        <textarea id="alamat" name="alamat" class="form-control" rows="3" required>{{ old('alamat', $housing->alamat) }}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="nama_pengembang" class="form-label fw-semibold text-muted text-uppercase small">Nama Pengembang <span class="text-danger">*</span></label>
                        <input type="text" id="nama_pengembang" name="nama_pengembang" class="form-control" value="{{ old('nama_pengembang', $housing->nama_pengembang) }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="no_ba_serah_terima" class="form-label fw-semibold text-muted text-uppercase small">No. BA Serah Terima</label>
                        <textarea id="no_ba_serah_terima" name="no_ba_serah_terima" class="form-control" rows="2" placeholder="Contoh: 600/123/2024 (Bisa input lebih dari satu)">{{ old('no_ba_serah_terima', $housing->no_ba_serah_terima) }}</textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label for="luas_lahan_m2" class="form-label fw-semibold text-muted text-uppercase small">Luas Lahan (m²)</label>
                        <input type="number" id="luas_lahan_m2" name="luas_lahan_m2" class="form-control" value="{{ old('luas_lahan_m2', $housing->luas_lahan_m2) }}" step="0.01">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label for="total_luas_psu" class="form-label fw-semibold text-muted text-uppercase small">Total Luas PSU (m²)</label>
                        <input type="number" id="total_luas_psu" name="total_luas_psu" class="form-control" value="{{ old('total_luas_psu', $housing->total_luas_psu) }}" step="0.01">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label for="jumlah_rumah" class="form-label fw-semibold text-muted text-uppercase small">Jumlah Rumah</label>
                        <input type="number" id="jumlah_rumah" name="jumlah_rumah" class="form-control" value="{{ old('jumlah_rumah', $housing->jumlah_rumah) }}">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group mb-3">
                        <label for="status_serah_terima" class="form-label fw-semibold text-muted text-uppercase small">Status Serah Terima <span class="text-danger">*</span></label>
                        <select id="status_serah_terima" name="status_serah_terima" class="form-select" required>
                            <option value="Belum Serah Terima" {{ old('status_serah_terima', $housing->status_serah_terima) == 'Belum Serah Terima' ? 'selected' : '' }}>Belum Serah Terima</option>
                            <option value="Sudah Serah Terima" {{ old('status_serah_terima', $housing->status_serah_terima) == 'Sudah Serah Terima' ? 'selected' : '' }}>Sudah Serah Terima</option>
                        </select>
                    </div>
                </div>
            </div>

            <div id="detail-psu-sections" style="display: none;" class="mt-5">
                <div class="divider divider-left mb-4">
                    <div class="divider-text fw-bold text-uppercase small text-success">
                        <i class="bi bi-clipboard-data me-2"></i> Detail Prasarana, Sarana & Utilitas
                    </div>
                </div>

                @php
                    $psuStructure = [
                        'prasarana' => [
                            'title' => 'DATA PRASARANA',
                            'items' => ['jaringan_jalan'=>'Jaringan Jalan','drainase'=>'Drainase','jaringan_persampahan'=>'PTST']
                        ],
                        'sarana' => [
                            'title' => 'DATA SARANA',
                            'items' => ['peribadatan'=>'Tempat Ibadah','pertamanan_rth'=>'Taman/RTH','lainnya'=>'Lainnya']
                        ]
                    ];
                @endphp

                <div class="row g-4">
                    <div class="col-12">
                        <div class="card shadow-none border rounded-3 overflow-hidden mb-0 h-100">
                            <div class="card-header bg-primary py-2 px-3 border-0">
                                <h6 class="mb-0 text-dark small fw-bold text-uppercase"><i class="bi bi-tools me-2"></i> Detail Teknis PSU</h6>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0" style="font-size: 0.85rem;">
                                        <thead class="bg-light">
                                            <tr>
                                                <th class="ps-3 border-0 py-2 text-dark fw-bold text-uppercase" style="font-size: 0.8rem; width: 35%;">Item Inventaris PSU</th>
                                                <th class="border-0 py-2 text-dark fw-bold text-uppercase text-center" style="font-size: 0.8rem; width: 22%;">Kondisi</th>
                                                <th class="border-0 py-2 text-dark fw-bold text-uppercase" style="font-size: 0.8rem; width: 20%;">Ukuran</th>
                                                <th class="pe-3 border-0 py-2 text-dark fw-bold text-uppercase" style="font-size: 0.8rem;">Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($psuStructure as $type => $config)
                                                @foreach($config['items'] as $key => $label)
                                                @php
                                                    $itemValue = $housing->$type[$key] ?? [];
                                                    $status = is_array($itemValue) ? ($itemValue['status'] ?? 'N/A') : 'N/A';
                                                    $ukuran = is_array($itemValue) ? ($itemValue['ukuran'] ?? '') : (is_string($itemValue) ? $itemValue : '');
                                                    $keterangan = is_array($itemValue) ? ($itemValue['keterangan'] ?? '') : '';
                                                @endphp
                                                <tr>
                                                    <td class="ps-3 fw-bold small">{{ $label }}</td>
                                                    <td class="text-center">
                                                        <select name="{{ $type }}[{{ $key }}][status]" class="form-select form-select-sm fw-bold" style="font-size: 0.75rem;">
                                                            @foreach($psuConditions as $cond)
                                                                <option value="{{ $cond->name }}" {{ old("$type.$key.status", $status) == $cond->name ? 'selected' : '' }}>{{ strtoupper($cond->name) }}</option>
                                                            @endforeach
                                                            <option value="N/A" {{ old("$type.$key.status", $status) == 'N/A' || !old("$type.$key.status", $status) ? 'selected' : '' }}>N/A</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <textarea name="{{ $type }}[{{ $key }}][ukuran]" class="form-control form-control-sm" rows="1" placeholder="Ukuran...">{{ old("$type.$key.ukuran", $ukuran) }}</textarea>
                                                    </td>
                                                    <td class="pe-3">
                                                        <textarea name="{{ $type }}[{{ $key }}][keterangan]" class="form-control form-control-sm" rows="1" placeholder="Keterangan...">{{ old("$type.$key.keterangan", $keterangan) }}</textarea>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12 d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.psu-housing.index') }}" class="btn btn-light-secondary">Batal</a>
                    <button type="submit" class="btn btn-warning text-dark"><i class="bi bi-pencil-square me-2"></i>Update Data</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Logic for conditional detail sections
        const statusSelect = document.getElementById('status_serah_terima');
        const detailSections = document.getElementById('detail-psu-sections');

        function toggleDetailSections() {
            if (statusSelect.value === 'Sudah Serah Terima') {
                detailSections.style.display = 'block';
            } else {
                detailSections.style.display = 'none';
            }
        }

        statusSelect.addEventListener('change', toggleDetailSections);
        toggleDetailSections();

        // Smart Navigation: Enter to move down, Ctrl+Enter for newline
        document.querySelectorAll('#detail-psu-sections textarea, #detail-psu-sections input').forEach(el => {
            el.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && !e.ctrlKey && !e.shiftKey) {
                    e.preventDefault();
                    const inputs = Array.from(document.querySelectorAll('#detail-psu-sections textarea, #detail-psu-sections input, #detail-psu-sections select'));
                    const index = inputs.indexOf(this);
                    if (index > -1 && inputs[index + 3]) {
                        inputs[index + 3].focus(); // Move to the same cell in the next row (3 inputs per row)
                    }
                }
            });
        });
    });
</script>
@endpush

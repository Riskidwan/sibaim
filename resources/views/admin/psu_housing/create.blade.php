@extends('admin.layouts.app')
@section('title', 'Tambah Data Perumahan')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h4 class="card-title">Tambah Data Perumahan Baru</h4>
            <p class="text-subtitle text-muted">Lengkapi data teknis perumahan dan detail PSU secara mendalam</p>
        </div>
        <a href="{{ route('admin.psu-housing.index') }}" class="btn btn-outline-secondary btn-sm">Batal</a>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.psu-housing.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
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
                        <input type="text" id="nama_perumahan" name="nama_perumahan" class="form-control" value="{{ old('nama_perumahan') }}" required placeholder="Contoh: Perumahan Puri Praja">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group mb-3">
                        <label for="alamat" class="form-label fw-semibold text-muted text-uppercase small">Alamat Lengkap <span class="text-danger">*</span></label>
                        <textarea id="alamat" name="alamat" class="form-control" rows="3" required placeholder="Masukkan alamat lengkap perumahan...">{{ old('alamat') }}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="nama_pengembang" class="form-label fw-semibold text-muted text-uppercase small">Nama Pengembang <span class="text-danger">*</span></label>
                        <input type="text" id="nama_pengembang" name="nama_pengembang" class="form-control" value="{{ old('nama_pengembang') }}" required placeholder="Masukkan nama pengembang">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="no_ba_serah_terima" class="form-label fw-semibold text-muted text-uppercase small">No. BA Serah Terima</label>
                        <textarea id="no_ba_serah_terima" name="no_ba_serah_terima" class="form-control" rows="2" placeholder="Contoh: 600/123/2024 (Bisa input lebih dari satu)">{{ old('no_ba_serah_terima') }}</textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label for="luas_lahan_m2" class="form-label fw-semibold text-muted text-uppercase small">Luas Lahan (m²)</label>
                        <input type="number" id="luas_lahan_m2" name="luas_lahan_m2" class="form-control" value="{{ old('luas_lahan_m2') }}" step="0.01">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label for="total_luas_psu" class="form-label fw-semibold text-muted text-uppercase small">Total Luas PSU (m²)</label>
                        <input type="number" id="total_luas_psu" name="total_luas_psu" class="form-control" value="{{ old('total_luas_psu') }}" step="0.01">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label for="jumlah_rumah" class="form-label fw-semibold text-muted text-uppercase small">Jumlah Rumah</label>
                        <input type="number" id="jumlah_rumah" name="jumlah_rumah" class="form-control" value="{{ old('jumlah_rumah') }}">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group mb-3">
                        <label for="status_serah_terima" class="form-label fw-semibold text-muted text-uppercase small">Status Serah Terima <span class="text-danger">*</span></label>
                        <select id="status_serah_terima" name="status_serah_terima" class="form-select" required>
                            <option value="Belum Serah Terima" {{ old('status_serah_terima') == 'Belum Serah Terima' ? 'selected' : '' }}>Belum Serah Terima</option>
                            <option value="Sudah Serah Terima" {{ old('status_serah_terima') == 'Sudah Serah Terima' ? 'selected' : '' }}>Sudah Serah Terima</option>
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
                
                <div class="row g-4">
                    <div class="col-12">
                        <div class="card shadow-none border rounded-3 overflow-hidden mb-0">
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
                                            @php 
                                                $psuStructure = [
                                                    'prasarana' =\u003e ['jaringan_jalan'=\u003e'Jaringan Jalan','drainase'=\u003e'Drainase','jaringan_persampahan'=\u003e'PTST'],
                                                    'sarana' =\u003e ['peribadatan'=\u003e'Tempat Ibadah','pertamanan_rth'=\u003e'Taman/RTH','lainnya'=\u003e'Lainnya']
                                                ]; 
                                            @endphp
                                            @foreach($psuStructure as $type =\u003e $items)
                                                @foreach($items as $key =\u003e $label)
                                                <tr>
                                                    <td class=\"ps-3 fw-bold small\">{{ $label }}</td>
                                                    <td>
                                                        <select name=\"{{ $type }}[{{ $key }}][status]\" class=\"form-select form-select-sm fw-bold\">
                                                            @foreach($psuConditions as $cond)
                                                                <option value=\"{{ $cond- \u003ename }}\" {{ old(\"$type.$key.status\") == $cond- \u003ename ? 'selected' : '' }}\u003e{{ strtoupper($cond- \u003ename) }}\u003c/option\u003e
                                                            @endforeach
                                                            <option value=\"N/A\" {{ old(\"$type.$key.status\") == 'N/A' || !old(\"$type.$key.status\") ? 'selected' : '' }}\u003eN/A\u003c/option\u003e
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <textarea name=\"{{ $type }}[{{ $key }}][ukuran]\" class=\"form-control form-control-sm\" rows=\"1\" placeholder=\"Ukuran...\"\u003e{{ old(\"$type.$key.ukuran\") }}\u003c/textarea\u003e
                                                    </td>
                                                    <td class=\"pe-3\">
                                                        <textarea name=\"{{ $type }}[{{ $key }}][keterangan]\" class=\"form-control form-control-sm\" rows=\"1\" placeholder=\"Keterangan...\"\u003e{{ old(\"$type.$key.keterangan\") }}\u003c/textarea\u003e
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
            </div>

            <div class="row mt-4">
                <div class="col-12 d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.psu-housing.index') }}" class="btn btn-light-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save me-2"></i>Simpan Data</button>
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
                        inputs[index + 3].focus(); // Move to the same column in the next row (since there are 3 inputs per row)
                    }
                }
            });
        });
    });
</script>
@endpush

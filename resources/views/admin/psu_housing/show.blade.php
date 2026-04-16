@extends('admin.layouts.app')
@section('title', 'Detail Perumahan - ' . $housing->nama_perumahan)

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="card-title">{{ $housing->nama_perumahan }}</h4>
                    <p class="text-subtitle text-muted">Informasi teknis dan status penyerahan PSU</p>
                </div>
                <div class="d-flex gap-2">
                    @if(!Auth::user()->isKepala())
                    <a href="{{ route('admin.psu-housing.edit', $housing->id) }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-pencil-square"></i> Edit Data
                    </a>
                    @endif
                    <a href="{{ route('admin.psu-housing.index') }}" class="btn btn-outline-secondary btn-sm">Kembali</a>
                </div>
            </div>

            <div class="card-body">
                @if($housing->status_serah_terima === 'Sudah Serah Terima')
                    <div class="alert alert-success d-flex align-items-center">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <div><strong>Telah Serah Terima:</strong> Seluruh fasilitas PSU telah diverifikasi dan diserahkan secara resmi.</div>
                    </div>
                @else
                    <div class="alert alert-secondary d-flex align-items-center">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        <div><strong>Belum Serah Terima:</strong> Dokumentasi serah terima PSU masih dalam proses.</div>
                    </div>
                @endif

                <div class="row mt-4">
                    <div class="col-md-6">
                        <table class="table table-sm">
                            <tbody>
                                <tr>
                                    <th class="text-muted" style="width: 40%;">Nama Perumahan</th>
                                    <td class="fw-bold">{{ $housing->nama_perumahan }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Pengembang</th>
                                    <td>{{ $housing->nama_pengembang }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Alamat</th>
                                    <td>{{ $housing->alamat }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">No. BA Serah Terima</th>
                                    <td class="fw-bold text-primary" style="white-space: pre-line;">{{ $housing->no_ba_serah_terima ?: '-' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm">
                            <tbody>
                                <tr>
                                    <th class="text-muted" style="width: 40%;">Luas Lahan</th>
                                    <td>{{ number_format($housing->luas_lahan_m2, 2) }} m²</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Total Luas PSU</th>
                                    <td>{{ number_format($housing->total_luas_psu, 2) }} m²</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Jumlah Rumah</th>
                                    <td>{{ number_format($housing->jumlah_rumah) }} Unit</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Status</th>
                                    <td>
                                        <span class="badge {{ $housing->status_serah_terima == 'Sudah Serah Terima' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $housing->status_serah_terima }}
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- PSU Inventory Sections -->
                <div class="divider divider-left mt-5">
                    <div class="divider-text fw-bold text-uppercase small"><i class="bi bi-clipboard-data me-2"></i> Rincian Inventaris PSU</div>
                </div>

                @php
                    $psuStructure = [
                        'prasarana' => ['title' => 'DATA PRASARANA', 'items' => ['jaringan_jalan'=>'Jaringan Jalan','drainase'=>'Drainase','jaringan_persampahan'=>'PTST']],
                        'sarana' => ['title' => 'DATA SARANA', 'items' => ['peribadatan'=>'Tempat Ibadah','pertamanan_rth'=>'Taman/RTH','lainnya'=>'Lainnya']]
                    ];
                @endphp

                <div class="row g-4">
                    <div class="col-12">
                        <div class="card shadow-none border mb-0">
                            <div class="card-header py-2 bg-light">
                                <h6 class="mb-0 small fw-bold"><i class="bi bi-tools me-2"></i> DETAIL TEKNIS PSU</h6>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover table-sm mb-0" style="font-size: 0.85rem;">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="ps-3 border-0 py-2">Item Inventaris PSU</th>
                                                <th class="text-center border-0 py-2" style="width: 120px;">Kondisi</th>
                                                <th class="border-0 py-2" style="width: 150px;">Ukuran</th>
                                                <th class="pe-3 border-0 py-2">Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($psuStructure as $type => $config)
                                                @foreach($config['items'] as $key => $label)
                                                    @php
                                                        $val = $housing->$type[$key] ?? null;
                                                        $status = is_array($val) ? ($val['status'] ?? 'N/A') : 'N/A';
                                                        $ukuran = is_array($val) ? ($val['ukuran'] ?? '-') : (is_string($val) ? $val : '-');
                                                        $keterangan = is_array($val) ? ($val['keterangan'] ?? '-') : '-';
                                                    @endphp
                                                    <tr>
                                                        <td class="ps-3 fw-bold">{{ $label }}</td>
                                                        <td class="text-center">
                                                            <span class="badge {{ match($status) {'Baik'=>'bg-success','Sedang'=>'bg-warning','Rusak'=>'bg-danger',default=>'bg-secondary'} }} small">
                                                                {{ strtoupper($status) }}
                                                            </span>
                                                        </td>
                                                        <td style="white-space: pre-line;">{{ $ukuran ?: '-' }}</td>
                                                        <td class="pe-3 text-muted" style="white-space: pre-line;">{{ $keterangan ?: '-' }}</td>
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
    </div>
</div>
@endsection

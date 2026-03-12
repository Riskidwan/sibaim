@extends('public.layouts.app')
@section('title', 'Cek Status Permohonan PSU')

@push('styles')
<style>
    .status-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        padding: 40px;
        margin-bottom: 50px;
    }
    .form-control {
        border-radius: 8px;
        padding: 12px;
        border: 1px solid #ddd;
    }
    .btn-check {
        background: #2563eb;
        color: white;
        padding: 12px 30px;
        border-radius: 8px;
        border: none;
        font-weight: 600;
        transition: all 0.3s;
    }
    .btn-check:hover {
        background: #1e40af;
        transform: translateY(-2px);
    }
    .status-result {
        margin-top: 30px;
        padding: 20px;
        border-radius: 12px;
        border: 1px solid #eef2ff;
    }
    .badge-status {
        padding: 6px 16px;
        border-radius: 999px;
        font-weight: 600;
        font-size: 0.9rem;
    }
    .status-verifikasi { background: #fef0c7; color: #915d0a; }
    .status-perbaikan { background: #fee4e2; color: #b42318; }
    .status-selesai { background: #ecfdf3; color: #027a48; }

    .retrieval-link {
        color: #2563eb;
        text-decoration: none;
        font-size: 0.9rem;
        cursor: pointer;
    }
    .retrieval-link:hover {
        text-decoration: underline;
    }

    #retrieval-results {
        margin-top: 15px;
        max-height: 200px;
        overflow-y: auto;
    }
    .retrieval-item {
        padding: 10px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.85rem;
    }
</style>
@endpush

@section('content')
<!-- ***** Spacer for Header ***** -->
<div style="height: 100px; background: #f7f7f7;"></div>

<section class="section" style="background: #f7f7f7; padding-top: 30px; min-height: 80vh;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading text-center" style="margin-bottom: 40px;">
                    <h2>Lacak Status Permohonan</h2>
                    <p style="margin-top: 15px; font-size: 15px; color: #666; max-width: 600px; margin-left: auto; margin-right: auto;">
                        Masukkan nomor registrasi Anda untuk mengetahui perkembangan proses verifikasi permohonan serah terima PSU.
                    </p>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="status-card">
                    @if(session('error'))
                        <div class="alert alert-danger" style="background-color: #fef3f2; color: #b42318; border: 1px solid #fecdca; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ url('/cek-status-psu') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label style="font-weight: 600; margin-bottom: 10px;">Nomor Registrasi</label>
                            <div class="input-group" style="display: flex; gap: 10px;">
                                <input type="text" name="no_registrasi" class="form-control" placeholder="Contoh: s-psu-ddmmyyyy-xxx" value="{{ isset($submission) ? $submission->no_registrasi : old('no_registrasi') }}" required style="flex: 1;">
                                <button type="submit" class="btn-check">
                                    <i class="fas fa-search"></i> Cek Status
                                </button>
                            </div>
                            <div style="margin-top: 10px; text-align: right;">
                                <span class="retrieval-link" data-toggle="modal" data-target="#retrievalModal">
                                    <i class="fas fa-question-circle"></i> Lupa nomor registrasi?
                                </span>
                            </div>
                        </div>
                    </form>

                    @if(isset($submission))
                        <div class="status-result">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                <h5 style="margin: 0; color: #1e3a8a;">Detail Permohonan</h5>
                                @if($submission->status === 'verifikasi dokumen')
                                    <span class="badge-status status-verifikasi">Dalam Proses Verifikasi</span>
                                @elseif($submission->status === 'perbaikan dokumen')
                                    <span class="badge-status status-perbaikan">Perlu Perbaikan</span>
                                @else
                                    <span class="badge-status status-selesai">BA Terima Terbit</span>
                                @endif
                            </div>

                            <table class="table table-borderless" style="margin: 0;">
                                <tr>
                                    <td style="width: 150px; font-weight: 600; padding: 8px 0;">Pemohon</td>
                                    <td style="padding: 8px 0;">: {{ $submission->nama_pemohon }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; padding: 8px 0;">Lokasi</td>
                                    <td style="padding: 8px 0;">: {{ $submission->lokasi_pembangunan }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; padding: 8px 0;">Tgl Pengajuan</td>
                                    <td style="padding: 8px 0;">: {{ $submission->created_at->format('d F Y') }}</td>
                                </tr>
                            </table>

                            @if($submission->status === 'perbaikan dokumen')
                                @if($submission->catatan_perbaikan)
                                    <div style="margin-top: 20px; padding: 15px; background: #fff1f2; border-left: 4px solid #e11d48; border-radius: 4px;">
                                        <h6 style="color: #9f1239; margin-bottom: 8px;"><i class="fas fa-edit"></i> Catatan Perbaikan:</h6>
                                        <p style="margin: 0; color: #444; font-size: 0.95rem;">{{ $submission->catatan_perbaikan }}</p>
                                    </div>
                                @endif
                                <div style="margin-top: 20px; text-align: center;">
                                    <a href="{{ url('/permohonan-psu/' . $submission->no_registrasi . '/edit') }}" class="btn-check" style="text-decoration: none; display: inline-block;">
                                        <i class="fas fa-edit"></i> Perbaiki Dokumen Sekarang
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Retrieval Modal -->
<div class="modal fade" id="retrievalModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div class="modal-header" style="border-bottom: 1px solid #f1f5f9;">
                <h5 class="modal-title" style="font-weight: 700;">Cari Nomor Registrasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 25px;">
                <p style="font-size: 0.9rem; color: #666; margin-bottom: 20px;">Masukkan nama pemohon dan lokasi pembangunan sesuai saat melakukan pendaftaran.</p>
                <div class="form-group">
                    <label style="font-size: 0.85rem; font-weight: 600;">Nama Pemohon</label>
                    <input type="text" id="find_nama" class="form-control" placeholder="Contoh: PT. Developer Jaya">
                </div>
                <div class="form-group">
                    <label style="font-size: 0.85rem; font-weight: 600;">Lokasi Pembangunan</label>
                    <input type="text" id="find_lokasi" class="form-control" placeholder="Contoh: Kelurahan Pemalang">
                </div>
                <button type="button" id="btn-find-id" class="btn-check" style="width: 100%; margin-top: 10px;">
                    <i class="fas fa-search"></i> Cari Data
                </button>

                <div id="retrieval-results" style="display: none;">
                    <!-- Results will be injected here -->
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('btn-find-id').addEventListener('click', function() {
        const nama = document.getElementById('find_nama').value;
        const lokasi = document.getElementById('find_lokasi').value;
        const resultsDiv = document.getElementById('retrieval-results');
        
        if (!nama || !lokasi) {
            alert('Mohon isi nama dan lokasi.');
            return;
        }

        this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mencari...';
        this.disabled = true;

        fetch('{{ url("/cari-registrasi-psu") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ nama_pemohon: nama, lokasi_pembangunan: lokasi })
        })
        .then(response => response.json())
        .then(data => {
            this.innerHTML = '<i class="fas fa-search"></i> Cari Data';
            this.disabled = false;
            resultsDiv.style.display = 'block';
            
            if (data.success) {
                let html = '<div style="margin-top: 15px; font-weight: 600; font-size: 0.9rem; color: #1e40af;">Hasil Ditemukan:</div>';
                data.data.forEach(item => {
                    html += `
                        <div class="retrieval-item">
                            <div style="font-weight: 700; color: #2563eb;">${item.no_registrasi}</div>
                            <div style="font-size: 0.75rem; color: #64748b;">${item.nama_pemohon} - ${item.lokasi_pembangunan}</div>
                        </div>
                    `;
                });
                resultsDiv.innerHTML = html;
            } else {
                resultsDiv.innerHTML = '<div style="color: #dc2626; text-align: center; padding: 10px; font-size: 0.9rem;">' + data.message + '</div>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            this.innerHTML = '<i class="fas fa-search"></i> Cari Data';
            this.disabled = false;
        });
    });
</script>
@endpush
@endsection

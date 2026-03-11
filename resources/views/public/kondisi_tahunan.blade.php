@extends('public.layouts.app')
@section('title', 'Kondisi Jalan Tahunan')

@push('styles')
  <style>
    .report-card {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
      padding: 40px;
      margin-bottom: 50px;
    }

    .table th {
      border-top: none;
      color: #555;
      font-weight: 600;
      padding-bottom: 15px;
    }

    .table td {
      vertical-align: middle;
      padding: 15px 10px;
      color: #666;
    }

    .btn-download-pdf {
      background-color: #dc3545;
      color: white;
      border-radius: 5px;
      padding: 8px 16px;
      transition: all 0.3s ease;
      text-decoration: none;
      display: inline-block;
      font-weight: 500;
      font-size: 14px;
    }

    .btn-download-pdf:hover {
      background-color: #c82333;
      color: white;
      transform: translateY(-2px);
      box-shadow: 0 4px 10px rgba(220, 53, 69, 0.3);
    }
  </style>
@endpush

@section('content')
  <!-- ***** Spacer for Header ***** -->
  <div style="height: 100px; background: #f7f7f7;"></div>

  <!-- ***** Laporan Kondisi Jalan Section Start ***** -->
  <section class="section" id="laporan-tahunan" style="background: #f7f7f7; padding-top: 30px; min-height: 70vh;">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="section-heading text-center" style="margin-bottom: 40px;">
            <h6>Dokumen & Publikasi</h6>
            <h2>Laporan Kondisi Jalan Tahunan</h2>
            <p
              style="margin-top: 15px; font-size: 15px; color: #666; max-width: 800px; margin-left: auto; margin-right: auto;">
              Arsip laporan rutin kondisi kerusakan dan kemantapan ruas jalan lingkungan Kabupaten Pemalang dari tahun ke
              tahun. Anda dapat mengunduh dokumen versi PDF pada tabel di bawah.
            </p>
          </div>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-lg-10">
          <div class="report-card">

            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col" style="width: 15%; text-align: center;">Tahun</th>
                    <th scope="col" style="width: 60%;">Judul Dokumen Laporan</th>
                    <th scope="col" style="width: 25%; text-align: center;">Aksi Unduh</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($reports as $report)
                    <tr>
                      <td style="text-align: center; font-size: 18px; font-weight: 700; color: #333;">
                        {{ $report->year }}
                      </td>
                      <td style="font-size: 16px; font-weight: 500;">
                        {{ $report->title }}
                      </td>
                      <td style="text-align: center;">
                        <a href="{{ asset('storage/' . $report->file_path) }}" target="_blank" class="btn-download-pdf">
                          <i class="fas fa-file-pdf" style="margin-right: 5px;"></i> Unduh PDF
                        </a>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="3" style="text-align: center; padding: 40px 0; color: #999;">
                        <i class="fas fa-folder-open fa-3x" style="margin-bottom: 15px; color: #ddd;"></i><br>
                        Belum ada arsip dokumen laporan yang diunggah.
                      </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- ***** Laporan Kondisi Jalan Section End ***** -->

@endsection
@extends('public.layouts.app')
@section('title', 'SK Jalan Lingkungan')

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
      background-color: #2563eb;
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
      background-color: #1e40af;
      color: white;
      transform: translateY(-2px);
      box-shadow: 0 4px 10px rgba(37, 99, 235, 0.3);
    }
  </style>
@endpush

@section('content')
  <!-- ***** Spacer for Header ***** -->
  <div style="height: 100px; background: #f7f7f7;"></div>

  <!-- ***** SK Jalan Lingkungan Section Start ***** -->
  <section class="section" id="sk-jalan-lingkungan" style="background: #f7f7f7; padding-top: 30px; min-height: 70vh;">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="section-heading text-center" style="margin-bottom: 40px;">
            <h2>SK Jalan Lingkungan</h2>
            <p
              style="margin-top: 15px; font-size: 15px; color: #666; max-width: 800px; margin-left: auto; margin-right: auto;">
              Arsip Surat Keputusan (SK) penetapan ruas jalan lingkungan Kabupaten Pemalang. Anda dapat mengunduh dokumen versi PDF pada tabel di bawah.
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
                    <th scope="col" style="width: 60%;">Judul SK</th>
                    <th scope="col" style="width: 25%; text-align: center;">Aksi Unduh</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($sk_items as $sk)
                    <tr>
                      <td style="text-align: center; font-size: 18px; font-weight: 700; color: #333;">
                        {{ $sk->year }}
                      </td>
                      <td style="font-size: 16px; font-weight: 500;">
                        {{ $sk->title }}
                      </td>
                      <td style="text-align: center;">
                        <a href="{{ asset('storage/' . $sk->file_path) }}" target="_blank" class="btn-download-pdf">
                          <i class="fas fa-file-pdf" style="margin-right: 5px;"></i> Unduh PDF
                        </a>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="3" style="text-align: center; padding: 40px 0; color: #999;">
                        <i class="fas fa-folder-open fa-3x" style="margin-bottom: 15px; color: #ddd;"></i><br>
                        Belum ada arsip SK yang diunggah.
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
  <!-- ***** SK Jalan Lingkungan Section End ***** -->

@endsection

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $recentGalleries = \App\Models\GaleriImage::with('kegiatan')
                                ->whereHas('kegiatan', function($q) {
                                    $q->where('is_active', true);
                                })
                                ->latest()
                                ->take(6)
                                ->get();
        
        $totalPsuSubmissions = \App\Models\PsuHousing::where('status_serah_terima', 'Sudah Serah Terima')->count();
        $totalPsuNotYet = \App\Models\PsuHousing::where('status_serah_terima', 'Belum Serah Terima')->count();
        $totalHousings = \App\Models\PsuHousing::count();
        $totalJalans = \App\Models\DataJalan::where('is_public', true)->count();

        return view('public.index', compact(
            'recentGalleries', 
            'totalPsuSubmissions', 
            'totalPsuNotYet',
            'totalHousings',
            'totalJalans'
        ));
    }

    public function galeri($category = null)
    {
        $query = \App\Models\GaleriKegiatan::with('images')->where('is_active', true);
        
        $title = 'Galeri Kegiatan';
        if ($category && in_array($category, ['berita', 'kunjungan', 'rapat', 'sosialisasi'])) {
            $query->where('kategori', $category);
            $labels = [
                'berita' => 'Berita Bergambar',
                'kunjungan' => 'Kunjungan Kerja',
                'rapat' => 'Rapat Koordinasi',
                'sosialisasi' => 'Sosialisasi'
            ];
            $title = 'Galeri: ' . $labels[$category];
        }

        $galleries = $query->orderBy('created_at', 'desc')->get();
                        
        return view('public.galeri', compact('galleries', 'category', 'title'));
    }

    public function downloadCenter()
    {
        $publicDownloads = \App\Models\PublicDownload::where('is_active', true)
                                ->orderBy('kategori')
                                ->orderBy('tanggal', 'desc')
                                ->get();

        return view('public.download', compact('publicDownloads'));
    }

    public function dataPerumahan(Request $request)
    {
        $query = \App\Models\PsuHousing::query();

        // Filter by Status
        if ($request->filled('status')) {
            $query->where('status_serah_terima', $request->status);
        }

        // Search Logic
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_perumahan', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%")
                  ->orWhere('no_ba_serah_terima', 'like', "%{$search}%")
                  ->orWhere('nama_pengembang', 'like', "%{$search}%");
            });
        }

        // Statistics for dashboard cards
        $totalCount = \App\Models\PsuHousing::count();
        $sudahCount = \App\Models\PsuHousing::where('status_serah_terima', 'Sudah Serah Terima')->count();
        $belumCount = \App\Models\PsuHousing::where('status_serah_terima', 'Belum Serah Terima')->count();

        $housings = $query->latest()->paginate(12);
        
        return view('public.psu_housing', compact(
            'housings', 
            'totalCount', 
            'sudahCount', 
            'belumCount'
        ));
    }
    public function dataJalan(Request $request)
    {
        $query = \App\Models\DataJalan::where('is_public', true);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_jalan',  'like', "%{$search}%")
                  ->orWhere('kecamatan', 'like', "%{$search}%")
                  ->orWhere('kelurahan', 'like', "%{$search}%");
            });
        }

        $totalJalan      = \App\Models\DataJalan::where('is_public', true)->count();
        $totalKecamatan  = \App\Models\DataJalan::where('is_public', true)->distinct('kecamatan')->count();

        $jalans = $query->orderBy('kecamatan')->orderBy('nama_jalan')->paginate(15);

        return view('public.data_jalan', compact('jalans', 'totalJalan', 'totalKecamatan'));
    }

}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PsuSubmission;
use App\Models\PsuHousing;
use App\Models\DataJalan;

class DashboardController extends Controller
{
    public function index()
    {
        // PSU Stats
        $psuTotalCount   = PsuSubmission::count();
        $psuPendingCount = PsuSubmission::where('status', 'verifikasi dokumen')->count();
        $housingCount    = PsuHousing::count();
        $roadCount       = DataJalan::count();

        $recentPsu = PsuSubmission::latest()->take(5)->get();

        // Recent Activity from ActivityLog table
        $recentActivity = \App\Models\ActivityLog::with('user')
            ->latest()
            ->take(6)
            ->get()
            ->map(function ($log) {
                $modelNames = [
                    'App\Models\PsuSubmission'  => 'Permohonan PSU',
                    'App\Models\PsuHousing'     => 'Data Perumahan',
                    'App\Models\PublicDownload'  => 'Pusat Unduhan',
                    'App\Models\GaleriKegiatan'  => 'Galeri Kegiatan',
                    'App\Models\User'            => 'Akun Pengguna',
                    'App\Models\DataJalan'       => 'Data Jalan',
                ];

                $modelName = $modelNames[$log->model_type] ?? 'Data Sistem';

                $actions = [
                    'created' => ['icon' => 'bi-plus-circle-fill', 'color' => 'success', 'label' => 'Menambah'],
                    'updated' => ['icon' => 'bi-pencil-square',    'color' => 'primary',  'label' => 'Mengubah'],
                    'deleted' => ['icon' => 'bi-trash3-fill',      'color' => 'danger',   'label' => 'Menghapus'],
                ];

                $action = $actions[$log->event] ?? ['icon' => 'bi-dot', 'color' => 'secondary', 'label' => 'Melakukan aksi di'];

                return [
                    'icon_class' => $action['icon'],
                    'color'      => $action['color'],
                    'title'      => $action['label'] . ' ' . $modelName,
                    'user'       => $log->user ? $log->user->name : 'Sistem',
                    'time'       => $log->created_at->diffForHumans(),
                ];
            });

        return view('admin.dashboard.index', compact(
            'psuTotalCount', 'psuPendingCount', 'housingCount', 'roadCount',
            'recentPsu', 'recentActivity'
        ));
    }
}

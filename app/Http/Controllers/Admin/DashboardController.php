<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Road;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalJalan = Road::count();
        $totalPanjang = Road::sum('panjang');

        $kondisiCount = Road::select('kondisi', DB::raw('count(*) as total'))
            ->groupBy('kondisi')
            ->pluck('total', 'kondisi')
            ->toArray();

        $perkerasanCount = Road::select('jenis_perkerasan', DB::raw('count(*) as total'))
            ->groupBy('jenis_perkerasan')
            ->pluck('total', 'jenis_perkerasan')
            ->toArray();

        // Default missing keys for UI
        $kondisiCount = array_merge([
            'Baik' => 0, 'Sedang' => 0, 'Rusak Ringan' => 0, 'Rusak Berat' => 0
        ], $kondisiCount);

        return view('admin.dashboard.index', compact('totalJalan', 'totalPanjang', 'kondisiCount', 'perkerasanCount'));
    }
}

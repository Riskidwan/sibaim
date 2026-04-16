<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Get PSU submissions belonging to the logged in user
        $query = Auth::user()->psuSubmissions()->latest();

        // Count Stats (Pre-Filter)
        $totalCount = Auth::user()->psuSubmissions()->count();
        $runningCount = Auth::user()->psuSubmissions()
            ->whereIn('status', ['verifikasi dokumen', 'perbaikan dokumen', 'penugasan tim verifikasi'])
            ->count();
        $finishedCount = Auth::user()->psuSubmissions()
            ->where('status', 'BA terima terbit')
            ->count();
        $cancelledCount = 0; // Currently no cancelled status in system

        // Filter by Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search Logic
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('no_registrasi', 'like', "%{$search}%")
                  ->orWhere('lokasi_pembangunan', 'like', "%{$search}%");
            });
        }

        // Paginate for the SIMBG look
        $submissions = $query->paginate(10);
        
        return view('public.dashboard', compact(
            'submissions', 
            'totalCount', 
            'runningCount', 
            'finishedCount', 
            'cancelledCount'
        ));
    }
}

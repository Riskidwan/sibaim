<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $activities = ActivityLog::with('user')
            ->latest()
            ->paginate(25);

        return view('admin.activity_log.index', compact('activities'));
    }

    /**
     * Clear all logs.
     */
    public function clear()
    {
        ActivityLog::query()->delete();
        
        return redirect()->route('admin.activity-log.index')
            ->with('success', 'Semua riwayat aktivitas sistem telah berhasil dibersihkan.');
    }
}

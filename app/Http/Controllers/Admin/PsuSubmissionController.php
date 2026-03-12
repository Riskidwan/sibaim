<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PsuSubmission;
use Illuminate\Http\Request;

class PsuSubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $submissions = PsuSubmission::orderBy('created_at', 'desc')->get();
        return view('admin.psu.index', compact('submissions'));
    }

    /**
     * Display the specified resource.
     */
    public function show(PsuSubmission $psu_submission)
    {
        return view('admin.psu.show', ['submission' => $psu_submission]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PsuSubmission $psu_submission)
    {
        $request->validate([
            'status' => 'required|in:verifikasi dokumen,perbaikan dokumen,BA terima terbit',
            'catatan_perbaikan' => 'nullable|string',
        ]);

        $psu_submission->update([
            'status' => $request->status,
            'catatan_perbaikan' => $request->status === 'perbaikan dokumen' ? $request->catatan_perbaikan : null,
        ]);

        return redirect()->route('admin.psu-submissions.index')->with('success', 'Status permohonan berhasil diperbarui.');
    }
}

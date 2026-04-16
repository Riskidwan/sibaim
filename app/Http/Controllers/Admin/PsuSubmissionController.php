<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PsuSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Notifications\SubmissionStatusUpdated;

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
     * Show the form for editing the specified resource.
     */
    public function edit(PsuSubmission $psu_submission)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        if ($user->isKepala()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki hak untuk mengubah data ini.');
        }

        return view('admin.psu.edit', ['submission' => $psu_submission]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PsuSubmission $psu_submission)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        if ($user->isKepala()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki hak untuk memperbarui data ini.');
        }

        $request->validate([
            'nama_pemohon' => 'nullable|string|max:255',
            'lokasi_pembangunan' => 'nullable|string',
            'status' => 'required|in:verifikasi dokumen,perbaikan dokumen,penugasan tim verifikasi,BA terima terbit',
            'catatan_perbaikan' => 'nullable|string',
            'nomor_surat_ba' => 'nullable|string|required_if:status,BA terima terbit',
            'file_ba_terbit' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            // File updates from edit form
            'fc_ktp' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'fc_akta_pendirian' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'fc_sertifikat_tanah' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'siteplan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'daftar_psu_nilai' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'fc_imb_pbg' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'file_template_diisi' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,zip|max:10240',
        ]);

        $oldStatus = $psu_submission->status;
        $newStatus = $request->status;

        $data = [
            'status' => $newStatus,
            'catatan_perbaikan' => $request->status === 'perbaikan dokumen' ? $request->catatan_perbaikan : $psu_submission->catatan_perbaikan,
            'nomor_surat_ba' => $request->status === 'BA terima terbit' ? $request->nomor_surat_ba : $psu_submission->nomor_surat_ba,
        ];

        // Handle basic info if provided (from edit form)
        if ($request->has('nama_pemohon')) $data['nama_pemohon'] = $request->nama_pemohon;
        if ($request->has('lokasi_pembangunan')) $data['lokasi_pembangunan'] = $request->lokasi_pembangunan;

        // Handle Verification File
        if ($request->hasFile('file_ba_terbit')) {
            if ($psu_submission->file_ba_terbit) {
                Storage::disk('public')->delete($psu_submission->file_ba_terbit);
            }
            $data['file_ba_terbit'] = $request->file('file_ba_terbit')->store('psu/ba_terbit', 'public');
        }

        // Handle Submission Files (from edit form)
        $files = ['fc_ktp', 'fc_akta_pendirian', 'fc_sertifikat_tanah', 'siteplan', 'daftar_psu_nilai', 'fc_imb_pbg', 'file_template_diisi'];
        foreach ($files as $fileKey) {
            if ($request->hasFile($fileKey)) {
                // Delete old file
                if ($psu_submission->$fileKey) {
                    Storage::disk('public')->delete($psu_submission->$fileKey);
                }
                // Store new file
                $path = $request->file($fileKey)->store('psu_submissions', 'public');
                $data[$fileKey] = $path;
            }
        }

        if ($request->status === 'BA terima terbit' && $psu_submission->status !== 'BA terima terbit') {
            $housing = \App\Models\PsuHousing::where('nama_perumahan', $psu_submission->lokasi_pembangunan)->first();
            if ($housing) {
                $housing->update([
                    'status_serah_terima' => 'Sudah Serah Terima',
                    'no_ba_serah_terima' => $request->nomor_surat_ba,
                ]);
            }
        }

        $psu_submission->update($data);

        // Send Notification to User if status changed
        if ($oldStatus !== $newStatus && $psu_submission->user) {
            $psu_submission->user->notify(new SubmissionStatusUpdated($psu_submission, $oldStatus, $newStatus));
        }

        return redirect()->route('admin.psu-submissions.index')->with('success', 'Data permohonan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PsuSubmission $psu_submission)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        if ($user->isKepala()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki hak untuk menghapus data ini.');
        }

        // List of file fields to delete
        $fileFields = [
            'fc_ktp', 'fc_akta_pendirian', 'fc_sertifikat_tanah', 
            'siteplan', 'daftar_psu_nilai', 'fc_imb_pbg', 
            'file_template_diisi', 'file_ba_terbit'
        ];

        foreach ($fileFields as $field) {
            if ($psu_submission->$field) {
                Storage::disk('public')->delete($psu_submission->$field);
            }
        }

        $psu_submission->delete();

        return redirect()->route('admin.psu-submissions.index')->with('success', 'Data permohonan berhasil dihapus.');
    }
}

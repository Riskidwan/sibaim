<?php

namespace App\Http\Controllers;

use App\Models\PsuSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PsuSubmissionController extends Controller
{
    public function index()
    {
        return view('public.psu.create');
    }

    public function store(Request $request)
    {
        // ... (existing validation)
        $request->validate([
            'nama_pemohon' => 'required|string|max:255',
            'lokasi_pembangunan' => 'required|string',
            'fc_ktp' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'fc_akta_pendirian' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'fc_sertifikat_tanah' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'siteplan' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'daftar_psu_nilai' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'fc_imb_pbg' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'required' => 'Field :attribute wajib diisi.',
            'file' => 'Input :attribute harus berupa file.',
            'mimes' => 'Format file :attribute harus berupa pdf, jpg, jpeg, atau png.',
            'max' => 'Ukuran file :attribute maksimal 5MB.',
        ]);

        // Generate Registration Number
        $date = Carbon::now()->format('dmY');
        $lastSubmission = PsuSubmission::whereDate('created_at', Carbon::today())->count();
        $sequence = str_pad($lastSubmission + 1, 3, '0', STR_PAD_LEFT);
        $noRegistrasi = "s-psu-{$date}-{$sequence}";

        $data = $request->only(['nama_pemohon', 'lokasi_pembangunan']);
        $data['no_registrasi'] = $noRegistrasi;

        // Handle File Uploads
        $files = ['fc_ktp', 'fc_akta_pendirian', 'fc_sertifikat_tanah', 'siteplan', 'daftar_psu_nilai', 'fc_imb_pbg'];
        foreach ($files as $fileKey) {
            if ($request->hasFile($fileKey)) {
                $path = $request->file($fileKey)->store('psu_submissions', 'public');
                $data[$fileKey] = $path;
            }
        }

        PsuSubmission::create($data);

        return redirect()->back()->with('success', "Permohonan berhasil dikirim dengan Nomor Registrasi: <strong>{$noRegistrasi}</strong>. Silakan simpan nomor ini untuk pengecekan status.");
    }

    public function checkStatusView()
    {
        return view('public.psu.check_status');
    }

    public function checkStatus(Request $request)
    {
        $request->validate([
            'no_registrasi' => 'required|string',
        ]);

        $submission = PsuSubmission::where('no_registrasi', $request->no_registrasi)->first();

        if (!$submission) {
            return redirect()->back()->with('error', 'Nomor registrasi tidak ditemukan. Mohon periksa kembali.');
        }

        return view('public.psu.check_status', compact('submission'));
    }

    public function findRegistrationId(Request $request)
    {
        $request->validate([
            'nama_pemohon' => 'required|string',
            'lokasi_pembangunan' => 'required|string',
        ]);

        $submissions = PsuSubmission::where('nama_pemohon', 'LIKE', "%{$request->nama_pemohon}%")
            ->where('lokasi_pembangunan', 'LIKE', "%{$request->lokasi_pembangunan}%")
            ->get();

        if ($submissions->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan.']);
        }

        return response()->json(['success' => true, 'data' => $submissions]);
    }

    public function edit($no_registrasi)
    {
        $submission = PsuSubmission::where('no_registrasi', $no_registrasi)->firstOrFail();

        if ($submission->status !== 'perbaikan dokumen') {
            return redirect()->route('psu.check_status')->with('error', 'Permohonan ini tidak dalam status perbaikan.');
        }

        return view('public.psu.edit', compact('submission'));
    }

    public function update(Request $request, $no_registrasi)
    {
        $submission = PsuSubmission::where('no_registrasi', $no_registrasi)->firstOrFail();

        if ($submission->status !== 'perbaikan dokumen') {
            return redirect()->route('psu.check_status')->with('error', 'Aksi tidak diizinkan.');
        }

        $request->validate([
            'nama_pemohon' => 'required|string|max:255',
            'lokasi_pembangunan' => 'required|string',
            'fc_ktp' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'fc_akta_pendirian' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'fc_sertifikat_tanah' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'siteplan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'daftar_psu_nilai' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'fc_imb_pbg' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'mimes' => 'Format file :attribute harus berupa pdf, jpg, jpeg, atau png.',
            'max' => 'Ukuran file :attribute maksimal 5MB.',
        ]);

        $data = $request->only(['nama_pemohon', 'lokasi_pembangunan']);
        $data['status'] = 'verifikasi dokumen'; // Revert back to verification
        $data['catatan_perbaikan'] = null; // Clear feedback

        // Handle File Uploads (replace only if uploaded)
        $files = ['fc_ktp', 'fc_akta_pendirian', 'fc_sertifikat_tanah', 'siteplan', 'daftar_psu_nilai', 'fc_imb_pbg'];
        foreach ($files as $fileKey) {
            if ($request->hasFile($fileKey)) {
                // Delete old file
                if (Storage::disk('public')->exists($submission->$fileKey)) {
                    Storage::disk('public')->delete($submission->$fileKey);
                }
                // Store new file
                $path = $request->file($fileKey)->store('psu_submissions', 'public');
                $data[$fileKey] = $path;
            }
        }

        $submission->update($data);

        return redirect()->route('psu.check_status')->with('success', 'Permohonan berhasil diperbarui dan dikirim kembali untuk verifikasi.');
    }
}

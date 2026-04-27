<?php

namespace App\Http\Controllers;

use App\Models\PsuSubmission;
use App\Models\PublicDownload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Notifications\SubmissionReceived;
use Illuminate\Support\Facades\Auth;

class PsuSubmissionController extends Controller
{
    public function index()
    {
        $templates = PublicDownload::where('kategori', 'Template PSU')
                                    ->where('is_active', true)
                                    ->orderBy('created_at', 'desc')
                                    ->get();
        return view('public.psu.create', compact('templates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pemohon' => 'required|string|max:255',
            'lokasi_pembangunan' => 'required|string',
            'fc_ktp' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'fc_akta_pendirian' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'fc_sertifikat_tanah' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'siteplan' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'daftar_psu_nilai' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'fc_imb_pbg' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'file_template_diisi' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,zip|max:10240',
        ], [
            'required' => 'Bidang :attribute wajib diisi.',
            'mimes' => 'Format file :attribute tidak diizinkan. Gunakan PDF atau Gambar (JPG/PNG).',
            'max' => 'Ukuran file :attribute terlalu besar (Maks 5MB-10MB).',
        ]);

        // Generate Unique Registration Number (Hardened)
        $date = Carbon::now()->format('dmY');
        $lastSubmission = PsuSubmission::latest('id')->first();
        $lastSequence = 0;
        
        if ($lastSubmission && preg_match('/-(\d+)$/', $lastSubmission->no_registrasi, $matches)) {
            $lastSequence = (int) $matches[1];
        }

        $nextSequence = $lastSequence + 1;
        $noRegistrasi = "";
        
        // Loop to prevent collision
        do {
            $sequenceStr = str_pad($nextSequence, 3, '0', STR_PAD_LEFT);
            $noRegistrasi = "s-psu-{$date}-{$sequenceStr}";
            $exists = PsuSubmission::where('no_registrasi', $noRegistrasi)->exists();
            if ($exists) {
                $nextSequence++;
            }
        } while ($exists);

        $data = $request->only(['nama_pemohon', 'lokasi_pembangunan']);
        $data['no_registrasi'] = $noRegistrasi;
        $data['user_id'] = \Illuminate\Support\Facades\Auth::id();

        // Handle File Uploads
        $files = ['fc_ktp', 'fc_akta_pendirian', 'fc_sertifikat_tanah', 'siteplan', 'daftar_psu_nilai', 'fc_imb_pbg', 'file_template_diisi'];
        foreach ($files as $fileKey) {
            if ($request->hasFile($fileKey)) {
                $path = $request->file($fileKey)->store('psu_submissions', 'local');
                $data[$fileKey] = $path;
            }
        }
        $submission = PsuSubmission::create($data);

        // Auto-sync: Create PsuHousing record with status 'Belum Serah Terima'
        \App\Models\PsuHousing::firstOrCreate(
            ['nama_perumahan' => $data['lokasi_pembangunan']],
            [
                'alamat' => $data['lokasi_pembangunan'],
                'nama_pengembang' => $data['nama_pemohon'],
                'status_serah_terima' => 'Belum Serah Terima',
            ]
        );

        // Send Notification to User
        try {
            Auth::user()->notify(new SubmissionReceived($submission));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send PSU submission email: ' . $e->getMessage());
        }

        return redirect('/user/dashboard')->with('success', "Permohonan berhasil dikirim. No. Registrasi: {$noRegistrasi}");
    }

    public function edit($no_registrasi)
    {
        $submission = PsuSubmission::where('no_registrasi', $no_registrasi)
                                 ->where('user_id', \Illuminate\Support\Facades\Auth::id())
                                 ->firstOrFail();

        if ($submission->status !== 'perbaikan dokumen') {
            return redirect('/user/dashboard')->with('error', 'Permohonan ini tidak dalam status perbaikan.');
        }

        return view('public.psu.edit', compact('submission'));
    }

    public function update(Request $request, $no_registrasi)
    {
        $submission = PsuSubmission::where('no_registrasi', $no_registrasi)
                                 ->where('user_id', \Illuminate\Support\Facades\Auth::id())
                                 ->firstOrFail();

        if ($submission->status !== 'perbaikan dokumen') {
            return redirect('/user/dashboard')->with('error', 'Aksi tidak diizinkan.');
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
            'file_template_diisi' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,zip|max:10240',
        ], [
            'mimes' => 'Format file :attribute harus berupa pdf, jpg, jpeg, atau png.',
            'max' => 'Ukuran file :attribute maksimal 5MB.',
        ]);

        $data = $request->only(['nama_pemohon', 'lokasi_pembangunan']);
        $data['status'] = 'verifikasi dokumen'; // Revert back to verification
        $data['catatan_perbaikan'] = null; // Clear feedback

        // Validate that all rejected files are re-uploaded
        $files = ['fc_ktp', 'fc_akta_pendirian', 'fc_sertifikat_tanah', 'siteplan', 'daftar_psu_nilai', 'fc_imb_pbg', 'file_template_diisi'];
        foreach ($files as $fileKey) {
            if (!$submission->$fileKey && !$request->hasFile($fileKey)) {
                return back()->withErrors([$fileKey => "Berkas ini wajib diunggah kembali karena sebelumnya telah ditolak/dihapus oleh Admin."])->withInput();
            }
        }

        // Handle File Uploads (replace only if uploaded)
        $files = ['fc_ktp', 'fc_akta_pendirian', 'fc_sertifikat_tanah', 'siteplan', 'daftar_psu_nilai', 'fc_imb_pbg', 'file_template_diisi'];
        foreach ($files as $fileKey) {
            if ($request->hasFile($fileKey)) {
                // Delete old file
                if ($submission->$fileKey && Storage::disk('local')->exists($submission->$fileKey)) {
                    Storage::disk('local')->delete($submission->$fileKey);
                }
                // Store new file
                $path = $request->file($fileKey)->store('psu_submissions', 'local');
                $data[$fileKey] = $path;
            }
        }

        $submission->update($data);

        // Send Notification to User for re-submission
        try {
            Auth::user()->notify(new SubmissionReceived($submission));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send PSU update email: ' . $e->getMessage());
        }

        return redirect('/user/dashboard')->with('success', 'Permohonan berhasil diperbarui dan dikirim kembali untuk verifikasi.');
    }
}

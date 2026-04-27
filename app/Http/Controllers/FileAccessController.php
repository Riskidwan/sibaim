<?php

namespace App\Http\Controllers;

use App\Models\PsuSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class FileAccessController extends Controller
{
    /**
     * Serve sensitive PSU submission files with authorization check.
     */
    public function servePsuFile(PsuSubmission $submission, $field)
    {
        // 1. Authorization Check
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $isOwner = $user->id === $submission->user_id;
        $isAdmin = $user->is_admin || in_array($user->role, ['superadmin', 'kepala']);

        if (!$isOwner && !$isAdmin) {
            abort(403, 'Anda tidak memiliki akses ke berkas ini.');
        }

        // 2. Validate Field
        $allowedFields = [
            'fc_ktp', 'fc_akta_pendirian', 'fc_sertifikat_tanah', 
            'siteplan', 'daftar_psu_nilai', 'fc_imb_pbg', 
            'file_template_diisi', 'file_ba_terbit'
        ];

        if (!in_array($field, $allowedFields)) {
            abort(404);
        }

        $path = $submission->$field;

        if (!$path || !Storage::disk('local')->exists($path)) {
            abort(404, 'Berkas tidak ditemukan.');
        }

        // 3. Serve File
        return Storage::disk('local')->response($path);
    }
}

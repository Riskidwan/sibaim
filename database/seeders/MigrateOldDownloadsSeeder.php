<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MigrateOldDownloadsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Migrate SK Jalan Lingkungan
        \App\Models\SkJalanLingkungan::all()->each(function ($item) {
            \App\Models\PublicDownload::create([
                'kategori' => 'SK Jalan Lingkungan',
                'title' => $item->title,
                'description' => 'Surat Keputusan Jalan Lingkungan',
                'tanggal' => $item->year . '-01-01',
                'file_path' => $item->file_path,
                'is_active' => $item->is_active ?? true,
            ]);
        });

        // 2. Migrate SK Kawasan Kumuh
        \App\Models\SkKawasanKumuh::all()->each(function ($item) {
            \App\Models\PublicDownload::create([
                'kategori' => 'SK Kawasan Kumuh',
                'title' => $item->judul,
                'description' => $item->deskripsi ?? $item->nomor_sk,
                'tanggal' => ($item->tahun ?? date('Y')) . '-01-01',
                'file_path' => $item->file_path,
                'is_active' => $item->is_active ?? true,
            ]);
        });

        // 3. Migrate BA Penanganan Kumuh
        \App\Models\BaPenangananKumuh::all()->each(function ($item) {
            \App\Models\PublicDownload::create([
                'kategori' => 'BA Penanganan Kumuh',
                'title' => $item->judul,
                'description' => $item->keterangan ?? 'Berita Acara Penanganan Kumuh',
                'tanggal' => $item->created_at,
                'file_path' => $item->file_path,
                'is_active' => $item->is_active ?? true,
            ]);
        });
        
        echo "Data migrasi selesai ditransfer ke PublicDownload.\n";
    }
}

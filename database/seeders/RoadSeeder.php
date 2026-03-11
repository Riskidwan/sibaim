<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Road;
use Illuminate\Support\Facades\File;

class RoadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(database_path('seeders/data.json'));
        $data = json_decode($json, true);

        if ($data) {
            foreach ($data as $item) {
                $roadCoords = [];
                if (isset($item['coordinates']) && is_array($item['coordinates'])) {
                    foreach ($item['coordinates'] as $index => $coord) {
                        $roadCoords[] = [(double)$coord[0], (double)$coord[1]];
                    }
                }

                Road::create([
                    'nama' => $item['nama'],
                    'panjang' => (float)$item['panjang'],
                    'lebar' => (float)$item['lebar'],
                    'jenis_perkerasan' => $item['jenis_perkerasan'],
                    'kondisi' => $item['kondisi'],
                    'kecamatan' => str_replace('Pontianak', 'Pemalang', $item['kecamatan']),
                    'kelurahan' => $item['kelurahan'] ?? null,
                    'tahun' => (int)$item['tahun'],
                    'coordinates' => $roadCoords,
                ]);
            }
        }
    }
}

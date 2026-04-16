<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MasterPavementType;
use App\Models\MasterRoadCondition;
use App\Models\MasterPsuCondition;

class MasterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pavement Types
        $pavementTypes = ['Aspal', 'Beton', 'Tanah', 'Kerikil', 'Paving'];
        foreach ($pavementTypes as $type) {
            MasterPavementType::firstOrCreate(['name' => $type]);
        }

        // Road Conditions
        $roadConditions = ['Baik', 'Sedang', 'Rusak Ringan', 'Rusak Berat'];
        foreach ($roadConditions as $condition) {
            MasterRoadCondition::firstOrCreate(['name' => $condition]);
        }

        // PSU Conditions
        $psuConditions = ['Baik', 'Sedang', 'Rusak', 'N/A'];
        foreach ($psuConditions as $condition) {
            MasterPsuCondition::firstOrCreate(['name' => $condition]);
        }
    }
}

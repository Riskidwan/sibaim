<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Road;

class RoadController extends Controller
{
    public function index()
    {
        $roads = Road::all();
        $formatted = $roads->map(function ($road) {
            return [
                'id' => $road->id,
                'nama' => $road->nama,
                'panjang' => $road->panjang,
                'lebar' => $road->lebar,
                'jenis_perkerasan' => $road->jenis_perkerasan,
                'kondisi' => $road->kondisi,
                'kecamatan' => $road->kecamatan,
                'kelurahan' => $road->kelurahan,
                'tahun' => $road->tahun,
                'coordinates' => is_array($road->coordinates) ? $road->coordinates : [],
            ];
        });
        
        return response()->json($formatted);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'panjang' => 'required|numeric',
            'lebar' => 'required|numeric',
            'jenis_perkerasan' => 'nullable|string|max:255',
            'kondisi' => 'nullable|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kelurahan' => 'nullable|string|max:255',
            'tahun' => 'nullable|integer',
            'coordinates' => 'required|array',
            'coordinates.*' => 'array|size:2',
            'coordinates.*.0' => 'numeric',
            'coordinates.*.1' => 'numeric',
        ]);

        $road = Road::create([
            'nama' => $validated['nama'],
            'panjang' => $validated['panjang'],
            'lebar' => $validated['lebar'],
            'jenis_perkerasan' => $validated['jenis_perkerasan'] ?? null,
            'kondisi' => $validated['kondisi'] ?? null,
            'kecamatan' => $validated['kecamatan'],
            'kelurahan' => $validated['kelurahan'] ?? null,
            'tahun' => $validated['tahun'] ?? date('Y'),
        ]);

        foreach ($validated['coordinates'] as $index => $coord) {
            $road->coordinates()->create([
                'latitude' => $coord[0],
                'longitude' => $coord[1],
                'order_index' => $index,
            ]);
        }

        return response()->json(['message' => 'Road created successfully', 'road' => $road], 201);
    }

    public function update(Request $request, $id)
    {
        $road = Road::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'panjang' => 'required|numeric',
            'lebar' => 'required|numeric',
            'jenis_perkerasan' => 'nullable|string|max:255',
            'kondisi' => 'nullable|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kelurahan' => 'nullable|string|max:255',
            'tahun' => 'nullable|integer',
            'coordinates' => 'required|array',
            'coordinates.*' => 'array|size:2',
            'coordinates.*.0' => 'numeric',
            'coordinates.*.1' => 'numeric',
        ]);

        $road->update([
            'nama' => $validated['nama'],
            'panjang' => $validated['panjang'],
            'lebar' => $validated['lebar'],
            'jenis_perkerasan' => $validated['jenis_perkerasan'] ?? null,
            'kondisi' => $validated['kondisi'] ?? null,
            'kecamatan' => $validated['kecamatan'],
            'kelurahan' => $validated['kelurahan'] ?? null,
            'tahun' => $validated['tahun'] ?? date('Y'),
            'coordinates' => $validated['coordinates'],
        ]);

        return response()->json(['message' => 'Road updated successfully', 'road' => $road]);
    }

    public function destroy($id)
    {
        $road = Road::findOrFail($id);
        $road->delete();

        return response()->json(['message' => 'Road deleted successfully']);
    }
}

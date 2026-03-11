<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Road;

class RoadController extends Controller
{
    public function index(Request $request)
    {
        $query = Road::latest();

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('kecamatan', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }

        $perPage = $request->input('per_page', 10);
        if (!in_array($perPage, [5, 10, 25, 100])) {
            $perPage = 10;
        }

        $roads = $query->paginate($perPage)->withQueryString();
        
        return view('admin.roads.index', compact('roads'));
    }

    public function create()
    {
        return view('admin.roads.create');
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
            'coordinates_json' => 'required|string', // Capture parsed JSON from leaflete UI
        ]);

        $coords = json_decode($validated['coordinates_json'], true);
        
        $roadData = $validated;
        $roadData['coordinates'] = $coords;
        
        Road::create($roadData);

        return redirect()->route('admin.roads.index')->with('success', 'Data jalan berhasil ditambahkan');
    }

    public function show($id)
    {
        $road = Road::findOrFail($id);
        return view('admin.roads.show', compact('road'));
    }

    public function edit($id)
    {
        $road = Road::findOrFail($id);
        return view('admin.roads.edit', compact('road'));
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
            'coordinates_json' => 'required|string',
        ]);

        $coords = json_decode($validated['coordinates_json'], true);
        
        $roadData = $validated;
        $roadData['coordinates'] = $coords;
        
        $road->update($roadData);

        return redirect()->route('admin.roads.index')->with('success', 'Data jalan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $road = Road::findOrFail($id);
        $road->delete();

        return redirect()->route('admin.roads.index')->with('success', 'Data jalan berhasil dihapus');
    }
}

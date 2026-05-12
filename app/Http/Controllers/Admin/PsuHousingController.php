<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PsuHousing;
use App\Models\MasterPsuCondition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PsuHousingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PsuHousing::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_perumahan', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%")
                  ->orWhere('nama_pengembang', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status_serah_terima', $request->status);
        }

        $housings = $query->latest()->paginate(10);
        return view('admin.psu_housing.index', compact('housings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $psuConditions = MasterPsuCondition::orderBy('name')->get();
        return view('admin.psu_housing.create', compact('psuConditions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_perumahan' => 'required|string|max:255',
            'alamat' => 'required|string|max:500',
            'nama_pengembang' => 'required|string|max:255',
            'no_ba_serah_terima' => 'nullable|string|max:255',
            'luas_lahan_m2' => 'nullable|numeric',
            'total_luas_psu' => 'nullable|numeric',
            'jumlah_rumah' => 'nullable|integer',
            'prasarana' => 'nullable',
            'sarana' => 'nullable',
            'utilitas' => 'nullable',
            'status_serah_terima' => 'required|string|in:Belum Serah Terima,Sudah Serah Terima',
        ]);


        // PSU components will be stored as arrays (JSON in DB)
        PsuHousing::create($validated);

        return redirect()->route('admin.psu-housing.index')->with('success', 'Data Perumahan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $housing = PsuHousing::findOrFail($id);
        return view('admin.psu_housing.show', compact('housing'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $housing = PsuHousing::findOrFail($id);
        $psuConditions = MasterPsuCondition::orderBy('name')->get();
        return view('admin.psu_housing.edit', compact('housing', 'psuConditions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $housing = PsuHousing::findOrFail($id);

        $validated = $request->validate([
            'nama_perumahan' => 'required|string|max:255',
            'alamat' => 'required|string|max:500',
            'nama_pengembang' => 'required|string|max:255',
            'no_ba_serah_terima' => 'nullable|string|max:255',
            'luas_lahan_m2' => 'nullable|numeric',
            'total_luas_psu' => 'nullable|numeric',
            'jumlah_rumah' => 'nullable|integer',
            'prasarana' => 'nullable',
            'sarana' => 'nullable',
            'utilitas' => 'nullable',
            'status_serah_terima' => 'required|string|in:Belum Serah Terima,Sudah Serah Terima',
        ]);


        $housing->update($validated);

        return redirect()->route('admin.psu-housing.index')->with('success', 'Data Perumahan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $housing = PsuHousing::findOrFail($id);
        $housing->delete();

        return redirect()->route('admin.psu-housing.index')->with('success', 'Data Perumahan berhasil dihapus.');
    }
}

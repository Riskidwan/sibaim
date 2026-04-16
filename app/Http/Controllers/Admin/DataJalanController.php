<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataJalan;
use Illuminate\Http\Request;

class DataJalanController extends Controller
{
    public function index(Request $request)
    {
        $query = DataJalan::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_jalan',  'like', "%{$search}%")
                  ->orWhere('kecamatan', 'like', "%{$search}%")
                  ->orWhere('kelurahan', 'like', "%{$search}%");
            });
        }

        $jalans = $query->latest()->paginate(15);
        return view('admin.data_jalan.index', compact('jalans'));
    }

    public function create()
    {
        return view('admin.data_jalan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kecamatan'     => 'required|string|max:255',
            'kelurahan'     => 'required|string|max:255',
            'nama_jalan'    => 'required|string|max:255',
            'panjang_jalan' => 'nullable|numeric|min:0',
        ]);

        $validated['is_public'] = $request->has('is_public');

        DataJalan::create($validated);

        return redirect()->route('admin.data-jalan.index')
            ->with('success', 'Data jalan berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $jalan = DataJalan::findOrFail($id);
        return view('admin.data_jalan.edit', compact('jalan'));
    }

    public function update(Request $request, string $id)
    {
        $jalan = DataJalan::findOrFail($id);

        $validated = $request->validate([
            'kecamatan'     => 'required|string|max:255',
            'kelurahan'     => 'required|string|max:255',
            'nama_jalan'    => 'required|string|max:255',
            'panjang_jalan' => 'nullable|numeric|min:0',
        ]);

        $validated['is_public'] = $request->has('is_public');

        $jalan->update($validated);

        return redirect()->route('admin.data-jalan.index')
            ->with('success', 'Data jalan berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $jalan = DataJalan::findOrFail($id);
        $jalan->delete();

        return redirect()->route('admin.data-jalan.index')
            ->with('success', 'Data jalan berhasil dihapus.');
    }

    /**
     * Toggle status is_public sebuah data jalan.
     */
    public function togglePublic(string $id)
    {
        $jalan = DataJalan::findOrFail($id);
        $jalan->is_public = !$jalan->is_public;
        $jalan->save();

        $status = $jalan->is_public ? 'dipublikasikan' : 'disembunyikan dari publik';

        return back()->with('success', "Data jalan \"{$jalan->nama_jalan}\" berhasil {$status}.");
    }
}

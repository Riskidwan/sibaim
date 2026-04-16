<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GaleriKegiatan;
use App\Models\GaleriImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GaleriKegiatanController extends Controller
{
    public function index()
    {
        $data = GaleriKegiatan::with('images')->orderBy('created_at', 'desc')->get();
        return view('admin.galeri-kegiatan.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|in:berita,kunjungan,rapat,sosialisasi',
            'tanggal' => 'nullable|date',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
        ], [
            'images.required' => 'Wajib memilih minimal 1 foto kegiatan.',
            'images.*.image' => 'File harus berupa gambar.',
            'images.*.max' => 'Ukuran setiap gambar maksimal 5MB.',
        ]);

        $kegiatan = GaleriKegiatan::create([
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'tanggal' => $request->tanggal,
            'deskripsi' => $request->deskripsi,
            'is_active' => $request->has('is_active'),
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('galeri', 'public');
                GaleriImage::create([
                    'galeri_kegiatan_id' => $kegiatan->id,
                    'file_path' => $path,
                ]);
            }
        }

        return redirect()->route('admin.galeri-kegiatan.index')->with('success', 'Kegiatan Galeri beserta foto berhasil diunggah.');
    }

    public function show(GaleriKegiatan $galeriKegiatan)
    {
        return response()->json($galeriKegiatan->load('images'));
    }

    public function update(Request $request, GaleriKegiatan $galeriKegiatan)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|in:berita,kunjungan,rapat,sosialisasi',
            'tanggal' => 'nullable|date',
            'new_images' => 'nullable|array',
            'new_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $galeriKegiatan->update([
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'tanggal' => $request->tanggal,
            'deskripsi' => $request->deskripsi,
            'is_active' => $request->has('is_active'),
        ]);

        if ($request->hasFile('new_images')) {
            foreach ($request->file('new_images') as $image) {
                $path = $image->store('galeri', 'public');
                GaleriImage::create([
                    'galeri_kegiatan_id' => $galeriKegiatan->id,
                    'file_path' => $path,
                ]);
            }
        }

        return redirect()->route('admin.galeri-kegiatan.index')->with('success', 'Data Kegiatan Galeri berhasil diperbarui.');
    }

    public function destroy(GaleriKegiatan $galeriKegiatan)
    {
        foreach ($galeriKegiatan->images as $image) {
            if (Storage::disk('public')->exists($image->file_path)) {
                Storage::disk('public')->delete($image->file_path);
            }
        }
        $galeriKegiatan->delete();

        return redirect()->route('admin.galeri-kegiatan.index')->with('success', 'Kegiatan Galeri dihapus.');
    }

    public function destroyImage(GaleriImage $image)
    {
        if (Storage::disk('public')->exists($image->file_path)) {
            Storage::disk('public')->delete($image->file_path);
        }
        $image->delete();

        return back()->with('success', 'Foto berhasil dihapus dari album.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SkJalanLingkungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SkJalanLingkunganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sk_items = SkJalanLingkungan::orderBy('year', 'desc')->get();
        return view('admin.sk_jalan_lingkungan.index', compact('sk_items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.sk_jalan_lingkungan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required|integer',
            'title' => 'required|string|max:255',
            'pdf_file' => 'required|file|mimes:pdf|max:10240', // max 10MB
        ], [
            'pdf_file.mimes' => 'File harus berupa dokumen PDF.',
            'pdf_file.max' => 'Ukuran file PDF maksimal adalah 10 MB.',
        ]);

        // Handle File Upload
        $file = $request->file('pdf_file');
        // Store in storage/app/public/sk_jalan_lingkungan
        $path = $file->store('sk_jalan_lingkungan', 'public');

        SkJalanLingkungan::create([
            'year' => $request->year,
            'title' => $request->title,
            'file_path' => $path,
        ]);

        return redirect()->route('admin.sk-jalan-lingkungan.index')->with('success', 'SK Jalan Lingkungan berhasil diunggah!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $sk = SkJalanLingkungan::findOrFail($id);
        return view('admin.sk_jalan_lingkungan.edit', compact('sk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $sk = SkJalanLingkungan::findOrFail($id);

        $request->validate([
            'year' => 'required|integer',
            'title' => 'required|string|max:255',
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240',
        ], [
            'pdf_file.mimes' => 'File harus berupa dokumen PDF.',
            'pdf_file.max' => 'Ukuran file PDF maksimal adalah 10 MB.',
        ]);

        $data = [
            'year' => $request->year,
            'title' => $request->title,
        ];

        if ($request->hasFile('pdf_file')) {
            // Delete old file
            if (Storage::disk('public')->exists($sk->file_path)) {
                Storage::disk('public')->delete($sk->file_path);
            }
            // Store new file
            $file = $request->file('pdf_file');
            $data['file_path'] = $file->store('sk_jalan_lingkungan', 'public');
        }

        $sk->update($data);

        return redirect()->route('admin.sk-jalan-lingkungan.index')->with('success', 'Data SK Jalan Lingkungan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sk = SkJalanLingkungan::findOrFail($id);
        
        if (Storage::disk('public')->exists($sk->file_path)) {
            Storage::disk('public')->delete($sk->file_path);
        }

        $sk->delete();

        return redirect()->route('admin.sk-jalan-lingkungan.index')->with('success', 'SK Jalan Lingkungan berhasil dihapus!');
    }
}

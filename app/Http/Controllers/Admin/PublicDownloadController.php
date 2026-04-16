<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PublicDownloadController extends Controller
{
    /**
     * Check if user is authorized to perform CRUD operations.
     */
    protected function authorizeAdmin()
    {
        if (!\Illuminate\Support\Facades\Auth::user()->isSuperAdmin()) {
            abort(403, 'Anda tidak memiliki hak akses untuk melakukan operasi ini.');
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $downloads = \App\Models\PublicDownload::orderBy('kategori')->orderBy('created_at', 'desc')->get();
        return view('admin.public_downloads.index', compact('downloads'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorizeAdmin();
        $categories = ['SK Jalan Lingkungan', 'SK Kawasan Kumuh', 'BA Penanganan Kumuh', 'Template PSU', 'Umum'];
        return view('admin.public_downloads.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorizeAdmin();
        $request->validate([
            'kategori' => 'required|string|in:SK Jalan Lingkungan,SK Kawasan Kumuh,BA Penanganan Kumuh,Template PSU,Umum',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'tanggal' => 'nullable|date',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,zip,rar|max:20480', // max 20MB
        ]);

        $publicDownload = new \App\Models\PublicDownload();
        $publicDownload->kategori = $request->kategori;
        $publicDownload->title = $request->title;
        $publicDownload->description = $request->description;
        $publicDownload->tanggal = $request->tanggal;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public_downloads', $filename, 'public');
            $publicDownload->file_path = $path;
        }

        $publicDownload->save();

        return redirect()->route('admin.public-downloads.index')->with('success', 'File berhasil diunggah ke kategori ' . $request->kategori);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->authorizeAdmin();
        $download = \App\Models\PublicDownload::findOrFail($id);
        $categories = ['SK Jalan Lingkungan', 'SK Kawasan Kumuh', 'BA Penanganan Kumuh', 'Template PSU', 'Umum'];
        return view('admin.public_downloads.edit', compact('download', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->authorizeAdmin();
        $request->validate([
            'kategori' => 'required|string|in:SK Jalan Lingkungan,SK Kawasan Kumuh,BA Penanganan Kumuh,Template PSU,Umum',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'tanggal' => 'nullable|date',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,zip,rar|max:20480',
        ]);

        $publicDownload = \App\Models\PublicDownload::findOrFail($id);
        $publicDownload->kategori = $request->kategori;
        $publicDownload->title = $request->title;
        $publicDownload->description = $request->description;
        $publicDownload->tanggal = $request->tanggal;

        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($publicDownload->file_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($publicDownload->file_path)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($publicDownload->file_path);
            }
            
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public_downloads', $filename, 'public');
            $publicDownload->file_path = $path;
        }

        $publicDownload->save();

        return redirect()->route('admin.public-downloads.index')->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorizeAdmin();
        $publicDownload = \App\Models\PublicDownload::findOrFail($id);
        
        if ($publicDownload->file_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($publicDownload->file_path)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($publicDownload->file_path);
        }
        
        $publicDownload->delete();

        return redirect()->route('admin.public-downloads.index')->with('success', 'File berhasil dihapus.');
    }
}

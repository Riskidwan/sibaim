<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoadConditionReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoadConditionReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reports = RoadConditionReport::orderBy('year', 'desc')->get();
        return view('admin.reports.index', compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.reports.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required|integer|unique:road_condition_reports,year',
            'title' => 'nullable|string|max:255',
            'pdf_file' => 'required|file|mimes:pdf|max:10240', // max 10MB
        ], [
            'year.unique' => 'Laporan untuk tahun ini sudah ada! Silakan hapus yang lama terlebih dahulu.',
            'pdf_file.mimes' => 'File harus berupa dokumen PDF.',
            'pdf_file.max' => 'Ukuran file PDF maksimal adalah 10 MB.',
        ]);

        // Handle File Upload
        $file = $request->file('pdf_file');
        // Store in storage/app/public/reports
        $path = $file->store('reports', 'public');

        RoadConditionReport::create([
            'year' => $request->year,
            'title' => $request->title ?: 'Laporan Kondisi Jalan Tahun ' . $request->year,
            'file_path' => $path,
        ]);

        return redirect()->route('admin.reports.index')->with('success', 'Laporan Kondisi Jalan tahun ' . $request->year . ' berhasil diunggah!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $report = RoadConditionReport::findOrFail($id);
        return view('admin.reports.edit', compact('report'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $report = RoadConditionReport::findOrFail($id);

        $request->validate([
            'year' => 'required|integer|unique:road_condition_reports,year,' . $report->id,
            'title' => 'nullable|string|max:255',
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240', // File is optional on update
        ], [
            'year.unique' => 'Laporan untuk tahun ini sudah ada! Silakan cek kembali.',
            'pdf_file.mimes' => 'File harus berupa dokumen PDF.',
            'pdf_file.max' => 'Ukuran file PDF maksimal adalah 10 MB.',
        ]);

        $data = [
            'year' => $request->year,
            'title' => $request->title ?: 'Laporan Kondisi Jalan Tahun ' . $request->year,
        ];

        // Jika mengunggah PDF baru
        if ($request->hasFile('pdf_file')) {
            // Hapus file lama
            if (Storage::disk('public')->exists($report->file_path)) {
                Storage::disk('public')->delete($report->file_path);
            }
            // Simpan file baru
            $file = $request->file('pdf_file');
            $data['file_path'] = $file->store('reports', 'public');
        }

        $report->update($data);

        return redirect()->route('admin.reports.index')->with('success', 'Data Laporan Kondisi Jalan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $report = RoadConditionReport::findOrFail($id);
        
        // Delete file from storage
        if (Storage::disk('public')->exists($report->file_path)) {
            Storage::disk('public')->delete($report->file_path);
        }

        $report->delete();

        return redirect()->route('admin.reports.index')->with('success', 'Dokumen Laporan berhasil dihapus!');
    }
}

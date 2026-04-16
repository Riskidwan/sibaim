<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PsuTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PsuTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $templates = PsuTemplate::orderBy('created_at', 'desc')->get();
        return view('admin.psu_template.index', compact('templates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.psu_template.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,zip|max:10240', // Max 10MB
        ]);

        $path = $request->file('file')->store('psu_templates', 'public');

        PsuTemplate::create([
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $path,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.psu-templates.index')->with('success', 'Template berhasil diunggah.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PsuTemplate $psu_template)
    {
        return view('admin.psu_template.edit', ['template' => $psu_template]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PsuTemplate $psu_template)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,zip|max:10240',
        ]);

        $data = $request->only(['title', 'description']);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('file')) {
            // Delete old file
            if (Storage::disk('public')->exists($psu_template->file_path)) {
                Storage::disk('public')->delete($psu_template->file_path);
            }
            $path = $request->file('file')->store('psu_templates', 'public');
            $data['file_path'] = $path;
        }

        $psu_template->update($data);

        return redirect()->route('admin.psu-templates.index')->with('success', 'Template berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PsuTemplate $psu_template)
    {
        if (Storage::disk('public')->exists($psu_template->file_path)) {
            Storage::disk('public')->delete($psu_template->file_path);
        }
        $psu_template->delete();

        return redirect()->route('admin.psu-templates.index')->with('success', 'Template berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterPsuCondition;

class MasterDataController extends Controller
{
    // --- Kondisi PSU Housing ---
    public function psuConditionIndex()
    {
        $data = MasterPsuCondition::orderBy('name')->get();
        return view('admin.master.housing_conditions.index', compact('data'));
    }

    public function psuConditionStore(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255|unique:master_psu_conditions,name']);
        MasterPsuCondition::create($request->all());
        return back()->with('success', 'Kondisi PSU berhasil ditambahkan');
    }

    public function psuConditionUpdate(Request $request, $id)
    {
        $request->validate(['name' => 'required|string|max:255|unique:master_psu_conditions,name,' . $id]);
        $m = MasterPsuCondition::findOrFail($id);
        $m->update($request->all());
        return back()->with('success', 'Kondisi PSU berhasil diperbarui');
    }

    public function psuConditionDestroy($id)
    {
        $m = MasterPsuCondition::findOrFail($id);
        $m->delete();
        return back()->with('success', 'Kondisi PSU berhasil dihapus');
    }
}

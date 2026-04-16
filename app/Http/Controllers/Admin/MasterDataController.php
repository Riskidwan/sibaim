<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterPavementType;
use App\Models\MasterRoadCondition;
use App\Models\MasterPsuCondition;

class MasterDataController extends Controller
{
    // --- Jenis Perkerasan ---
    public function pavementIndex()
    {
        $data = MasterPavementType::orderBy('name')->get();
        return view('admin.master.pavement_types.index', compact('data'));
    }

    public function pavementStore(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255|unique:master_pavement_types,name']);
        MasterPavementType::create($request->all());
        return back()->with('success', 'Jenis perkerasan berhasil ditambahkan');
    }

    public function pavementUpdate(Request $request, $id)
    {
        $request->validate(['name' => 'required|string|max:255|unique:master_pavement_types,name,' . $id]);
        $m = MasterPavementType::findOrFail($id);
        $m->update($request->all());
        return back()->with('success', 'Jenis perkerasan berhasil diperbarui');
    }

    public function pavementDestroy($id)
    {
        $m = MasterPavementType::findOrFail($id);
        $m->delete();
        return back()->with('success', 'Jenis perkerasan berhasil dihapus');
    }

    // --- Kondisi Jalan ---
    public function roadConditionIndex()
    {
        $data = MasterRoadCondition::orderBy('name')->get();
        return view('admin.master.road_conditions.index', compact('data'));
    }

    public function roadConditionStore(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255|unique:master_road_conditions,name']);
        MasterRoadCondition::create($request->all());
        return back()->with('success', 'Kondisi jalan berhasil ditambahkan');
    }

    public function roadConditionUpdate(Request $request, $id)
    {
        $request->validate(['name' => 'required|string|max:255|unique:master_road_conditions,name,' . $id]);
        $m = MasterRoadCondition::findOrFail($id);
        $m->update($request->all());
        return back()->with('success', 'Kondisi jalan berhasil diperbarui');
    }

    public function roadConditionDestroy($id)
    {
        $m = MasterRoadCondition::findOrFail($id);
        $m->delete();
        return back()->with('success', 'Kondisi jalan berhasil dihapus');
    }

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

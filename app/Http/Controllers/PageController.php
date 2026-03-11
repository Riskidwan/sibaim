<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        return view('public.index');
    }

    public function peta()
    {
        return view('public.peta');
    }

    public function kondisiTahunan()
    {
        $reports = \App\Models\RoadConditionReport::orderBy('year', 'desc')->get();
        return view('public.kondisi_tahunan', compact('reports'));
    }
}

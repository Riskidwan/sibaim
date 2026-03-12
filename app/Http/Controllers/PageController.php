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

    public function skJalanLingkungan()
    {
        $sk_items = \App\Models\SkJalanLingkungan::orderBy('year', 'desc')->get();
        return view('public.sk_jalan_lingkungan', compact('sk_items'));
    }

    public function psuTemplates()
    {
        $templates = \App\Models\PsuTemplate::orderBy('created_at', 'desc')->get();
        return view('public.psu_template', compact('templates'));
    }
}

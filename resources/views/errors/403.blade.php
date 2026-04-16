@extends('errors.minimal')

@section('title', 'Akses Ditolak')
@section('code', '403')
@section('icon')
    <i class="fas fa-user-shield"></i>
@endsection
@section('message', 'Akses Ditolak')
@section('description', 'Maaf, Anda tidak memiliki izin untuk mengakses halaman ini. Ini adalah area khusus administratif.')
@section('link', auth()->check() ? (auth()->user()->role === 'user' ? '/user/dashboard' : '/admin/dashboard') : '/login')
@section('button_text', auth()->check() ? 'Kembali ke Dashboard' : 'Login Sekarang')

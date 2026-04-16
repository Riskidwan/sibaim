@extends('errors.minimal')

@section('title', 'Halaman Tidak Ditemukan')
@section('code', '404')
@section('icon')
    <i class="fas fa-map-marked-alt"></i>
@endsection
@section('message', 'Ops! Halaman Tidak Ditemukan')
@section('description', 'Maaf, sepertinya Anda tersesat di peta. Halaman yang Anda cari tidak tersedia atau telah dipindahkan.')
@section('link', '/')
@section('button_text', 'Kembali ke Beranda')

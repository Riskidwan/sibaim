@extends('errors.minimal')

@section('title', 'Kesalahan Server')
@section('code', '500')
@section('icon')
    <i class="fas fa-server"></i>
@endsection
@section('message', 'Ops! Ada Masalah di Server')
@section('description', 'Terjadi kesalahan sistem yang tidak terduga. Tim teknis kami sedang berusaha memperbaikinya.')
@section('link', '/')
@section('button_text', 'Kembali ke Beranda')

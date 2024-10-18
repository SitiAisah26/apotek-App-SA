@extends('layout.layout')
@section('content')
<div class="Jumbotron py-4 px-5">

    @if (Session::get('failed'))
        <div class="alert alert-danger">{{ Session::get('failed') }}</div>
    @endif

    @if (Session::get('login'))
        <div class="alert alert-danger">{{ Session::get('login') }}</div>
    @endif

    <h1 class="display-4">
        Selamat Datang {{ Auth::user()->name }} !
    </h1>
    <p>Aplikasi ini hanya bisa digunakan oleh pegawai administrator APOTEK | Digunakan untuk mengelola data obat, stock obat, dan juga pembelian (kasir).</p>
    <hr class="my-4">
</div>
@endsection

@extends('layout.layout')

@section('content')
<h1 class="text-center mt-4">Halaman Edit Obat</h1>
<div class="d-flex justify-content-center mt-5">
    <form action="{{ route('obat.edit.formulir', $medicine['id']) }}" method="POST" class="card p-4 shadow-sm rounded" style="width: 50%;">
        {{--
           1. tag <form> attr action &  method
            method :
            - GET : ketika form tujuan nya mencari data (search)
            - POST : ketika form tujuan nya menambahkan/menghapus/mengubah (selain mencari)
            action : route untuk memproses data
            - arahkan route yg akan menangani proses data ke db nya
            - jika GET : arahkan ke route yg sama dengan route yg menampilkan blade ini
            - jika POST : arahkan ke route baru dengan httpmethod sesuai tujuan nya -> POST (tambah), PATCH (ubah), DELETE (hapus)
            2. jika form method POST :@csrf
            3. input attr name (di disamakan dengan column di migration)
            4. button/input yg tipe nya submit -> agar bisa di jalankan
        --}}
        @csrf
        @method('PATCH')
        @if (Session::get('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ( $errors->all() as $error )
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="mb-3">
            <label for="name" class="form-label">Nama Obat :</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama obat" value="{{ $medicine['name']}}">
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Jenis Obat :</label>
            <select class="form-select" id="type" name="type">
                <option selected disabled hidden>Pilih jenis obat</option>
                <option value="tablet" {{ $medicine['type'] == 'tablet' ? 'selected' : '' }}>Tablet</option>
                <option value="sirup" {{ $medicine['type'] == 'sirup' ? 'selected' : '' }}>Sirup</option>
                <option value="kapsul" {{ $medicine['type'] == 'kapsul' ? 'selected' : '' }}>Kapsul</option>
            </select>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="price" class="form-label">Harga :</label>
                <input type="number" class="form-control" id="price" name="price" placeholder="Harga dalam rupiah" value="{{ $medicine['price']}}">
            </div>
            {{-- <div class="col-md-6 mb-3">
                <label for="stock" class="form-label">Stock</label>
                <input type="number" class="form-control" id="stock" name="stock" placeholder="Stock tersedia" value="{{ $medicine['stock']}}">
            </div>
        </div> --}}

        <button type="submit" style="background-color: #007bff; color: white;">Tambah Data</button>
    </form>
</div>
@endsection

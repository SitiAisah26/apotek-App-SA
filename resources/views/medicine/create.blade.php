@extends('layout.layout')

@section('content')
<form action="{{ route('obat.tambah_obat.formulir') }}" method="POST" class="card-p-5">
    {{--
        1. tag <form> attribute action & method
            method :
            - GET : form tujuan untuk mencari data (search)
            - POST : form tujuan menambahkan, menghapus, atau mengubah data
            action : route memproses data
            - arahkan route yang akan menangani proses data ke databasenya
            - jika GET : arahkan ke route yang sama dengan route yang menampilkan blade ini
            - jika POST : arahkan ke route baru dengan httpmethod sesuai dengan tujuan POST (tambah), PATCH (ubah), DELETE (hapus)
        2. jika form methodnya adalah POST : @csrf -> adalah token keamanan atau kunci
        3. di bagian input wajib ada attribute name yang harus disamakan dengan column yang ada di migration
        4. harus ada button atau input yang memiliki type submit agar action dapat dijalankan
    --}}
    @csrf
    @if(Session::get('success'))
        <div class="alert alert-success">
            {{Session ('success')}}
        </div>
    @endif
    @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all () as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
                </div>
    @endif
    <div class="mb-3 row">
        <label for="name" class="col-sm-2 col-form-label">Nama Obat : </label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}" placeholder="Masukkan Nama Obat">

        </div>
    </div>
    <div class="mb-3 row">
        <label for="type" class="col-sm-2 col-form-label">Jenis Obat :</label>
        <div class="col-sm-10">
            <select class="form-select" id="type" name="type"> <option selected disabled hidden> Pilih</option>
                <option value="tablet" {{ old('type') == 'tablet' ? 'selected' : ''}}>Tablet</option>
                <option value="sirup" {{ old('type') == 'sirup' ? 'selected' : ''}}>Sirup</option>
                <option value="kapsul" {{ old('type') == 'kapsul' ? 'selected' : ''}}>Kapsul</option>
            </select>
        </div>
    </div>
    <div class="mb-3 row">
        <label for="price" class="col-sm-2 col-form-label">Harga Obat : </label>
        <div class="col-sm-10">
            <input type="number" class="form-control" id="price" name="price" value="{{old('price')}}">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="stock" class="col-sm-2 col-form-label">Stock Tersedia : </label>
        <div class="col-sm-10">
            <input type="number" class="form-control" id="stock" name="stock" value="{{old('stock')}}">
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Tambah Data</button>
</form>
@endsection

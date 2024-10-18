@extends ('layout.layout')

@section ('content')
    <div class="container mt-3">
        <form action="" class="card m-auto p-5" method="POST">
            @csrf
            {{-- validasi error --}}
            @if ($errors->any())
                <ul class="alert alert-danger p-3">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            @if (Session::get('failed'))
                <div class="alert alert-danger">{{ Session::get('failed') }}</div>
            @endif
                <p>Penanggung Jawab : <b>{{  Auth::user()->name }}</b></p>
            <div class="mb-3 row">
                <label for="nama_costumer" class="col-sm-2 col-form-label">Nama Pembeli : </label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="nama_customer" name="nama_customer">
                </div>
            </div>
            <div class="mb-3 row">
                <abel for="medicines" class="col-sm-2 col-form-label"> Obat : </label>
                <div class="col-sm-10">
                    {{-- name dibuat array karena nantinya data obat {medicines} akan berbentuk array/data yang bisa lebih dari satu --}}
                    <select name="medicines[]" id="medicines" class="form-select">
                        <option selected hidden disable>Pesanan 1</option>
                        @foreach ($medicines as $item )
                            <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                        @endforeach
                    </select>
                    {{-- div pembungkus untuk tambahan select yang akan muncul --}}
                    <div id="medicines-wrap"></div>
                    <br>
                    <p style="cursor : pointer;" class="text-primary" id="add-select">+ Tambah Obat</p>
            </div>
            </div>
                <button type="submit" class="btn btn-block btn-lg btn-primary">Konfirmasi Pembelian</button>
        </form>
    </div>
@endsection

@push('script')
    <script>
        let no = 2;
        $("#add-select").on("click", function() {
            let el = `<br>
                <select name="medicines[]" id="medicines" class="form-select">
                    <option selected hidden disabled>Pesanan ${no}</option>
                    @foreach ($medicines as $item )
                        <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                    @endforeach
                </select>`;

            $("#medicines-wrap").append(el);
            no++;
        });
    </script>
@endpush


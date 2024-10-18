@extends('layout.layout')
{{-- extends : import blade --}}

@section('content')
    @if (Session::get('success'))
    <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif
    <div class="d-flex justify-content-end">
    <form action="{{ route('obat.data') }}" class="me-2" method="GET">
        <input type="hidden" name="short_stock" value="stock">
        <button class="btn btn-primary" type="submit">Urutkan Stock</button>
    </form>
    <form class="d-flex" role="search" action="{{ route('obat.data')}}" method="GET">
        <input type="text" class="form-control me-2" placeholder="Search Data Obat" aria-label="Search" name="search_obat">
        <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
    </div>
    <table class="table
    table-bordered table-stripped mt-2">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Obat</th>
                <th>Jenis</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @if (count($medicines) < 1)
                <tr>
                    <td colspan="6" class="text-center">Data Obat Kosong</td>
                <tr>
                @else
                    @foreach ($medicines as $index => $item)
                <tr>
                    <td>{{ ($medicines->currentPage() - 1) * $medicines->perPage() + ($index + 1) }}</td>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['type'] }}</td>
                    <td>Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                    <td class="{{ $item['stock'] <= 3 ? 'bg-danger text-white' : '' }}" style="cursor: pointer" onclick="showModalStock('{{ $item->id }}', '{{ $item->stock }}')">
                        {{ $item['stock'] }}</td>
                    <td class="d-flex">
                        {{-- <button class="btn btn-primary me-2">Edit</button> --}}
                        <a href="{{ route('obat.edit', $item['id']) }}" class="btn btn-primary me-2">Edit</a>
                        <button class="btn btn-danger"
                            onclick="showModal('{{ $item->id }}', '{{ $item['name'] }}')">Hapus</button>
                    </td>
                </tr>
            @endforeach
            @endif
        </tbody>
    </table>

    {{--modal hapus--}}
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="form-delete-obat" method="POST">
                @csrf
                {{-- menimpa method="POST" diganti menjadi delete, sesuai dengan http
            method untul menghapus data- --}}
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Hapus Data Obat</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah anda yakin ingin menghapus obat <span id="nama-obat"></span>?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batalkan</button>
                        <button type="submit" class="btn btn-danger" id="confirm-delete">Hapus</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{--modal edit stok--}}
    <div class="modal fade" id="modal_edit_stock" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="form_edit_stock" method="POST">
                @csrf
                {{-- menimpa method="POST" diganti menjadi delete, sesuai dengan http
            method untul menghapus data- --}}
                @method('PATCH')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Stock Obat</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                       <div class="form-group">
                        <label for="stock_edit" class="form-label">Stok:</label>
                        <input type="number" name="stock" id="stock_edit" class="form-control">
                        @if (Session::get('failed'))
                        <small class="text-danger">{{ Session::get('failed') }}</small>

                        @endif
                       </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batalkan</button>
                        <button type="submit" class="btn btn-danger" id="confirm-delete">Edit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="d-flex justify-content-end">
        {{-- links : memunculkan button pagination --}}
        {{ $medicines->links() }}
    </div>
</div>
@endsection
@push('script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        function showModal(id, name) {
            // ini untuk url delete di dalam route
            let urlDelete = '{{ route('obat.hapus', ':id') }}';
            urlDelete = urlDelete.replace(":id", id);
            // ini untuk action attributenya
            $('#form-delete-obat').attr('action', urlDelete);
            // ini untuk showModal
            $('#exampleModal').modal('show');
            // ini untuk mengisi modalnya
            $('#nama-obat').text(name);
        }

        function showModalStock(id, stock) {
            //mengis stok yg dikirim ke input yg id nya stock_edit
        $("#stock_edit").val(stock);
        //ambil route patch stok
        let url = "{{ route('obat.edit.stock', ':id') }}";
        //isi path dinamis :id dengan id dr parameter ($item->id)
        url = url.replace(":id", id);
        //url tadi kirim ke action
        $("#form_edit_stock").attr("action", url);
        //tampilkan modal
        $("#modal_edit_stock").modal("show");

        }

        @if (Session::get('failed'))
        // jika halaman html nya sudah selesai load cdn, jalankan didalamnya
        $(document).ready(function() {
            //id dari with failed 'id' controller redirect back
           let id = "{{ Session::get('id') }}";
           // stock dari with failed 'stock' controller redirect back
           let stock = "{{ Session::get('stock') }}";
           //panggil func showModalStock dengan data id dan stock di atas
           showModalStock(id, stock);
        });

        @endif
    </script>
@endpush

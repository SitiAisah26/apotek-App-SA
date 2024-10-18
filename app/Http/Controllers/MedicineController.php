<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicine;

class MedicineController extends Controller
{
    /**
     * R : read, untuk menampilkan banyak data atau halaman awal fitur
     */
    public function index(Request $request)
    {
        // return view ('pages.data_obat');
        // $medicines = Medicine::orderBy('name', 'ASC')->simplePaginate(5);
        $orderStock = $request->short_stock ? 'stock' : 'name';
        $medicines = Medicine::where('name', 'LIKE', '%' .$request->search_obat . '%')->orderBy($orderStock, 'ASC')->simplePaginate(5)->appends($request->all());
        // orderBy : mengurutkan berdasarkan field atau column migration tertentu
        // ACS : ascending (kecil ke besar)
        // DESC : descending (besar ke kecil)
        // simplePaginate () untuk memisahkan data dengan pagination, angka 5 menunjukan data yang muncul perhalaman
        // all mengambil semua data
        // orderBy () untuk mengurutkan
        // ASC mengurutkan A-Z atau 0-9
        // DEC z-a atau 9-0
        // jika mengambil semua data tetapi melalui proses filter sebelumnya, all nya ganti menjadi get
        return view('medicine.index', compact('medicines')); // compact () untuk mengirim data ke view (isinya sama dengan $)
    }


    /**
     * C : create, untuk menampilkan form untuk menambahkan data
     */
    public function create()
    {
        return view ('medicine.create');
        // untuk mengambil file blade
    }

    /**
     * C : create, untuk menambahkan data ke dalam database atau mengeksekusi formulir
     */


    public function store(Request $request) //Request $request mengambil atau menyimpan data dari inputan
    {
        $request->validate([
            'name' => 'required|max:100', // required untuk memastikan inputannya terisi
            'type' => 'required|min:3',
            'price' => 'required|numeric', // memastikan nilai inputannya berbentuk angka
            'stock' => 'required|numeric',
        ], [
            'name.required' => 'Nama obat harus diisi!',
            'type.required' => 'Jenis obat harus diisi!',
            'price.required' => 'Harga obat harus diisi!',
            'stock.required' => 'Stok obat harus diisi!',
            'name.max' => 'Nama obat maksimal harus 100 karakter!',
            'type.min' => 'Jenis obat minimal harus 3 karaktek!',
            'price.numeric' => 'Harga obat harus berupa angka!',
            'stock.numeric' => 'Stok obat harus berupa angka',
        ]);

        // method-method dalam models pada laravel -> ORM atau elequent
        // untuk memanggil sql
        Medicine::create ([
            'name' => $request->name, // name pada request adalah dari nama postnya
            'type' => $request->type,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        return redirect()->back()->with('success', 'Berhasil Menambahkan Data Obat');
    }

    /**
     * R : read, untuk menampilkan data spesifik atau hanya menampilkan data hanya 1
     */
    public function show(string $id)
    {
        //
    }

    /**
     * U : update, untuk menampilkan formulir edit data
     */
    public function edit(string $id)
    {
        //
        $medicine = Medicine::where('id', $id)->first();
        return view('medicine.edit', compact ('medicine'));
    }

    /**
     * U : update, untuk mengupdate data ke database atau mengeksekusi formulir edit
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate ([
            'name' => 'required|max:100',
            'type' => 'required|min:3',
            'price' => 'required|numeric',
            // 'stock' => 'required|numeric'
        ]);

         Medicine::where('id', $id)->update([
            'name' => $request->name,
            'type' => $request->type,
            'price' => $request->price,
            // 'stock' => $request->stock
         ]);

         return redirect()->route('obat.data')->with('success', 'Berhasil mengupdate data obat');
    }

    /**
     * D : delete, untuk menghapus data dari database
     */
    public function destroy(string $id)
    {
        //
        $deleteData = Medicine::where('id', $id)->delete();

        if ($deleteData) {
            return redirect ()->back()->with('success', 'Berhasil menghapus data obat');
        } else {
            return redirect ()->back()->with('error', 'Gagal menghapus data obat');
        }
    }

    public function updateStock(Request $request, $id)
    {
        //untuk modal tanpa ajax, tidak support validasi, jg digunakan isset untuk pengecekan required nya
        if (isset($request->stock) == FALSE) {
            $datasebelumnya = Medicine::where('id', $id)->first();
            //kembali dengan pesan, id sebelumnya, dan stock sebelumhya (stock awal)
            return redirect()->back()->with([
            'failed' => 'Stock Tidak Boleh Kosong!',
            'id' => $id,
            'stock' => $datasebelumnya->stock,
          ]);
        }

        //jika tidak kosng, langsung update stock
        Medicine::where('id', $id)->update([
            'stock' => $request->stock,
        ]);

        return redirect()->back()->with('success', 'Berhasil Mengupdate Stock Obat');
    }
}

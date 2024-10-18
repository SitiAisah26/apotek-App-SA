<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
// use : import file disesuaikan dengan namespace

use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::httpMethod('/isi-path', [NamaController::class, 'namaFunc'])->name('identitas_unique_route');
// httpMethod :
// 1. get->mengambil data/menampilkan halaman
// 2. post->menambahkan data ke db
// 3. put/patch->mengupdate data ke db
// 4. delete->menghapus data

// diakses sebelum login
Route::middleware(['isGuest'])->group(function () {
    Route::get('/', [UserController::class, 'login'])->name('login');
    Route::post('/login', [UserController::class, 'loginAuth'])->name('login.auth');
});
// diakses sesudah login
Route::middleware(['isLogin',])->group(function () {

    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/home', [UserController::class, 'home'])->name('home');

    Route::middleware(['isAdmin'])->group(function () {
        // //mengelola obat
        // Route::get('/data-obat', [MedicineController::class, 'index']) -> name('data_obat');
        // class menggunakan index karena di dalam medicine controllernya class index berfungsi untuk menambilkan data
        //fitur/bagian fitur
        //put/patch -> mengupdate data
        // {} dalam route namanya pet dinamis untuk mencari spesifik data
        Route::prefix('/obat')->name('obat.')->group(function () {
            Route::get('/tambah-obat', [MedicineController::class, 'create'])->name('tambah_obat');
            Route::post('/tambah-obat', [MedicineController::class, 'store'])->name('tambah_obat.formulir');
            Route::get('/data', [MedicineController::class, 'index'])->name('data');
            Route::delete('/hapus/{id}', [MedicineController::class, 'destroy'])->name('hapus');
            Route::get('/edit/{id}', [MedicineController::class, 'edit'])->name('edit');
            Route::patch('/edit/{id}', [MedicineController::class, 'update'])->name('edit.formulir');
            Route::get('/obat', [MedicineController::class, 'index'])->name('obat.index');
            Route::patch('/edit/stock/{id}', action: [MedicineController::class, 'updateStock'])->name('edit.stock');
        });

        // mengelola data akun
        // route mengelola data atau menampilkan class
        // prefix untuk mempersingkat nilai yang ada pada slice'
        Route::prefix('/akun')->name('akun.')->group(function () {
            Route::get('/data', [UserController::class, 'index'])->name('data');
            Route::get('/tambah', [UserController::class, 'create'])->name('tambah');
            Route::post('/tambah/akun', [UserController::class, 'store'])->name('tambah.akun');
            Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
            Route::patch('/edit/{id}', [UserController::class, 'update'])->name('edit.formulir');
            Route::delete('/hapus/{id}', [UserController::class, 'destroy'])->name('hapus');
        });

        // mengelola data pembayaran
        Route::get('/pembelian', [OrderController::class, 'index'])->name('pembelian');
        Route::get('/create/pembelian', [OrderController::class, 'create'])->name('tambah.pembelian');
        Route::post('/store/pembelian', [OrderController::class, 'store'])->name('store');
        Route::get('print/pembelian', [OrderController::class, 'show'])->name('print.pembelian');

    });
});


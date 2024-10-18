<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller

{
    public function index( Request $request) // menampilkan akun
    {
        $users = User::where('name', 'LIKE', '%' .$request->search_name . '%')->orderBy('name', 'ASC')->simplePaginate(5);
        return view('user.akun', compact('users')); // compact () untuk mengirim data ke view (isinya sama dengan $)
    }

    public function create() // menampilkan tambah akun
    {
        return view('user.tambah');
        // memanggil file blade
        // ('') -> name file blade, tambah nama file
    }
    public function store(Request $request) // untuk proses tambah akun
    {

        $request->validate([
            'name' => "required",
            'email' => "required",
            'role' => "required",
            'password' => "required",
        ]);
       User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), // untuk mengenskripsi data
            'role' => $request->role,

        ]);
        return redirect()->route('akun.data')->with('success', 'Berhasil menambahkan data user');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $users = User::where('id', $id)->first();
        return view('user.edit', compact ('users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    // Validasi input tanpa password
    $request->validate([
        'name' => 'required', // required -> harus diisi
        'email' => 'required',
        'password' => 'nullable',
        'role' => 'required',
    ]);

    // Ambil user berdasarkan ID
    $user = User::findOrFail($id);

    // Update fields
    $user->name = $request->name;
    $user->email = $request->email;
    $user->role = $request->role;

    // Simpan perubahan
    $user->save();

    return redirect()->route('akun.data')->with('success', 'Berhasil mengupdate data user');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $deleteData = User::where('id', $id)->delete();

        if ($deleteData) {
            return redirect ()->back()->with('success', 'Berhasil menghapus data akun');
        } else {
            return redirect ()->back()->with('error', 'Gagal menghapus data akun');
        }
    }

    public function login(){
        return view(view : 'login');
    }

    public function home() {
        return view(view : 'home');
    }
        
    public function loginAuth(Request $request)
    {
        $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required',
        ]);

        $user = $request->only([ 'email', 'password',]);
        if (Auth::attempt($user)) {
            return redirect()->route('home');
        } else {
            return redirect()->back()->with('failed', 'Proses login gagal, silahkan coba kembali dengan data yang benar!');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('logout', 'Anda telah logout!');
    }
}

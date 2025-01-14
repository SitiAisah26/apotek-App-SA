<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Http\Facades\Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('order.kasir.index');
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $medicines = Medicine::all();
        return view("order.kasir.create", compact('medicines'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name_customer' => 'required|max50',
            'medicines' => 'required',
        ]);

        //mencari jumlah item yg sama pd array
        $arrayDistinct = array_count_values($request->medicines)();
        // menyiapkan array kosong untuk menampung format array baru
        $arrayMedicines = [];

        foreach ($arrayDistinct as $id => $count) {
            $medicine = Medicine::where('id', $id)->first();

        $subPrice = $medicine['price'] * $count;

        $arrayItem = [
            "id" => $id,
            "name_medicines" => $medicine['name'],
            'quantity' => $count,
            'price' => $medicine['price'],
            'subPrice' => $subPrice,
            ];

        array_push($arrayMedicines, $arrayItem);
        }
        $totalPrice = 0;
        foreach ($arrayMedicines as $item) {
            $totalPrice += $item['subPrice'];
        }

        // harga total price ditambah 10%
        $pricePpn = $totalPrice +($totalPrice * 0.01);

        $proses = Order::create([
            "user_id" => FacadesAuth::user()->id,
            "medicines" => $arrayMedicines,
            "name_customer" => $request->name_customer,
            "total_price" => $pricePpn,
        ]);

        if ($proses) {
            $order = Order::where('user_id', FacadesAuth::user()->id)->orderBy('created_at', 'DESC')->first();
                return redirect()->route('kasir.order.print', $order['id']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $order = Order::find($id);
        return view('order.kasir.print', compact('order'));
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}

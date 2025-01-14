<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'medicines',
        'name_custmor',
        'total_price',
    ];

        //penegasan tipe data dari  migration(hasil property ini ketika di ambil atau diinsert/update dibuat dalam bentuk tipe data apa)

        protected $casts = [
            'medicines' => 'array',
        ];
}

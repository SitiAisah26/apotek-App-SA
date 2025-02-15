<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Kasir Apotek',
            'email' => 'kasir1@gmail.com',
            'password' => Hash::make('kasirapotek'),
            'role'=> 'kasir',
        ]);

        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('adminapotek'),
            'role'=> 'admin',
        ]);
    }
}

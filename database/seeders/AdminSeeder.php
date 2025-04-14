<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => Hash::make('12345678'),
            'role_as' => 1,
            'province_id' => null,
            'regency_id' => null,
            'district_id' => null,
            'village_id' => null,
            'alamat' => 'Kompleks PT.PLN P2B TJBB, Krukut, Kec. Limo, Kota Depok, Jawa Barat 16514',
            'tanda_tangan' => null,
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

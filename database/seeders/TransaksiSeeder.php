<?php

namespace Database\Seeders;

use App\Models\Transaksi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Transaksi::create([
            'date'      => date('Y-m-d H:i:s'),
            'user_id'   => 1,
            'from'      => 1,
            'to'        => 2,
            'amount'    => 20000,
            'cost'      => 0,
            'revenue'   => 0,
            'status'    => 'success',
            'desc'      => null,
        ]);
    }
}

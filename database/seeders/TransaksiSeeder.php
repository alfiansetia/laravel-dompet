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
        $transaksi = Transaksi::create([
            'date'      => date('Y-m-d H:i:s'),
            'user_id'   => 2,
            'from_id'   => 1,
            'to_id'     => 2,
            'amount'    => 20000,
            'cost'      => 0,
            'revenue'   => 0,
            'status'    => 'success',
            'desc'      => null,
        ]);

        $transaksi->from->update(['saldo' => $transaksi->from->saldo - $transaksi->amount - $transaksi->cost]);
        $transaksi->to->update(['saldo' => $transaksi->to->saldo + $transaksi->amount + $transaksi->revenue - $transaksi->cost]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Capital;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CapitalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cap1 = Capital::create([
            'user_id'   => 2,
            'date'      => date('Y-m-d H:i:s'),
            'dompet_id' => 1,
            'amount'    => 200000,
            'desc'      => 'Modal',
        ]);

        $cap1->dompet->update([
            'saldo' => $cap1->dompet->saldo + $cap1->amount
        ]);

        $cap2 = Capital::create([
            'user_id'   => 2,
            'date'      => date('Y-m-d H:i:s'),
            'dompet_id' => 2,
            'amount'    => 500000,
            'desc'      => 'Modal',
        ]);

        $cap2->dompet->update([
            'saldo' => $cap2->dompet->saldo + $cap2->amount
        ]);

        $cap3 = Capital::create([
            'user_id'   => 2,
            'date'      => date('Y-m-d H:i:s'),
            'dompet_id' => 3,
            'amount'    => 100000,
            'desc'      => 'Modal',
        ]);

        $cap3->dompet->update([
            'saldo' => $cap3->dompet->saldo + $cap3->amount
        ]);
    }
}

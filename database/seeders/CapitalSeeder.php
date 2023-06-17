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
        Capital::create([
            'date'      => date('Y-m-d H:i:s'),
            'dompet_id' => 1,
            'amount'    => 200000,
            'desc'      => 'Modal',
        ]);

        Capital::create([
            'date'      => date('Y-m-d H:i:s'),
            'dompet_id' => 2,
            'amount'    => 400000,
            'desc'      => 'Modal',
        ]);

        Capital::create([
            'date'      => date('Y-m-d H:i:s'),
            'dompet_id' => 2,
            'amount'    => 100000,
            'desc'      => 'Modal',
        ]);
    }
}

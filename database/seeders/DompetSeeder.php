<?php

namespace Database\Seeders;

use App\Models\Dompet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DompetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'DANA',
            'MITRA TOPED',
            'GOPAY',
            'OVO',
            'SPAY',
        ];

        Dompet::create([
            'name'       => 'CASH',
            'type'       => 'cash',
            'acc_name'   => 'Alf',
            'acc_number' => '12345'
        ]);

        foreach ($data as $item) {
            Dompet::create([
                'name'       => $item,
                'type'       => 'ewallet',
                'acc_name'   => 'Alf',
                'acc_number' => '12345'
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Expenditure;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExpenditureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $exp = Expenditure::create([
            'user_id'   => 2,
            'date'      => date('Y-m-d H:i:s'),
            'dompet_id' => 2,
            'amount'    => 2300,
            'desc'      => 'Tarik Saldo saleho',
        ]);

        $exp->dompet->update([
            'saldo' => $exp->dompet->saldo - $exp->amount
        ]);
    }
}

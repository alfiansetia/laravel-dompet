<?php

namespace Database\Seeders;

use App\Models\Comp;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Comp::create([
            'name'      => 'CELL ENK',
            'phone'     => '082324129752',
            'address'   => 'Jl Blora Jkt KM. 09',
        ]);
    }
}

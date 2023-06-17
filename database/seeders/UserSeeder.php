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
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name'      => 'User',
            'email'     => 'user@gmail.com',
            'phone'     => '082322323333',
            'password'  => Hash::make('user12345'),
            'role'      => 'user',
        ]);

        $admin = User::create([
            'name'      => 'Admin',
            'email'     => 'admin@gmail.com',
            'phone'     => '08343444452',
            'password'  => Hash::make('admin12345'),
            'role'      => 'admin',
        ]);
    }
}

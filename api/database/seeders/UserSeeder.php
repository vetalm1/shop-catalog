<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@test.ru',
            'phone' => '+7(924)111-11-11',
            'password' => Hash::make('password'),
            'phone_verified_at' => '2022-07-18 10:25:38',
            'email_verified_at' => '2022-07-18 10:25:38',
        ]);
    }
}

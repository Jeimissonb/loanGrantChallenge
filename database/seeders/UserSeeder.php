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
        User::create([
            'name' => 'Fernando',
            'email' => 'fernando-danatas@hotmail.com',
            'cpf' => '07598354030',
            'email_code' => '777777'
           ]);
        User::create([
            'name' => 'Nadir',
            'email' => 'nadirdantas000@gmail.com',
            'cpf' => '04774409081',
            'email_code' => '777777'
           ]);
    }
}

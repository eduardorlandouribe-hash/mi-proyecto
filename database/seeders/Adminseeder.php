<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class Adminseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'     => 'Administrador',
            'email'    => 'admin@ucc.edu.co',
            'password' => Hash::make('19087'),
            'rol'      => 'admin',
        ]);
    }
}

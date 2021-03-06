<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create([
            'name' => 'Administrador',
            'email' => 'administrador@axa.com.co',
            'password' => bcrypt('Colombia2022*'),
            'administrative_charge' => 'Administrador',
            'project' => 'Gestor de Usuarios',
            'active' => 1
        ]);
    }
}

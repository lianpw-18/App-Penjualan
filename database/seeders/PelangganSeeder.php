<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;

class PelangganSeeder extends Seeder
{
    public function run(): void
    {
        $role = Role::firstOrCreate(['role' => 'pelanggan']);

        User::firstOrCreate(['email' => 'pelanggan@gmail.com'], [
            'name'     => 'Siti Pelanggan',
            'password' => bcrypt('1234'),
            'role_id'  => $role->id,
        ]);
    }
}

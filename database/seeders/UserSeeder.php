<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt('12345678'),
        ])->assignRole('superadmin');
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),
        ])->assignRole('admin');
        User::create([
            'name' => 'Cajero',
            'email' => 'cajero@gmail.com',
            'password' => bcrypt('12345678'),
        ])->assignRole('cajero');
        User::create([
            'name' => 'Diseñador',
            'email' => 'diseñador@gmail.com',
            'password' => bcrypt('12345678'),
        ])->assignRole('diseñador');
        User::create([
            'name' => 'Impresor',
            'email' => 'impresor@gmail.com',
            'password' => bcrypt('12345678'),
        ])->assignRole('impresor');
    }
}

<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Client;
use App\Models\Departament;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(DepartamentSeeder::class);
        $this->call(ClientSeeder::class);
        $this->call(CategoriaSeeder::class);
        // $this->call(ProductSeeder::class);
        // $this->call(VentaSeeder::class);
        // $this->call(PaySeeder::class);
    }
}

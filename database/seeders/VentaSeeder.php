<?php

namespace Database\Seeders;

use App\Models\Venta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VentaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Venta::create([
            'id_user' => 1,
            'id_client' => 1,
            'id_product' => json_encode([
                'age' => 30,
                'city' => 'New York',
                'hobbies' => ['reading', 'traveling']
            ]),
            'subtotal' => 200,
            'total_price' => 1000,
            'extra' => 100,
            'balance' => 123,
            'discount' => 10,

        ]);
    }
}

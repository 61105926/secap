<?php

namespace Database\Seeders;

use App\Models\Pay;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pay::create([
            'id_user' => 1,
            'id_venta' => '1',
            'type_transfer' => 'cash',
            'amount' => 1000,
            'created_at' => Carbon::now()->subMonths(1),

        ]);
        Pay::create([
            'id_user' => 1,
            'id_venta' => '1',
            'type_transfer' => 'cash',
            'amount' => 6000,
            'created_at' => Carbon::now()->subMonths(2),

        ]);
        Pay::create([
            'id_user' => 1,
            'id_venta' => '1',
            'type_transfer' => 'cash',
            'amount' => 10000,
            'created_at' => Carbon::now()->subYear()->month(1)->startOfMonth(),

        ]);
        Pay::create([
            'id_user' => 1,
            'id_venta' => '1',
            'type_transfer' => 'cash',
            'amount' => 500,
            'created_at' => Carbon::now()->subYear()->month(2)->startOfMonth(),

        ]);
        Pay::create([
            'id_user' => 1,
            'id_venta' => '1',
            'type_transfer' => 'cash',
            'amount' => 4000,
            'created_at' => Carbon::now()->subYear()->month(3)->startOfMonth(),

        ]);
        Pay::create([
            'id_user' => 1,
            'id_venta' => '1',
            'type_transfer' => 'cash',
            'amount' => 20000,
            'created_at' => Carbon::now()->subYear()->month(4)->startOfMonth(),

        ]);
        Pay::create([
            'id_user' => 1,
            'id_venta' => '1',
            'type_transfer' => 'cash',
            'amount' => 7000,
            'created_at' => Carbon::now()->subMonths(3),

        ]);
        Pay::create([
            'id_user' => 1,
            'id_venta' => '1',
            'type_transfer' => 'cash',
            'amount' => 10000,
            'created_at' => Carbon::now()->subMonths(4),

        ]);
    }
}

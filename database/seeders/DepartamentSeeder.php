<?php

namespace Database\Seeders;

use App\Models\Departament;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartamentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Departament::create([
            'name' => 'La Paz',
            'abv' => 'LP'

        ]);
        Departament::create([
            'name' => 'Cochabamba',
            'abv' => 'CB'

        ]);
        Departament::create([
            'name' => 'Pando',
            'abv' => 'PD'

        ]);
        Departament::create([
            'name' => 'Santa Cruz',
            'abv' => 'SCZ'

        ]);
        Departament::create([
            'name' => 'Tarija',
            'abv' => 'TJ'

        ]);
        Departament::create([
            'name' => 'Potosí',
            'abv' => 'PT'

        ]);

        Departament::create([
            'name' => 'Chuquisaca',
            'abv' => 'CH'

        ]);
        Departament::create([
            'name' => 'Oruro',
            'abv' => 'OR'

        ]);
        Departament::create([
            'name' => 'Beni',
            'abv' => 'BN'
        ]);
    }
}

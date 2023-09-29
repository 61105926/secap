<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role1 =  Role::create(['name' => 'superadmin']);
        $role2 =  Role::create(['name' => 'admin']);
        $role3 =  Role::create(['name' => 'cajero']);
        $role4 =  Role::create(['name' => 'diseñador']);
        $role5 =  Role::create(['name' => 'impresor']);

        Permission::create(['name' => 'web.dashboard'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'web.usuarios'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'web.clientes'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name' => 'web.categoria'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'web.producto'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'web.venta'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name' => 'web.caja'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name' => 'web.cobros'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name' => 'web.gastos'])->syncRoles([$role1, $role2, $role3]);
    }
}

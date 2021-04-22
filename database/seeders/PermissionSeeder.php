<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::getQuery()->delete();
        Role::getQuery()->delete();
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'list organizations']);
        Permission::create(['name' => 'show organizations']);
        Permission::create(['name' => 'create organizations']);
        Permission::create(['name' => 'update organizations']);
        Permission::create(['name' => 'delete organizations']);

        $superAdminRole = Role::create(['name' => 'super-admin']);

        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo('create organizations');
        $adminRole->givePermissionTo('update organizations');
        $adminRole->givePermissionTo('delete organizations');

        $agentRole = Role::create(['name' => 'agent']);
        $agentRole->givePermissionTo('list organizations');
        $agentRole->givePermissionTo('show organizations');

        $userRole = Role::create(['name' => 'user']);
    }
}

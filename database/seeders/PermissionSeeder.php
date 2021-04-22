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
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'create organizations']);
        Permission::create(['name' => 'edit organizations']);
        Permission::create(['name' => 'delete organizations']);


        // create roles and assign existing permissions
        $superAdminRole = Role::create(['name' => 'super-admin']);

        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo('create organizations');
        $adminRole->givePermissionTo('edit organizations');
        $adminRole->givePermissionTo('delete organizations');

        $agentRole = Role::create(['name' => 'agent']);

        $userRole = Role::create(['name' => 'user']);
        



    }
}

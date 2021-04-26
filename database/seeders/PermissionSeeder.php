<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

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

        Permission::create(['name' => 'list companies']);
        Permission::create(['name' => 'show companies']);
        Permission::create(['name' => 'create companies']);
        Permission::create(['name' => 'update companies']);
        Permission::create(['name' => 'delete companies']);

        $superAdminRole = Role::create(['name' => 'super-admin']);

        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo('create organizations');
        $adminRole->givePermissionTo('update organizations');
        $adminRole->givePermissionTo('delete organizations');
        $adminRole->givePermissionTo('create companies');
        $adminRole->givePermissionTo('update companies');
        $adminRole->givePermissionTo('delete companies');

        $agentRole = Role::create(['name' => 'agent']);
        $agentRole->givePermissionTo('list organizations');
        $agentRole->givePermissionTo('show organizations');
        $agentRole->givePermissionTo('list companies');
        $agentRole->givePermissionTo('show companies');

        $userRole = Role::create(['name' => 'user']);

        app(CreatesNewUsers::class)
            ->create([
                'name'                  => 'Shane Poppleton',
                'email'                 => 'shane@alphasg.com.au',
                'password'              => 'secret123',
                'password_confirmation' => 'secret123'
            ])
            ->assignRole(['admin', 'agent'])
            ->update(['email_verified_at' => now()]);
    }
}

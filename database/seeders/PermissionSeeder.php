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
        Permission::create(['name' => 'edit organizations']);
        Permission::create(['name' => 'delete organizations']);

        Permission::create(['name' => 'list companies']);
        Permission::create(['name' => 'show companies']);
        Permission::create(['name' => 'create companies']);
        Permission::create(['name' => 'edit companies']);
        Permission::create(['name' => 'delete companies']);

        Permission::create(['name' => 'list notes']);
        Permission::create(['name' => 'favorite notes']);
        Permission::create(['name' => 'unfavorite notes']);
        Permission::create(['name' => 'delete notes']);
        Permission::create(['name' => 'create notes']);

        Permission::create(['name' => 'list tickets']);
        Permission::create(['name' => 'create tickets']);

        Permission::create(['name' => 'list users']);
        Permission::create(['name' => 'show users']);
        Permission::create(['name' => 'delete users']);
        Permission::create(['name' => 'edit users']);

        $superAdminRole = Role::create(['name' => 'super-admin']);

        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo('create organizations');
        $adminRole->givePermissionTo('edit organizations');
        $adminRole->givePermissionTo('delete organizations');
        $adminRole->givePermissionTo('create companies');
        $adminRole->givePermissionTo('edit companies');
        $adminRole->givePermissionTo('delete companies');
        $adminRole->givePermissionTo('delete notes');
        $adminRole->givePermissionTo('delete users');

        $agentRole = Role::create(['name' => 'agent']);
        $agentRole->givePermissionTo('list organizations');
        $agentRole->givePermissionTo('show organizations');
        $agentRole->givePermissionTo('list companies');
        $agentRole->givePermissionTo('show companies');
        $agentRole->givePermissionTo('list notes');
        $agentRole->givePermissionTo('favorite notes');
        $agentRole->givePermissionTo('unfavorite notes');
        $agentRole->givePermissionTo('create notes');
        $agentRole->givePermissionTo('list users');
        $agentRole->givePermissionTo('show users');
        $agentRole->givePermissionTo('edit users');

        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo('create tickets');

        $restrictedRole = Role::create(['name' => 'restricted user']);
        $restrictedRole->givePermissionTo('list tickets');


        app(CreatesNewUsers::class)
            ->create([
                'name'                  => 'Shane Poppleton',
                'email'                 => 'shane@alphasg.com.au',
                'password'              => 'secret123',
                'password_confirmation' => 'secret123'
            ])
            ->assignRole(['admin', 'agent', 'user', 'restricted user'])
            ->update(['email_verified_at' => now()]);
    }
}

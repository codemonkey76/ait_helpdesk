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

        Permission::create(['name' => 'list notes']);
        Permission::create(['name' => 'pin notes']);
        Permission::create(['name' => 'unpin notes']);
        Permission::create(['name' => 'delete notes']);
        Permission::create(['name' => 'create notes']);

        Permission::create(['name' => 'list tickets']);
        Permission::create(['name' => 'list own tickets']);
        Permission::create(['name' => 'create tickets']);
        Permission::create(['name' => 'create ticket for unassigned companies']);
        Permission::create(['name' => 'view all tickets']);
        Permission::create(['name' => 'delete tickets']);
        Permission::create(['name' => 'view own company tickets']);
        Permission::create(['name' => 'create job card']);
        Permission::create(['name' => 'create job']);

        Permission::create(['name' => 'respond to all tickets']);
        Permission::create(['name' => 'respond to own company tickets']);
        Permission::create(['name' => 'edit tickets']);
        Permission::create(['name' => 'change ticket status']);
        Permission::create(['name' => 'subscribe to tickets']);

        Permission::create(['name' => 'list users']);
        Permission::create(['name' => 'show users']);
        Permission::create(['name' => 'delete users']);
        Permission::create(['name' => 'update users']);

        Permission::create(['name' => 'view team settings']);
        Permission::create(['name' => 'create teams']);
        Permission::create(['name' => 'switch teams']);

        $superAdminRole = Role::create(['name' => 'super-admin']);

        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo('create organizations');
        $adminRole->givePermissionTo('update organizations');
        $adminRole->givePermissionTo('delete organizations');
        $adminRole->givePermissionTo('create companies');
        $adminRole->givePermissionTo('update companies');
        $adminRole->givePermissionTo('delete companies');
        $adminRole->givePermissionTo('delete notes');
        $adminRole->givePermissionTo('delete users');
        $adminRole->givePermissionto('delete tickets');

        $managerRole = Role::create(['name' => 'manager']);
        $managerRole->givePermissionTo('view own company tickets');
        $managerRole->givePermissionTo('respond to own company tickets');

        $accountsRole = Role::create(['name' => 'accounts']);

        $accountsRole->givePermissionTo('create job card');
        $accountsRole->givePermissionTo('create job');
        $accountsRole->givePermissionTo('change ticket status');


        $agentRole = Role::create(['name' => 'agent']);
        $agentRole->givePermissionTo('list organizations');
        $agentRole->givePermissionTo('show organizations');
        $agentRole->givePermissionTo('list companies');
        $agentRole->givePermissionTo('show companies');
        $agentRole->givePermissionTo('list notes');
        $agentRole->givePermissionTo('pin notes');
        $agentRole->givePermissionTo('unpin notes');
        $agentRole->givePermissionTo('create notes');
        $agentRole->givePermissionTo('list users');
        $agentRole->givePermissionTo('show users');
        $agentRole->givePermissionTo('update users');
        $agentRole->givePermissionTo('view team settings');
        $agentRole->givePermissionTo('create teams');
        $agentRole->givePermissionTo('list tickets');
        $agentRole->givePermissionTo('edit tickets');
        $agentRole->givePermissionTo('view all tickets');
        $agentRole->givePermissionTo('change ticket status');
        $agentRole->givePermissionTo('respond to all tickets');
        $agentRole->givePermissionTo('create job');
        $agentRole->givePermissionTo('create ticket for unassigned companies');

        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo('create tickets');
        $userRole->givePermissionTo('switch teams');

        $restrictedRole = Role::create(['name' => 'restricted user']);
        $restrictedRole->givePermissionTo('list own tickets');
        $restrictedRole->givePermissionTo('subscribe to tickets');

        $admin = app(CreatesNewUsers::class)
            ->create([
                'name'                  => 'Shane Poppleton',
                'email'                 => 'shane@alphasg.com.au',
                'phone'                 => '0400 588 588',
                'password'              => 'secret123',
                'password_confirmation' => 'secret123',
                'terms'                 => true
            ])
            ->assignRole(['admin', 'agent', 'user', 'restricted user']);
        $admin->update(['email_verified_at' => now()]);

    }
}

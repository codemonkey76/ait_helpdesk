<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Laravel\Fortify\Contracts\CreatesNewUsers;
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

        $this->createPermissions();
        $this->createAdmin();
        $this->createAgent();
        $this->createAccounts();
        $this->createManager();
        $this->createUser();
        $this->createRestrictedUser();

        $superAdminRole = Role::create(['name' => 'super-admin']);



        $admin = app(CreatesNewUsers::class)
            ->create([
                'name'                  => 'Shane Poppleton',
                'email'                 => 'shane@alphasg.com.au',
                'phone'                 => '0400 588 588',
                'password'              => 'secret123',
                'password_confirmation' => 'secret123',
                'terms'                 => true
            ])
            ->removeRole('user')
            ->assignRole('admin');
        $admin->update(['email_verified_at' => now()]);
    }

    public function createPermissions()
    {
        // Organizations
        Permission::create(['name' => 'list organizations']);
        Permission::create(['name' => 'show organizations']);
        Permission::create(['name' => 'create organizations']);
        Permission::create(['name' => 'update organizations']);
        Permission::create(['name' => 'delete organizations']);

        // Companies
        Permission::create(['name' => 'list companies']);
        Permission::create(['name' => 'show companies']);
        Permission::create(['name' => 'create companies']);
        Permission::create(['name' => 'update companies']);
        Permission::create(['name' => 'delete companies']);

        // Notes
        Permission::create(['name' => 'list notes']);
        Permission::create(['name' => 'pin notes']);
        Permission::create(['name' => 'unpin notes']);
        Permission::create(['name' => 'delete notes']);
        Permission::create(['name' => 'create notes']);

        // Tickets
        Permission::create(['name' => 'list tickets']);
        Permission::create(['name' => 'list own tickets']);
        Permission::create(['name' => 'create tickets']);
        Permission::create(['name' => 'create ticket for unassigned companies']);
        Permission::create(['name' => 'view all tickets']);
        Permission::create(['name' => 'delete tickets']);
        Permission::create(['name' => 'view own company tickets']);
        Permission::create(['name' => 'edit tickets']);
        Permission::create(['name' => 'change ticket status']);
        Permission::create(['name' => 'subscribe to tickets']);
        Permission::create(['name' => 'notified of new tickets']);

        // Responses
        Permission::create(['name' => 'delete own response']);
        Permission::create(['name' => 'delete all responses']);
        Permission::create(['name' => 'respond to all tickets']);
        Permission::create(['name' => 'edit own response']);
        Permission::create(['name' => 'edit all responses']);
        Permission::create(['name' => 'respond to own company tickets']);
        Permission::create(['name' => 'see private responses']);
        Permission::create(['name' => 'create private responses']);

        // Jobs
        Permission::create(['name' => 'create job']);
        Permission::create(['name' => 'see jobs']);
        Permission::create(['name' => 'see status changes']);
        // Job Cards
        Permission::create(['name' => 'create job card']);

        // Users
        Permission::create(['name' => 'list users']);
        Permission::create(['name' => 'show users']);
        Permission::create(['name' => 'delete users']);
        Permission::create(['name' => 'update users']);
        Permission::create(['name' => 'attach companies']);
        Permission::create(['name' => 'detach companies']);

        // Teams
        Permission::create(['name' => 'view team settings']);
        Permission::create(['name' => 'create teams']);
        Permission::create(['name' => 'switch teams']);

        // Permissions
        Permission::create(['name' => 'list permissions']);
        Permission::create(['name' => 'delete permissions']);
        Permission::create(['name' => 'edit permissions']);
        Permission::create(['name' => 'create permissions']);

        Permission::create(['name' => 'list roles']);
        Permission::create(['name' => 'delete roles']);
        Permission::create(['name' => 'edit roles']);
        Permission::create(['name' => 'create roles']);

        Permission::create(['name' => 'attach permissions']);
        Permission::create(['name' => 'detach permissions']);
    }


    public function createAgent()
    {
        $agentRole = Role::create(['name' => 'agent']);

        // Organizations
        $agentRole->givePermissionTo('list organizations');
        $agentRole->givePermissionTo('show organizations');
        $agentRole->givePermissionTo('create organizations');
        $agentRole->givePermissionTo('update organizations');
        $agentRole->givePermissionTo('delete organizations');

        // Companies
        $agentRole->givePermissionTo('list companies');
        $agentRole->givePermissionTo('show companies');
        $agentRole->givePermissionTo('create companies');
        $agentRole->givePermissionTo('update companies');
        $agentRole->givePermissionTo('delete companies');

        // Notes
        $agentRole->givePermissionTo('list notes');
        $agentRole->givePermissionTo('pin notes');
        $agentRole->givePermissionTo('unpin notes');
        $agentRole->givePermissionTo('create notes');
        $agentRole->givePermissionTo('delete notes');

        // Tickets
        $agentRole->givePermissionTo('list tickets');
        $agentRole->givePermissionTo('list own tickets');
        $agentRole->givePermissionTo('edit tickets');
        $agentRole->givePermissionTo('view all tickets');
        $agentRole->givePermissionTo('change ticket status');
        $agentRole->givePermissionTo('respond to all tickets');
        $agentRole->givePermissionTo('create tickets');
        $agentRole->givePermissionTo('create ticket for unassigned companies');
        $agentRole->givePermissionTo('delete tickets');
        $agentRole->givePermissionTo('view own company tickets');
        $agentRole->givePermissionTo('subscribe to tickets');
        $agentRole->givePermissionTo('notified of new tickets');

        // Ticket Responses
        $agentRole->givePermissionTo('edit own response');
        $agentRole->givePermissionTo('delete own response');
        $agentRole->givePermissionTo('respond to all tickets');
        $agentRole->givePermissionTo('respond to own company tickets');
        $agentRole->givePermissionTo('see private responses');
        $agentRole->givePermissionTo('create private responses');

        // Jobs
        $agentRole->givePermissionTo('create job');
        $agentRole->givePermissionTo('see jobs');
        $agentRole->givePermissionTo('see status changes');

        // Users
        $agentRole->givePermissionTo('list users');
        $agentRole->givePermissionTo('show users');
        $agentRole->givePermissionTo('attach companies');
        $agentRole->givePermissionTo('detach companies');
    }

    public function createAdmin()
    {
        $adminRole = Role::create(['name' => 'admin']);

        // Organizations
        $adminRole->givePermissionTo('list organizations');
        $adminRole->givePermissionTo('show organizations');
        $adminRole->givePermissionTo('create organizations');
        $adminRole->givePermissionTo('update organizations');
        $adminRole->givePermissionTo('delete organizations');

        // Companies
        $adminRole->givePermissionTo('list companies');
        $adminRole->givePermissionTo('show companies');
        $adminRole->givePermissionTo('create companies');
        $adminRole->givePermissionTo('update companies');
        $adminRole->givePermissionTo('delete companies');

        // Notes
        $adminRole->givePermissionTo('list notes');
        $adminRole->givePermissionTo('pin notes');
        $adminRole->givePermissionTo('unpin notes');
        $adminRole->givePermissionTo('delete notes');
        $adminRole->givePermissionTo('create notes');

        // Tickets
        $adminRole->givePermissionTo('list tickets');
        $adminRole->givePermissionTo('list own tickets');
        $adminRole->givePermissionTo('create tickets');
        $adminRole->givePermissionTo('create ticket for unassigned companies');
        $adminRole->givePermissionTo('view all tickets');
        $adminRole->givePermissionTo('delete tickets');
        $adminRole->givePermissionTo('view own company tickets');
        $adminRole->givePermissionTo('edit tickets');
        $adminRole->givePermissionTo('change ticket status');
        $adminRole->givePermissionTo('subscribe to tickets');
        $adminRole->givePermissionTo('notified of new tickets');

        // Responses
        $adminRole->givePermissionTo('delete own response');
        $adminRole->givePermissionTo('delete all responses');
        $adminRole->givePermissionTo('respond to all tickets');
        $adminRole->givePermissionTo('edit own response');
        $adminRole->givePermissionTo('edit all responses');
        $adminRole->givePermissionTo('respond to own company tickets');
        $adminRole->givePermissionTo('see private responses');
        $adminRole->givePermissionTo('create private responses');
        // Jobs
        $adminRole->givePermissionTo('create job');
        $adminRole->givePermissionTo('see jobs');
        $adminRole->givePermissionTo('see status changes');

        // Job Cards
        $adminRole->givePermissionTo('create job card');

        // Users
        $adminRole->givePermissionTo('list users');
        $adminRole->givePermissionTo('show users');
        $adminRole->givePermissionTo('delete users');
        $adminRole->givePermissionTo('update users');
        $adminRole->givePermissionTo('attach companies');
        $adminRole->givePermissionTo('detach companies');

        // Teams
        $adminRole->givePermissionTo('view team settings');
        $adminRole->givePermissionTo('create teams');
        $adminRole->givePermissionTo('switch teams');

        // Permissions
        $adminRole->givePermissionTo('list permissions');
        $adminRole->givePermissionTo('delete permissions');
        $adminRole->givePermissionTo('edit permissions');
        $adminRole->givePermissionTo('create permissions');

        $adminRole->givePermissionTo('list roles');
        $adminRole->givePermissionTo('delete roles');
        $adminRole->givePermissionTo('edit roles');
        $adminRole->givePermissionTo('create roles');

        $adminRole->givePermissionTo('attach permissions');
        $adminRole->givePermissionTo('detach permissions');
        $adminRole->givePermissionTo('create organizations');
        $adminRole->givePermissionTo('update organizations');
        $adminRole->givePermissionTo('delete organizations');
        $adminRole->givePermissionTo('create companies');
        $adminRole->givePermissionTo('update companies');
        $adminRole->givePermissionTo('delete companies');
        $adminRole->givePermissionTo('delete notes');
        $adminRole->givePermissionTo('delete users');
        $adminRole->givePermissionTo('delete tickets');
        $adminRole->givePermissionTo('edit all responses');
        $adminRole->givePermissionTo('delete all responses');
        $adminRole->givePermissionTo('list permissions');
        $adminRole->givePermissionTo('edit permissions');
        $adminRole->givePermissionTo('create permissions');
        $adminRole->givePermissionTo('delete permissions');
        $adminRole->givePermissionTo('list roles');
        $adminRole->givePermissionTo('edit roles');
        $adminRole->givePermissionTo('create roles');
        $adminRole->givePermissionTo('delete roles');
        $adminRole->givePermissionTo('create job card');
        $adminRole->givePermissionTo('attach permissions');
        $adminRole->givePermissionTo('detach permissions');
    }
    public function createAccounts()
    {
        $accountsRole = Role::create(['name' => 'accounts']);

        // Organizations
        $accountsRole->givePermissionTo('list organizations');
        $accountsRole->givePermissionTo('show organizations');
        $accountsRole->givePermissionTo('create organizations');
        $accountsRole->givePermissionTo('update organizations');

        // Companies
        $accountsRole->givePermissionTo('list companies');
        $accountsRole->givePermissionTo('show companies');
        $accountsRole->givePermissionTo('create companies');
        $accountsRole->givePermissionTo('update companies');

        // Notes
        $accountsRole->givePermissionTo('list notes');
        $accountsRole->givePermissionTo('create notes');

        // Tickets
        $accountsRole->givePermissionTo('list tickets');
        $accountsRole->givePermissionTo('list own tickets');
        $accountsRole->givePermissionTo('edit tickets');
        $accountsRole->givePermissionTo('view all tickets');
        $accountsRole->givePermissionTo('change ticket status');
        $accountsRole->givePermissionTo('respond to all tickets');
        $accountsRole->givePermissionTo('create tickets');
        $accountsRole->givePermissionTo('create ticket for unassigned companies');
        $accountsRole->givePermissionTo('view own company tickets');
        $accountsRole->givePermissionTo('subscribe to tickets');

        // Ticket Responses
        $accountsRole->givePermissionTo('edit own response');
        $accountsRole->givePermissionTo('delete own response');
        $accountsRole->givePermissionTo('respond to all tickets');
        $accountsRole->givePermissionTo('respond to own company tickets');
        $accountsRole->givePermissionTo('see private responses');
        $accountsRole->givePermissionTo('create private responses');

        // Jobs
        $accountsRole->givePermissionTo('create job');
        $accountsRole->givePermissionTo('see jobs');
        $accountsRole->givePermissionTo('see status changes');
        $accountsRole->givePermissionTo('create job card');

        // Users
        $accountsRole->givePermissionTo('list users');
        $accountsRole->givePermissionTo('show users');
        $accountsRole->givePermissionTo('attach companies');
        $accountsRole->givePermissionTo('detach companies');
    }
    public function createManager()
    {
        $managerRole = Role::create(['name' => 'manager']);

        // Tickets
        $managerRole->givePermissionTo('list own tickets');
        $managerRole->givePermissionTo('create tickets');
        $managerRole->givePermissionTo('view own company tickets');
        $managerRole->givePermissionTo('subscribe to tickets');

        // Ticket Responses
        $managerRole->givePermissionTo('edit own response');
        $managerRole->givePermissionTo('delete own response');
        $managerRole->givePermissionTo('respond to own company tickets');
    }

    public function createUser()
    {
        $userRole = Role::create(['name' => 'user']);

        $userRole->givePermissionTo('list own tickets');
        $userRole->givePermissionTo('create tickets');
        $userRole->givePermissionTo('subscribe to tickets');

        // Ticket Responses
        $userRole->givePermissionTo('edit own response');
        $userRole->givePermissionTo('delete own response');
        $userRole->givePermissionTo('create tickets');

        $userRole->givePermissionTo('see status changes');
    }

    public function createRestrictedUser()
    {
        $restrictedRole = Role::create(['name' => 'restricted user']);
        $restrictedRole->givePermissionTo('list own tickets');
        $restrictedRole->givePermissionTo('create tickets');
        $restrictedRole->givePermissionTo('subscribe to tickets');

        // Ticket Responses
        $restrictedRole->givePermissionTo('edit own response');
        $restrictedRole->givePermissionTo('delete own response');
    }
}

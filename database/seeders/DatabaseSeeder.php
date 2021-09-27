<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Note;
use App\Models\Organization;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Artisan::call('scout:flush', [User::class]);
        Artisan::call('scout:flush', [Organization::class]);
        Artisan::call('scout:flush',  [Company::class]);
        Artisan::call('scout:flush', [Note::class]);
        Artisan::call('scout:flush', [Ticket::class]);

        //Create permissions and roles and admin user
        $this->call(PermissionSeeder::class);

        //Create default teams
        //$this->call(TeamSeeder::class);

        //Create orgs and companies
        $this->call(OrganizationSeeder::class);
        $this->call(CompanySeeder::class);

        //Create some standard users
        $this->call(UserSeeder::class);

        // Setup ticket statuses
        $this->call(TicketStatusSeeder::class);
    }
}

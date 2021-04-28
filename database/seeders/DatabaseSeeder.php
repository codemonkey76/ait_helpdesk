<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //Create permissions and roles and admin user
        $this->call(PermissionSeeder::class);

        //Create some standard users
        $this->call(UserSeeder::class);

        //Create orgs and companies
        $this->call(OrganizationSeeder::class);
        $this->call(CompanySeeder::class);

        //Create some notes
        $this->call(NoteSeeder::class);

        //Create some tickets
        $this->call(TicketSeeder::class);

    }
}

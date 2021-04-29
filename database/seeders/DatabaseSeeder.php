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
        Artisan::call('scout:flush', ['model' => User::class]);
        Artisan::call('scout:flush', ['model' => Organization::class]);
        Artisan::call('scout:flush', ['model' => Company::class]);
        Artisan::call('scout:flush', ['model' => Note::class]);
        Artisan::call('scout:flush', ['model' => Ticket::class]);


        //Create permissions and roles and admin user
        $this->call(PermissionSeeder::class);

        //Create default teams
        $this->call(TeamSeeder::class);

        //Create orgs and companies
        $this->call(OrganizationSeeder::class);
        $this->call(CompanySeeder::class);

        //Create some standard users
        $this->call(UserSeeder::class);

        //Create some notes
        $this->call(NoteSeeder::class);

        //Create some tickets
        $this->call(TicketSeeder::class);


    }
}

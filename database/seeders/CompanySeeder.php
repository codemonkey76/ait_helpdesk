<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Organization;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Organization::each(fn($org) =>
            Company::factory()
                ->count(mt_rand(1, 5))
                ->create(['organization_id' => $org->id])
        );
    }
}

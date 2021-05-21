<?php

namespace Database\Seeders;

use App\Models\Organization;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Organization::factory()->count(10)->create();

        $org = Organization::create(['name' => 'Alpha Solutions Group']);
        $org->companies()->create([
            'name' => 'Alpha IT Centre',
            'address' => '1/48 Lillian Ave',
            'suburb' => 'Salisbury',
            'state' => 'QLD',
            'postcode' => '4107',
            'phone' => '07 3277 3636'
        ]);
    }
}

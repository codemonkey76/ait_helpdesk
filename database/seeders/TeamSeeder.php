<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminUser = User::find(1);

        Team::create([
            'name' => 'Support',
            'user_id' => $adminUser->id,
            'personal_team' => false
        ]);
        Team::create([
            'name' => 'Sales',
            'user_id' => $adminUser->id,
            'personal_team' => false
        ]);
        Team::create([
            'name' => 'Accounts',
            'user_id' => $adminUser->id,
            'personal_team' => false
        ]);
    }
}

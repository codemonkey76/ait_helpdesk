<?php

namespace Database\Seeders;

use App\Actions\Fortify\CreateNewUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
            ->count(30)
            ->withPersonalTeam()
            ->state(new Sequence(
                ['email_verified_at' => now()],
                ['email_verified_at' => null]
            ))
            ->create();
    }
}

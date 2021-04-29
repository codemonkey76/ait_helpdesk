<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::all()->each(fn($user) =>
            Ticket::factory()
                ->count(mt_rand(1, 5))
                ->state(new Sequence(
                    ['company_id' => $user->company?->id],
                    ['company_id' => null]
                ))
                ->state(new Sequence(fn() => ['current_team_id' => Team::inRandomOrder()->first()->id]))
                ->create([
                    'user_id' => $user->id,
                ])

        );
    }
}

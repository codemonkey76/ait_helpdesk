<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\User;
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
                ->create([
                    'user_id' => $user->id,
                ])
        );
    }
}

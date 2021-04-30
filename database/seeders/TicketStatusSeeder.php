<?php

namespace Database\Seeders;

use App\Models\TicketStatus;
use Illuminate\Database\Seeder;

class TicketStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TicketStatus::create(['name' => 'Pending', 'description' => 'Yet to be looked at']);
        TicketStatus::create(['name' => 'Open', 'description' => 'Currently being worked on']);
        TicketStatus::create(['name' => 'Waiting', 'description' => 'Waiting on customer']);
        TicketStatus::create(['name' => 'Billing', 'description' => 'Awaiting billing']);
        TicketStatus::create(['name' => 'Closed', 'description' => 'Completed or cancelled']);
    }
}

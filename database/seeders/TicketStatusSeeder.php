<?php

namespace Database\Seeders;

use App\Enums\TICKET_STATUS;
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
        TicketStatus::create([
            'id'          => TICKET_STATUS::PENDING,
            'name'        => 'Pending',
            'description' => 'Yet to be looked at'
        ]);
        TicketStatus::create([
            'id'          => TICKET_STATUS::OPEN,
            'name'        => 'Open',
            'description' => 'Currently being worked on'
        ]);
        TicketStatus::create([
            'id'          => TICKET_STATUS::WAITING,
            'name'        => 'Waiting',
            'description' => 'Waiting on customer'
        ]);
        TicketStatus::create([
            'id'          => TICKET_STATUS::BILLING,
            'name'        => 'Billing',
            'description' => 'Awaiting billing'
        ]);
        TicketStatus::create([
            'id'          => TICKET_STATUS::CLOSED,
            'name'        => 'Closed',
            'description' => 'Completed or cancelled',
            'final'       => true
        ]);
    }
}

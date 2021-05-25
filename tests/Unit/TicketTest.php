<?php

namespace Tests\Unit;


use App\Models\Job;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketTest extends TestCase
{
    use RefreshDatabase;

    public function test_ticket_can_get_job_summary()
    {
        $ticket = Ticket::factory()->create();
        $agent = User::factory()->withPersonalTeam()->create(['name' => 'Agent name']);

        $job = Job::factory(3)->create([
            'ticket_id'  => $ticket->id,
            'content'    => 'content',
            'time_spent' => 30,
            'user_id'    => $agent->id
        ]);

        $this->assertEquals(<<<TEXT
25/05/2021
content

Agent: Agent name
Time: 30 minutes


25/05/2021
content

Agent: Agent name
Time: 30 minutes


25/05/2021
content

Agent: Agent name
Time: 30 minutes
TEXT
            , $ticket->jobSummary);
    }
}

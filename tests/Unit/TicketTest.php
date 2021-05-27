<?php

namespace Tests\Unit;


use App\Models\Job;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Database\Seeders\PermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(PermissionSeeder::class);
    }

    public function test_ticket_can_get_job_summary()
    {
        $ticket = Ticket::factory()->create();
        $agent = User::factory()->create(['name' => 'Agent name']);

        $job = Job::factory(3)->create([
            'ticket_id'  => $ticket->id,
            'content'    => 'content',
            'time_spent' => 30,
            'user_id'    => $agent->id,
            'date'  => Carbon::create(2021,05,25,9,0,0)
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

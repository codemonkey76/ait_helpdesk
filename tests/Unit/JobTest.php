<?php

namespace Tests\Unit;

use App\Models\Job;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Database\Seeders\PermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JobTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(PermissionSeeder::class);
    }

    public function test_job_can_retrieve_summary()
    {
        $ticket = Ticket::factory()->create();
        $agentUser = User::factory()->withPersonalTeam()->create(['name' => 'Agent name'])->assignRole('agent');
        $jobs = Job::factory(3)->create([
            'ticket_id'  => $ticket->id,
            'user_id'    => $agentUser->id,
            'time_spent' => 30,
            'content'    => 'Test job message 1
Test job message 2
Test job message 3',
            'date'       => Carbon::create(2021, 5, 25, 9, 0, 0, 'Australia/Brisbane')
        ]);

        $firstJob = $jobs->first();
        $this->assertEquals(
            <<<TEXT
25/05/2021
Test job message 1
Test job message 2
Test job message 3

Agent: Agent name
Time: 30 minutes
TEXT
            ,
            $firstJob->summary);
    }
}

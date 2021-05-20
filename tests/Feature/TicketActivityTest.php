<?php

namespace Tests\Feature;

use App\Enums\TICKET_STATUS;
use App\Models\Ticket;
use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\TicketStatusSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TicketActivityTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Ticket $ticket;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(PermissionSeeder::class);
        $this->seed(TicketStatusSeeder::class);
        $this->user = User::factory()->withPersonalTeam()->create();
        $this->ticket = Ticket::factory()->statusOpen()->create(['user_id' => $this->user->id]);

    }

    public function test_ticket_will_record_activity_when_status_is_changed()
    {
        $this->assertCount(0, $this->ticket->activity);

        $this->actingAs($this->user)->ticket->update(['status_id' => TICKET_STATUS::WAITING]);

        $this->assertCount(1, $this->ticket->fresh()->activity);
    }

    public function test_ticket_will_record_activity_when_responded_to()
    {
        $this->assertCount(0, $this->ticket->activity);

        $this->actingAs($this->user);

        $this->ticket->responses()->create([
            'user_id' => $this->user->id,
            'content' => 'some content'
        ]);

        $this->assertCount(1, $this->ticket->fresh()->activity);
    }

    public function test_ticket_will_record_activity_when_jobs_are_added()
    {
        $this->assertCount(0, $this->ticket->activity);
        $this->actingAs($this->user);

        $this->ticket->addJob(now(), 15, 'some content', $this->user);

        $this->assertCount(1, $this->ticket->fresh()->activity);
    }
}

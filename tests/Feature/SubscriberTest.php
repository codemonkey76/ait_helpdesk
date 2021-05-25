<?php

namespace Tests\Feature;

use App\Models\Ticket;
use App\Models\User;
use App\Notifications\TicketCreated;
use App\Notifications\TicketRespondedTo;
use Database\Seeders\PermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SubscriberTest extends TestCase
{
    use RefreshDatabase;

    private User $agent;
    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(PermissionSeeder::class);
        $this->user = User::factory()->withPersonalTeam()->create()->assignRole('user');
        $this->agent = User::factory()->withPersonalTeam()->create()->assignRole('agent');
    }

    public function test_subscriber_received_notification_when_ticket_is_responded_to()
    {
        Notification::fake();
        // We have a ticket and a user, and user is subscribed to ticket
        $ticket = Ticket::factory()->create();
        $ticket->subscribers()->syncWithoutDetaching($this->user->id);


        $ticket->responses()->create([
            'content' => 'some content',
            'user_id' => $this->agent->id
        ]);
        Notification::assertSentTo($this->user, TicketRespondedTo::class);
    }

    public function test_subscriber_doesnt_receive_notification_when_they_respond_to_ticket()
    {
        Notification::fake();
        // We have a ticket and a user, and user is subscribed to ticket
        $ticket = Ticket::factory()->create();

        $ticket->subscribers()->syncWithoutDetaching($this->user->id);

        $ticket->responses()->create([
            'content' => 'some content',
            'user_id' => $this->user->id
        ]);
        Notification::assertNotSentTo($this->user, TicketRespondedTo::class);
    }

    public function test_assigned_agent_receives_notifications_when_ticket_is_responded_to()
    {
        Notification::fake();
        // We have a ticket and a user, and user is subscribed to ticket
        $ticket = Ticket::factory()->create(['assigned_agent_id' => $this->agent->id]);

        $ticket->responses()->create([
            'content' => 'some content',
            'user_id' => $this->user->id
        ]);

        Notification::assertSentTo($this->agent, TicketRespondedTo::class);
    }

    public function test_assigned_agent_doesnt_receive_notification_when_they_respond_to_ticket()
    {
        Notification::fake();
        // We have a ticket and a user, and user is subscribed to ticket
        $ticket = Ticket::factory()->create(['assigned_agent_id' => $this->agent->id]);

        $ticket->responses()->create([
            'content' => 'some content',
            'user_id' => $this->user->id
        ]);
        Notification::assertSentTo($this->agent, TicketRespondedTo::class);
    }

    public function test_assigned_owner_receives_notifications_when_ticket_is_responded_to()
    {
        Notification::fake();
        // We have a ticket and a user, and user is subscribed to ticket
        $ticket = Ticket::factory()->create(['owner_id' => $this->user->id]);

        $ticket->responses()->create([
            'content' => 'some content',
            'user_id' => $this->agent->id
        ]);

        Notification::assertSentTo($this->user, TicketRespondedTo::class);
    }

    public function test_assigned_owner_doesnt_receive_notifications_when_they_respond_to_ticket()
    {
        Notification::fake();
        // We have a ticket and a user, and user is subscribed to ticket
        $ticket = Ticket::factory()->create(['owner_id' => $this->user->id]);

        $ticket->responses()->create([
            'content' => 'some content',
            'user_id' => $this->user->id
        ]);

        Notification::assertNotSentTo($this->user, TicketRespondedTo::class);
    }

    public function test_subscriber_doesnt_receive_notification_when_response_is_private()
    {
        Notification::fake();
        // We have a ticket and a user, and user is subscribed to ticket
        $ticket = Ticket::factory()->create();
        $ticket->subscribers()->syncWithoutDetaching($this->user->id);


        $ticket->responses()->create([
            'content' => 'some content',
            'user_id' => $this->agent->id,
            'private' => true
        ]);
        Notification::assertNotSentTo($this->user, TicketRespondedTo::class);
    }

    public function test_agent_receives_notification_when_ticket_is_created()
    {
        Notification::fake();
        // We have a ticket and a user, and user is subscribed to ticket
        $this->agent = User::factory()->withPersonalTeam()->create()->assignRole('agent');
        $ticket = Ticket::factory()->create(['owner_id' => $this->user->id]);

        Notification::assertSentTo($this->agent, TicketCreated::class);
    }
}

<?php

namespace Tests\Feature;

use App\Models\Ticket;
use App\Models\User;
use App\Notifications\TicketRespondedTo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SubscriberTest extends TestCase
{
    use RefreshDatabase;

    public function test_subscriber_received_notification_when_ticket_is_responded_to()
    {
        Notification::fake();
        // We have a ticket and a user, and user is subscribed to ticket
        $ticket = Ticket::factory()->create();
        $user = User::factory()->withPersonalTeam()->create();
        $ticket->subscribers()->syncWithoutDetaching($user->id);
        $agent = User::factory()->withPersonalTeam()->create();


        $ticket->responses()->create([
            'content' => 'some content',
            'user_id' => $agent->id
        ]);
        Notification::assertSentTo($user, TicketRespondedTo::class);
    }

    public function test_subscriber_doesnt_receive_notification_when_they_respond_to_ticket()
    {
        Notification::fake();
        // We have a ticket and a user, and user is subscribed to ticket
        $ticket = Ticket::factory()->create();
        $user = User::factory()->withPersonalTeam()->create();
        $ticket->subscribers()->syncWithoutDetaching($user->id);
        $agent = User::factory()->withPersonalTeam()->create();


        $ticket->responses()->create([
            'content' => 'some content',
            'user_id' => $user->id
        ]);
        Notification::assertNotSentTo($user, TicketRespondedTo::class);
    }

    public function test_assigned_agent_receives_notifications_when_ticket_is_responded_to()
    {
        Notification::fake();
        // We have a ticket and a user, and user is subscribed to ticket
        $agent = User::factory()->withPersonalTeam()->create();
        $ticket = Ticket::factory()->create(['assigned_agent_id' => $agent->id]);
        $user = User::factory()->withPersonalTeam()->create();

        $ticket->responses()->create([
            'content' => 'some content',
            'user_id' => $user->id
        ]);

        Notification::assertSentTo($agent, TicketRespondedTo::class);
    }

    public function test_assigned_agent_doesnt_receive_notification_when_they_respond_to_ticket()
    {
        Notification::fake();
        // We have a ticket and a user, and user is subscribed to ticket
        $agent = User::factory()->withPersonalTeam()->create();
        $ticket = Ticket::factory()->create(['assigned_agent_id' => $agent->id]);
        $user = User::factory()->withPersonalTeam()->create();

        $ticket->responses()->create([
            'content' => 'some content',
            'user_id' => $user->id
        ]);
        Notification::assertSentTo($agent, TicketRespondedTo::class);
    }

    public function test_assigned_owner_receives_notifications_when_ticket_is_responded_to()
    {
        Notification::fake();
        // We have a ticket and a user, and user is subscribed to ticket
        $user = User::factory()->withPersonalTeam()->create();
        $ticket = Ticket::factory()->create(['owner_id' => $user->id]);
        $agent = User::factory()->withPersonalTeam()->create();

        $ticket->responses()->create([
            'content' => 'some content',
            'user_id' => $agent->id
        ]);

        Notification::assertSentTo($user, TicketRespondedTo::class);
    }

    public function test_assigned_owner_doesnt_receive_notifications_when_they_respond_to_ticket()
    {
        Notification::fake();
        // We have a ticket and a user, and user is subscribed to ticket
        $user = User::factory()->withPersonalTeam()->create();
        $ticket = Ticket::factory()->create(['owner_id' => $user->id]);

        $ticket->responses()->create([
            'content' => 'some content',
            'user_id' => $user->id
        ]);

        Notification::assertNotSentTo($user, TicketRespondedTo::class);
    }

    public function test_subscriber_receives_notification_via_preferred_method()
    {
        $this->markTestSkipped('Not yet implemented');
    }

    public function test_subscriber_doesnt_receive_notification_when_response_is_private()
    {
        Notification::fake();
        // We have a ticket and a user, and user is subscribed to ticket
        $ticket = Ticket::factory()->create();
        $user = User::factory()->withPersonalTeam()->create();
        $ticket->subscribers()->syncWithoutDetaching($user->id);
        $agent = User::factory()->withPersonalTeam()->create();


        $ticket->responses()->create([
            'content' => 'some content',
            'user_id' => $agent->id,
            'private' => true
        ]);
        Notification::assertNotSentTo($user, TicketRespondedTo::class);
    }

    public function test_ticket_owner_receives_notifications_via_preferred_method()
    {
        $this->markTestSkipped('Not yet implemented');
    }

    public function test_ticket_owner_receives_notifications_when_ticket_is_responded_to()
    {
        $this->markTestSkipped('Not yet implemented');
    }

    public function test_agent_receives_notification_when_ticket_is_created()
    {
        $this->markTestSkipped('Not yet implemented');
    }

    public function test_agent_receives_notification_by_preferred_method()
    {
        $this->markTestSkipped('Not yet implemented');
    }
}

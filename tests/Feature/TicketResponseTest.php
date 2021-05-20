<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Organization;
use App\Models\Ticket;
use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TicketResponseTest extends TestCase
{
    use RefreshDatabase;

    private User $adminUser;
    private User $agentUser;
    private User $managerUser;
    private User $standardUser;
    private Company $company1;
    private Company $company2;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(PermissionSeeder::class);

        $this->adminUser = User::factory()->withPersonalTeam()->create()->assignRole([
            'admin', 'agent', 'user', 'restricted user'
        ]);
        $this->managerUser = User::factory()->withPersonalTeam()->create()->assignRole([
            'manager', 'user', 'restricted user'
        ]);
        $this->agentUser = User::factory()->withPersonalTeam()->create()->assignRole([
            'agent', 'manager', 'user', 'restricted user'
        ]);
        $this->standardUser = User::factory()->withPersonalTeam()->create()->assignRole(['user', 'restricted user']);

        $organization = Organization::factory()->create();
        $this->company1 = Company::factory()->create(['organization_id' => $organization->id]);
        $this->company2 = Company::factory()->create(['organization_id' => $organization->id]);
    }

    public function test_user_can_respond_to_their_own_ticket()
    {
        $ticket = Ticket::factory()->create([
            'user_id'    => $this->standardUser->id,
            'company_id' => $this->company1->id
        ]);

        $this->company1->users()->attach([$this->standardUser->id]);

        $response = $this->actingAs($this->standardUser)->post(route('tickets.responses.store', $ticket->id), [
            'content' => 'some content'
        ]);

        $response->assertRedirect(route('tickets.show', $ticket->id));

        $this->assertDatabaseHas('ticket_responses', [
            'ticket_id' => $ticket->id,
            'user_id' => $this->standardUser->id,
            'content' => 'some content'
        ]);
    }

    public function test_user_cannot_respond_to_their_ticket_when_they_are_no_longer_assigned_to_that_company()
    {
        $ticket = Ticket::factory()->create([
            'user_id'    => $this->standardUser->id,
            'company_id' => $this->company1->id
        ]);

        $response = $this->actingAs($this->standardUser)->post(route('tickets.responses.store', $ticket->id), [
            'content' => 'some content'
        ]);

        $response->assertStatus(403);

        $this->assertDatabaseMissing('ticket_responses', [
            'ticket_id' => $ticket->id,
            'user_id' => $this->standardUser->id,
            'content' => 'some content'
        ]);
    }

    public function test_manager_can_respond_to_another_users_ticket_assigned_to_same_company()
    {
        $ticket = Ticket::factory()->create([
            'user_id'    => $this->standardUser->id,
            'company_id' => $this->company1->id
        ]);

        $this->company1->users()->attach([$this->managerUser->id]);

        $response = $this->actingAs($this->managerUser)->post(route('tickets.responses.store', $ticket->id), [
            'content' => 'some content'
        ]);

        $response->assertRedirect(route('tickets.show', $ticket->id));

        $this->assertDatabaseHas('ticket_responses', [
            'ticket_id' => $ticket->id,
            'user_id' => $this->managerUser->id,
            'content' => 'some content'
        ]);
    }

    public function test_manager_cannot_respond_to_another_users_ticket_assigned_to_different_company()
    {
        $ticket = Ticket::factory()->create([
            'user_id'    => $this->standardUser->id,
            'company_id' => $this->company1->id
        ]);

        $this->company2->users()->attach([$this->managerUser->id]);

        $response = $this->actingAs($this->managerUser)->post(route('tickets.responses.store', $ticket->id), [
            'content' => 'some content'
        ]);

        $response->assertStatus(403);

        $this->assertDatabaseMissing('ticket_responses', [
            'ticket_id' => $ticket->id,
            'user_id' => $this->managerUser->id,
            'content' => 'some content'
        ]);
    }

}

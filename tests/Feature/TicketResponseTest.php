<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Organization;
use App\Models\Ticket;
use App\Models\TicketResponse;
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
    private Ticket $ticket;
    private TicketResponse $userResponse;
    private TicketResponse $agentResponse;

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
        $this->ticket = Ticket::factory()->create([
            'user_id' => $this->standardUser->id,
            'company_id' => $this->company1->id
        ]);

        $this->userResponse = TicketResponse::factory()->create([
            'user_id' => $this->standardUser->id,
            'ticket_id' => $this->ticket->id
        ]);
        $this->agentResponse = TicketResponse::factory()->create([
            'user_id' => $this->agentUser->id,
            'ticket_id' => $this->ticket->id
        ]);
    }

    public function test_user_can_respond_to_their_own_ticket()
    {
        $this->company1->users()->attach([$this->standardUser->id]);

        $response = $this->actingAs($this->standardUser)->post(route('tickets.responses.store', $this->ticket->id), [
            'content' => 'some content'
        ]);

        $response->assertRedirect(route('tickets.show', $this->ticket->id));

        $this->assertDatabaseHas('ticket_responses', [
            'ticket_id' => $this->ticket->id,
            'user_id' => $this->standardUser->id,
            'content' => 'some content'
        ]);
    }

    public function test_user_cannot_respond_to_their_ticket_when_they_are_no_longer_assigned_to_that_company()
    {
        $response = $this->actingAs($this->standardUser)->post(route('tickets.responses.store', $this->ticket->id), [
            'content' => 'some content'
        ]);

        $response->assertStatus(403);

        $this->assertDatabaseMissing('ticket_responses', [
            'ticket_id' => $this->ticket->id,
            'user_id' => $this->standardUser->id,
            'content' => 'some content'
        ]);
    }

    public function test_manager_can_respond_to_another_users_ticket_assigned_to_same_company()
    {
        $this->company1->users()->attach([$this->managerUser->id]);

        $response = $this->actingAs($this->managerUser)->post(route('tickets.responses.store', $this->ticket->id), [
            'content' => 'some content'
        ]);

        $response->assertRedirect(route('tickets.show', $this->ticket->id));

        $this->assertDatabaseHas('ticket_responses', [
            'ticket_id' => $this->ticket->id,
            'user_id' => $this->managerUser->id,
            'content' => 'some content'
        ]);
    }

    public function test_manager_cannot_respond_to_another_users_ticket_assigned_to_different_company()
    {
        $this->company2->users()->attach([$this->managerUser->id]);

        $response = $this->actingAs($this->managerUser)->post(route('tickets.responses.store', $this->ticket->id), [
            'content' => 'some content'
        ]);

        $response->assertStatus(403);

        $this->assertDatabaseMissing('ticket_responses', [
            'ticket_id' => $this->ticket->id,
            'user_id' => $this->managerUser->id,
            'content' => 'some content'
        ]);
    }

    public function test_agent_can_delete_own_response()
    {
        $this->actingAs($this->agentUser)
            ->delete(route('tickets.responses.destroy', [$this->ticket->id, $this->agentResponse->id]))
            ->assertRedirect(route('tickets.show', $this->ticket->id));

        $this->assertNotNull($this->agentResponse->fresh()->deleted_at);
    }


    public function test_gent_can_edit_own_response()
    {
        $this->actingAs($this->agentUser)
            ->get(route('tickets.responses.edit', [$this->ticket->id, $this->agentResponse->id]))
            ->assertStatus(200);

        $this->patch(route('tickets.responses.update', [$this->ticket->id, $this->agentResponse->id]),[
            'content' => 'new content'
        ])
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('tickets.show', [$this->ticket->id]));

        $this->assertDatabaseHas('ticket_responses', [
            'id' => $this->agentResponse->id,
            'content' => 'new content'
        ]);
    }

    public function test_admin_can_delete_other_users_response()
    {
        $this->actingAs($this->adminUser)
            ->delete(route('tickets.responses.destroy', [$this->ticket->id, $this->agentResponse->id]))
            ->assertRedirect(route('tickets.show', $this->ticket->id));

        $this->assertNotNull($this->agentResponse->fresh()->deleted_at);
    }

    public function test_non_admin_cannot_delete_other_users_response()
    {
        $this->actingAs($this->adminUser)
            ->delete(route('tickets.responses.destroy', [$this->ticket->id, $this->userResponse->id]))
            ->assertRedirect(route('tickets.show', $this->ticket->id));

        $this->assertNotNull($this->userResponse->fresh()->deleted_at);
    }

    public function test_admin_can_edit_any_response()
    {
        $this->actingAs($this->adminUser)
            ->get(route('tickets.responses.edit', [$this->ticket->id, $this->agentResponse->id]))
            ->assertStatus(200);

        $this->patch(route('tickets.responses.update', [$this->ticket->id, $this->agentResponse->id]),[
            'content' => 'new content'
        ])
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('tickets.show', [$this->ticket->id]));

        $this->assertDatabaseHas('ticket_responses', [
            'id' => $this->agentResponse->id,
            'content' => 'new content'
        ]);
    }

    public function test_non_admin_cannot_edit_other_users_response()
    {
        $this->actingAs($this->agentUser)
            ->get(route('tickets.responses.edit', [$this->ticket->id, $this->userResponse->id]))
            ->assertStatus(403);

        $this->patch(route('tickets.responses.update', [$this->ticket->id, $this->userResponse->id]),[
            'content' => 'new content'
        ])
            ->assertStatus(403);

        $this->assertDatabaseHas('ticket_responses', [
            'id' => $this->userResponse->id,
            'content' => $this->userResponse->content
        ]);
    }

    public function test_agent_can_make_response_private()
    {
        $this->actingAs($this->agentUser)
            ->post(route('tickets.responses.store', $this->ticket->id), [
                'content' => 'some content',
                'private' => true
            ])
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('tickets.show', $this->ticket->id));

        $this->assertDatabaseHas('ticket_responses', [
            'ticket_id' => $this->ticket->id,
            'user_id' => $this->agentUser->id,
            'content' => 'some content',
            'private' => '1'
        ]);
    }

    public function test_standard_user_cannot_make_response_private()
    {
        $this->company1->users()->syncWithoutDetaching($this->standardUser->id);

        $this->actingAs($this->standardUser)
            ->post(route('tickets.responses.store', $this->ticket->id), [
                'content' => 'some content',
                'private' => true
            ])
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('tickets.show', $this->ticket->id));

        $this->assertDatabaseHas('ticket_responses', [
            'ticket_id' => $this->ticket->id,
            'user_id' => $this->standardUser->id,
            'content' => 'some content',
            'private' => '0'
        ]);
    }

    public function test_agent_can_see_private_responses()
    {
        $this->markTestSkipped('Not yet implemented');
    }

    public function test_standard_user_cannot_see_private_responses()
    {
        $this->markTestSkipped('Not yet implemented');
    }

}

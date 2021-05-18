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

class TicketsTest extends TestCase
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

    public function test_user_can_create_a_ticket()
    {
        $this->actingAs($this->standardUser);

        $response = $this->post('/tickets', [
            'subject' => 'test subject',
            'content' => 'test content'
        ]);

        $response->assertRedirect(route('tickets.index'));

        $this->assertDatabaseHas('tickets', [
            'subject' => 'test subject',
            'content' => 'test content'
        ]);
    }

    public function test_user_can_view_their_own_tickets()
    {
        $this->withoutExceptionHandling();
        $ticket = Ticket::factory()->create(['user_id' => $this->standardUser]);

        $response = $this->actingAs($this->standardUser)->get(route('tickets.show', $ticket->id));

        $response->assertStatus(200);
    }

    public function test_user_cannot_view_other_users_tickets()
    {
        // Given we have 2 users in the same company
        $standardUser1 = User::factory()->withPersonalTeam()->create()->assignRole(['user', 'restricted user']);
        $standardUser2 = User::factory()->withPersonalTeam()->create()->assignRole(['user', 'restricted user']);

        $this->company1->users()->attach([$standardUser1->id, $standardUser2->id]);

        // and user 1 creates a ticket
        $ticket = Ticket::factory()->create(['user_id' => $standardUser1]);

        // user 2 cannot see the ticket
        $this->actingAs($standardUser2);
        $response = $this->get(route('tickets.show', $ticket->id));
        $response->assertStatus(403);
    }

    public function test_user_cannot_create_tickets_for_a_company_they_are_not_assigned_to()
    {
        // Given we have user attached to company 1
        $this->company1->users()->attach([$this->standardUser->id]);

        // User cannot create ticket assigned to company 2 if they are not assigned to it
        $this->actingAs($this->standardUser);

        $response = $this->post('/tickets', [
            'subject'    => 'test subject',
            'content'    => 'test content',
            'company_id' => $this->company2->id
        ]);

        $response->assertSessionHasErrors(['company_id']);
    }

    public function test_user_cannot_view_ticket_they_created_if_they_are_no_longer_assigned_to_that_company()
    {
        // Given we have a ticket created by user, assigned to company 1
        $ticket = Ticket::factory()->create(['user_id'    => $this->standardUser->id,
                                             'company_id' => $this->company1->id
        ]);

        // And user is not assigned to company 1, User should not be able to view the ticket
        $response = $this->actingAs($this->standardUser)->get(route('tickets.show', $ticket->id));

        $response->assertStatus(403);
    }

    public function test_manager_can_view_ticket_created_by_another_user_of_same_company()
    {
        // Given we have a ticket created by standard user, assigned to company 1
        $ticket = Ticket::factory()->create(['user_id'    => $this->standardUser->id,
                                             'company_id' => $this->company1->id
        ]);

        // and manager is assigned to same company
        $this->company1->users()->attach([$this->managerUser->id]);

        // Manager should be able to view the ticket
        $response = $this->actingAs($this->managerUser)->get(route('tickets.show', $ticket->id));
        $response->assertStatus(200);
    }

    public function test_manager_cannot_view_ticket_created_by_user_of_different_company()
    {
        // Given we have a ticket created by standard user, assigned to company 1
        $ticket = Ticket::factory()->create(['user_id'    => $this->standardUser->id,
                                             'company_id' => $this->company1->id
        ]);

        // and manager is assigned to a different company
        $this->company2->users()->attach([$this->managerUser->id]);

        // Manager should not be able to view the ticket
        $response = $this->actingAs($this->managerUser)->get(route('tickets.show', $ticket->id));
        $response->assertStatus(403);
    }

    public function test_user_can_respond_to_their_own_ticket()
    {
        $this->markTestSkipped('not yet implemented');
    }

    public function test_manager_can_respond_to_another_users_ticket_assigned_to_same_company()
    {
        $this->markTestSkipped('not yet implemented');
    }

    public function test_agent_can_change_status_of_ticket()
    {
        $this->markTestSkipped('not yet implemented');
    }

    public function test_nonagent_cannot_change_ticket_status()
    {
        $this->markTestSkipped('not yet implemented');
    }

    public function test_non_admin_cannot_delete_ticket()
    {
        $this->markTestSkipped('not yet implemented');
    }

    public function test_admin_can_delete_a_ticket()
    {
        $this->markTestSkipped('not yet implemented');
    }
}

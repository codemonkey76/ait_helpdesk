<?php

namespace Tests\Feature;

use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\TicketStatusSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class JobCardTest extends TestCase
{
    use RefreshDatabase;

    private User $adminUser;
    private User $agentUser;
    private User $managerUser;
    private User $accountsUser;
    private User $standardUser;
    private Ticket $ticket;
    private string $workDate;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(PermissionSeeder::class);
        $this->seed(TicketStatusSeeder::class);

        $this->workDate = now()->format('Y-m-d');

        $this->adminUser = User::factory()->withPersonalTeam()->create()->assignRole([
            'admin', 'agent', 'user', 'restricted user'
        ]);
        $this->managerUser = User::factory()->withPersonalTeam()->create()->assignRole([
            'manager', 'user', 'restricted user'
        ]);

        $this->accountsUser = User::factory()->withPersonalTeam()->create()->assignRole([
            'accounts', 'manager', 'user', 'restricted user'
        ]);

        $this->agentUser = User::factory()->withPersonalTeam()->create()->assignRole([
            'agent', 'manager', 'user', 'restricted user'
        ]);
        $this->standardUser = User::factory()->withPersonalTeam()->create()->assignRole(['user', 'restricted user']);
        $this->ticket = Ticket::factory()->create();
    }

    public function test_accounts_can_create_job_card_from_ticket()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($this->accountsUser)
            ->post(route('tickets.job-card.store', $this->ticket->id), [
                'content'    => 'some content',
                'time_spent' => 30
            ])
            ->assertRedirect(route('tickets.show', $this->ticket->id));

        $this->assertNotNull($this->ticket->fresh()->jobCard);
    }

    public function test_job_card_has_required_validation()
    {
        $this->actingAs($this->accountsUser)
            ->post(route('tickets.job-card.store', $this->ticket->id), [
                'time_spent' => 30
            ])
            ->assertSessionHasErrors('content');

        $this->assertNull($this->ticket->fresh()->jobCard);

        $this->actingAs($this->accountsUser)
            ->post(route('tickets.job-card.store', $this->ticket->id), [
                'content' => 'some content',
            ])
            ->assertSessionHasErrors('time_spent');

        $this->assertNull($this->ticket->fresh()->jobCard);

        $this->actingAs($this->accountsUser)
            ->post(route('tickets.job-card.store', $this->ticket->id), [
                'content'    => 'some content',
                'time_spent' => 27
            ])
            ->assertSessionHasErrors('time_spent');

        $this->assertNull($this->ticket->fresh()->jobCard);
    }

    public function test_non_accounts_cannot_create_job_card_from_ticket()
    {
        $this->actingAs($this->standardUser)
            ->post(route('tickets.job-card.store', $this->ticket->id), [
                'content'    => 'some content',
                'time_spent' => 30
            ])
            ->assertStatus(403);

        $this->assertNull($this->ticket->fresh()->jobCard);
    }

    public function test_agent_can_add_job_to_ticket()
    {
        $workDate = now()->format('Y-m-d');

        $response = $this->actingAs($this->agentUser)
            ->post(route('tickets.jobs.store', $this->ticket->id), [
                'date'       => $workDate,
                'time_spent' => 30,
                'user_id'    => $this->agentUser->id,
                'content'    => 'some content'
            ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('tickets.show', $this->ticket->id));
        $this->assertDatabaseHas('jobs', [
            'ticket_id'  => $this->ticket->id,
            'user_id'    => $this->agentUser->id,
            'date'       => $workDate,
            'time_spent' => 30,
            'content'    => 'some content'
        ]);
    }

    public function test_non_agent_cannot_add_job_to_ticket()
    {
        $workDate = now();

        $response = $this->actingAs($this->standardUser)
            ->post(route('tickets.jobs.store', $this->ticket->id), [
                'date'       => $workDate,
                'time_spent' => 30,
                'user_id'    => $this->agentUser->id,
                'content'    => 'some content'
            ]);

        $response->assertStatus(403);

        $this->assertDatabasemissing('jobs', [
            'ticket_id'  => $this->ticket->id,
            'user_id'    => $this->agentUser->id,
            'date'       => $workDate,
            'time_spent' => 30,
            'content'    => 'some content'
        ]);

    }

    private function getTestData()
    {
        return [
            'time_spent' => 30,
            'date'       => now(),
            'user_id'    => $this->agentUser->id,
            'content'    => 'some content'
        ];
    }

    public function test_job_must_contain_required_fields()
    {
        $this->actingAs($this->agentUser);

        // date is required
        $testData = $this->getTestData();
        unset($testData['date']);
        $this->post(route('tickets.jobs.store', $this->ticket->id), $testData)
            ->assertSessionHasErrors('date');
        $this->assertDatabasemissing('jobs', $testData);

        // user_id is required
        $testData = $this->getTestData();
        unset($testData['user_id']);
        $this->post(route('tickets.jobs.store', $this->ticket->id), $testData)
            ->assertSessionHasErrors('user_id');
        $this->assertDatabasemissing('jobs', $testData);

        // time_spent is required
        $testData = $this->getTestData();
        unset($testData['time_spent']);
        $this->post(route('tickets.jobs.store', $this->ticket->id), $testData)
            ->assertSessionHasErrors('time_spent');
        $this->assertDatabasemissing('jobs', $testData);

        // time_spent is required
        $testData = $this->getTestData();
        unset($testData['content']);
        $this->post(route('tickets.jobs.store', $this->ticket->id), $testData)
            ->assertSessionHasErrors('content');
        $this->assertDatabasemissing('jobs', $testData);
    }

    public function test_job_must_be_assigned_to_agent()
    {
        $this->actingAs($this->agentUser);

        $testData = $this->getTestData();
        $testData['user_id'] = $this->standardUser->id;

        $this->post(route('tickets.jobs.store', $this->ticket->id), $testData)
            ->assertSessionHasErrors('user_id');
        $this->assertDatabasemissing('jobs', $testData);
    }

    public function test_job_time_spent_must_be_multiple_of_minimum_time()
    {
        $this->actingAs($this->agentUser);

        $testData = $this->getTestData();
        $testData['time_spent'] = 27;

        $this->post(route('tickets.jobs.store', $this->ticket->id), $testData)
            ->assertSessionHasErrors('time_spent');
        $this->assertDatabasemissing('jobs', $testData);
    }

    public function test_job_date_must_be_in_correct_format()
    {
        $this->actingAs($this->agentUser);

        $testData = $this->getTestData();
        $testData['date'] = now()->format('d/m/Y');

        $this->post(route('tickets.jobs.store', $this->ticket->id), $testData)
            ->assertSessionHasErrors('date');
        $this->assertDatabasemissing('jobs', $testData);
    }

    public function test_job_create_can_be_rendered()
    {
        $this->actingAs($this->agentUser)
            ->get(route('tickets.jobs.create', $this->ticket->id))
            ->assertStatus(200);
    }
}

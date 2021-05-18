<?php

namespace Tests\Feature;

use App\Models\Organization;
use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrganizationsTest extends TestCase
{
    use RefreshDatabase;

    private User $adminUser;
    private User $agentUser;
    private User $managerUser;
    private User $standardUser;

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
    }

    public function test_agent_can_view_organizations_page()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($this->agentUser);

        $response = $this->get('/organizations');

        $response->assertStatus(200);
    }

    public function test_non_agent_cannot_view_organizations_page()
    {
        $this->actingAs($this->managerUser);

        $response = $this->get('/organizations');

        $response->assertStatus(403);
    }
    public function test_admin_can_create_organization()
    {
        $this->actingAs($this->adminUser);

        $response = $this->post('/organizations', [
           'name' => 'organization name'
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/organizations');
        $this->assertDatabaseHas('organizations', ['name' => 'organization name']);
    }

    public function test_non_admin_cannot_create_organization()
    {
        $this->actingAs($this->agentUser);

        $response = $this->post('/organizations', [
            'name' => 'organization name'
        ]);

        $response->assertStatus(403);
    }
}

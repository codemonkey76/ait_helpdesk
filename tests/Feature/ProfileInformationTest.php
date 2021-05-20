<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileInformationTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(PermissionSeeder::class);
        $this->user = User::factory()->withPersonalTeam()->create();
    }

    public function test_profile_information_can_be_updated()
    {
        $this->actingAs($this->user);

        $response = $this->put('/user/profile-information', [
            'name' => 'Test Name',
            'email' => 'test@example.com',
        ]);

        $this->assertEquals('Test Name', $this->user->fresh()->name);
        $this->assertEquals('test@example.com', $this->user->fresh()->email);
    }
    public function test_profile_page_can_be_rendered()
    {
        $this->actingAs($this->user);

        $response = $this->get(route('profile.show'));

        $response->assertStatus(200);
    }
}

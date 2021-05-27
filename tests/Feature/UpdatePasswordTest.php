<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UpdatePasswordTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_password_can_be_updated()
    {
        $this->actingAs($this->user);

        $response = $this->put('/user/password', [
            'current_password' => 'password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

        $this->assertTrue(Hash::check('new-password', $this->user->fresh()->password));
    }

    public function test_current_password_must_be_correct()
    {
        $this->actingAs($this->user);

        $response = $this->put('/user/password', [
            'current_password' => 'wrong-password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

        $response->assertSessionHasErrors();

        $this->assertTrue(Hash::check('password', $this->user->fresh()->password));
    }

    public function test_new_passwords_must_match()
    {
        $this->actingAs($this->user);

        $response = $this->put('/user/password', [
            'current_password' => 'password',
            'password' => 'new-password',
            'password_confirmation' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors();

        $this->assertTrue(Hash::check('password', $this->user->fresh()->password));
    }
}

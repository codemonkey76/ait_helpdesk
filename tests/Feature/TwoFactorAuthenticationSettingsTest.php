<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TwoFactorAuthenticationSettingsTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->withPersonalTeam()->create();
    }

    public function test_two_factor_authentication_can_be_enabled()
    {
        $this->actingAs($this->user);

        $this->withSession(['auth.password_confirmed_at' => time()]);

        $response = $this->post('/user/two-factor-authentication');

        $this->assertNotNull($this->user->fresh()->two_factor_secret);
        $this->assertCount(8, $this->user->fresh()->recoveryCodes());
    }

    public function test_recovery_codes_can_be_regenerated()
    {
        $this->actingAs($this->user);

        $this->withSession(['auth.password_confirmed_at' => time()]);

        $this->post('/user/two-factor-authentication');
        $this->post('/user/two-factor-recovery-codes');

        $this->user = $this->user->fresh();

        $this->post('/user/two-factor-recovery-codes');

        $this->assertCount(8, $this->user->recoveryCodes());
        $this->assertCount(8, array_diff($this->user->recoveryCodes(), $this->user->fresh()->recoveryCodes()));
    }

    public function test_two_factor_authentication_can_be_disabled()
    {
        $this->actingAs($this->user);

        $this->withSession(['auth.password_confirmed_at' => time()]);

        $this->post('/user/two-factor-authentication');

        $this->assertNotNull($this->user->fresh()->two_factor_secret);

        $this->delete('/user/two-factor-authentication');

        $this->assertNull($this->user->fresh()->two_factor_secret);
    }
}

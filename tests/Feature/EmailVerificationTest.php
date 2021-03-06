<?php

namespace Tests\Feature;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Database\Seeders\PermissionSeeder;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    private User $unverifiedUser;
    public function setUp(): void
    {
        parent::setUp();

        $this->seed(PermissionSeeder::class);
        $this->unverifiedUser = User::factory()->unverified()->create();
    }

    public function test_email_verification_screen_can_be_rendered()
    {
        $response = $this->actingAs($this->unverifiedUser)->get(route('verification.notice'));

        $response->assertStatus(200);
    }

    public function test_email_can_be_verified()
    {
        Event::fake();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $this->unverifiedUser->id, 'hash' => sha1($this->unverifiedUser->email)]
        );

        $response = $this->actingAs($this->unverifiedUser)->get($verificationUrl);

        Event::assertDispatched(Verified::class);

        $this->assertTrue($this->unverifiedUser->fresh()->hasVerifiedEmail());
        $response->assertRedirect(RouteServiceProvider::HOME.'?verified=1');
    }

    public function test_email_can_not_verified_with_invalid_hash()
    {
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $this->unverifiedUser->id, 'hash' => sha1('wrong-email')]
        );

        $this->actingAs($this->unverifiedUser)->get($verificationUrl);

        $this->assertFalse($this->unverifiedUser->fresh()->hasVerifiedEmail());
    }
    public function test_dashboard_cannot_be_accessed_by_unverified_users()
    {
        $response = $this->actingAs($this->unverifiedUser)->get('/dashboard');

        $response->assertRedirect('/email/verify');
    }
}

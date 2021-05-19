<?php

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\VerifyPhone;
use Database\Seeders\PermissionSeeder;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class PhoneVerificationTest extends TestCase
{
    use RefreshDatabase;

    private User $unverifiedUser;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(PermissionSeeder::class);
        $this->unverifiedUser = User::factory()->phoneUnverified()->withPersonalTeam()->create();
    }

    public function test_phone_verification_screen_can_be_rendered()
    {
        $this->actingAs($this->unverifiedUser)->get(route('phone.verify.notice'));
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_phone_can_be_verified()
    {
        Notification::fake();

        // Check that code and expiry and verification date are all null
        $this->assertNull($this->unverifiedUser->phone_verification_code);
        $this->assertNull($this->unverifiedUser->phone_verification_expiry);
        $this->assertNull($this->unverifiedUser->phone_verified_at);

        $this->unverifiedUser->markEmailAsVerified();

        // Request code
        $response = $this->actingAs($this->unverifiedUser)->post(route('phone.verify.send'));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('phone.verify.notice'));

        // Confirm that code and expiry were generated
        $this->unverifiedUser->refresh();
        $this->assertNotNull($this->unverifiedUser->phone_verification_code);
        $this->assertNotNull($this->unverifiedUser->phone_verification_expiry);

        // check user received the code
        Notification::assertSentTo($this->unverifiedUser, VerifyPhone::class);

        // Submit the code for verification
        $response = $this->actingAs($this->unverifiedUser)->post(route('phone.verify'), [
            'phone_verification_code' => $this->unverifiedUser->phone_verification_code
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('profile.show'));
        $this->assertNotNull($this->unverifiedUser->fresh()->phone_verified_at);
    }
}

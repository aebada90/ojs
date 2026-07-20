<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_unverified_user_is_redirected_from_dashboard(): void
    {
        $user = User::factory()->unverified()->create();

        $this->actingAs($user)
            ->get('/dashboard')
            ->assertRedirect(route('verification.notice'));
    }

    public function test_verify_email_page_renders_for_unverified_user(): void
    {
        $user = User::factory()->unverified()->create([
            'email' => 'guest@oktoberfest.ai',
        ]);

        $this->actingAs($user)
            ->get(route('verification.notice'))
            ->assertOk()
            ->assertSee('guest@oktoberfest.ai')
            ->assertSee(__('platform.verify.resend'));
    }

    public function test_resend_verification_sends_notification(): void
    {
        Notification::fake();

        $user = User::factory()->unverified()->create();

        $this->actingAs($user)
            ->post(route('verification.send'))
            ->assertRedirect();

        Notification::assertSentTo($user, \App\Notifications\VerifyEmail::class);
    }

    public function test_users_verify_command_marks_email_verified(): void
    {
        $user = User::factory()->unverified()->create([
            'email' => 'stuck@oktoberfest.ai',
        ]);

        $this->artisan('users:verify', ['email' => 'stuck@oktoberfest.ai'])
            ->assertSuccessful();

        $this->assertTrue($user->fresh()->hasVerifiedEmail());
    }
}

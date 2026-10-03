<?php

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\VerifyEmail;
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

        Notification::assertSentTo($user, VerifyEmail::class);
    }

    public function test_mail_failure_flashes_inline_verify_link_instead_of_500(): void
    {
        $user = User::factory()->unverified()->create();

        // Point SMTP at a closed port so the real mailer throws.
        config([
            'mail.default' => 'smtp',
            'mail.mailers.smtp.transport' => 'smtp',
            'mail.mailers.smtp.host' => '127.0.0.1',
            'mail.mailers.smtp.port' => 9,
            'mail.mailers.smtp.timeout' => 1,
            'mail.from.address' => 'noreply@oktoberfest.ai',
            'mail.from.name' => 'Oktoberfest',
            'platform.verify_inline_fallback' => false,
        ]);

        $this->actingAs($user)
            ->from(route('verification.notice'))
            ->post(route('verification.send'))
            ->assertRedirect()
            ->assertSessionHas('verification_inline_url')
            ->assertSessionHas('verification_mail_failed');
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

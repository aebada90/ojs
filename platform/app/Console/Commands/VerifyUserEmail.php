<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class VerifyUserEmail extends Command
{
    protected $signature = 'users:verify {email : The user email to mark as verified}';

    protected $description = 'Mark a user email as verified (Hostinger emergency unlock when SMTP mail is blocked)';

    public function handle(): int
    {
        $email = strtolower(trim((string) $this->argument('email')));

        $user = User::query()->where('email', $email)->first();

        if (! $user) {
            $this->error("No user found for {$email}");

            return self::FAILURE;
        }

        if ($user->hasVerifiedEmail()) {
            $this->info("{$email} is already verified.");

            return self::SUCCESS;
        }

        $user->forceFill(['email_verified_at' => now()])->save();

        $this->info("Verified {$email}. User can now open /dashboard.");

        return self::SUCCESS;
    }
}

<?php

namespace Modules\Auth\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    /** @var list<string> */
    protected array $providers = ['google', 'facebook', 'apple', 'linkedin'];

    public function redirect(string $provider): RedirectResponse
    {
        $this->validateProvider($provider);

        return Socialite::driver($provider)->redirect();
    }

    public function callback(string $provider): RedirectResponse
    {
        $this->validateProvider($provider);

        $socialUser = Socialite::driver($provider)->user();

        $user = User::query()->firstOrCreate(
            ['email' => $socialUser->getEmail()],
            [
                'name' => $socialUser->getName() ?? $socialUser->getNickname() ?? 'User',
                'username' => Str::slug($socialUser->getNickname() ?? $socialUser->getName() ?? Str::random(8)),
                'password' => bcrypt(Str::random(32)),
                'avatar' => $socialUser->getAvatar(),
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
                'email_verified_at' => now(),
            ]
        );

        if (! $user->provider) {
            $user->update([
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
            ]);
        }

        if (! $user->hasRole('customer')) {
            $user->assignRole('customer');
        }

        Auth::login($user, remember: true);

        return redirect()->intended(route('dashboard'));
    }

    protected function validateProvider(string $provider): void
    {
        abort_unless(in_array($provider, $this->providers, true), 404);
    }
}

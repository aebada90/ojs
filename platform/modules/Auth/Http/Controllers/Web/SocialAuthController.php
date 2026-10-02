<?php

namespace Modules\Auth\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class SocialAuthController extends Controller
{
    /** @var list<string> */
    protected array $providers = ['google', 'facebook', 'apple', 'linkedin'];

    public function redirect(string $provider): RedirectResponse
    {
        $this->validateProvider($provider);

        return $this->socialite($provider)->redirect();
    }

    public function callback(string $provider): RedirectResponse
    {
        $this->validateProvider($provider);

        try {
            $socialUser = $this->socialite($provider)->user();
        } catch (Throwable $e) {
            Log::error('social.auth.callback_failed', [
                'provider' => $provider,
                'message' => $e->getMessage(),
            ]);

            return redirect()->route('login')
                ->withErrors([
                    'email' => ucfirst($provider).' sign-in failed. Please try again or use email login.',
                ]);
        }

        if (! $socialUser->getEmail()) {
            return redirect()->route('login')
                ->withErrors([
                    'email' => ucfirst($provider).' did not provide an email address.',
                ]);
        }

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

    /**
     * Ops JSON: whether Google accepts the configured redirect URI.
     */
    public function googleSetupCheck(): JsonResponse
    {
        $redirect = (string) config('services.google.redirect');
        $clientId = (string) config('services.google.client_id');
        $appUrl = rtrim((string) config('app.url'), '/');

        $probe = 'https://accounts.google.com/o/oauth2/v2/auth?'.http_build_query([
            'client_id' => $clientId,
            'redirect_uri' => $redirect,
            'response_type' => 'code',
            'scope' => 'openid email profile',
            'prompt' => 'select_account',
        ]);

        $ch = curl_init($probe);
        curl_setopt_array($ch, [
            CURLOPT_NOBODY => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 3,
            CURLOPT_TIMEOUT => 15,
        ]);
        $headers = (string) curl_exec($ch);
        curl_close($ch);

        $mismatch = str_contains($headers, 'redirect_uri_mismatch')
            || str_contains($headers, 'ChVyZWRpcmVjdF91cmlfbWlzbWF0Y2g');
        $accepted = ! $mismatch && (
            str_contains($headers, 'signin/identifier')
            || str_contains($headers, 'oauth/legacy/consent')
            || str_contains($headers, 'AccountChooser')
        );

        return response()->json([
            'client_id' => $clientId,
            'redirect_uri' => $redirect,
            'accepted_by_google' => $accepted,
            'redirect_uri_mismatch' => $mismatch,
            'fix_if_mismatch' => [
                'console' => 'https://console.cloud.google.com/apis/credentials',
                'oauth_client' => $clientId,
                'add_authorized_redirect_uri' => $redirect,
                'add_authorized_javascript_origin' => $appUrl,
                'note' => 'This OAuth client currently allows https://nexora.ehopn.com/auth/google/callback only. Add the Oktoberhub redirect URI (or create a dedicated Oktoberhub OAuth client) then retry Continue with Google.',
            ],
        ]);
    }

    protected function socialite(string $provider): mixed
    {
        $driver = Socialite::driver($provider);
        $redirect = config('services.'.$provider.'.redirect');
        if (is_string($redirect) && $redirect !== '' && method_exists($driver, 'redirectUrl')) {
            $driver->redirectUrl($redirect);
        }

        return $driver;
    }

    protected function validateProvider(string $provider): void
    {
        abort_unless(in_array($provider, $this->providers, true), 404);
    }
}

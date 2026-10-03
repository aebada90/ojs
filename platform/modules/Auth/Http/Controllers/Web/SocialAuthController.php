<?php

namespace Modules\Auth\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class SocialAuthController extends Controller
{
    /** @var list<string> */
    protected array $providers = ['google', 'facebook', 'apple', 'linkedin'];

    public const NEXORA_GOOGLE_CALLBACK = 'https://nexora.ehopn.com/auth/google/callback';

    public function redirect(string $provider = 'google'): RedirectResponse|View
    {
        $this->validateProvider($provider);

        if ($provider === 'google' && $this->googleRedirectMismatched()) {
            return $this->googleFixView();
        }

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

    public function googleFix(): View|RedirectResponse
    {
        if (! $this->googleRedirectMismatched(force: true)) {
            return $this->socialite('google')->redirect();
        }

        return $this->googleFixView();
    }

    public function googleSetupCheck(): JsonResponse
    {
        $redirect = $this->configuredGoogleRedirect();
        $clientId = (string) config('services.google.client_id');
        $mismatch = $this->googleRedirectMismatched(force: true);

        return response()->json([
            'client_id' => $clientId,
            'redirect_uri' => $redirect,
            'accepted_by_google' => ! $mismatch,
            'redirect_uri_mismatch' => $mismatch,
            'fix_if_mismatch' => [
                'console' => 'https://console.cloud.google.com/apis/credentials',
                'oauth_client' => $clientId,
                'add_authorized_redirect_uri' => $redirect,
                'add_authorized_javascript_origin' => rtrim((string) config('app.url'), '/'),
                'currently_authorized' => self::NEXORA_GOOGLE_CALLBACK,
            ],
        ]);
    }

    protected function googleFixView(): View
    {
        $clientId = (string) config('services.google.client_id');
        $redirect = $this->configuredGoogleRedirect();
        $appUrl = rtrim((string) config('app.url'), '/');

        return view('auth.google-fix', [
            'clientId' => $clientId,
            'redirectUri' => $redirect,
            'origin' => $appUrl,
            'consoleUrl' => 'https://console.cloud.google.com/apis/credentials/oauthclient/'.$clientId.'?project=148156861979',
            'credentialsUrl' => 'https://console.cloud.google.com/apis/credentials?project=148156861979',
            'nexoraCallback' => self::NEXORA_GOOGLE_CALLBACK,
        ]);
    }

    protected function googleRedirectMismatched(bool $force = false): bool
    {
        $ttl = $force ? 0 : 45;
        $key = 'oauth.google.redirect_mismatch.'.$this->configuredGoogleRedirect();

        $probe = function (): bool {
            $clientId = (string) config('services.google.client_id');
            $redirect = $this->configuredGoogleRedirect();
            if ($clientId === '' || $redirect === '') {
                return true;
            }

            $url = 'https://accounts.google.com/o/oauth2/v2/auth?'.http_build_query([
                'client_id' => $clientId,
                'redirect_uri' => $redirect,
                'response_type' => 'code',
                'scope' => 'openid email profile',
                'prompt' => 'select_account',
            ]);

            $ch = curl_init($url);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADER => true,
                CURLOPT_NOBODY => false,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_MAXREDIRS => 4,
                CURLOPT_TIMEOUT => 12,
                CURLOPT_USERAGENT => 'Oktoberhub-OAuth-Check',
            ]);
            $body = (string) curl_exec($ch);
            curl_close($ch);

            return str_contains($body, 'redirect_uri_mismatch')
                || str_contains($body, 'ChVyZWRpcmVjdF91cmlfbWlzbWF0Y2g');
        };

        if ($ttl <= 0) {
            $mismatch = $probe();
            Cache::put($key, $mismatch, 45);

            return $mismatch;
        }

        return (bool) Cache::remember($key, $ttl, $probe);
    }

    protected function configuredGoogleRedirect(): string
    {
        return (string) config('services.google.redirect');
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

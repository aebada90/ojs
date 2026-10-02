<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\View\View;

class PartnerController extends Controller
{
    /**
     * Nexora Meet Up landing — sister Connect app for AI matchmaking.
     */
    public function dating(): View
    {
        return view('partners.dating', [
            'nexora' => $this->nexora(),
        ]);
    }

    /**
     * Connect hub: digital networking card + matchmaking + Nexora Connect app.
     */
    public function connect(): View
    {
        $user = auth()->user();
        $card = null;

        if ($user) {
            $username = $user->username ?: Str::slug(strtok((string) $user->email, '@') ?: 'member');
            $card = [
                'name' => $user->name,
                'username' => $username,
                'bio' => $user->bio,
                'avatar' => $user->avatar,
                'profile_url' => $user->username
                    ? url('/u/'.$user->username)
                    : url('/profile/edit'),
            ];
        }

        return view('partners.connect', [
            'nexora' => $this->nexora(),
            'models' => $this->models(),
            'card' => $card,
            'intents' => $this->intents(),
        ]);
    }

    /** @return array{name:string,tagline:string,home:string,register:string,login:string,reels:string} */
    private function nexora(): array
    {
        $cfg = config('connect.nexora');

        return is_array($cfg) ? $cfg + [
            'name' => 'Nexora',
            'tagline' => 'Connect. Discover. Meet.',
            'home' => 'https://nexora.ehopn.com',
            'register' => 'https://nexora.ehopn.com/register',
            'login' => 'https://nexora.ehopn.com/login',
            'reels' => 'https://nexora.ehopn.com/discover/reels',
        ] : [
            'name' => 'Nexora',
            'tagline' => 'Connect. Discover. Meet.',
            'home' => 'https://nexora.ehopn.com',
            'register' => 'https://nexora.ehopn.com/register',
            'login' => 'https://nexora.ehopn.com/login',
            'reels' => 'https://nexora.ehopn.com/discover/reels',
        ];
    }

    /** @return array{name:string,home:string} */
    private function models(): array
    {
        $cfg = config('connect.models');

        return is_array($cfg) ? $cfg + [
            'name' => 'HOPn Models',
            'home' => 'https://models.ehopn.com',
        ] : [
            'name' => 'HOPn Models',
            'home' => 'https://models.ehopn.com',
        ];
    }

    /** @return array<string,string> */
    private function intents(): array
    {
        $cfg = config('connect.intents');

        return is_array($cfg) && $cfg !== [] ? $cfg : [
            'dating' => 'Dating',
            'friends' => 'Friends',
            'business' => 'Business networking',
            'events' => 'Events & parties',
            'travel' => 'Travel buddies',
        ];
    }
}

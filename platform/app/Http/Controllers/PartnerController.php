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
            'nexora' => config('connect.nexora'),
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
            'nexora' => config('connect.nexora'),
            'models' => config('connect.models'),
            'card' => $card,
            'intents' => config('connect.intents'),
        ]);
    }
}

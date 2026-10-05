<?php

namespace App\Http\Controllers;

use App\Support\ConnectDemoProfiles;
use App\Support\DirndlContest;
use App\Support\MemberProfileStore;
use App\Support\ProfileChatStore;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $profile = MemberProfileStore::current($request);

        return view('dashboard', [
            'myProfile' => $profile,
            'peopleCount' => count(ConnectDemoProfiles::publicProfiles()),
            'contestCount' => count(DirndlContest::contestants()),
            'votesCast' => DirndlContest::totalVotes(),
            'chatCount' => count(ProfileChatStore::inbox(ProfileChatStore::ownerKey())),
            'tiles' => $this->tiles($profile),
        ]);
    }

    /** @return array<int, array<string, mixed>> */
    private function tiles(?array $profile): array
    {
        return [
            [
                'href' => $profile ? route('matchmaking.show', $profile['slug']) : route('network.create'),
                'title' => __('platform.dashboard.tiles.profile'),
                'body' => $profile
                    ? __('platform.dashboard.tiles.profile_ready', ['name' => $profile['display_name']])
                    : __('platform.dashboard.tiles.profile_body'),
                'cta' => $profile ? __('platform.dashboard.tiles.view') : __('platform.dashboard.tiles.create'),
                'icon' => 'profile',
                'image' => $profile['avatar_url'] ?? 'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=800&h=500&q=80',
            ],
            [
                'href' => url('/network'),
                'title' => __('platform.nav.network'),
                'body' => __('platform.nav.network_desc'),
                'cta' => __('platform.dashboard.tiles.browse'),
                'icon' => 'network',
                'image' => 'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?auto=format&fit=crop&w=800&h=500&q=80',
            ],
            [
                'href' => url('/chat'),
                'title' => __('platform.nav.chat'),
                'body' => __('platform.nav.chat_desc'),
                'cta' => __('platform.dashboard.tiles.open'),
                'icon' => 'chat',
                'image' => 'https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?auto=format&fit=crop&w=800&h=500&q=80',
            ],
            [
                'href' => url('/competition'),
                'title' => __('platform.nav.competition'),
                'body' => __('platform.nav.competition_desc'),
                'cta' => __('platform.dashboard.tiles.vote'),
                'icon' => 'crown',
                'image' => 'https://images.pexels.com/photos/5638732/pexels-photo-5638732.jpeg?auto=compress&cs=tinysrgb&w=800',
            ],
            [
                'href' => url('/matchmaking'),
                'title' => __('platform.nav.matchmaking'),
                'body' => __('platform.nav.matchmaking_desc'),
                'cta' => __('platform.dashboard.tiles.browse'),
                'icon' => 'heart',
                'image' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=800&h=500&q=80',
            ],
            [
                'href' => url('/rentals'),
                'title' => __('platform.nav.tracht'),
                'body' => __('platform.dashboard.tiles.tracht_body'),
                'cta' => __('platform.dashboard.tiles.browse'),
                'icon' => 'shirt',
                'image' => 'https://images.pexels.com/photos/5638645/pexels-photo-5638645.jpeg?auto=compress&cs=tinysrgb&w=800',
            ],
            [
                'href' => url('/events'),
                'title' => __('platform.nav.events'),
                'body' => __('platform.dashboard.tiles.events_body'),
                'cta' => __('platform.dashboard.tiles.open'),
                'icon' => 'calendar',
                'image' => 'https://images.unsplash.com/photo-1569931080489-627940a2e4c8?auto=format&fit=crop&w=800&h=500&q=80',
            ],
            [
                'href' => url('/hotels'),
                'title' => __('platform.nav.hotels'),
                'body' => __('platform.dashboard.tiles.hotels_body'),
                'cta' => __('platform.dashboard.tiles.browse'),
                'icon' => 'hotel',
                'image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=800&h=500&q=80',
            ],
        ];
    }
}

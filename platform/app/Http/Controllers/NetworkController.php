<?php

namespace App\Http\Controllers;

use App\Support\ConnectDemoProfiles;
use App\Support\MemberProfileStore;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NetworkController extends Controller
{
    public function index(Request $request): View
    {
        $intent = $request->string('intent')->toString();

        return view('network.index', [
            'profiles' => ConnectDemoProfiles::publicProfiles($intent !== '' ? $intent : null),
            'allProfiles' => ConnectDemoProfiles::publicProfiles(),
            'intent' => $intent,
            'intents' => ConnectDemoProfiles::intents(),
            'relationships' => ConnectDemoProfiles::relationships(),
            'statuses' => ConnectDemoProfiles::statuses(),
            'nexora' => ConnectDemoProfiles::nexora(),
            'groups' => ConnectDemoProfiles::demoGroups(),
            'peopleCount' => count(ConnectDemoProfiles::publicProfiles()),
            'myProfile' => MemberProfileStore::current($request),
        ]);
    }

    public function create(Request $request): View
    {
        $profile = MemberProfileStore::current($request);
        if ($profile === null && $request->user()) {
            $profile = [
                'display_name' => $request->user()->name,
                'headline' => '',
                'bio' => $request->user()->bio ?? '',
                'city' => 'Munich',
                'age' => null,
                'intent' => 'friends',
                'interests' => [],
                'languages' => [$request->user()->locale ?? 'en'],
                'avatar_url' => ConnectDemoProfiles::presetPortraits()[0] ?? null,
                'instagram' => null,
                'tiktok' => null,
                'website' => null,
                'linkedin_url' => null,
                'relationship' => 'prefer_not',
                'looking_for' => 'friends',
                'status' => 'open_to_meet',
                'status_quote' => '',
                'is_public' => true,
                'open_to_connect' => true,
            ];
        }

        return view('network.create', [
            'profile' => $profile ?? [
                'display_name' => '',
                'headline' => '',
                'bio' => '',
                'city' => 'Munich',
                'age' => '',
                'intent' => 'friends',
                'interests' => [],
                'languages' => ['en', 'de'],
                'avatar_url' => ConnectDemoProfiles::presetPortraits()[0] ?? '',
                'instagram' => '',
                'tiktok' => '',
                'website' => '',
                'linkedin_url' => '',
                'relationship' => 'single',
                'looking_for' => 'friends',
                'status' => 'open_to_meet',
                'status_quote' => '',
            ],
            'intents' => ConnectDemoProfiles::intents(),
            'relationships' => ConnectDemoProfiles::relationships(),
            'statuses' => ConnectDemoProfiles::statuses(),
            'portraits' => ConnectDemoProfiles::presetPortraits(),
            'nexora' => ConnectDemoProfiles::nexora(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $profile = MemberProfileStore::save($request, $data);

        return redirect()
            ->route('matchmaking.show', $profile['slug'])
            ->with('success', __('platform.profiles.saved'));
    }

    /** @return array<string, mixed> */
    private function validated(Request $request): array
    {
        $data = $request->validate([
            'display_name' => ['required', 'string', 'max:80'],
            'headline' => ['nullable', 'string', 'max:140'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'city' => ['nullable', 'string', 'max:80'],
            'age' => ['nullable', 'integer', 'min:18', 'max:99'],
            'intent' => ['required', 'in:dating,friends,business,events,travel'],
            'interests' => ['nullable', 'string', 'max:300'],
            'languages' => ['nullable', 'string', 'max:120'],
            'company' => ['nullable', 'string', 'max:120'],
            'role_title' => ['nullable', 'string', 'max:120'],
            'instagram' => ['nullable', 'string', 'max:80'],
            'tiktok' => ['nullable', 'string', 'max:80'],
            'website' => ['nullable', 'url', 'max:255'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'avatar_url' => ['nullable', 'url', 'max:500'],
            'relationship' => ['nullable', 'in:single,taken,open,prefer_not'],
            'looking_for' => ['nullable', 'in:dating,friends,business,events,travel'],
            'status' => ['nullable', 'in:at_wiesn,online,open_to_meet,traveling'],
            'status_quote' => ['nullable', 'string', 'max:140'],
            'is_public' => ['nullable', 'boolean'],
            'open_to_connect' => ['nullable', 'boolean'],
        ]);

        $data['is_public'] = $request->boolean('is_public', true);
        $data['open_to_connect'] = $request->boolean('open_to_connect', true);

        return $data;
    }
}

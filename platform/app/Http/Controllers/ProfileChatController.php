<?php

namespace App\Http\Controllers;

use App\Support\ConnectDemoProfiles;
use App\Support\ProfileChatStore;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileChatController extends Controller
{
    public function index(): View
    {
        $owner = ProfileChatStore::ownerKey();

        return view('chat.index', [
            'threads' => ProfileChatStore::inbox($owner),
            'people' => ConnectDemoProfiles::publicProfiles(),
            'nexora' => ConnectDemoProfiles::nexora(),
            'intents' => ConnectDemoProfiles::intents(),
            'relationships' => ConnectDemoProfiles::relationships(),
            'statuses' => ConnectDemoProfiles::statuses(),
        ]);
    }

    public function show(string $slug): View
    {
        $profile = ConnectDemoProfiles::resolve($slug);
        abort_if($profile === null, 404);

        $messages = ProfileChatStore::ensureThread(ProfileChatStore::ownerKey(), $profile);

        return view('chat.show', [
            'profile' => $profile,
            'messages' => $messages,
            'fromName' => ProfileChatStore::displayName(),
            'intents' => ConnectDemoProfiles::intents(),
        ]);
    }

    public function send(Request $request, string $slug): RedirectResponse
    {
        $profile = ConnectDemoProfiles::resolve($slug);
        abort_if($profile === null, 404);

        $data = $request->validate([
            'body' => ['required', 'string', 'min:1', 'max:400'],
        ]);

        ProfileChatStore::send(
            ProfileChatStore::ownerKey(),
            $profile,
            $data['body'],
            ProfileChatStore::displayName()
        );

        return redirect()->route('chat.show', $slug);
    }
}

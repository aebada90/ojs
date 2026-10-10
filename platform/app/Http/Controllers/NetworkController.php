<?php

namespace App\Http\Controllers;

use App\Support\ConnectDemoProfiles;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NetworkController extends Controller
{
    public function index(Request $request): View
    {
        $intent = $request->string('intent')->toString();

        return view('network.index', [
            'profiles' => ConnectDemoProfiles::publicProfiles($intent !== '' ? $intent : null),
            'intent' => $intent,
            'intents' => ConnectDemoProfiles::intents(),
            'nexora' => ConnectDemoProfiles::nexora(),
            'groups' => ConnectDemoProfiles::demoGroups(),
            'peopleCount' => count(ConnectDemoProfiles::publicProfiles()),
        ]);
    }
}

@extends('layouts.app')

@section('title', 'Finish Google sign-in')

@section('content')
<div class="flex min-h-[70vh] items-center justify-center px-4 py-16">
    <div class="w-full max-w-lg overflow-hidden rounded-3xl border border-bavarian-200 bg-white shadow-2xl">
        <div class="bg-gradient-to-r from-bavarian-700 to-bavarian-600 px-8 py-6 text-center">
            <span class="text-3xl">🔐</span>
            <h1 class="mt-2 font-display text-2xl font-bold text-white">Google login needs one Console click</h1>
        </div>
        <div class="space-y-5 p-8 text-sm text-stone-700">
            <p>
                Continue with Google is blocked because this Google app only allows
                <code class="rounded bg-stone-100 px-1">nexora.ehopn.com</code>.
                Oktoberhub’s callback is not in the authorized list yet — that is the
                <strong>redirect_uri_mismatch</strong> error.
            </p>

            <ol class="list-decimal space-y-3 pl-5">
                <li>
                    Open
                    <a href="{{ $consoleUrl }}" target="_blank" rel="noopener noreferrer" class="font-semibold text-bavarian-700 underline">
                        Google Cloud → this OAuth client
                    </a>
                    (sign in as the Google Cloud owner).
                </li>
                <li>
                    Under <strong>Authorized redirect URIs</strong> add exactly:
                    <div class="mt-2 flex gap-2">
                        <input id="redirect-uri" readonly value="{{ $redirectUri }}" class="w-full rounded-xl border border-bavarian-200 bg-stone-50 px-3 py-2 font-mono text-xs">
                        <button type="button" onclick="navigator.clipboard.writeText(document.getElementById('redirect-uri').value)" class="shrink-0 rounded-xl bg-bavarian-700 px-3 py-2 text-xs font-bold text-white">Copy</button>
                    </div>
                </li>
                <li>
                    Under <strong>Authorized JavaScript origins</strong> add:
                    <div class="mt-2 flex gap-2">
                        <input id="js-origin" readonly value="{{ $origin }}" class="w-full rounded-xl border border-bavarian-200 bg-stone-50 px-3 py-2 font-mono text-xs">
                        <button type="button" onclick="navigator.clipboard.writeText(document.getElementById('js-origin').value)" class="shrink-0 rounded-xl bg-bavarian-700 px-3 py-2 text-xs font-bold text-white">Copy</button>
                    </div>
                </li>
                <li>Save. Wait a few seconds, then try Google again.</li>
            </ol>

            <p class="text-xs text-stone-500">
                Client ID: <code class="break-all">{{ $clientId }}</code><br>
                Already authorized: <code class="break-all">{{ $nexoraCallback }}</code>
            </p>

            <div class="flex flex-col gap-3 sm:flex-row">
                <a href="{{ route('auth.google.fix') }}" class="flex-1 rounded-xl bg-gradient-to-r from-gold-400 to-gold-500 py-3 text-center text-sm font-bold text-beer">I’ve added it — continue with Google</a>
                <a href="{{ route('login') }}" class="flex-1 rounded-xl border border-bavarian-200 py-3 text-center text-sm font-semibold text-bavarian-800">Use email login</a>
            </div>
        </div>
    </div>
</div>
@endsection

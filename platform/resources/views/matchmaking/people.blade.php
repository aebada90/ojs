@extends('layouts.app')

@section('title', __('platform.matchmaking.people_title'))

@section('content')
<div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <a href="{{ route('matchmaking.index') }}" class="text-sm font-semibold text-bavarian-600 hover:text-gold-600">← {{ __('platform.matchmaking.back') }}</a>
            <h1 class="section-heading mt-2">{{ __('platform.matchmaking.people_title') }}</h1>
            <p class="section-subheading">{{ __('platform.matchmaking.people_subtitle') }}</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('chat.index') }}" class="btn-gold">{{ __('platform.nav.chat') }}</a>
            @auth
                <a href="{{ route('matchmaking.profile.edit') }}" class="rounded-full border-2 border-bavarian-300 px-4 py-2 text-sm font-bold text-bavarian-700">{{ __('platform.connect.edit_match_profile') }}</a>
                <a href="{{ route('matchmaking.connections') }}" class="rounded-full border-2 border-bavarian-300 px-4 py-2 text-sm font-bold text-bavarian-700">{{ __('platform.matchmaking.connections') }}</a>
            @endauth
        </div>
    </div>

    <form method="GET" class="mb-8 flex flex-wrap gap-3">
        <select name="intent" class="rounded-xl border border-bavarian-200 px-4 py-2 text-sm" onchange="this.form.submit()">
            <option value="">{{ __('platform.matchmaking.all_intents') }}</option>
            @foreach ($intents as $key => $label)
                <option value="{{ $key }}" @selected($intent === $key)>{{ $label }}</option>
            @endforeach
        </select>
    </form>

    @if ($usingDemo ?? false)
        <p class="mb-6 rounded-xl border border-gold-200 bg-gold-50 px-4 py-3 text-sm text-beer">{{ __('platform.matchmaking.demo_notice') }} <a href="{{ $nexora['register'] }}" target="_blank" rel="noopener noreferrer" class="font-bold underline">{{ $nexora['name'] }}</a></p>
    @endif

    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($profiles as $profile)
            @include('network.partials.person-card', ['profile' => $profile, 'intents' => $intents])
        @endforeach
    </div>
</div>
@endsection

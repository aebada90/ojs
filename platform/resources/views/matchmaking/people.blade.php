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
            @auth
                <a href="{{ route('matchmaking.profile.edit') }}" class="rounded-full border-2 border-bavarian-300 px-4 py-2 text-sm font-bold text-bavarian-700">{{ __('platform.connect.edit_match_profile') }}</a>
                <a href="{{ route('matchmaking.connections') }}" class="rounded-full border-2 border-bavarian-300 px-4 py-2 text-sm font-bold text-bavarian-700">{{ __('platform.matchmaking.connections') }}</a>
            @else
                <a href="{{ url('/login') }}" class="btn-gold">{{ __('platform.matchmaking.login_to_connect') }}</a>
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
            @php
                $slug = is_array($profile) ? $profile['slug'] : $profile->slug;
                $name = is_array($profile) ? $profile['display_name'] : $profile->display_name;
                $headline = is_array($profile) ? ($profile['headline'] ?? '') : $profile->headline;
                $intentKey = is_array($profile) ? $profile['intent'] : $profile->intent;
                $avatar = is_array($profile) ? ($profile['avatar_url'] ?? null) : $profile->avatar_url;
                $city = is_array($profile) ? ($profile['city'] ?? 'Munich') : $profile->city;
                $interests = is_array($profile) ? ($profile['interests'] ?? []) : ($profile->interests ?? []);
            @endphp
            <a href="{{ route('matchmaking.show', $slug) }}" class="card-fest group block overflow-hidden">
                <div class="aspect-[16/10] overflow-hidden bg-bavarian-100">
                    @if ($avatar)
                        <img src="{{ $avatar }}" alt="{{ $name }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105" loading="lazy">
                    @else
                        <div class="flex h-full items-center justify-center font-display text-4xl font-bold text-bavarian-400">{{ strtoupper(substr($name, 0, 1)) }}</div>
                    @endif
                </div>
                <div class="p-5">
                    <div class="flex items-start justify-between gap-2">
                        <h3 class="font-semibold text-bavarian-900 group-hover:text-bavarian-600">{{ $name }}</h3>
                        <span class="rounded-full bg-bavarian-50 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-bavarian-600">{{ $intents[$intentKey] ?? $intentKey }}</span>
                    </div>
                    <p class="mt-1 text-xs text-stone-500">{{ $city }}</p>
                    <p class="mt-2 line-clamp-2 text-sm text-stone-600">{{ $headline }}</p>
                    @if (!empty($interests))
                        <div class="mt-3 flex flex-wrap gap-1.5">
                            @foreach (array_slice($interests, 0, 3) as $tag)
                                <span class="rounded-full bg-cream px-2 py-0.5 text-[11px] font-medium text-beer">{{ $tag }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </a>
        @endforeach
    </div>
</div>
@endsection

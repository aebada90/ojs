@extends('layouts.app')

@php
    $name = is_array($profile) ? $profile['display_name'] : $profile->display_name;
    $slug = is_array($profile) ? $profile['slug'] : $profile->slug;
    $headline = is_array($profile) ? ($profile['headline'] ?? '') : $profile->headline;
    $bio = is_array($profile) ? ($profile['bio'] ?? '') : $profile->bio;
    $intentKey = is_array($profile) ? $profile['intent'] : $profile->intent;
    $avatar = is_array($profile) ? ($profile['avatar_url'] ?? null) : $profile->avatar_url;
    $city = is_array($profile) ? ($profile['city'] ?? 'Munich') : $profile->city;
    $age = is_array($profile) ? ($profile['age'] ?? null) : $profile->age;
    $interests = is_array($profile) ? ($profile['interests'] ?? []) : ($profile->interests ?? []);
    $company = is_array($profile) ? ($profile['company'] ?? null) : $profile->company;
    $role = is_array($profile) ? ($profile['role_title'] ?? null) : $profile->role_title;
    $statusKey = is_array($profile) ? ($profile['status'] ?? 'online') : 'online';
    $quote = is_array($profile) ? ($profile['status_quote'] ?? '') : '';
    $relationshipKey = is_array($profile) ? ($profile['relationship'] ?? '') : '';
    $lookingKey = is_array($profile) ? ($profile['looking_for'] ?? $intentKey) : $intentKey;
    $intents = $intents ?? [];
    $relationships = $relationships ?? [];
    $statuses = $statuses ?? [];
    $socials = $socials ?? \App\Support\ConnectDemoProfiles::socialLinks(is_array($profile) ? $profile : []);
@endphp

@section('title', $name.' · '.__('platform.matchmaking.badge'))

@section('content')
<div class="mx-auto max-w-5xl px-4 py-12 sm:px-6 lg:px-8">
    <a href="{{ route('network.index') }}" class="text-sm font-semibold text-bavarian-600 hover:text-gold-600">← {{ __('platform.nav.network') }}</a>

    @if (session('success'))
        <p class="mt-4 rounded-xl border border-gold-200 bg-gold-50 px-4 py-3 text-sm font-semibold text-beer">{{ session('success') }}</p>
    @endif

    <div class="mt-6 grid gap-8 lg:grid-cols-[320px_1fr]">
        <div class="overflow-hidden rounded-3xl border border-bavarian-100 bg-white shadow-md">
            @if ($avatar)
                <img src="{{ $avatar }}" alt="{{ $name }}" class="aspect-[3/4] w-full object-cover">
            @else
                <div class="flex aspect-[3/4] items-center justify-center bg-bavarian-100 font-display text-6xl font-bold text-bavarian-400">{{ strtoupper(substr($name, 0, 1)) }}</div>
            @endif
        </div>

        <div>
            <div class="flex flex-wrap items-center gap-2">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-bavarian-100 px-3 py-1 text-xs font-bold uppercase tracking-widest text-bavarian-700">
                    <span class="status-dot status-{{ $statusKey }}"></span>
                    {{ $statuses[$statusKey] ?? $statusKey }}
                </span>
                <span class="rounded-full bg-gold-100 px-3 py-1 text-xs font-bold uppercase tracking-widest text-gold-800">{{ $intents[$intentKey] ?? $intentKey }}</span>
                @if ($relationshipKey !== '' && isset($relationships[$relationshipKey]))
                    <span class="rounded-full bg-cream px-3 py-1 text-xs font-bold uppercase tracking-widest text-beer">{{ $relationships[$relationshipKey] }}</span>
                @endif
            </div>
            <h1 class="mt-3 font-display text-4xl font-bold text-bavarian-900">{{ $name }}@if($age), {{ $age }}@endif</h1>
            <p class="mt-2 text-stone-500">{{ $city }}@if($company) · {{ $role ? $role.' at '.$company : $company }}@endif</p>
            <p class="mt-4 text-lg text-bavarian-800">{{ $headline }}</p>
            @if ($quote !== '')
                <p class="mt-3 text-sm italic text-gold-700">“{{ $quote }}”</p>
            @endif
            <p class="mt-4 leading-relaxed text-stone-600">{{ $bio }}</p>
            <p class="mt-4 text-sm text-bavarian-700">{{ __('platform.profiles.looking_label') }}: <strong>{{ $intents[$lookingKey] ?? $lookingKey }}</strong></p>

            @if (!empty($interests))
                <div class="mt-5 flex flex-wrap gap-2">
                    @foreach ($interests as $tag)
                        <span class="rounded-full bg-cream px-3 py-1 text-xs font-semibold text-beer">{{ $tag }}</span>
                    @endforeach
                </div>
            @endif

            @if ($socials !== [])
                <div class="mt-6">
                    @include('network.partials.social-icons', ['socials' => $socials, 'compact' => false])
                </div>
            @endif

            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('chat.show', $slug) }}" class="btn-gold">{{ __('platform.network.chat') }}</a>
                <a href="{{ route('network.index') }}" class="inline-flex rounded-full border-2 border-bavarian-300 px-5 py-2.5 text-sm font-bold text-bavarian-700 hover:border-gold-400">{{ __('platform.nav.network') }}</a>
                <a href="{{ route('network.create') }}" class="inline-flex rounded-full border-2 border-gold-400 px-5 py-2.5 text-sm font-bold text-beer hover:bg-gold-50">{{ __('platform.network.cta_create') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection

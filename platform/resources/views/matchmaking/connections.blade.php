@extends('layouts.app')

@section('title', __('platform.matchmaking.connections'))

@section('content')
<div class="mx-auto max-w-4xl px-4 py-12 sm:px-6 lg:px-8">
    <h1 class="section-heading">{{ __('platform.matchmaking.connections') }}</h1>
    <p class="section-subheading">{{ __('platform.matchmaking.connections_subtitle') }}</p>

    <div class="mt-10">
        <h2 class="font-display text-xl font-bold text-bavarian-900">{{ __('platform.matchmaking.pending') }}</h2>
        <div class="mt-4 space-y-3">
            @forelse ($pending as $conn)
                <div class="flex flex-wrap items-center justify-between gap-3 rounded-2xl border border-bavarian-100 bg-white p-4">
                    <div>
                        <p class="font-semibold text-bavarian-900">{{ $conn->requester->display_name ?? 'Member' }}</p>
                        <p class="text-sm text-stone-500">{{ $conn->message }}</p>
                    </div>
                    <div class="flex gap-2">
                        <form method="POST" action="{{ route('matchmaking.accept', $conn->requester->slug) }}">@csrf<button class="rounded-full bg-gold-400 px-4 py-1.5 text-sm font-bold text-beer">{{ __('platform.matchmaking.accept') }}</button></form>
                        <form method="POST" action="{{ route('matchmaking.decline', $conn->requester->slug) }}">@csrf<button class="rounded-full border border-stone-300 px-4 py-1.5 text-sm font-semibold">{{ __('platform.matchmaking.decline') }}</button></form>
                    </div>
                </div>
            @empty
                <p class="text-sm text-stone-500">{{ __('platform.matchmaking.no_pending') }}</p>
            @endforelse
        </div>
    </div>

    <div class="mt-10">
        <h2 class="font-display text-xl font-bold text-bavarian-900">{{ __('platform.matchmaking.accepted') }}</h2>
        <div class="mt-4 space-y-3">
            @forelse ($accepted as $conn)
                @php
                    $other = $conn->requester_profile_id === ($profile->id ?? null) ? $conn->receiver : $conn->requester;
                @endphp
                <a href="{{ route('matchmaking.show', $other->slug ?? '#') }}" class="block rounded-2xl border border-bavarian-100 bg-white p-4 hover:border-gold-400">
                    <p class="font-semibold text-bavarian-900">{{ $other->display_name ?? 'Member' }}</p>
                    <p class="text-sm text-stone-500">{{ $other->headline ?? '' }}</p>
                </a>
            @empty
                <p class="text-sm text-stone-500">{{ __('platform.matchmaking.no_accepted') }}</p>
            @endforelse
        </div>
    </div>

    <div class="mt-10 rounded-2xl border border-gold-200 bg-gold-50 p-5 text-sm text-beer">
        {{ __('platform.matchmaking.nexora_hint') }}
        <a href="{{ $nexora['home'] }}" target="_blank" rel="noopener noreferrer" class="font-bold underline">{{ $nexora['name'] }}</a>
    </div>
</div>
@endsection

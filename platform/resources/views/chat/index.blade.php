@extends('layouts.app')

@section('title', __('platform.chat.inbox_title'))
@section('meta_description', __('platform.chat.inbox_subtitle'))

@section('content')
<div class="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <a href="{{ route('network.index') }}" class="text-sm font-semibold text-bavarian-600 hover:text-gold-600">← {{ __('platform.network.badge') }}</a>
            <h1 class="section-heading mt-2">{{ __('platform.chat.inbox_title') }}</h1>
            <p class="section-subheading">{{ __('platform.chat.inbox_subtitle') }}</p>
        </div>
        <a href="{{ route('network.index') }}#people" class="btn-gold">{{ __('platform.chat.start_new') }}</a>
    </div>

    @if (count($threads) > 0)
        <div class="space-y-3">
            @foreach ($threads as $thread)
                @php
                    $person = $thread['profile'];
                    $name = is_array($person) ? ($person['display_name'] ?? $thread['slug']) : ($person->display_name ?? $thread['slug']);
                    $avatar = is_array($person) ? ($person['avatar_url'] ?? null) : ($person->avatar_url ?? null);
                    $preview = $thread['last']['body'] ?? '';
                @endphp
                <a href="{{ route('chat.show', $thread['slug']) }}" class="flex items-center gap-4 rounded-2xl border border-bavarian-100 bg-white p-4 shadow-sm transition hover:border-gold-400">
                    @if ($avatar)
                        <img src="{{ $avatar }}" alt="{{ $name }}" class="h-14 w-14 rounded-2xl object-cover">
                    @else
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-bavarian-100 font-display text-xl font-bold text-bavarian-500">{{ strtoupper(substr($name, 0, 1)) }}</div>
                    @endif
                    <div class="min-w-0 flex-1">
                        <p class="font-semibold text-bavarian-900">{{ $name }}</p>
                        <p class="truncate text-sm text-stone-500">{{ $preview }}</p>
                    </div>
                    <span class="text-xs font-bold text-bavarian-500">{{ $thread['count'] }}</span>
                </a>
            @endforeach
        </div>
    @else
        <p class="mb-8 rounded-xl border border-gold-200 bg-gold-50 px-4 py-3 text-sm text-beer">{{ __('platform.chat.empty_inbox') }}</p>
    @endif

    <h2 class="mt-12 font-display text-2xl font-bold text-bavarian-900">{{ __('platform.chat.people_heading') }}</h2>
    <p class="mt-2 text-sm text-stone-500">{{ __('platform.chat.people_sub') }}</p>
    <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($people as $profile)
            @include('network.partials.person-card', [
                'profile' => $profile,
                'intents' => $intents ?? config('connect.intents', []),
                'relationships' => $relationships ?? [],
                'statuses' => $statuses ?? [],
            ])
        @endforeach
    </div>
</div>
@endsection

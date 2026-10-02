@extends('layouts.app')

@section('title', __('platform.connect.page_title'))
@section('meta_description', __('platform.connect.page_subtitle'))

@section('content')
<section class="relative overflow-hidden bg-gradient-to-br from-bavarian-900 via-bavarian-800 to-beer text-white">
    <div class="pointer-events-none absolute inset-0 opacity-20" style="background-image: url('https://images.pexels.com/photos/28753305/pexels-photo-28753305.jpeg?auto=compress&cs=tinysrgb&w=1920&h=823&fit=crop'); background-size: cover; background-position: center;"></div>
    <div class="relative mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-22">
        <div class="grid gap-12 lg:grid-cols-2 lg:items-center">
            <div>
                <span class="inline-block rounded-full bg-gold-400/20 px-4 py-1 text-xs font-bold uppercase tracking-widest text-gold-200">{{ __('platform.connect.badge') }}</span>
                <h1 class="mt-6 font-display text-4xl font-bold sm:text-5xl">{{ __('platform.connect.title') }}</h1>
                <p class="mt-6 max-w-xl text-lg leading-relaxed text-white/80">{{ __('platform.connect.subtitle') }}</p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('matchmaking.index') }}" class="btn-gold">{{ __('platform.connect.cta_matchmaking') }}</a>
                    <a href="{{ $nexora['home'] }}" target="_blank" rel="noopener noreferrer" class="inline-flex rounded-full border-2 border-white/40 px-6 py-2.5 text-sm font-bold text-white transition hover:bg-white/10">{{ __('platform.connect.cta_nexora') }}</a>
                </div>
                <p class="mt-5 text-sm text-white/50">{{ __('platform.connect.powered_by', ['app' => $nexora['name']]) }}</p>
            </div>

            <div class="rounded-3xl border border-white/15 bg-black/30 p-6 shadow-2xl backdrop-blur-md">
                <p class="text-xs font-bold uppercase tracking-widest text-gold-200">{{ __('platform.connect.card_label') }}</p>
                @if ($card)
                    <div class="mt-5 flex items-center gap-4">
                        <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gold-400 font-display text-2xl font-bold text-beer">
                            {{ strtoupper(substr($card['name'], 0, 1)) }}
                        </div>
                        <div>
                            <h2 class="font-display text-2xl font-bold">{{ $card['name'] }}</h2>
                            <p class="text-sm text-white/60">@{{ $card['username'] }}</p>
                        </div>
                    </div>
                    <p class="mt-4 text-sm leading-relaxed text-white/75">{{ $card['bio'] ?: __('platform.connect.card_empty_bio') }}</p>
                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="{{ $card['profile_url'] }}" class="rounded-full bg-white px-4 py-2 text-sm font-bold text-bavarian-800">{{ __('platform.connect.view_profile') }}</a>
                        <a href="{{ route('matchmaking.profile.edit') }}" class="rounded-full border border-white/30 px-4 py-2 text-sm font-semibold text-white hover:bg-white/10">{{ __('platform.connect.edit_match_profile') }}</a>
                    </div>
                @else
                    <h2 class="mt-4 font-display text-2xl font-bold">{{ __('platform.connect.card_guest_title') }}</h2>
                    <p class="mt-3 text-sm leading-relaxed text-white/75">{{ __('platform.connect.card_guest_body') }}</p>
                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="{{ url('/register') }}" class="rounded-full bg-gold-400 px-4 py-2 text-sm font-bold text-beer">{{ __('platform.connect.create_card') }}</a>
                        <a href="{{ url('/login') }}" class="rounded-full border border-white/30 px-4 py-2 text-sm font-semibold text-white hover:bg-white/10">{{ __('platform.nav.login') }}</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
    <div class="mb-10 text-center">
        <h2 class="section-heading">{{ __('platform.connect.hub_title') }}</h2>
        <p class="section-subheading mx-auto max-w-2xl">{{ __('platform.connect.hub_subtitle') }}</p>
    </div>

    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
        <a href="{{ route('matchmaking.people') }}" class="card-fest block p-6 transition hover:border-gold-400">
            <p class="text-xs font-bold uppercase tracking-widest text-bavarian-500">{{ __('platform.connect.tile_match_badge') }}</p>
            <h3 class="mt-3 font-display text-xl font-bold text-bavarian-900">{{ __('platform.connect.tile_match_title') }}</h3>
            <p class="mt-2 text-sm text-stone-600">{{ __('platform.connect.tile_match_body') }}</p>
        </a>
        <a href="{{ route('matchmaking.groups.index') }}" class="card-fest block p-6 transition hover:border-gold-400">
            <p class="text-xs font-bold uppercase tracking-widest text-bavarian-500">{{ __('platform.connect.tile_network_badge') }}</p>
            <h3 class="mt-3 font-display text-xl font-bold text-bavarian-900">{{ __('platform.connect.tile_network_title') }}</h3>
            <p class="mt-2 text-sm text-stone-600">{{ __('platform.connect.tile_network_body') }}</p>
        </a>
        <a href="{{ url('/meet') }}" class="card-fest block p-6 transition hover:border-gold-400">
            <p class="text-xs font-bold uppercase tracking-widest text-bavarian-500">{{ __('platform.connect.tile_meet_badge') }}</p>
            <h3 class="mt-3 font-display text-xl font-bold text-bavarian-900">{{ __('platform.connect.tile_meet_title') }}</h3>
            <p class="mt-2 text-sm text-stone-600">{{ __('platform.connect.tile_meet_body') }}</p>
        </a>
        <a href="{{ $nexora['home'] }}" target="_blank" rel="noopener noreferrer" class="card-fest block p-6 transition hover:border-gold-400">
            <p class="text-xs font-bold uppercase tracking-widest text-bavarian-500">{{ $nexora['name'] }}</p>
            <h3 class="mt-3 font-display text-xl font-bold text-bavarian-900">{{ __('platform.connect.tile_app_title') }}</h3>
            <p class="mt-2 text-sm text-stone-600">{{ __('platform.connect.tile_app_body') }}</p>
        </a>
    </div>
</section>

<section class="bg-cream py-16">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid gap-8 rounded-3xl border border-bavarian-100 bg-white p-8 shadow-lg lg:grid-cols-2 lg:items-center">
            <div>
                <span class="inline-block rounded-full bg-bavarian-100 px-3 py-1 text-xs font-bold uppercase tracking-widest text-bavarian-600">{{ $nexora['name'] }} Connect App</span>
                <h2 class="mt-4 font-display text-3xl font-bold text-bavarian-900">{{ __('platform.connect.nexora_title') }}</h2>
                <p class="mt-3 text-stone-600">{{ __('platform.connect.nexora_body') }}</p>
                <ul class="mt-5 space-y-2 text-sm text-stone-700">
                    @foreach ($intents as $label)
                        <li class="flex items-center gap-2"><span class="h-1.5 w-1.5 rounded-full bg-gold-400"></span>{{ $label }}</li>
                    @endforeach
                </ul>
                <div class="mt-7 flex flex-wrap gap-3">
                    <a href="{{ $nexora['register'] }}" target="_blank" rel="noopener noreferrer" class="btn-gold">{{ __('platform.connect.open_nexora') }}</a>
                    <a href="{{ $nexora['login'] }}" target="_blank" rel="noopener noreferrer" class="inline-flex rounded-full border-2 border-bavarian-300 px-5 py-2.5 text-sm font-bold text-bavarian-700 hover:border-gold-400">{{ __('platform.connect.nexora_login') }}</a>
                </div>
            </div>
            <div class="overflow-hidden rounded-2xl">
                <img src="https://images.pexels.com/photos/1024993/pexels-photo-1024993.jpeg?auto=compress&cs=tinysrgb&fit=crop&w=900&h=700" alt="{{ $nexora['name'] }}" class="h-full w-full object-cover">
            </div>
        </div>
    </div>
</section>
@endsection

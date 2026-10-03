@extends('layouts.app')

@section('title', __('platform.matchmaking.page_title'))
@section('meta_description', __('platform.matchmaking.page_subtitle'))

@section('content')
<section class="relative overflow-hidden bg-gradient-to-br from-bavarian-900 via-bavarian-700 to-bavarian-900 text-white">
    <div class="relative mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <span class="inline-block rounded-full bg-gold-400/20 px-4 py-1 text-xs font-bold uppercase tracking-widest text-gold-200">{{ __('platform.matchmaking.badge') }}</span>
        <h1 class="mt-5 max-w-3xl font-display text-4xl font-bold sm:text-5xl">{{ __('platform.matchmaking.title') }}</h1>
        <p class="mt-5 max-w-2xl text-lg text-white/80">{{ __('platform.matchmaking.subtitle') }}</p>
        <div class="mt-8 flex flex-wrap gap-3">
            <a href="{{ route('matchmaking.people') }}" class="btn-gold">{{ __('platform.matchmaking.cta_people') }}</a>
            <a href="{{ route('network.index') }}" class="inline-flex rounded-full border-2 border-white/40 px-6 py-2.5 text-sm font-bold text-white hover:bg-white/10">{{ __('platform.nav.network') }}</a>
            <a href="{{ route('chat.index') }}" class="inline-flex rounded-full border-2 border-gold-400/50 px-6 py-2.5 text-sm font-bold text-gold-200 hover:bg-gold-400/10">{{ __('platform.nav.chat') }}</a>
        </div>
        <p class="mt-6 text-sm text-white/50">{{ __('platform.matchmaking.people_ready', ['count' => $peopleCount]) }}</p>
    </div>
</section>

<section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
    <div class="grid gap-6 md:grid-cols-3">
        @foreach ($intents as $key => $label)
            <a href="{{ route('matchmaking.people', ['intent' => $key]) }}" class="card-fest block p-6 hover:border-gold-400">
                <h3 class="font-display text-xl font-bold text-bavarian-900">{{ $label }}</h3>
                <p class="mt-2 text-sm text-stone-600">{{ __('platform.matchmaking.browse_intent', ['intent' => $label]) }}</p>
            </a>
        @endforeach
    </div>

    <div class="mt-12 rounded-3xl border border-bavarian-100 bg-cream p-8 text-center">
        <h2 class="font-display text-2xl font-bold text-bavarian-900">{{ __('platform.matchmaking.nexora_banner_title') }}</h2>
        <p class="mx-auto mt-3 max-w-2xl text-stone-600">{{ __('platform.matchmaking.nexora_banner_body') }}</p>
        <a href="{{ $nexora['home'] }}" target="_blank" rel="noopener noreferrer" class="btn-gold mt-6 inline-flex">{{ __('platform.connect.open_nexora') }} →</a>
    </div>
</section>
@endsection

@extends('layouts.app')

@section('title', __('platform.competition.page_title'))
@section('meta_description', __('platform.competition.page_subtitle'))

@section('content')
<section class="relative overflow-hidden bg-gradient-to-br from-bavarian-900 via-bavarian-800 to-beer text-white">
    <div class="pointer-events-none absolute inset-0 opacity-20" style="background-image: url('https://images.pexels.com/photos/5638732/pexels-photo-5638732.jpeg?auto=compress&cs=tinysrgb&w=1600'); background-size: cover; background-position: center;"></div>
    <div class="relative mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <span class="inline-block rounded-full bg-gold-400/20 px-4 py-1 text-xs font-bold uppercase tracking-widest text-gold-200">{{ __('platform.competition.badge') }}</span>
        <h1 class="mt-5 max-w-3xl font-display text-4xl font-bold sm:text-5xl">{{ __('platform.competition.title') }}</h1>
        <p class="mt-5 max-w-2xl text-lg text-white/80">{{ __('platform.competition.subtitle') }}</p>
        <div class="mt-8 flex flex-wrap gap-3">
            <a href="#contestants" class="btn-gold">{{ __('platform.competition.cta_vote') }}</a>
            <a href="{{ route('competition.enter') }}" class="inline-flex rounded-full border-2 border-white/40 px-6 py-2.5 text-sm font-bold text-white hover:bg-white/10">{{ __('platform.competition.cta_enter') }}</a>
        </div>
        <p class="mt-6 text-sm text-white/50">{{ __('platform.competition.votes_cast', ['count' => $totalVotes]) }}</p>
    </div>
</section>

@if (session('success'))
    <div class="mx-auto max-w-7xl px-4 pt-8 sm:px-6 lg:px-8">
        <p class="rounded-xl border border-gold-200 bg-gold-50 px-4 py-3 text-sm font-semibold text-beer">{{ session('success') }}</p>
    </div>
@endif
@if (session('error'))
    <div class="mx-auto max-w-7xl px-4 pt-8 sm:px-6 lg:px-8">
        <p class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-800">{{ session('error') }}</p>
    </div>
@endif

<section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
    <div class="grid gap-6 md:grid-cols-3">
        <div class="card-fest p-6">
            <p class="text-xs font-bold uppercase tracking-widest text-bavarian-500">01</p>
            <h2 class="mt-2 font-display text-xl font-bold text-bavarian-900">{{ __('platform.competition.how_1_title') }}</h2>
            <p class="mt-2 text-sm text-stone-600">{{ __('platform.competition.how_1_body') }}</p>
        </div>
        <div class="card-fest p-6">
            <p class="text-xs font-bold uppercase tracking-widest text-bavarian-500">02</p>
            <h2 class="mt-2 font-display text-xl font-bold text-bavarian-900">{{ __('platform.competition.how_2_title') }}</h2>
            <p class="mt-2 text-sm text-stone-600">{{ __('platform.competition.how_2_body') }}</p>
        </div>
        <div class="card-fest p-6">
            <p class="text-xs font-bold uppercase tracking-widest text-bavarian-500">03</p>
            <h2 class="mt-2 font-display text-xl font-bold text-bavarian-900">{{ __('platform.competition.how_3_title') }}</h2>
            <p class="mt-2 text-sm text-stone-600">{{ __('platform.competition.how_3_body') }}</p>
        </div>
    </div>
</section>

<section id="contestants" class="mx-auto max-w-7xl px-4 pb-16 sm:px-6 lg:px-8">
    <div class="mb-8 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h2 class="section-heading">{{ __('platform.competition.grid_title') }}</h2>
            <p class="section-subheading">{{ __('platform.competition.grid_subtitle') }}</p>
        </div>
        @if ($votedFor)
            <p class="text-sm font-semibold text-bavarian-700">{{ __('platform.competition.your_vote') }}</p>
        @endif
    </div>

    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ($contestants as $person)
            @php
                $pct = $totalVotes > 0 ? round(($person['votes'] / $totalVotes) * 100) : 0;
                $isVote = $votedFor === $person['slug'];
            @endphp
            <article class="card-fest flex flex-col overflow-hidden {{ $person['rank'] <= 3 ? 'ring-2 ring-gold-400/70' : '' }}">
                <a href="{{ route('competition.show', $person['slug']) }}" class="block">
                    <div class="relative aspect-[3/4] overflow-hidden bg-bavarian-100">
                        <img src="{{ $person['photo'] }}" alt="{{ $person['name'] }}" class="h-full w-full object-cover" loading="lazy">
                        <span class="absolute left-3 top-3 rounded-full bg-beer/80 px-2.5 py-1 text-xs font-bold text-gold-300">#{{ $person['rank'] }}</span>
                        @if ($isVote)
                            <span class="absolute right-3 top-3 rounded-full bg-gold-400 px-2.5 py-1 text-xs font-bold text-beer">{{ __('platform.competition.voted_badge') }}</span>
                        @endif
                    </div>
                    <div class="p-4 pb-2">
                        <h3 class="font-display text-lg font-bold text-bavarian-900">{{ $person['name'] }}</h3>
                        <p class="text-xs text-stone-500">{{ $person['city'] }} · {{ $person['age'] }}</p>
                        <p class="mt-2 line-clamp-2 text-sm text-stone-600">{{ $person['dirndl'] }}</p>
                    </div>
                </a>
                <div class="mt-auto px-4 pb-4">
                    <div class="mb-3 h-1.5 overflow-hidden rounded-full bg-bavarian-100">
                        <div class="h-full rounded-full bg-gold-400" style="width: {{ $pct }}%"></div>
                    </div>
                    <p class="mb-3 text-xs font-semibold text-stone-500">{{ __('platform.competition.vote_count', ['count' => $person['votes']]) }}</p>
                    <form method="POST" action="{{ route('competition.vote', $person['slug']) }}">
                        @csrf
                        <button type="submit" class="{{ $isVote ? 'inline-flex w-full items-center justify-center rounded-full border-2 border-gold-400 bg-gold-50 px-4 py-2 text-sm font-bold text-beer' : 'btn-gold w-full' }}">
                            {{ $isVote ? __('platform.competition.voted_button') : __('platform.competition.vote_button') }}
                        </button>
                    </form>
                </div>
            </article>
        @endforeach
    </div>
</section>
@endsection

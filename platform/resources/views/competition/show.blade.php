@extends('layouts.app')

@section('title', $contestant['name'].' · '.__('platform.competition.badge'))
@section('meta_description', $contestant['bio'])

@section('content')
<div class="mx-auto max-w-5xl px-4 py-12 sm:px-6 lg:px-8">
    <a href="{{ route('competition.index') }}" class="text-sm font-semibold text-bavarian-600 hover:text-gold-600">← {{ __('platform.competition.back') }}</a>

    @if (session('success'))
        <p class="mt-6 rounded-xl border border-gold-200 bg-gold-50 px-4 py-3 text-sm font-semibold text-beer">{{ session('success') }}</p>
    @endif

    <div class="mt-6 grid gap-8 lg:grid-cols-[320px_1fr]">
        <div class="overflow-hidden rounded-3xl border border-bavarian-100 bg-white shadow-md">
            <img src="{{ $contestant['photo'] }}" alt="{{ $contestant['name'] }}" class="aspect-[3/4] w-full object-cover">
        </div>
        <div>
            <span class="inline-block rounded-full bg-gold-100 px-3 py-1 text-xs font-bold uppercase tracking-widest text-beer">#{{ $contestant['rank'] }} · {{ __('platform.competition.badge') }}</span>
            <h1 class="mt-3 font-display text-4xl font-bold text-bavarian-900">{{ $contestant['name'] }}</h1>
            <p class="mt-2 text-stone-500">{{ $contestant['city'] }} · {{ $contestant['age'] }}</p>
            <p class="mt-4 text-lg text-bavarian-800">{{ $contestant['dirndl'] }}</p>
            <p class="mt-4 leading-relaxed text-stone-600">{{ $contestant['bio'] }}</p>
            <p class="mt-6 text-sm font-semibold text-stone-500">{{ __('platform.competition.vote_count', ['count' => $contestant['votes']]) }}</p>

            <form method="POST" action="{{ route('competition.vote', $contestant['slug']) }}" class="mt-6">
                @csrf
                <button type="submit" class="btn-gold">
                    {{ $votedFor === $contestant['slug'] ? __('platform.competition.voted_button') : __('platform.competition.vote_button') }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

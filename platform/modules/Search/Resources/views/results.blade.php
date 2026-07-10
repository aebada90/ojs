@extends('layouts.app')

@section('title', 'Search Results')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="font-display text-3xl font-bold text-stone-900">Universal Search</h1>
        <p class="mt-2 text-stone-600">Search hotels, products, events, properties, rentals, restaurants, jobs, and more.</p>
    </div>

    <div class="mb-8 rounded-3xl border border-stone-200 bg-white p-6 shadow-sm">
        <livewire:search.universal-search />
    </div>

    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($results as $item)
            <article class="rounded-3xl border border-stone-200 bg-white p-6 shadow-sm">
                <div class="text-xs font-semibold uppercase tracking-wider text-amber-700">{{ ucfirst($item->type) }}</div>
                <h2 class="mt-2 text-lg font-semibold text-stone-900">{{ $item->title }}</h2>
                <p class="mt-2 text-sm text-stone-600">{{ $item->summary }}</p>
                <div class="mt-4 flex items-center justify-between text-sm">
                    <span>{{ $item->city }}</span>
                    <span class="font-semibold">€{{ number_format((float) $item->price, 0) }}</span>
                </div>
            </article>
        @empty
            <div class="col-span-full rounded-3xl border border-dashed border-stone-300 p-12 text-center text-stone-500">
                No results found. Try another search or seed demo data.
            </div>
        @endforelse
    </div>

    <div class="mt-8">{{ $results->links() }}</div>
</div>
@endsection

@extends('layouts.app')

@section('title', __('platform.search.page_title'))

@section('content')
<div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
    <div class="mb-8 text-center">
        <h1 class="section-heading">{{ __('platform.search.page_title') }}</h1>
        <p class="section-subheading mx-auto max-w-2xl">{{ __('platform.search.page_subtitle') }}</p>
    </div>

    <div class="mx-auto mb-8 max-w-2xl rounded-3xl border border-bavarian-200 bg-white p-6 shadow-lg">
        <livewire:search.universal-search variant="light" />
    </div>

    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($results as $item)
            <article class="card-fest p-6">
                <span class="inline-block rounded-full bg-bavarian-100 px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider text-bavarian-600">{{ __("platform.types.{$item->type}") }}</span>
                <h2 class="mt-3 text-lg font-bold text-bavarian-900">{{ $item->title }}</h2>
                <p class="mt-2 text-sm text-bavarian-700/70">{{ $item->summary }}</p>
                <div class="mt-4 flex items-center justify-between border-t border-bavarian-50 pt-3 text-sm">
                    <span class="text-bavarian-600">{{ $item->city }}</span>
                    <span class="font-bold text-bavarian-900">€{{ number_format((float) $item->price, 0) }}</span>
                </div>
            </article>
        @empty
            <div class="col-span-full rounded-2xl border-2 border-dashed border-bavarian-200 p-12 text-center text-bavarian-500">
                {{ __('platform.search.no_results') }}
            </div>
        @endforelse
    </div>

    <div class="mt-8">{{ $results->links() }}</div>
</div>
@endsection

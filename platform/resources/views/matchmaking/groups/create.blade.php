@extends('layouts.app')

@section('title', __('platform.matchmaking.create_group'))

@section('content')
<div class="mx-auto max-w-2xl px-4 py-12 sm:px-6 lg:px-8">
    <h1 class="section-heading">{{ __('platform.matchmaking.create_group') }}</h1>
    <form method="POST" action="{{ route('matchmaking.groups.store') }}" class="mt-8 space-y-5 rounded-3xl border border-bavarian-100 bg-white p-6 shadow-md">
        @csrf
        <div>
            <label class="text-sm font-semibold">{{ __('platform.matchmaking.field_group_title') }}</label>
            <input name="title" required class="mt-1 w-full rounded-xl border border-bavarian-200 px-4 py-2.5 text-sm">
        </div>
        <div>
            <label class="text-sm font-semibold">{{ __('platform.matchmaking.field_bio') }}</label>
            <textarea name="description" rows="4" class="mt-1 w-full rounded-xl border border-bavarian-200 px-4 py-2.5 text-sm"></textarea>
        </div>
        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="text-sm font-semibold">{{ __('platform.matchmaking.field_intent') }}</label>
                <select name="intent" class="mt-1 w-full rounded-xl border border-bavarian-200 px-4 py-2.5 text-sm">
                    @foreach ($intents as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-sm font-semibold">{{ __('platform.matchmaking.field_city') }}</label>
                <input name="city" value="Munich" class="mt-1 w-full rounded-xl border border-bavarian-200 px-4 py-2.5 text-sm">
            </div>
        </div>
        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="text-sm font-semibold">{{ __('platform.matchmaking.field_meets_at') }}</label>
                <input type="datetime-local" name="meets_at" class="mt-1 w-full rounded-xl border border-bavarian-200 px-4 py-2.5 text-sm">
            </div>
            <div>
                <label class="text-sm font-semibold">{{ __('platform.matchmaking.field_capacity') }}</label>
                <input type="number" name="capacity" value="12" min="2" max="200" class="mt-1 w-full rounded-xl border border-bavarian-200 px-4 py-2.5 text-sm">
            </div>
        </div>
        <button class="btn-gold" type="submit">{{ __('platform.matchmaking.create_group') }}</button>
    </form>
</div>
@endsection

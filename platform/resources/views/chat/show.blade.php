@extends('layouts.app')

@php
    $name = $profile['display_name'];
    $slug = $profile['slug'];
    $avatar = $profile['avatar_url'] ?? null;
    $intentKey = $profile['intent'] ?? '';
@endphp

@section('title', __('platform.chat.thread_title', ['name' => $name]))

@section('content')
<div class="mx-auto flex max-w-3xl flex-col px-4 py-8 sm:px-6 lg:px-8" style="min-height: calc(100vh - 12rem);">
    <div class="mb-5 flex items-center gap-4">
        <a href="{{ route('chat.index') }}" class="text-sm font-semibold text-bavarian-600 hover:text-gold-600">← {{ __('platform.chat.inbox_title') }}</a>
    </div>

    <div class="flex items-center gap-4 rounded-2xl border border-bavarian-100 bg-white p-4 shadow-sm">
        <a href="{{ route('matchmaking.show', $slug) }}" class="flex min-w-0 flex-1 items-center gap-4">
            @if ($avatar)
                <img src="{{ $avatar }}" alt="{{ $name }}" class="h-14 w-14 rounded-2xl object-cover">
            @else
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-bavarian-100 font-display text-xl font-bold text-bavarian-500">{{ strtoupper(substr($name, 0, 1)) }}</div>
            @endif
            <div class="min-w-0">
                <p class="font-display text-lg font-bold text-bavarian-900">{{ $name }}</p>
                <p class="truncate text-sm text-stone-500">{{ $profile['headline'] ?? '' }}</p>
            </div>
        </a>
        <span class="hidden rounded-full bg-bavarian-50 px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-bavarian-600 sm:inline">{{ $intents[$intentKey] ?? $intentKey }}</span>
    </div>

    <div
        class="mt-5 flex-1 space-y-3 overflow-y-auto rounded-3xl border border-bavarian-100 bg-white p-4 shadow-sm sm:p-6"
        x-data
        x-init="$nextTick(() => { $el.scrollTop = $el.scrollHeight })"
        style="max-height: 28rem;"
    >
        @foreach ($messages as $message)
            <div class="flex {{ $message['mine'] ? 'justify-end' : 'justify-start' }}">
                <div @class([
                    'max-w-[85%] rounded-2xl px-4 py-2.5 text-sm leading-relaxed',
                    'bg-gold-400 text-beer' => $message['mine'],
                    'bg-cream text-beer' => ! $message['mine'],
                ])>
                    <p class="text-[11px] font-bold uppercase tracking-wider opacity-70">{{ $message['from'] }}</p>
                    <p class="mt-0.5">{{ $message['body'] }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <form method="POST" action="{{ route('chat.send', $slug) }}" class="mt-4" x-data="{ body: @js(old('body', '')) }">
        @csrf
        @if ($errors->any())
            <p class="mb-3 text-sm text-red-600">{{ $errors->first('body') }}</p>
        @endif
        <div class="mb-3 flex flex-wrap gap-2">
            @foreach (__('platform.chat.quick') as $quick)
                <button type="button" class="rounded-full border border-bavarian-200 bg-white px-3 py-1 text-xs font-semibold text-bavarian-700 hover:border-gold-400" @click="body = @js($quick)">{{ $quick }}</button>
            @endforeach
        </div>
        <div class="flex gap-2">
            <label class="sr-only" for="chat-body">{{ __('platform.chat.placeholder') }}</label>
            <input
                id="chat-body"
                type="text"
                name="body"
                x-model="body"
                maxlength="400"
                required
                placeholder="{{ __('platform.chat.placeholder') }}"
                class="w-full rounded-2xl border border-bavarian-200 bg-white px-4 py-3 text-sm text-beer focus:border-gold-400 focus:outline-none"
            >
            <button type="submit" class="shrink-0 rounded-2xl bg-gradient-to-r from-gold-400 to-gold-500 px-5 py-3 text-sm font-bold text-beer hover:from-gold-300">{{ __('platform.chat.send') }}</button>
        </div>
    </form>
</div>
@endsection

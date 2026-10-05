@extends('layouts.app')

@section('title', __('platform.profiles.create_title'))

@php
    $isArray = is_array($profile);
    $val = fn ($key, $default = '') => $isArray ? ($profile[$key] ?? $default) : ($profile->{$key} ?? $default);
    $interests = $isArray ? implode(', ', $profile['interests'] ?? []) : implode(', ', $profile->interests ?? []);
    $languages = $isArray ? implode(', ', $profile['languages'] ?? []) : implode(', ', $profile->languages ?? []);
    $currentPhoto = old('avatar_url', $val('avatar_url', $portraits[0] ?? ''));
@endphp

@section('content')
<div class="mx-auto max-w-3xl px-4 py-12 sm:px-6 lg:px-8">
    <a href="{{ route('network.index') }}" class="text-sm font-semibold text-bavarian-600 hover:text-gold-600">← {{ __('platform.nav.network') }}</a>
    <h1 class="section-heading mt-3">{{ __('platform.profiles.create_title') }}</h1>
    <p class="section-subheading">{{ __('platform.profiles.create_subtitle') }}</p>

    @if (session('error'))
        <p class="mt-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">{{ session('error') }}</p>
    @endif

    <form
        method="POST"
        action="{{ route('network.store') }}"
        class="mt-8 space-y-6 rounded-3xl border border-bavarian-100 bg-white p-6 shadow-md"
        x-data="{ photo: @js($currentPhoto) }"
    >
        @csrf

        <div>
            <p class="text-sm font-semibold text-bavarian-800">{{ __('platform.profiles.pick_photo') }}</p>
            <div class="mt-3 grid grid-cols-4 gap-2 sm:grid-cols-6">
                @foreach ($portraits as $portrait)
                    <button
                        type="button"
                        @click="photo = '{{ $portrait }}'"
                        class="overflow-hidden rounded-xl ring-2 ring-offset-2 transition"
                        :class="photo === '{{ $portrait }}' ? 'ring-gold-400' : 'ring-transparent hover:ring-bavarian-200'"
                    >
                        <img src="{{ $portrait }}" alt="" class="aspect-[3/4] w-full object-cover">
                    </button>
                @endforeach
            </div>
            <input type="hidden" name="avatar_url" :value="photo">
            <div class="mt-3 overflow-hidden rounded-2xl border border-bavarian-100">
                <img :src="photo" alt="" class="aspect-[3/4] max-h-72 w-full object-cover">
            </div>
        </div>

        <div>
            <label class="text-sm font-semibold text-bavarian-800">{{ __('platform.matchmaking.field_name') }}</label>
            <input name="display_name" value="{{ old('display_name', $val('display_name')) }}" required class="mt-1 w-full rounded-xl border border-bavarian-200 px-4 py-2.5 text-sm">
        </div>
        <div>
            <label class="text-sm font-semibold text-bavarian-800">{{ __('platform.matchmaking.field_headline') }}</label>
            <input name="headline" value="{{ old('headline', $val('headline')) }}" class="mt-1 w-full rounded-xl border border-bavarian-200 px-4 py-2.5 text-sm">
        </div>
        <div>
            <label class="text-sm font-semibold text-bavarian-800">{{ __('platform.matchmaking.field_bio') }}</label>
            <textarea name="bio" rows="4" class="mt-1 w-full rounded-xl border border-bavarian-200 px-4 py-2.5 text-sm">{{ old('bio', $val('bio')) }}</textarea>
        </div>
        <div>
            <label class="text-sm font-semibold text-bavarian-800">{{ __('platform.profiles.field_status_quote') }}</label>
            <input name="status_quote" value="{{ old('status_quote', $val('status_quote')) }}" maxlength="140" class="mt-1 w-full rounded-xl border border-bavarian-200 px-4 py-2.5 text-sm" placeholder="{{ __('platform.profiles.status_quote_placeholder') }}">
        </div>
        <div class="grid gap-4 sm:grid-cols-3">
            <div>
                <label class="text-sm font-semibold text-bavarian-800">{{ __('platform.matchmaking.field_city') }}</label>
                <input name="city" value="{{ old('city', $val('city', 'Munich')) }}" class="mt-1 w-full rounded-xl border border-bavarian-200 px-4 py-2.5 text-sm">
            </div>
            <div>
                <label class="text-sm font-semibold text-bavarian-800">{{ __('platform.matchmaking.field_age') }}</label>
                <input type="number" min="18" max="99" name="age" value="{{ old('age', $val('age')) }}" class="mt-1 w-full rounded-xl border border-bavarian-200 px-4 py-2.5 text-sm">
            </div>
            <div>
                <label class="text-sm font-semibold text-bavarian-800">{{ __('platform.matchmaking.field_intent') }}</label>
                <select name="intent" class="mt-1 w-full rounded-xl border border-bavarian-200 px-4 py-2.5 text-sm">
                    @foreach ($intents as $key => $label)
                        <option value="{{ $key }}" @selected(old('intent', $val('intent', 'friends')) === $key)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="grid gap-4 sm:grid-cols-3">
            <div>
                <label class="text-sm font-semibold text-bavarian-800">{{ __('platform.profiles.field_looking') }}</label>
                <select name="looking_for" class="mt-1 w-full rounded-xl border border-bavarian-200 px-4 py-2.5 text-sm">
                    @foreach ($intents as $key => $label)
                        <option value="{{ $key }}" @selected(old('looking_for', $val('looking_for', $val('intent', 'friends'))) === $key)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-sm font-semibold text-bavarian-800">{{ __('platform.profiles.field_relationship') }}</label>
                <select name="relationship" class="mt-1 w-full rounded-xl border border-bavarian-200 px-4 py-2.5 text-sm">
                    @foreach ($relationships as $key => $label)
                        <option value="{{ $key }}" @selected(old('relationship', $val('relationship', 'single')) === $key)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-sm font-semibold text-bavarian-800">{{ __('platform.profiles.field_status') }}</label>
                <select name="status" class="mt-1 w-full rounded-xl border border-bavarian-200 px-4 py-2.5 text-sm">
                    @foreach ($statuses as $key => $label)
                        <option value="{{ $key }}" @selected(old('status', $val('status', 'open_to_meet')) === $key)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="text-sm font-semibold text-bavarian-800">{{ __('platform.matchmaking.field_interests') }}</label>
                <input name="interests" value="{{ old('interests', $interests) }}" placeholder="music, tents, startups" class="mt-1 w-full rounded-xl border border-bavarian-200 px-4 py-2.5 text-sm">
            </div>
            <div>
                <label class="text-sm font-semibold text-bavarian-800">{{ __('platform.matchmaking.field_languages') }}</label>
                <input name="languages" value="{{ old('languages', $languages) }}" placeholder="en, de" class="mt-1 w-full rounded-xl border border-bavarian-200 px-4 py-2.5 text-sm">
            </div>
        </div>
        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="text-sm font-semibold text-bavarian-800">Instagram</label>
                <input name="instagram" value="{{ old('instagram', $val('instagram')) }}" placeholder="@yourhandle" class="mt-1 w-full rounded-xl border border-bavarian-200 px-4 py-2.5 text-sm">
            </div>
            <div>
                <label class="text-sm font-semibold text-bavarian-800">TikTok</label>
                <input name="tiktok" value="{{ old('tiktok', $val('tiktok')) }}" placeholder="@yourhandle" class="mt-1 w-full rounded-xl border border-bavarian-200 px-4 py-2.5 text-sm">
            </div>
            <div>
                <label class="text-sm font-semibold text-bavarian-800">LinkedIn</label>
                <input name="linkedin_url" value="{{ old('linkedin_url', $val('linkedin_url')) }}" placeholder="https://" class="mt-1 w-full rounded-xl border border-bavarian-200 px-4 py-2.5 text-sm">
            </div>
            <div>
                <label class="text-sm font-semibold text-bavarian-800">{{ __('platform.profiles.website') }}</label>
                <input name="website" value="{{ old('website', $val('website')) }}" placeholder="https://" class="mt-1 w-full rounded-xl border border-bavarian-200 px-4 py-2.5 text-sm">
            </div>
        </div>
        <div class="flex flex-wrap gap-5 text-sm">
            <label class="inline-flex items-center gap-2"><input type="checkbox" name="is_public" value="1" @checked(old('is_public', $val('is_public', true)))> {{ __('platform.matchmaking.field_public') }}</label>
            <label class="inline-flex items-center gap-2"><input type="checkbox" name="open_to_connect" value="1" @checked(old('open_to_connect', $val('open_to_connect', true)))> {{ __('platform.matchmaking.field_open') }}</label>
        </div>
        <button type="submit" class="btn-gold">{{ __('platform.matchmaking.save_profile') }}</button>
    </form>
</div>
@endsection

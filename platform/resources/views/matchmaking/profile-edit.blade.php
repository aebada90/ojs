@extends('layouts.app')

@section('title', __('platform.matchmaking.edit_profile_title'))

@php
    $isArray = is_array($profile);
    $val = fn ($key, $default = '') => $isArray ? ($profile[$key] ?? $default) : ($profile->{$key} ?? $default);
    $interests = $isArray ? implode(', ', $profile['interests'] ?? []) : implode(', ', $profile->interests ?? []);
    $languages = $isArray ? implode(', ', $profile['languages'] ?? []) : implode(', ', $profile->languages ?? []);
@endphp

@section('content')
<div class="mx-auto max-w-3xl px-4 py-12 sm:px-6 lg:px-8">
    <h1 class="section-heading">{{ __('platform.matchmaking.edit_profile_title') }}</h1>
    <p class="section-subheading">{{ __('platform.matchmaking.edit_profile_subtitle') }}</p>

    @if (session('error'))
        <p class="mt-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">{{ session('error') }}</p>
    @endif

    <form method="POST" action="{{ route('matchmaking.profile.update') }}" class="mt-8 space-y-5 rounded-3xl border border-bavarian-100 bg-white p-6 shadow-md">
        @csrf
        @method('PUT')

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
                <label class="text-sm font-semibold text-bavarian-800">{{ __('platform.matchmaking.field_company') }}</label>
                <input name="company" value="{{ old('company', $val('company')) }}" class="mt-1 w-full rounded-xl border border-bavarian-200 px-4 py-2.5 text-sm">
            </div>
            <div>
                <label class="text-sm font-semibold text-bavarian-800">{{ __('platform.matchmaking.field_role') }}</label>
                <input name="role_title" value="{{ old('role_title', $val('role_title')) }}" class="mt-1 w-full rounded-xl border border-bavarian-200 px-4 py-2.5 text-sm">
            </div>
        </div>
        <div>
            <label class="text-sm font-semibold text-bavarian-800">{{ __('platform.matchmaking.field_avatar') }}</label>
            <input name="avatar_url" value="{{ old('avatar_url', $val('avatar_url')) }}" class="mt-1 w-full rounded-xl border border-bavarian-200 px-4 py-2.5 text-sm">
        </div>
        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="text-sm font-semibold text-bavarian-800">LinkedIn</label>
                <input name="linkedin_url" value="{{ old('linkedin_url', $val('linkedin_url')) }}" class="mt-1 w-full rounded-xl border border-bavarian-200 px-4 py-2.5 text-sm">
            </div>
            <div>
                <label class="text-sm font-semibold text-bavarian-800">{{ $nexora['name'] }} URL</label>
                <input name="nexora_url" value="{{ old('nexora_url', $val('nexora_url')) }}" class="mt-1 w-full rounded-xl border border-bavarian-200 px-4 py-2.5 text-sm">
            </div>
        </div>
        <div class="flex flex-wrap gap-5 text-sm">
            <label class="inline-flex items-center gap-2"><input type="checkbox" name="is_public" value="1" @checked(old('is_public', $val('is_public', true)))> {{ __('platform.matchmaking.field_public') }}</label>
            <label class="inline-flex items-center gap-2"><input type="checkbox" name="open_to_connect" value="1" @checked(old('open_to_connect', $val('open_to_connect', true)))> {{ __('platform.matchmaking.field_open') }}</label>
        </div>
        <button type="submit" class="btn-gold">{{ __('platform.matchmaking.save_profile') }}</button>
    </form>

    <p class="mt-6 text-sm text-stone-500">{{ __('platform.matchmaking.nexora_hint') }} <a href="{{ $nexora['register'] }}" target="_blank" rel="noopener noreferrer" class="font-semibold text-bavarian-700 underline">{{ $nexora['name'] }}</a></p>
</div>
@endsection

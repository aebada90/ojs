@extends('layouts.app')

@section('title', __('platform.competition.enter_title'))

@section('content')
<div class="mx-auto max-w-2xl px-4 py-12 sm:px-6 lg:px-8">
    <a href="{{ route('competition.index') }}" class="text-sm font-semibold text-bavarian-600 hover:text-gold-600">← {{ __('platform.competition.back') }}</a>
    <h1 class="section-heading mt-4">{{ __('platform.competition.enter_title') }}</h1>
    <p class="section-subheading">{{ __('platform.competition.enter_subtitle') }}</p>

    <form method="POST" action="{{ route('competition.enter.store') }}" class="mt-8 space-y-5 rounded-3xl border border-bavarian-100 bg-white p-6 shadow-md">
        @csrf
        <div>
            <label class="text-sm font-semibold text-bavarian-800" for="name">{{ __('platform.competition.field_name') }}</label>
            <input id="name" name="name" value="{{ old('name') }}" required maxlength="80" class="mt-1 w-full rounded-xl border border-bavarian-200 px-4 py-2.5 text-sm">
            @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="text-sm font-semibold text-bavarian-800" for="city">{{ __('platform.competition.field_city') }}</label>
                <input id="city" name="city" value="{{ old('city', 'Munich') }}" maxlength="80" class="mt-1 w-full rounded-xl border border-bavarian-200 px-4 py-2.5 text-sm">
            </div>
            <div>
                <label class="text-sm font-semibold text-bavarian-800" for="age">{{ __('platform.competition.field_age') }}</label>
                <input id="age" name="age" type="number" min="18" max="99" value="{{ old('age') }}" required class="mt-1 w-full rounded-xl border border-bavarian-200 px-4 py-2.5 text-sm">
                @error('age') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
        <div>
            <label class="text-sm font-semibold text-bavarian-800" for="dirndl">{{ __('platform.competition.field_dirndl') }}</label>
            <input id="dirndl" name="dirndl" value="{{ old('dirndl') }}" maxlength="120" class="mt-1 w-full rounded-xl border border-bavarian-200 px-4 py-2.5 text-sm">
        </div>
        <div>
            <label class="text-sm font-semibold text-bavarian-800" for="bio">{{ __('platform.competition.field_bio') }}</label>
            <textarea id="bio" name="bio" rows="4" maxlength="400" class="mt-1 w-full rounded-xl border border-bavarian-200 px-4 py-2.5 text-sm">{{ old('bio') }}</textarea>
        </div>
        <div>
            <label class="text-sm font-semibold text-bavarian-800" for="photo">{{ __('platform.competition.field_photo') }}</label>
            <input id="photo" name="photo" type="url" value="{{ old('photo') }}" maxlength="255" placeholder="https://" class="mt-1 w-full rounded-xl border border-bavarian-200 px-4 py-2.5 text-sm">
            @error('photo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <p class="text-xs text-stone-500">{{ __('platform.competition.enter_age_note') }}</p>
        <button type="submit" class="btn-gold">{{ __('platform.competition.enter_submit') }}</button>
    </form>
</div>
@endsection

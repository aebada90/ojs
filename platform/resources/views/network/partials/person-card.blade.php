@php
    $slug = is_array($profile) ? $profile['slug'] : $profile->slug;
    $name = is_array($profile) ? $profile['display_name'] : $profile->display_name;
    $headline = is_array($profile) ? ($profile['headline'] ?? '') : $profile->headline;
    $intentKey = is_array($profile) ? $profile['intent'] : $profile->intent;
    $avatar = is_array($profile) ? ($profile['avatar_url'] ?? null) : $profile->avatar_url;
    $city = is_array($profile) ? ($profile['city'] ?? 'Munich') : $profile->city;
    $interests = is_array($profile) ? ($profile['interests'] ?? []) : ($profile->interests ?? []);
@endphp
<article class="card-fest flex flex-col overflow-hidden">
    <a href="{{ route('matchmaking.show', $slug) }}" class="group block">
        <div class="aspect-[16/10] overflow-hidden bg-bavarian-100">
            @if ($avatar)
                <img src="{{ $avatar }}" alt="{{ $name }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105" loading="lazy">
            @else
                <div class="flex h-full items-center justify-center font-display text-4xl font-bold text-bavarian-400">{{ strtoupper(substr($name, 0, 1)) }}</div>
            @endif
        </div>
        <div class="p-5 pb-3">
            <div class="flex items-start justify-between gap-2">
                <h3 class="font-semibold text-bavarian-900 group-hover:text-bavarian-600">{{ $name }}</h3>
                <span class="rounded-full bg-bavarian-50 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-bavarian-600">{{ $intents[$intentKey] ?? $intentKey }}</span>
            </div>
            <p class="mt-1 text-xs text-stone-500">{{ $city }}</p>
            <p class="mt-2 line-clamp-2 text-sm text-stone-600">{{ $headline }}</p>
            @if (!empty($interests))
                <div class="mt-3 flex flex-wrap gap-1.5">
                    @foreach (array_slice($interests, 0, 3) as $tag)
                        <span class="rounded-full bg-cream px-2 py-0.5 text-[11px] font-medium text-beer">{{ $tag }}</span>
                    @endforeach
                </div>
            @endif
        </div>
    </a>
    <div class="mt-auto flex gap-2 px-5 pb-5">
        <a href="{{ route('matchmaking.show', $slug) }}" class="inline-flex flex-1 items-center justify-center rounded-full border-2 border-bavarian-200 px-3 py-2 text-sm font-bold text-bavarian-700 hover:border-gold-400">{{ __('platform.network.view_profile') }}</a>
        <a href="{{ route('chat.show', $slug) }}" class="inline-flex flex-1 items-center justify-center rounded-full bg-gradient-to-r from-gold-400 to-gold-500 px-3 py-2 text-sm font-bold text-beer hover:from-gold-300">{{ __('platform.network.chat') }}</a>
    </div>
</article>

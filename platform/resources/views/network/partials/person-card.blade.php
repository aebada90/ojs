@php
    $name = $profile['display_name'] ?? 'Member';
    $slug = $profile['slug'] ?? '';
    $intentKey = $profile['intent'] ?? 'friends';
    $statusKey = $profile['status'] ?? 'online';
    $looking = $profile['looking_for'] ?? $intentKey;
    $avatar = $profile['avatar_url'] ?? null;
    $intents = $intents ?? [];
    $relationships = $relationships ?? [];
    $statuses = $statuses ?? [];
    $filterable = $filterable ?? false;
    $socials = \App\Support\ConnectDemoProfiles::socialLinks($profile);
    $search = strtolower(implode(' ', array_filter([
        $name,
        $profile['headline'] ?? '',
        $profile['city'] ?? '',
        $profile['bio'] ?? '',
        $intentKey,
        $looking,
    ])));
@endphp
<article
    class="card-fest group flex flex-col overflow-hidden"
    data-intent="{{ $intentKey }}"
    data-looking="{{ $looking }}"
    data-search="{{ $search }}"
    @if ($filterable)
        x-show="matches($el)"
        x-transition
    @endif
>
    <a href="{{ route('matchmaking.show', $slug) }}" class="relative block overflow-hidden">
        <div class="relative aspect-[3/4] overflow-hidden bg-bavarian-100">
            @if ($avatar)
                <img src="{{ $avatar }}" alt="{{ $name }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105" loading="lazy">
            @else
                <div class="flex h-full items-center justify-center bg-gradient-to-br from-bavarian-200 to-gold-100 font-display text-5xl font-bold text-bavarian-700">{{ strtoupper(substr($name, 0, 1)) }}</div>
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-beer/80 via-beer/10 to-transparent"></div>
            <span class="absolute left-3 top-3 inline-flex items-center gap-1.5 rounded-full bg-white/90 px-2.5 py-1 text-[11px] font-bold uppercase tracking-wider text-bavarian-800">
                <span class="status-dot status-{{ $statusKey }}"></span>
                {{ $statuses[$statusKey] ?? $statusKey }}
            </span>
            <div class="absolute bottom-3 left-3 right-3">
                <p class="font-display text-xl font-bold text-white">{{ $name }}@if(!empty($profile['age'])), {{ $profile['age'] }}@endif</p>
                <p class="text-xs text-white/80">{{ $profile['city'] ?? 'Munich' }}</p>
            </div>
        </div>
    </a>
    <div class="flex flex-1 flex-col p-4">
        <div class="flex flex-wrap gap-1.5">
            <span class="rounded-full bg-bavarian-50 px-2.5 py-0.5 text-[11px] font-bold uppercase tracking-wider text-bavarian-700">{{ $intents[$intentKey] ?? $intentKey }}</span>
            @if (($relationships[$profile['relationship'] ?? ''] ?? null))
                <span class="rounded-full bg-gold-50 px-2.5 py-0.5 text-[11px] font-bold uppercase tracking-wider text-gold-700">{{ $relationships[$profile['relationship']] }}</span>
            @endif
        </div>
        <p class="mt-3 line-clamp-2 text-sm text-stone-600">{{ $profile['headline'] ?? '' }}</p>
        @if (!empty($profile['status_quote']))
            <p class="mt-2 line-clamp-1 text-xs italic text-bavarian-600">“{{ $profile['status_quote'] }}”</p>
        @endif
        @if ($socials !== [])
            <div class="mt-3">
                @include('network.partials.social-icons', ['socials' => $socials, 'compact' => true])
            </div>
        @endif
        <div class="mt-auto flex gap-2 pt-4">
            <a href="{{ route('chat.show', $slug) }}" class="btn-gold flex-1 px-3 py-2 text-xs">{{ __('platform.network.chat') }}</a>
            <a href="{{ route('matchmaking.show', $slug) }}" class="inline-flex flex-1 items-center justify-center rounded-full border-2 border-bavarian-200 px-3 py-2 text-xs font-bold text-bavarian-800 hover:border-gold-400">{{ __('platform.network.view_profile') }}</a>
        </div>
    </div>
</article>

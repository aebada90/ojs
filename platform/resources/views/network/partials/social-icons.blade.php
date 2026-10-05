@php
    $compact = $compact ?? false;
@endphp
<div class="flex flex-wrap items-center gap-1.5">
    @foreach ($socials as $social)
        <a
            href="{{ $social['url'] }}"
            target="_blank"
            rel="noopener noreferrer"
            class="social-chip {{ $compact ? 'social-chip-sm' : '' }}"
            title="{{ $social['label'] }}"
            @click.stop
        >
            @include('network.partials.social-svg', ['network' => $social['network']])
            @unless ($compact)
                <span>{{ $social['label'] }}</span>
            @endunless
        </a>
    @endforeach
</div>

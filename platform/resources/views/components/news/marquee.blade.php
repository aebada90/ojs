@php
    $newsItems = [];
    if (class_exists(\App\Services\OktoberfestNewsService::class)) {
        try {
            $newsItems = app(\App\Services\OktoberfestNewsService::class)->marqueeItems(app()->getLocale(), 28);
        } catch (\Throwable) {
            $newsItems = [];
        }
    }

    // Fixed 45s felt too fast with many headlines (wider track = higher px/s).
    // ~8s per item keeps titles readable; floor at 140s for short lists.
    $durationSeconds = max(140, (int) (count($newsItems) * 8));

    $newsAria = __('platform.news.aria');
    $newsBadge = __('platform.news.badge');
    $newsBadgeShort = __('platform.news.badge_short');
    if ($newsAria === 'platform.news.aria') {
        $newsAria = app()->getLocale() === 'de' ? 'Oktoberfest Nachrichten-Ticker' : 'Oktoberfest news ticker';
    }
    if ($newsBadge === 'platform.news.badge') {
        $newsBadge = 'Wiesn News';
    }
    if ($newsBadgeShort === 'platform.news.badge_short') {
        $newsBadgeShort = 'News';
    }
@endphp

@if (count($newsItems) > 0)
    <div class="news-marquee relative z-[90] border-b border-white/10 bg-bavarian-900 text-white" role="region" aria-label="{{ $newsAria }}">
        <div class="flex items-stretch">
            <div class="flex shrink-0 items-center bg-gold-500 px-2.5 text-[9px] font-bold uppercase tracking-[0.14em] text-beer sm:px-3 sm:text-[10px]">
                <span class="hidden sm:inline">{{ $newsBadge }}</span>
                <span class="sm:hidden">{{ $newsBadgeShort }}</span>
            </div>
            <div class="news-marquee-viewport min-w-0 flex-1 overflow-hidden">
                <div
                    class="news-marquee-track flex w-max items-center gap-5 whitespace-nowrap will-change-transform py-1.5 pl-3 sm:gap-7"
                    style="animation-duration: {{ $durationSeconds }}s;"
                >
                    @foreach ([1, 2] as $loopCopy)
                        @foreach ($newsItems as $item)
                            <a
                                href="{{ $item->url ?: '#' }}"
                                @if ($item->url) target="_blank" rel="noopener noreferrer" @endif
                                class="inline-flex items-center gap-1.5 text-[11px] leading-none text-white/85 transition hover:text-gold-200 sm:text-xs"
                            >
                                <span class="inline-block h-1 w-1 shrink-0 rounded-full bg-gold-400" aria-hidden="true"></span>
                                <span>{{ $item->title }}</span>
                                @if ($item->source)
                                    <span class="text-white/40">· {{ $item->source }}</span>
                                @endif
                            </a>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Inline so the ticker animates even if a stale Vite CSS hash is served --}}
    <style>
        .news-marquee-viewport {
            mask-image: linear-gradient(90deg, transparent, #000 1.5%, #000 98.5%, transparent);
            -webkit-mask-image: linear-gradient(90deg, transparent, #000 1.5%, #000 98.5%, transparent);
        }
        .news-marquee-track {
            animation-name: news-marquee-scroll;
            animation-timing-function: linear;
            animation-iteration-count: infinite;
        }
        .news-marquee:hover .news-marquee-track {
            animation-play-state: paused;
        }
        @keyframes news-marquee-scroll {
            from { transform: translateX(0); }
            to { transform: translateX(-50%); }
        }
        @media (prefers-reduced-motion: reduce) {
            .news-marquee-track {
                animation: none;
                transform: none;
            }
        }
    </style>
@endif

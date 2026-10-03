@php
    $newsItems = [];
    if (class_exists(\App\Services\OktoberfestNewsService::class)) {
        try {
            $newsItems = app(\App\Services\OktoberfestNewsService::class)->marqueeItems(app()->getLocale(), 28);
        } catch (\Throwable) {
            $newsItems = [];
        }
    }

    // Pace by content length so more headlines don't fly by faster.
    $durationSeconds = max(160, (int) (count($newsItems) * 10));

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
            <div class="news-marquee-badge flex shrink-0 items-center bg-gold-500 px-2.5 text-[9px] font-bold uppercase tracking-[0.14em] text-beer sm:px-3 sm:text-[10px]">
                <span class="hidden sm:inline">{{ $newsBadge }}</span>
                <span class="sm:hidden">{{ $newsBadgeShort }}</span>
            </div>

            <div class="news-marquee-viewport min-w-0 flex-1 overflow-hidden">
                <div class="news-marquee-track" style="--news-marquee-duration: {{ $durationSeconds }}s;">
                    @foreach ([false, true] as $isClone)
                        <div class="news-marquee-group" @if ($isClone) aria-hidden="true" @endif>
                            @foreach ($newsItems as $item)
                                <a
                                    href="{{ $item->url ?: '#' }}"
                                    @if ($item->url) target="_blank" rel="noopener noreferrer" @endif
                                    class="news-marquee-item"
                                    @if ($isClone) tabindex="-1" @endif
                                >
                                    <span class="news-marquee-dot" aria-hidden="true"></span>
                                    <span class="news-marquee-title">{{ $item->title }}</span>
                                    @if ($item->source)
                                        <span class="news-marquee-source">· {{ $item->source }}</span>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Inline styles keep the ticker working even with a stale Vite CSS hash --}}
    <style>
        .news-marquee-viewport {
            position: relative;
            mask-image: linear-gradient(90deg, transparent, #000 2%, #000 98%, transparent);
            -webkit-mask-image: linear-gradient(90deg, transparent, #000 2%, #000 98%, transparent);
        }
        .news-marquee-track {
            display: flex;
            width: max-content;
            align-items: center;
            animation: news-marquee-scroll var(--news-marquee-duration, 160s) linear infinite;
            will-change: transform;
        }
        .news-marquee-group {
            display: flex;
            flex-shrink: 0;
            align-items: center;
            gap: 1.75rem;
            padding: 0.4rem 1.75rem 0.4rem 0.85rem;
        }
        .news-marquee-item {
            display: inline-flex;
            flex-shrink: 0;
            align-items: center;
            gap: 0.4rem;
            white-space: nowrap;
            font-size: 0.7rem;
            line-height: 1;
            color: rgba(255, 255, 255, 0.88);
            text-decoration: none;
            transition: color 0.15s ease;
        }
        .news-marquee-item:hover {
            color: #fde68a;
        }
        .news-marquee-dot {
            display: inline-block;
            width: 0.25rem;
            height: 0.25rem;
            flex-shrink: 0;
            border-radius: 9999px;
            background: #f5b800;
        }
        .news-marquee-source {
            color: rgba(255, 255, 255, 0.4);
        }
        .news-marquee:hover .news-marquee-track {
            animation-play-state: paused;
        }
        @keyframes news-marquee-scroll {
            from { transform: translate3d(0, 0, 0); }
            to { transform: translate3d(-50%, 0, 0); }
        }
        @media (min-width: 640px) {
            .news-marquee-item { font-size: 0.75rem; }
            .news-marquee-group { gap: 2rem; padding-right: 2rem; }
        }
        @media (prefers-reduced-motion: reduce) {
            .news-marquee-track {
                animation: none;
                transform: none;
            }
            .news-marquee-viewport {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                mask-image: none;
                -webkit-mask-image: none;
            }
            .news-marquee-group[aria-hidden="true"] {
                display: none;
            }
        }
    </style>
@endif

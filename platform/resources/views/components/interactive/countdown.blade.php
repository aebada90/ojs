@props(['target' => '2026-09-19T12:00:00'])

@php
    $labels = [
        'days' => __('platform.countdown.days'),
        'hours' => __('platform.countdown.hours'),
        'minutes' => __('platform.countdown.minutes'),
        'seconds' => __('platform.countdown.seconds'),
    ];

    $fallback = app()->getLocale() === 'de'
        ? ['days' => 'Tage', 'hours' => 'Std.', 'minutes' => 'Min.', 'seconds' => 'Sek.']
        : ['days' => 'Days', 'hours' => 'Hours', 'minutes' => 'Min', 'seconds' => 'Sec'];

    foreach ($labels as $unit => $label) {
        if ($label === "platform.countdown.{$unit}") {
            $labels[$unit] = $fallback[$unit];
        }
    }
@endphp

<div
    {{ $attributes->merge(['class' => 'countdown']) }}
    x-data="{
        target: new Date('{{ $target }}').getTime(),
        days: '00', hours: '00', minutes: '00', seconds: '00',
        tick() {
            const diff = Math.max(0, this.target - Date.now());
            this.days = String(Math.floor(diff / 86400000)).padStart(2, '0');
            this.hours = String(Math.floor((diff % 86400000) / 3600000)).padStart(2, '0');
            this.minutes = String(Math.floor((diff % 3600000) / 60000)).padStart(2, '0');
            this.seconds = String(Math.floor((diff % 60000) / 1000)).padStart(2, '0');
        }
    }"
    x-init="tick(); setInterval(() => tick(), 1000)"
>
    @foreach ($labels as $unit => $label)
        <div class="countdown-unit">
            <span class="countdown-value" x-text="{{ $unit }}"></span>
            <span class="countdown-label">{{ $label }}</span>
        </div>
    @endforeach
</div>

<style>
    .countdown {
        display: inline-flex;
        flex-wrap: wrap;
        gap: 0.65rem;
    }
    .countdown-unit {
        min-width: 4.25rem;
        padding: 0.65rem 0.75rem;
        border-radius: 0.9rem;
        border: 1px solid rgba(255, 255, 255, 0.18);
        background: rgba(0, 24, 41, 0.55);
        text-align: center;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.08);
    }
    .countdown-value {
        display: block;
        font-family: 'Playfair Display', ui-serif, Georgia, serif;
        font-size: 1.55rem;
        font-weight: 700;
        line-height: 1;
        letter-spacing: 0.02em;
        color: #fde68a;
    }
    .countdown-label {
        display: block;
        margin-top: 0.35rem;
        font-size: 0.65rem;
        font-weight: 700;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: rgba(255, 255, 255, 0.78);
    }
    @media (min-width: 640px) {
        .countdown-unit { min-width: 4.75rem; padding: 0.75rem 0.85rem; }
        .countdown-value { font-size: 1.75rem; }
        .countdown-label { font-size: 0.7rem; }
    }
</style>

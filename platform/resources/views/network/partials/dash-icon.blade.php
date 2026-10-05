@php
    $icon = $icon ?? 'spark';
@endphp
@switch($icon)
    @case('profile')
        <svg viewBox="0 0 24 24" class="h-6 w-6 fill-current" aria-hidden="true"><path d="M12 12a4.5 4.5 0 1 0-4.5-4.5A4.5 4.5 0 0 0 12 12zm0 2c-4 0-8 2-8 5v2h16v-2c0-3-4-5-8-5z"/></svg>
        @break
    @case('network')
        <svg viewBox="0 0 24 24" class="h-6 w-6 fill-current" aria-hidden="true"><path d="M7 7a3 3 0 1 0-3-3 3 3 0 0 0 3 3zm10 0a3 3 0 1 0-3-3 3 3 0 0 0 3 3zM7 20a3 3 0 1 0-3-3 3 3 0 0 0 3 3zm10 0a3 3 0 1 0-3-3 3 3 0 0 0 3 3zM8.7 8.7l6.6 6.6M15.3 8.7l-6.6 6.6"/></svg>
        @break
    @case('chat')
        <svg viewBox="0 0 24 24" class="h-6 w-6 fill-current" aria-hidden="true"><path d="M4 4h16a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H8l-4 4V6a2 2 0 0 1 2-2z"/></svg>
        @break
    @case('crown')
        <svg viewBox="0 0 24 24" class="h-6 w-6 fill-current" aria-hidden="true"><path d="M3 18h18v2H3zm1-8 4 3 4-7 4 7 4-3v8H4z"/></svg>
        @break
    @case('heart')
        <svg viewBox="0 0 24 24" class="h-6 w-6 fill-current" aria-hidden="true"><path d="M12 21s-7.5-4.6-9.5-9A5.5 5.5 0 0 1 12 6.7 5.5 5.5 0 0 1 21.5 12c-2 4.4-9.5 9-9.5 9z"/></svg>
        @break
    @case('shirt')
        <svg viewBox="0 0 24 24" class="h-6 w-6 fill-current" aria-hidden="true"><path d="M8 4 3 7v4l3-1v10h12V10l3 1V7l-5-3-3 4-3-4z"/></svg>
        @break
    @case('calendar')
        <svg viewBox="0 0 24 24" class="h-6 w-6 fill-current" aria-hidden="true"><path d="M7 2v2H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-3V2h-2v2H9V2zm13 8H4v10h16z"/></svg>
        @break
    @case('hotel')
        <svg viewBox="0 0 24 24" class="h-6 w-6 fill-current" aria-hidden="true"><path d="M4 21V9l8-5 8 5v12h-5v-6H9v6z"/></svg>
        @break
    @default
        <svg viewBox="0 0 24 24" class="h-6 w-6 fill-current" aria-hidden="true"><path d="M4 11h7V4h2v7h7v2h-7v7h-2v-7H4z"/></svg>
@endswitch

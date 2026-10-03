<div class="space-y-4">
    <div class="max-h-96 space-y-3 overflow-y-auto rounded-xl bg-bavarian-50/50 p-3">
        @forelse ($conversation as $message)
            <div @class([
                'rounded-xl px-4 py-3 text-sm leading-relaxed',
                'ml-8 bg-bavarian-600 text-white' => $message['role'] === 'user',
                'mr-8 border border-bavarian-100 bg-white text-bavarian-800 shadow-sm' => $message['role'] === 'assistant',
            ])>
                {{ $message['content'] }}
            </div>
        @empty
            <div class="flex items-start gap-3 rounded-xl border border-dashed border-bavarian-200 bg-white p-4 text-sm text-bavarian-600">
                <span class="text-xl">🍺</span>
                <p>{{ __('platform.planner.empty') }}</p>
            </div>
        @endforelse
    </div>

    <form wire:submit="send" class="flex gap-3">
        <input
            wire:model="message"
            type="text"
            placeholder="{{ __('platform.planner.placeholder') }}"
            class="flex-1 rounded-xl border border-bavarian-200 bg-white px-4 py-3 text-sm text-bavarian-900 placeholder:text-bavarian-400 focus:border-gold-400 focus:outline-none focus:ring-2 focus:ring-gold-400/20"
        >
        <button type="submit" class="shrink-0 rounded-xl bg-gradient-to-r from-bavarian-600 to-bavarian-700 px-5 py-3 text-sm font-bold text-white transition hover:from-bavarian-500 hover:to-bavarian-600">
            {{ __('platform.planner.send') }}
        </button>
    </form>
</div>

<div
    class="fixed bottom-5 right-5 z-[100] flex flex-col items-end"
    x-data="{ open: @entangle('isOpen') }"
>
    {{-- Chat panel --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 scale-95"
        class="mb-4 flex h-[32rem] w-[22rem] flex-col overflow-hidden rounded-2xl border border-bavarian-200 bg-white shadow-2xl shadow-bavarian-900/20 sm:w-[24rem]"
        style="display: none;"
    >
        {{-- Header --}}
        <div class="flex items-center justify-between bg-gradient-to-r from-bavarian-700 to-bavarian-600 px-4 py-3">
            <div class="flex items-center gap-3">
                <span class="flex h-9 w-9 items-center justify-center rounded-full bg-gold-400 text-lg">🍺</span>
                <div>
                    <div class="text-sm font-bold text-white">{{ __('platform.chatbot.title') }}</div>
                    <div class="flex items-center gap-1.5 text-[10px] text-gold-200">
                        <span class="h-1.5 w-1.5 rounded-full bg-green-400 animate-pulse"></span>
                        {{ __('platform.chatbot.online') }}
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-1">
                <button wire:click="clearChat" type="button" class="rounded-lg p-1.5 text-white/70 transition hover:bg-white/10 hover:text-white" title="{{ __('platform.chatbot.clear') }}">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
                <button wire:click="toggle" type="button" class="rounded-lg p-1.5 text-white/70 transition hover:bg-white/10 hover:text-white">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        {{-- Messages --}}
        <div
            class="flex-1 overflow-y-auto bg-cream p-4 space-y-3"
            x-data
            x-init="$wire.on('chatbot-scroll-bottom', () => { $el.scrollTop = $el.scrollHeight })"
            id="chatbot-messages"
        >
            @if (empty($conversation))
                <div class="rounded-xl border border-dashed border-bavarian-200 bg-white p-4 text-center">
                    <div class="text-3xl">🎪</div>
                    <p class="mt-2 text-sm font-semibold text-bavarian-800">{{ __('platform.chatbot.welcome') }}</p>
                    <p class="mt-1 text-xs text-bavarian-600/70">{{ __('platform.chatbot.welcome_hint') }}</p>
                </div>

                <div class="flex flex-wrap gap-2">
                    @foreach ($quickActions as $action)
                        <button
                            wire:click="quickAsk(@js($action))"
                            type="button"
                            class="rounded-full border border-bavarian-200 bg-white px-3 py-1.5 text-xs font-semibold text-bavarian-700 transition hover:border-gold-400 hover:bg-gold-50"
                        >
                            {{ $action }}
                        </button>
                    @endforeach
                </div>
            @endif

            @foreach ($conversation as $msg)
                <div @class([
                    'max-w-[85%] rounded-2xl px-3.5 py-2.5 text-sm leading-relaxed',
                    'ml-auto bg-bavarian-600 text-white rounded-br-sm' => $msg['role'] === 'user',
                    'mr-auto border border-bavarian-100 bg-white text-bavarian-800 shadow-sm rounded-bl-sm' => $msg['role'] === 'assistant',
                ])>
                    {!! nl2br(e($msg['content'])) !!}
                </div>
            @endforeach

            <div wire:loading.flex wire:target="send,quickAsk" class="mr-auto items-center gap-1 rounded-2xl border border-bavarian-100 bg-white px-4 py-3 shadow-sm">
                <span class="h-2 w-2 animate-bounce rounded-full bg-bavarian-400"></span>
                <span class="h-2 w-2 animate-bounce rounded-full bg-bavarian-400" style="animation-delay: 150ms"></span>
                <span class="h-2 w-2 animate-bounce rounded-full bg-bavarian-400" style="animation-delay: 300ms"></span>
            </div>
        </div>

        {{-- Input --}}
        <form wire:submit="send" class="border-t border-bavarian-100 bg-white p-3">
            <div class="flex gap-2">
                <input
                    wire:model="message"
                    type="text"
                    placeholder="{{ __('platform.chatbot.placeholder') }}"
                    class="flex-1 rounded-xl border border-bavarian-200 px-3 py-2.5 text-sm text-bavarian-900 placeholder:text-bavarian-400 focus:border-gold-400 focus:outline-none focus:ring-2 focus:ring-gold-400/20"
                    wire:loading.attr="disabled"
                    wire:target="send,quickAsk"
                >
                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    wire:target="send,quickAsk"
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gradient-to-r from-gold-400 to-gold-500 text-beer shadow transition hover:from-gold-300 disabled:opacity-50"
                >
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                </button>
            </div>
        </form>
    </div>

    {{-- Toggle button --}}
    <button
        wire:click="toggle"
        type="button"
        class="group flex h-14 w-14 items-center justify-center rounded-full bg-gradient-to-br from-bavarian-600 to-bavarian-700 text-2xl shadow-xl shadow-bavarian-900/30 transition hover:scale-105 hover:from-bavarian-500 hover:to-bavarian-600"
        aria-label="{{ __('platform.chatbot.open') }}"
    >
        <span x-show="!open">🍺</span>
        <svg x-show="open" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
    </button>
</div>

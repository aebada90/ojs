<?php

namespace Modules\AI\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use Modules\AI\Services\AiAssistantService;
use Modules\AI\Services\ChatSessionService;

class Chatbot extends Component
{
    public bool $isOpen = false;

    public string $message = '';

    public ?string $sessionId = null;

    /** @var list<array{role: string, content: string}> */
    public array $conversation = [];

    public function mount(ChatSessionService $sessions): void
    {
        try {
            $this->sessionId = session('chatbot_session_id');

            if ($this->sessionId) {
                $session = $sessions->getOrCreateSession($this->sessionId);
                $this->conversation = $sessions->getConversation($session);
            }
        } catch (\Throwable $e) {
            report($e);
            session()->forget('chatbot_session_id');
            $this->sessionId = null;
            $this->conversation = [];
        }
    }

    public function toggle(): void
    {
        $this->isOpen = ! $this->isOpen;
    }

    public function send(AiAssistantService $ai, ChatSessionService $sessions): void
    {
        $this->validate(['message' => 'required|string|max:2000']);

        $session = $sessions->getOrCreateSession($this->sessionId);
        $this->sessionId = $session->id;
        session(['chatbot_session_id' => $this->sessionId]);

        $userMessage = trim($this->message);
        $this->conversation[] = ['role' => 'user', 'content' => $userMessage];
        $sessions->appendMessage($session, 'user', $userMessage);

        $this->message = '';

        $reply = $ai->chatWithHistory(
            collect($this->conversation)->map(fn ($m) => [
                'role' => $m['role'],
                'content' => $m['content'],
            ])->all(),
            [
                'module' => 'chatbot',
                'city' => config('platform.default_city'),
                'page' => url()->current(),
            ]
        );

        $this->conversation[] = ['role' => 'assistant', 'content' => $reply];
        $sessions->appendMessage($session, 'assistant', $reply);

        $this->dispatch('chatbot-scroll-bottom');
    }

    public function quickAsk(string $prompt): void
    {
        $this->message = $prompt;
        $this->send(app(AiAssistantService::class), app(ChatSessionService::class));
    }

    public function clearChat(ChatSessionService $sessions): void
    {
        session()->forget('chatbot_session_id');
        $this->sessionId = null;
        $this->conversation = [];
        $this->message = '';
    }

    public function render(): View
    {
        return view('ai::livewire.chatbot', [
            'quickActions' => [
                __('platform.chatbot.quick_hotels'),
                __('platform.chatbot.quick_events'),
                __('platform.chatbot.quick_rentals'),
                __('platform.chatbot.quick_restaurants'),
            ],
        ]);
    }
}

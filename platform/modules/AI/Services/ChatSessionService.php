<?php

namespace Modules\AI\Services;

use Illuminate\Support\Str;
use Modules\AI\Models\AiChatMessage;
use Modules\AI\Models\AiChatSession;

class ChatSessionService
{
    public function getOrCreateSession(?string $sessionId = null): AiChatSession
    {
        if ($sessionId) {
            $session = AiChatSession::query()->find($sessionId);
            if ($session) {
                return $session;
            }
        }

        return AiChatSession::query()->create([
            'id' => (string) Str::uuid(),
            'user_id' => auth()->id(),
            'locale' => app()->getLocale(),
            'source' => 'chatbot',
        ]);
    }

    /** @return list<array{role: string, content: string}> */
    public function getConversation(AiChatSession $session, int $limit = 20): array
    {
        return $session->messages()
            ->latest()
            ->limit($limit)
            ->get()
            ->reverse()
            ->map(fn (AiChatMessage $msg) => [
                'role' => $msg->role,
                'content' => $msg->content,
            ])
            ->values()
            ->all();
    }

    public function appendMessage(AiChatSession $session, string $role, string $content, ?string $provider = null): AiChatMessage
    {
        return $session->messages()->create([
            'role' => $role,
            'content' => $content,
            'provider' => $provider,
        ]);
    }
}

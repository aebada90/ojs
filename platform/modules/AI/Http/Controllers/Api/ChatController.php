<?php

namespace Modules\AI\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\AI\Services\AiAssistantService;
use Modules\AI\Services\AiGatewayService;
use Modules\AI\Services\ChatSessionService;

class ChatController extends Controller
{
    public function chat(Request $request, AiAssistantService $ai, ChatSessionService $sessions): JsonResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|max:4000',
            'session_id' => 'nullable|uuid',
            'context' => 'nullable|array',
        ]);

        $session = $sessions->getOrCreateSession($validated['session_id'] ?? null);
        $sessions->appendMessage($session, 'user', $validated['message']);

        $conversation = $sessions->getConversation($session);
        $reply = $ai->chatWithHistory($conversation, array_merge(
            $validated['context'] ?? [],
            ['source' => 'api']
        ));

        $sessions->appendMessage($session, 'assistant', $reply);

        return response()->json([
            'session_id' => $session->id,
            'reply' => $reply,
            'message' => $reply,
            'provider' => config('ai-providers.default'),
        ]);
    }

    public function status(AiGatewayService $gateway): JsonResponse
    {
        return response()->json([
            'enabled' => true,
            'default_provider' => config('ai-providers.default'),
            'available_providers' => $gateway->availableProviders(),
        ]);
    }

    public function history(string $sessionId, ChatSessionService $sessions): JsonResponse
    {
        $session = $sessions->getOrCreateSession($sessionId);

        if ($session->wasRecentlyCreated) {
            return response()->json(['messages' => []]);
        }

        return response()->json([
            'session_id' => $session->id,
            'messages' => $sessions->getConversation($session),
        ]);
    }
}

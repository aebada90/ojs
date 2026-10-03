<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChatbotTest extends TestCase
{
    use RefreshDatabase;

    public function test_chatbot_component_renders_on_homepage(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSeeLivewire('ai.chatbot');
    }

    public function test_ai_status_endpoint_returns_providers(): void
    {
        $response = $this->getJson('/api/v1/ai/status');

        $response->assertOk()
            ->assertJsonPath('enabled', true)
            ->assertJsonStructure(['default_provider', 'available_providers']);
    }

    public function test_ai_chat_endpoint_accepts_messages(): void
    {
        $response = $this->postJson('/api/v1/ai/chat', [
            'message' => 'Hello, what hotels are near Oktoberfest?',
        ]);

        $response->assertOk()
            ->assertJsonStructure(['session_id', 'reply', 'message']);

        $this->assertDatabaseHas('ai_chat_messages', [
            'role' => 'user',
            'content' => 'Hello, what hotels are near Oktoberfest?',
        ]);
    }
}

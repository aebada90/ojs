<?php

namespace Tests\Feature;

use Tests\TestCase;

class NetworkChatTest extends TestCase
{
    public function test_network_hub_lists_profiles_and_chat_actions(): void
    {
        $response = $this->get('/network');

        $response->assertOk();
        $response->assertSee('Network', false);
        $response->assertSee('Lena K.', false);
        $response->assertSee('/chat/lena-munich', false);
        $response->assertSee('Klara V.', false);
        $response->assertSee('Tom B.', false);
        $response->assertSee('instagram.com/lena.at.wiesn', false);
        $response->assertSee('Create your profile', false);
    }

    public function test_networking_redirects_to_network(): void
    {
        $this->get('/networking')->assertRedirect('/network');
    }

    public function test_chat_inbox_lists_people_to_message(): void
    {
        $response = $this->get('/chat');

        $response->assertOk();
        $response->assertSee('Marco S.', false);
        $response->assertSee('/chat/marco-business', false);
    }

    public function test_guest_can_open_and_send_profile_chat(): void
    {
        $this->get('/chat/lena-munich')
            ->assertOk()
            ->assertSee('Lena K.', false);

        $this->post('/chat/lena-munich', [
            'body' => 'Want to grab a Maß at Hofbräu?',
        ])->assertRedirect('/chat/lena-munich');

        $this->get('/chat/lena-munich')
            ->assertOk()
            ->assertSee('Want to grab a Maß at Hofbräu?', false)
            ->assertSee('Hofbräu', false);
    }

    public function test_unknown_profile_chat_is_not_found(): void
    {
        $this->get('/chat/not-a-real-person')->assertNotFound();
    }

    public function test_header_exposes_network_and_chat(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('/network', false)
            ->assertSee('/chat', false);
    }
}

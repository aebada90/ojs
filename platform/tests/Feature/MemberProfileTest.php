<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class MemberProfileTest extends TestCase
{
    public function test_home_shows_interactive_profile_cards(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Amina H.', false)
            ->assertSee('Klara V.', false)
            ->assertSee('/network/create', false);
    }

    public function test_guest_can_open_create_profile_form(): void
    {
        $this->get('/network/create')
            ->assertOk()
            ->assertSee('Create your Wiesn profile', false)
            ->assertSee('Instagram', false)
            ->assertSee('TikTok', false)
            ->assertSee('Pick a portrait', false);
    }

    public function test_guest_can_create_a_live_network_profile(): void
    {
        $this->post('/network/create', [
            'display_name' => 'Nora Test',
            'headline' => 'Here for tents and pretzels',
            'bio' => 'Demo member created in tests.',
            'city' => 'Munich',
            'age' => 29,
            'intent' => 'friends',
            'interests' => 'tents, pretzels',
            'languages' => 'en, de',
            'instagram' => 'nora.wiesn',
            'tiktok' => 'norafest',
            'relationship' => 'single',
            'looking_for' => 'friends',
            'status' => 'at_wiesn',
            'status_quote' => 'Maß o’clock',
            'avatar_url' => 'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=900&h=1200&q=80',
            'is_public' => 1,
            'open_to_connect' => 1,
        ])->assertRedirect();

        $this->get('/network')
            ->assertOk()
            ->assertSee('Nora Test', false)
            ->assertSee('instagram.com/nora.wiesn', false);

        $this->get('/matchmaking/people')
            ->assertOk()
            ->assertSee('Nora Test', false);
    }

    public function test_verified_dashboard_has_interactive_tiles(): void
    {
        $user = User::factory()->create([
            'name' => 'Prof. Dr. Ahmed Ebada',
        ]);

        $this->actingAs($user)
            ->get('/dashboard')
            ->assertOk()
            ->assertSee('Prof. Dr. Ahmed Ebada', false)
            ->assertSee('/network', false)
            ->assertSee('/chat', false)
            ->assertSee('/competition', false)
            ->assertSee('Create your profile', false);
    }

    public function test_profile_page_shows_socials_and_status(): void
    {
        $this->get('/matchmaking/people/amina-dating')
            ->assertOk()
            ->assertSee('Amina H.', false)
            ->assertSee('instagram.com/amina.dirndl', false)
            ->assertSee('At the Wiesn', false)
            ->assertSee('/chat/amina-dating', false);
    }
}

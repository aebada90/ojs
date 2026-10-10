<?php

namespace Tests\Feature;

use Tests\TestCase;

class FestivalNewsAndMenuFixTest extends TestCase
{
    public function test_news_ticker_shows_2027_festival_headlines(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Munich Festivals 2027', false)
            ->assertSee('Oktoberfest 2027', false)
            ->assertSee('Festival News', false)
            ->assertDontSee('Official 2026 Maß prices', false);
    }

    public function test_mobile_nav_is_viewport_fixed_outside_sticky_header(): void
    {
        $html = $this->get('/')->assertOk()->getContent();

        $this->assertStringContainsString('id="mobile-nav"', $html);
        $this->assertStringContainsString('fixed inset-0 z-[200]', $html);
        $this->assertStringContainsString('x-init="$watch(\'mobileOpen\'', $html);
        // Drawer markup should appear after the sticky header closes.
        $headerClose = strpos($html, '</header>');
        $drawer = strpos($html, 'id="mobile-nav"');
        $this->assertNotFalse($headerClose);
        $this->assertNotFalse($drawer);
        $this->assertGreaterThan($headerClose, $drawer);
    }

    public function test_starkbierfest_image_is_reachable_in_markup(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('photo-1608270586620-248524c67de9', false)
            ->assertDontSee('photo-1436076863939-06817fe63948', false);
    }
}

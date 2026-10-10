<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomePageTest extends TestCase
{
    public function test_homepage_loads_successfully(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee(config('platform.name'));
    }

    public function test_health_endpoint_returns_ok(): void
    {
        $response = $this->getJson('/api/v1/health');

        $response->assertOk()
            ->assertJsonPath('status', 'ok');
    }

    public function test_sitemap_is_available(): void
    {
        $response = $this->get('/sitemap.xml');

        $response->assertOk();
    }
}

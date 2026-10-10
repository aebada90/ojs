<?php

namespace Tests\Feature;

use Tests\TestCase;

class MobileNavOverlapTest extends TestCase
{
    public function test_header_stacks_above_news_marquee(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('z-[110]', false);
        $response->assertSee('mobile-nav-open', false);
        $response->assertSee('id="mobile-nav"', false);
    }
}

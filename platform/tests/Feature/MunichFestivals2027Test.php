<?php

namespace Tests\Feature;

use Tests\TestCase;

class MunichFestivals2027Test extends TestCase
{
    public function test_home_focuses_on_munich_festivals_2027(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Munich Festivals 2027', false)
            ->assertSee('Oktoberhub', false)
            ->assertSee('/festivals', false)
            ->assertSee('Frühlingsfest', false)
            ->assertSee('2027-09-18', false);
    }

    public function test_festivals_hub_lists_2027_seasons(): void
    {
        $this->get('/festivals')
            ->assertOk()
            ->assertSee('Munich festivals for 2027', false)
            ->assertSee('Starkbierfest', false)
            ->assertSee('Frühlingsfest', false)
            ->assertSee('Oktoberfest', false)
            ->assertSee('Christkindlmarkt', false)
            ->assertSee('Tollwood', false)
            ->assertSee('/festivals/oktoberfest', false);
    }

    public function test_oktoberfest_2027_page_loads(): void
    {
        $this->get('/festivals/oktoberfest')
            ->assertOk()
            ->assertSee('18 Sep – 3 Oct 2027', false)
            ->assertSee('/competition', false);
    }

    public function test_mobile_header_stacks_above_news_marquee(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('z-[110]', false)
            ->assertSee('mobile-nav-open', false)
            ->assertSee('id="mobile-nav"', false);
    }

    public function test_dirndl_competition_is_2027(): void
    {
        $this->get('/competition')
            ->assertOk()
            ->assertSee('Best Dirndl 2027', false);
    }
}

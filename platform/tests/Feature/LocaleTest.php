<?php

namespace Tests\Feature;

use Tests\TestCase;

class LocaleTest extends TestCase
{
    public function test_homepage_renders_in_german(): void
    {
        $response = $this->withSession(['locale' => 'de'])->get('/');

        $response->assertOk();
        $response->assertSee('Entdecken. Buchen. Feiern.');
    }

    public function test_locale_can_be_switched(): void
    {
        $response = $this->get(route('locale.switch', 'de'));

        $response->assertRedirect();
        $this->assertEquals('de', session('locale'));
    }
}

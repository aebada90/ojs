<?php

namespace Tests\Feature;

use App\Support\DirndlContest;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class DirndlCompetitionTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        @unlink(storage_path('app/dirndl-contest.json'));
        Cache::forget('dirndl-contest');
    }

    public function test_competition_lists_contestants_and_vote_actions(): void
    {
        $this->get('/competition')
            ->assertOk()
            ->assertSee('Best woman in a Dirndl', false)
            ->assertSee('Anna M.', false)
            ->assertSee('/competition/anna-munich', false);
    }

    public function test_dirndl_alias_redirects_to_competition(): void
    {
        $this->get('/dirndl')->assertRedirect('/competition');
    }

    public function test_guest_can_vote_and_cannot_double_count(): void
    {
        $before = DirndlContest::find('anna-munich')['votes'];

        $this->post('/competition/anna-munich/vote')->assertRedirect();

        $this->get('/competition')
            ->assertOk()
            ->assertSee('Your vote', false);

        $this->assertSame($before + 1, DirndlContest::find('anna-munich')['votes']);

        $this->post('/competition/anna-munich/vote')->assertRedirect();
        $this->assertSame($before + 1, DirndlContest::find('anna-munich')['votes']);
    }

    public function test_guest_can_move_vote_to_another_contestant(): void
    {
        $anna = DirndlContest::find('anna-munich')['votes'];
        $clara = DirndlContest::find('clara-vienna')['votes'];

        $this->post('/competition/anna-munich/vote');
        $this->post('/competition/clara-vienna/vote');

        $this->assertSame($anna, DirndlContest::find('anna-munich')['votes']);
        $this->assertSame($clara + 1, DirndlContest::find('clara-vienna')['votes']);
    }

    public function test_contestant_page_loads(): void
    {
        $this->get('/competition/anna-munich')
            ->assertOk()
            ->assertSee('Anna M.', false)
            ->assertSee('Vote', false);
    }

    public function test_unknown_contestant_is_not_found(): void
    {
        $this->get('/competition/not-a-contestant')->assertNotFound();
    }

    public function test_adult_can_enter_the_competition(): void
    {
        $this->post('/competition/enter', [
            'name' => 'Test Entrant',
            'city' => 'Munich',
            'age' => 22,
            'dirndl' => 'Emerald dirndl',
            'bio' => 'Here for the Wiesn look.',
        ])->assertRedirect();

        $this->get('/competition')->assertSee('Test Entrant', false);
    }

    public function test_under_18_cannot_enter(): void
    {
        $this->from('/competition/enter')->post('/competition/enter', [
            'name' => 'Too Young',
            'age' => 17,
        ])->assertSessionHasErrors('age');
    }

    public function test_header_exposes_competition(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('/competition', false)
            ->assertSee('Anna M.', false);
    }
}

<?php

namespace Tests\Feature;

use App\Core\Module\ModuleManager;
use Tests\TestCase;

class ModuleManagerTest extends TestCase
{
    public function test_core_modules_are_enabled(): void
    {
        $manager = app(ModuleManager::class);

        $this->assertTrue($manager->isEnabled('Core'));
        $this->assertTrue($manager->isEnabled('Marketplace'));
        $this->assertTrue($manager->isEnabled('AI'));
        $this->assertGreaterThan(10, $manager->enabled()->count());
    }
}

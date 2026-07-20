<?php

namespace Modules\AI\Providers;

use App\Core\Module\BaseModuleServiceProvider;

class AIServiceProvider extends BaseModuleServiceProvider
{
    protected string $module = 'AI';

    public function registerModule(): void
    {
        $this->app->singleton(\Modules\AI\Services\AiGatewayService::class);
        $this->app->singleton(\Modules\AI\Services\AiAssistantService::class);
        $this->app->singleton(\Modules\AI\Services\ChatSessionService::class);
    }

    public function bootModule(): void
    {
        \Livewire\Livewire::component('ai.trip-planner', \Modules\AI\Livewire\TripPlanner::class);
        \Livewire\Livewire::component('ai.chatbot', \Modules\AI\Livewire\Chatbot::class);
    }
}
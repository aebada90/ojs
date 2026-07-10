<?php

namespace Modules\AI\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use Modules\AI\Services\AiAssistantService;

class TripPlanner extends Component
{
    public string $message = '';

    /** @var list<array{role: string, content: string}> */
    public array $conversation = [];

    public function send(AiAssistantService $ai): void
    {
        $this->validate(['message' => 'required|string|max:2000']);

        $this->conversation[] = ['role' => 'user', 'content' => $this->message];

        $reply = $ai->chat($this->message, [
            'city' => config('platform.default_city'),
            'module' => 'trip_planner',
        ]);

        $this->conversation[] = ['role' => 'assistant', 'content' => $reply];
        $this->message = '';
    }

    public function render(): View
    {
        return view('ai::livewire.trip-planner');
    }
}

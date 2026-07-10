<?php

namespace Modules\Search\Livewire;

use App\Models\Listing;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class UniversalSearch extends Component
{
    public string $query = '';

    public string $type = 'all';

    public string $city = '';

    public function search(): void
    {
        $this->redirectRoute('search.results', [
            'q' => $this->query,
            'type' => $this->type,
            'city' => $this->city,
        ]);
    }

    public function suggestions(): array
    {
        if (strlen($this->query) < 2) {
            return [];
        }

        return Listing::query()
            ->where('status', 'published')
            ->where(function ($q) {
                $q->where('title', 'like', '%'.$this->query.'%')
                    ->orWhere('summary', 'like', '%'.$this->query.'%')
                    ->orWhere('city', 'like', '%'.$this->query.'%');
            })
            ->when($this->type !== 'all', fn ($q) => $q->where('type', $this->type))
            ->limit(8)
            ->get(['id', 'title', 'slug', 'type', 'city', 'price', 'currency'])
            ->toArray();
    }

    public function render(): View
    {
        return view('search::livewire.universal-search', [
            'suggestions' => $this->suggestions(),
            'types' => [
                'all' => 'Everything',
                'hotel' => 'Hotels',
                'rental' => 'Rentals',
                'product' => 'Products',
                'event' => 'Events',
                'property' => 'Properties',
                'restaurant' => 'Restaurants',
                'experience' => 'Experiences',
                'service' => 'Services',
                'job' => 'Jobs',
            ],
        ]);
    }
}

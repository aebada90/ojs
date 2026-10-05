<?php

namespace App\Livewire;

use App\Models\Listing;
use App\Support\ConnectDemoProfiles;
use App\Support\DirndlContest;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Modules\Marketplace\Models\Product;

class HomePage extends Component
{
    public function render(): View
    {
        return view('livewire.home-page', [
            'featuredHotels' => $this->featured('hotel'),
            'featuredRentals' => $this->featured('rental'),
            'featuredExperiences' => $this->featured('experience'),
            'featuredEvents' => $this->featured('event'),
            'featuredRestaurants' => $this->featured('restaurant'),
            'featuredProperties' => $this->featured('property'),
            'featuredProducts' => Product::query()
                ->where('status', 'published')
                ->where('is_featured', true)
                ->latest()
                ->limit(8)
                ->get(),
            'featuredJobs' => $this->featured('job'),
            'networkPeople' => array_slice(ConnectDemoProfiles::publicProfiles(), 0, 8),
            'dirndlContestants' => array_slice(DirndlContest::contestants(), 0, 4),
            'intents' => ConnectDemoProfiles::intents(),
            'relationships' => ConnectDemoProfiles::relationships(),
            'statuses' => ConnectDemoProfiles::statuses(),
        ]);
    }

    protected function featured(string $type)
    {
        return Listing::query()
            ->where('type', $type)
            ->where('status', 'published')
            ->where('is_featured', true)
            ->latest('published_at')
            ->limit(8)
            ->get();
    }
}

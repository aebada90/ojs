<?php

namespace Modules\Search\Providers;

use App\Core\Module\BaseModuleServiceProvider;

class SearchServiceProvider extends BaseModuleServiceProvider
{
    protected string $module = 'Search';

    public function registerModule(): void
    {
        //
    }

    public function bootModule(): void
    {
        \Livewire\Livewire::component('search.universal-search', \Modules\Search\Livewire\UniversalSearch::class);
    }
}
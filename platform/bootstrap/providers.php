<?php

use App\Providers\AppServiceProvider;
use App\Providers\FortifyServiceProvider;
use App\Providers\PlatformServiceProvider;

return [
    AppServiceProvider::class,
    PlatformServiceProvider::class,
    FortifyServiceProvider::class,
];

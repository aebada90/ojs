<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /** @var list<string> */
    protected array $supported = ['en', 'de'];

    public function handle(Request $request, Closure $next): Response
    {
        $locale = session('locale', config('platform.default_locale', 'en'));

        if ($request->user()?->locale && in_array($request->user()->locale, $this->supported, true)) {
            $locale = $request->user()->locale;
        }

        if (! in_array($locale, $this->supported, true)) {
            $locale = 'en';
        }

        App::setLocale($locale);

        return $next($request);
    }
}

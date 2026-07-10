<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $urls = [
            ['loc' => url('/'), 'priority' => '1.0'],
            ['loc' => url('/search'), 'priority' => '0.9'],
            ['loc' => url('/hotels'), 'priority' => '0.8'],
            ['loc' => url('/rentals'), 'priority' => '0.8'],
            ['loc' => url('/marketplace'), 'priority' => '0.8'],
            ['loc' => url('/events'), 'priority' => '0.8'],
            ['loc' => url('/restaurants'), 'priority' => '0.8'],
            ['loc' => url('/experiences'), 'priority' => '0.8'],
            ['loc' => url('/jobs'), 'priority' => '0.7'],
            ['loc' => url('/properties'), 'priority' => '0.8'],
            ['loc' => url('/map'), 'priority' => '0.7'],
        ];

        return response()->view('sitemap', compact('urls'))
            ->header('Content-Type', 'application/xml');
    }
}

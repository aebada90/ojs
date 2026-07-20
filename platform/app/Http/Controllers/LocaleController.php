<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LocaleController extends Controller
{
    /** @var list<string> */
    protected array $supported = ['en', 'de'];

    public function switch(Request $request, string $locale): RedirectResponse
    {
        if (! in_array($locale, $this->supported, true)) {
            abort(404);
        }

        session(['locale' => $locale]);

        if ($request->user()) {
            $request->user()->update(['locale' => $locale]);
        }

        return back();
    }
}

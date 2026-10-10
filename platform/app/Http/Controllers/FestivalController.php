<?php

namespace App\Http\Controllers;

use App\Support\MunichFestivals;
use Illuminate\View\View;

class FestivalController extends Controller
{
    public function index(): View
    {
        return view('festivals.index', [
            'festivals' => MunichFestivals::all(),
            'year' => MunichFestivals::seasonYear(),
            'featured' => MunichFestivals::featured(),
            'oktoberfestOpensAt' => MunichFestivals::oktoberfestOpensAt(),
        ]);
    }

    public function show(string $slug): View
    {
        $festival = MunichFestivals::find($slug);
        abort_if($festival === null, 404);

        return view('festivals.show', [
            'festival' => $festival,
            'year' => MunichFestivals::seasonYear(),
            'festivals' => MunichFestivals::all(),
        ]);
    }
}

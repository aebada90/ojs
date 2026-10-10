<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class RobotsController extends Controller
{
    public function index(): View
    {
        return view('robots');
    }
}

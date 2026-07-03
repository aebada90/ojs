<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Journal;
use App\Models\Review;
use App\Models\User;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $stats = [
            'journals' => Journal::where('is_active', true)->count(),
            'articles_reviewed' => Article::whereIn('status', [
                Article::STATUS_REVIEWED,
                Article::STATUS_ACCEPTED,
                Article::STATUS_REVISION,
                Article::STATUS_REJECTED,
            ])->count(),
            'reviews_completed' => Review::where('status', Review::STATUS_COMPLETED)->count(),
        ];

        $journals = Journal::where('is_active', true)->latest()->take(6)->get();

        return view('home', compact('stats', 'journals'));
    }
}

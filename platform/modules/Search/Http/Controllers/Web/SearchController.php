<?php

namespace Modules\Search\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function index(Request $request): View
    {
        $query = Listing::query()->where('status', 'published');

        if ($search = $request->string('q')->toString()) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%'.$search.'%')
                    ->orWhere('summary', 'like', '%'.$search.'%')
                    ->orWhere('description', 'like', '%'.$search.'%');
            });
        }

        if ($type = $request->string('type')->toString()) {
            if ($type !== 'all') {
                $query->where('type', $type);
            }
        }

        if ($city = $request->string('city')->toString()) {
            $query->where('city', 'like', '%'.$city.'%');
        }

        $sort = $request->string('sort', 'featured')->toString();
        match ($sort) {
            'price_asc' => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'rating' => $query->orderByDesc('rating'),
            'newest' => $query->orderByDesc('published_at'),
            default => $query->orderByDesc('is_featured')->orderByDesc('published_at'),
        };

        return view('search::results', [
            'results' => $query->paginate(12)->withQueryString(),
            'filters' => $request->only(['q', 'type', 'city', 'sort']),
        ]);
    }
}

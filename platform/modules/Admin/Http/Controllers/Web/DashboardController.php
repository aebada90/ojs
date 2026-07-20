<?php

namespace Modules\Admin\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use App\Models\User;
use Illuminate\View\View;
use Modules\Marketplace\Models\Product;
use Modules\Vendor\Models\Vendor;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin::dashboard', [
            'stats' => [
                'users' => User::count(),
                'vendors' => Vendor::count(),
                'products' => Product::count(),
                'listings' => Listing::count(),
            ],
        ]);
    }
}

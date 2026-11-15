<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CatalogService;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(
        private CatalogService $catalogService
    ) {
    }

    public function index(): View
    {
        return view('home', [
            'items' => $this->catalogService->featured(3),
            'totalProducts' => Product::query()
                ->where('status', 'published')
                ->count(),
        ]);
    }
}

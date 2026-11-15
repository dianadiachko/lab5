<?php

namespace App\Http\Controllers;

use App\Data\CatalogFilterData;
use App\Http\Requests\CatalogFilterRequest;
use App\Services\CatalogService;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function __construct(
        private CatalogService $catalogService
    ) {
    }

    public function index(CatalogFilterRequest $request): View
    {
        $filters = CatalogFilterData::fromArray(
            $request->validated()
        );

        return view('catalog.index', [
            'items' => $this->catalogService->paginate($filters),
            'categories' => $this->catalogService->categories(),
            'filters' => $filters,
        ]);
    }

    public function show(string $slug): View
    {
        $item = $this->catalogService->findBySlug($slug);

        return view('catalog.show', [
            'item' => $item,
        ]);
    }
}

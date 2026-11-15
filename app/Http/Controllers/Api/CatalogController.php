<?php

namespace App\Http\Controllers\Api;

use App\Data\CatalogFilterData;
use App\Http\Controllers\Controller;
use App\Http\Requests\CatalogFilterRequest;
use App\Http\Resources\ProductResource;
use App\Services\CatalogService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CatalogController extends Controller
{
    public function __construct(
        private CatalogService $catalogService
    ) {
    }

    public function index(
        CatalogFilterRequest $request
    ): AnonymousResourceCollection {
        $filters = CatalogFilterData::fromArray(
            $request->validated()
        );

        $products = $this->catalogService->paginate($filters);

        return ProductResource::collection($products);
    }

    public function show(string $slug): ProductResource|JsonResponse
    {
        try {
            $product = $this->catalogService->findBySlug($slug);

            return new ProductResource($product);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return response()->json([
                'message' => 'Оголошення не знайдено.',
            ], 404);
        }
    }
}

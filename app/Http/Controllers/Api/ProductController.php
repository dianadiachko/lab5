<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreProductRequest;
use App\Http\Requests\Api\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    public function __construct(
        private ProductService $productService
    ) {
    }

    public function index(): AnonymousResourceCollection
    {
        return ProductResource::collection(
            $this->productService->all()
        );
    }

    public function store(StoreProductRequest $request): ProductResource
    {
        return new ProductResource(
            $this->productService->create($request->validated())
        );
    }

    public function show(string $id): ProductResource
    {
        return new ProductResource(
            $this->productService->find((int) $id)
        );
    }

    public function update(
        UpdateProductRequest $request,
        string $id
    ): ProductResource {
        $product = Product::findOrFail($id);

        return new ProductResource(
            $this->productService->update(
                $product,
                $request->validated()
            )
        );
    }

    public function destroy(string $id): JsonResponse
    {
        $product = Product::findOrFail($id);

        $this->productService->delete($product);

        return response()->json([
            'message' => 'Товар успішно видалено.',
        ]);
    }
}

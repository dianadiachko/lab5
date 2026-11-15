<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\CategoryNotEmpty;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreCategoryRequest;
use App\Http\Requests\Api\UpdateCategoryRequest;
use App\Http\Resources\Api\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryController extends Controller
{
    public function __construct(
        private CategoryService $categoryService
    ) {
    }

    public function index(): AnonymousResourceCollection
    {
        return CategoryResource::collection(
            $this->categoryService->all()
        );
    }

    public function store(StoreCategoryRequest $request): CategoryResource
    {
        $category = $this->categoryService->create(
            $request->validated()
        );

        return new CategoryResource($category);
    }

    public function show(string $id): CategoryResource
    {
        return new CategoryResource(
            $this->categoryService->find((int) $id)
        );
    }

    public function update(
        UpdateCategoryRequest $request,
        string $id
    ): CategoryResource {
        $category = $this->categoryService->find((int) $id);

        return new CategoryResource(
            $this->categoryService->update(
                $category,
                $request->validated()
            )
        );
    }

    public function destroy(string $id): JsonResponse
    {
        $category = Category::findOrFail($id);

        try {
            $this->categoryService->delete($category);
        } catch (CategoryNotEmpty $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], 409);
        }

        return response()->json([
            'message' => 'Категорію успішно видалено.',
        ], 200);
    }
}

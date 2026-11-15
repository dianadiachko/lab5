<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class CategoryService
{
    public function all(): Collection
    {
        return Category::query()
            ->withCount('products')
            ->orderBy('id')
            ->get();
    }

    public function find(int $id): Category
    {
        return Category::query()
            ->withCount('products')
            ->findOrFail($id);
    }

    public function create(array $data): Category
    {
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);

        return Category::create($data);
    }

    public function update(Category $category, array $data): Category
    {
        if (isset($data['name']) && !isset($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $category->update($data);

        return $category->refresh()->loadCount('products');
    }

    public function delete(Category $category): void
    {
        if ($category->products()->exists()) {
            throw new \App\Exceptions\CategoryNotEmpty();
        }

        $category->delete();
    }
}

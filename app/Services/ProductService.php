<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class ProductService
{
    public function all(): Collection
    {
        return Product::query()
            ->with('category')
            ->orderByDesc('created_at')
            ->get();
    }

    public function find(int $id): Product
    {
        return Product::query()
            ->with('category')
            ->findOrFail($id);
    }

    public function create(array $data): Product
    {
        $data['slug'] = Str::slug($data['title'])
            . '-' . Str::lower(Str::random(6));

        return Product::create($data)->load('category');
    }

    public function update(Product $product, array $data): Product
    {
        if (isset($data['title'])) {
            $data['slug'] = Str::slug($data['title'])
                . '-' . Str::lower(Str::random(6));
        }

        $product->update($data);

        return $product->refresh()->load('category');
    }

    public function delete(Product $product): void
    {
        $product->delete();
    }
}

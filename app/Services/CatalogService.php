<?php

namespace App\Services;

use App\Data\CatalogFilterData;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class CatalogService
{
    public function featured(int $limit = 3): Collection
    {
        return Product::query()
            ->with('category')
            ->where('status', 'published')
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->limit($limit)
            ->get();
    }

    public function paginate(
        CatalogFilterData $filters
    ): LengthAwarePaginator {
        $query = Product::query()
            ->with('category')
            ->where('status', 'published');

        if ($filters->q !== null && trim($filters->q) !== '') {
            $search = trim($filters->q);

            $query->where(function ($builder) use ($search) {
                $builder
                    ->where('title', 'like', "%{$search}%")
                    ->orWhere(
                        'short_description',
                        'like',
                        "%{$search}%"
                    );
            });
        }

        if ($filters->category !== null && $filters->category !== '') {
            $query->whereHas('category', function ($builder) use ($filters) {
                $builder->where('name', $filters->category);
            });
        }

        if ($filters->operation !== null && $filters->operation !== '') {
            $query->where('operation', $filters->operation);
        }

        switch ($filters->sort) {
            case 'price_asc':
                $query->orderBy('price')->orderBy('id');
                break;

            case 'price_desc':
                $query->orderByDesc('price')->orderByDesc('id');
                break;

            default:
                $query->orderByDesc('published_at')->orderByDesc('id');
                break;
        }

        return $query
            ->paginate($filters->perPage)
            ->appends(array_filter([
                'q' => $filters->q,
                'category' => $filters->category,
                'operation' => $filters->operation,
                'sort' => $filters->sort,
                'per_page' => $filters->perPage,
            ], fn ($value) => $value !== null && $value !== ''));
    }

    public function findBySlug(string $slug): Product
    {
        return Product::query()
            ->with('category')
            ->where('status', 'published')
            ->where('slug', $slug)
            ->firstOrFail();
    }

    public function categories(): Collection
    {
        return Category::query()
            ->orderBy('name')
            ->get();
    }

    public function publishedCount(): int
    {
        return Product::query()
            ->where('status', 'published')
            ->count();
    }
}

<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use App\Interfaces\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function findById(int $id): ?Product
    {
        return $this->product->with('categories')->find($id);
    }

    public function create(array $data): Product
    {
        return $this->product->create($data);
    }

    public function getWithFilters(array $filters = [], ?string $sortBy = null, string $sortDirection = 'asc'): Collection
    {
        $query = $this->product->with('categories');

        // Apply category filter
        if (!empty($filters['category_id'])) {
            $query->whereHas('categories', function ($subQuery) use ($filters) {
                $subQuery->where('categories.id', $filters['category_id']);
            });
        }

        // Apply price range filters
        if (!empty($filters['min_price'])) {
            $query->where('price', '>=', $filters['min_price']);
        }

        if (!empty($filters['max_price'])) {
            $query->where('price', '<=', $filters['max_price']);
        }

        // Apply sorting
        if ($sortBy) {
            $query->orderBy($sortBy, $sortDirection);
        }

        return $query->get();
    }

    public function attachCategories(Product $product, array $categoryIds): void
    {
        $product->categories()->sync($categoryIds);
    }
}

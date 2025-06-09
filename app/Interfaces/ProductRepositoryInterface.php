<?php

namespace App\Interfaces;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

interface ProductRepositoryInterface
{
    public function findById(int $id): ?Product;

    public function create(array $data): Product;

    public function getAll(): Collection;

    public function getWithFilters(array $filters = [], ?string $sortBy = null, string $sortDirection = 'asc'): Collection;

    public function attachCategories(Product $product, array $categoryIds): void;
}

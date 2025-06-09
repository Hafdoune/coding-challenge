<?php

namespace App\Interfaces;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

interface ProductRepositoryInterface
{
    public function findById(int $id): ?Product;

    public function create(array $data): Product;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;

    public function getAll(): Collection;

    public function attachCategories(Product $product, array $categoryIds): void;

    public function detachCategories(Product $product, array $categoryIds = []): void;
}

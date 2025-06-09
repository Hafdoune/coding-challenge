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

    public function update(int $id, array $data): bool
    {
        return $this->product->where('id', $id)->update($data);
    }

    public function delete(int $id): bool
    {
        return $this->product->destroy($id);
    }

    public function getAll(): Collection
    {
        return $this->product->with('categories')->get();
    }

    public function attachCategories(Product $product, array $categoryIds): void
    {
        $product->categories()->sync($categoryIds);
    }

    public function detachCategories(Product $product, array $categoryIds = []): void
    {
        if (empty($categoryIds)) {
            $product->categories()->detach();
        } else {
            $product->categories()->detach($categoryIds);
        }
    }
}

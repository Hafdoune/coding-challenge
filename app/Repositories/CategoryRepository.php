<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use App\Interfaces\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    private $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function create(array $data): Category
    {
        return $this->category->create($data);
    }

    public function update(int $id, array $data): bool
    {
        return $this->category->where('id', $id)->update($data);
    }

    public function delete(int $id): bool
    {
        return $this->category->destroy($id);
    }

    public function getAll(): Collection
    {
        return $this->category->with('parentCategory')->get();
    }
}
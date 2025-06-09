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

    public function getAll(): Collection
    {
        return $this->category->with('parentCategory')->get();
    }
}
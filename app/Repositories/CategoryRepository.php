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

    public function findOrCreateByName(string $name, ?int $parentId = null): Category
    {
        return $this->category->firstOrCreate([
            'name' => $name,
            'parent_category_id' => $parentId,
        ]);
    }

    public function getCategoryTree(): Collection
    {
        return $this->category->roots()
            ->with(['descendants' => function ($query) {
                $query->with('descendants');
            }])
            ->get();
    }
}

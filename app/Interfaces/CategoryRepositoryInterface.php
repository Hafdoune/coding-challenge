<?php

namespace App\Interfaces;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

interface CategoryRepositoryInterface
{
    public function create(array $data): Category;

    public function getAll(): Collection;

    public function findOrCreateByName(string $name, ?int $parentId = null): Category;
}

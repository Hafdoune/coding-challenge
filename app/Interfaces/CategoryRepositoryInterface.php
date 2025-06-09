<?php

namespace App\Interfaces;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

interface CategoryRepositoryInterface
{
    public function create(array $data): Category;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;

    public function getAll(): Collection;
}

<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition()
    {
        return [
            'name' => $this->faker->unique()->words(2, true),
            'parent_category_id' => null,
        ];
    }

    /**
     * Indicate that the category is a child category.
     */
    public function child()
    {
        return $this->state(function (array $attributes) {
            return [
                'parent_category_id' => Category::factory()->create()->id,
            ];
        });
    }

    /**
     * Indicate that the category is a root category.
     */
    public function root()
    {
        return $this->state(function (array $attributes) {
            return [
                'parent_category_id' => null,
            ];
        });
    }
}

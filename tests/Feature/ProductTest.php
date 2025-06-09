<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_product_with_categories()
    {
        Storage::fake('public');

        $categories = Category::factory()->count(2)->create();
        $data = $this->validProductData([
            'categories' => $categories->pluck('id')->toArray(),
        ]);

        $response = $this->post('/products', $data);

        $response->assertRedirect();

        $this->assertDatabaseHas('products', [
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
        ]);

        $product = Product::first();

        $this->assertTrue(Storage::disk('public')->exists($product->image));
        $this->assertCount(2, $product->categories);
        $this->assertTrue($product->categories->pluck('id')->sort()->values()->all() === $categories->pluck('id')->sort()->values()->all());
    }

    private function validProductData(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Test Product',
            'description' => 'A simple test product.',
            'price' => 99.99,
            'image' => UploadedFile::fake()->image('product.jpg'),
        ], $overrides);
    }
}

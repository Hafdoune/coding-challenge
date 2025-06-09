<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Collection;
use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\CategoryRepositoryInterface;

class ProductService
{
    private $productRepository;
    private $categoryRepository;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        CategoryRepositoryInterface $categoryRepository
    ) {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function createProduct(array $data): Product
    {
        // Handle image upload
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $data['image'] = $this->storeImage($data['image']);
        }

        // Create the product
        $product = $this->productRepository->create([
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'image' => $data['image'] ?? null,
        ]);

        // Attach categories if provided
        if (!empty($data['categories'])) {
            $categoryIds = $this->resolveCategoryIds($data['categories']);
            $this->productRepository->attachCategories($product, $categoryIds);
        }

        return $this->productRepository->findById($product->id);
    }

    public function getProducts(array $filters = [], ?string $sortBy = null, string $sortDirection = 'asc'): Collection
    {
        return $this->productRepository->getWithFilters($filters, $sortBy, $sortDirection);
    }

    private function resolveCategoryIds(array $categories): array
    {
        $categoryIds = [];

        foreach ($categories as $category) {
            if (is_numeric($category)) {
                // Category ID provided
                $categoryIds[] = (int) $category;
            } elseif (is_string($category)) {
                // Category name provided - find or create
                $categoryModel = $this->categoryRepository->findOrCreateByName($category);
                $categoryIds[] = $categoryModel->id;
            }
        }

        return array_unique($categoryIds);
    }

    private function storeImage(UploadedFile $image): string
    {
        $filename = Str::uuid() . '.' . $image->getClientOriginalExtension();
        return $image->storeAs('products', $filename, 'public');
    }
}

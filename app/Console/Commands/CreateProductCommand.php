<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ProductService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreProductRequest;

class CreateProductCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:create
                            {--name : The product name}
                            {--description= : The product description}
                            {--price= : The product price}
                            {--image= : Path to the product image}
                            {--categories=* : Product categories (names or IDs)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new product via CLI';

    private $productService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        ProductService $productService
    )
    {
        $this->productService = $productService;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $productData = $this->collectProductData();
            
            if (!$this->validateProductData($productData)) {
                return Command::FAILURE;
            }

            $product = $this->productService->createProduct($productData);

            $this->info("Product created successfully!");
            $this->table(
                ['Field', 'Value'],
                [
                    ['ID', $product->id],
                    ['Name', $product->name],
                    ['Description', substr($product->description, 0, 50) . '...'],
                    ['Price', "$ $product->price"],
                    ['Image', $product->image ? 'Yes' : 'No'],
                    ['Categories', $product->categories->pluck('name')->implode(', ')],
                ]
            );

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error("Error creating product: " . $e->getMessage());
            return Command::FAILURE;
        }
    }

    private function collectProductData(): array
    {
        $data = [];

        // Get product name
        $data['name'] = $this->option('name') ?: $this->ask('Product name');

        // Get product description
        $data['description'] = $this->option('description') ?: $this->ask('Product description');

        // Get product price
        $priceInput = $this->option('price') ?: $this->ask('Product price');
        $data['price'] = (float) $priceInput;

        // Handle image
        $imagePath = $this->option('image');
        if (!$imagePath && $this->confirm('Would you like to add an image?')) {
            $imagePath = $this->ask('Enter the path to the image file');
        }
        
        if ($imagePath) {
            if (!File::exists($imagePath)) {
                $this->error("Image file not found: {$imagePath}");
                if (!$this->confirm('Continue without image?')) {
                    exit(1);
                }
            } else {
                $data['image'] = $this->createUploadedFileFromPath($imagePath);
            }
        }

        // Handle categories
        $categories = $this->option('categories');
        if (empty($categories) && $this->confirm('Add categories?')) {
            $categoryInput = $this->ask('Enter categories (comma-separated)');
            $categories = array_map('trim', explode(',', $categoryInput));
        }
        
        if (!empty($categories)) {
            $data['categories'] = $categories;
        }

        return $data;
    }

    private function validateProductData(array $data): bool
    {
        $request = new StoreProductRequest();
        $validator = Validator::make($data, $request->rules(), $request->messages());

        if ($validator->fails()) {
            $this->error('Validation failed:');
            foreach ($validator->errors()->all() as $error) {
                $this->error("  - {$error}");
            }
            return false;
        }

        return true;
    }

    private function createUploadedFileFromPath(string $path): UploadedFile
    {
        $filename = basename($path);
        $mimeType = mime_content_type($path);
        $size = filesize($path);

        return new UploadedFile(
            $path,
            $filename,
            $mimeType,
            null,
            true
        );
    }
}

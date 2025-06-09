<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Services\ProductService;
use App\Http\Requests\StoreProductRequest;
use App\Interfaces\CategoryRepositoryInterface;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $productService;
    private $categoriesRepository;

    public function __construct(
        ProductService $productService,
        CategoryRepositoryInterface $categoriesRepository
    ) {
        $this->productService = $productService;
        $this->categoriesRepository = $categoriesRepository;
    }

    public function index(Request $request): Response
    {
        $filters = $this->buildFilters($request);
        $sortBy = $request->get('sort_by', 'name');
        $sortDirection = $request->get('sort_direction', 'asc');

        $products = $this->productService->getProducts($filters, $sortBy, $sortDirection);
        $categories = $this->categoriesRepository->getAll();

        return Inertia::render('Products/Index', [
            'products' => $products->map(function ($product) {
                $product->image_url = $product->image_url ?? null;
                return $product;
            }),
            'categories' => $categories,
            'filters' => $filters,
            'sort_by' => $sortBy,
            'sort_direction' => $sortDirection,
        ]);
    }

    public function create()
    {
        $categories = $this->categoriesRepository->getAll();

        return Inertia::render('Products/Create', [
            'categories' => $categories,
        ]);
    }

    public function store(StoreProductRequest $request)
    {
        $this->productService->createProduct($request->validated());

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully!');
    }

    private function buildFilters(Request $request): array
    {
        return array_filter([
            'category_id' => $request->get('category_id'),
            'min_price' => $request->get('min_price'),
            'max_price' => $request->get('max_price'),
            'sort_by' => $request->get('sort_by'),
        ]);
    }
}

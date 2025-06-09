<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Repositories\CategoryRepository;

class CategoryController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    
    public function index()
    {
        $categories = $this->categoryRepository->getCategoryTree();

        return Inertia::render('Categories/Index', [
            'categories' => $categories
        ]);
    }

    public function create()
    {
        $categories = $this->categoryRepository->getAll();
        return Inertia::render('Categories/Create', [
            'categories' => $categories
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'parent_category_id' => 'nullable|exists:categories,id'
        ]);

        $this->categoryRepository->create($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully.');
    }
}

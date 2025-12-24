<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display all categories
     */
    public function index()
    {
        $categories = Category::withCount('products')
            ->active()
            ->orderBy('name')
            ->get();
            
        return view('categories.index', compact('categories'));
    }

    /**
     * Display products by category
     */
    public function show($slug)
    {
        $category = Category::where('slug', $slug)
            ->active()
            ->with(['products' => function($query) {
                $query->where('is_active', true)
                      ->orderBy('name');
            }])
            ->firstOrFail();
            
        // Get related categories
        $relatedCategories = Category::where('id', '!=', $category->id)
            ->active()
            ->take(6)
            ->get();
            
        return view('categories.show', compact('category', 'relatedCategories'));
    }

    /**
     * Get subcategories (for AJAX)
     */
    public function subcategories($parentId)
    {
        $subcategories = Category::where('parent_id', $parentId)
            ->active()
            ->orderBy('name')
            ->get();
            
        return response()->json($subcategories);
    }
}
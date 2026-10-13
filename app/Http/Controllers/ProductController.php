<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        return view('pages.products.index', [
            'categories' => Category::query()->published()
                ->with(['products' => fn ($query) => $query->published()])
                ->get(),
        ]);
    }

    public function category(Category $category): View
    {
        abort_unless($category->is_active, 404);

        return view('pages.products.category', [
            'category' => $category,
            'products' => $category->products()->published()->get(),
            'categories' => Category::query()->published()->get(),
        ]);
    }

    public function show(Product $product): View
    {
        abort_unless($product->is_active && $product->category?->is_active, 404);

        return view('pages.products.show', [
            'product' => $product->load('category'),
            'relatedProducts' => Product::query()->published()
                ->where('category_id', $product->category_id)
                ->whereKeyNot($product->getKey())
                ->limit(4)
                ->get(),
        ]);
    }
}

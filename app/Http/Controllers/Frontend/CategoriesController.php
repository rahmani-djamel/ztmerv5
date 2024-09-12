<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Inertia\Inertia;

class CategoriesController extends Controller
{
    public function index()
    {
        $categoryQuery = Category::query()
            ->withCount('products') // Add this line to count the products
            ->having('products_count', '>', 0) // Add this line to filter states with products
            ->search(request('search'));
    
        $categories = $categoryQuery->paginate(10)->withQueryString()->through(fn ($category) => [
            'id' => $category->id,
            'name' => $category->name,
            'slug' => $category->slug,
            'image' => $category->image->path 
                ? (app()->environment('production') 
                    ? asset('storage/' . $category->image->path) 
                    : asset($category->image->path)) 
                : asset('images/default-category.jpg'),
            'products_count' => $category->products_count, // Include the product count
        ]);
    
        return Inertia::render('Frontend/Categories', [
            'categories' => $categories,
            'filters' => request()->all(['search']),
        ]);
    }

    public function show()
    {
        $category = Category::where('slug', request('category'))->firstOrFail();
    
        $products = $category->products()
        ->search(request('search'))
        ->orderByPrice(request('order_by'))
        ->paginate(10)->withQueryString()->through(fn ($product) => [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'category' => $product->category->name,
            'city' => $product->city->name,
            'vendor' => $product->user,
            'media' => $product->media->map(function ($media) {
                return [
                    'id' => $media->id,
                    'type' => in_array(pathinfo($media->path, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png']) ? 'image' : 'video',
                    'path' => $media->path 
                        ? (app()->environment('production') 
                            ? asset('storage/' . $media->path) 
                            : asset($media->path)) 
                        : asset('images/default-category.jpg'),
                ];
            }),
        ]);
    
        return Inertia::render('Frontend/Category/Show', [
            'category' => $category,
            'products' => $products,
            'filters' => request()->all(['search','order_by']),
        ]);
    }
}

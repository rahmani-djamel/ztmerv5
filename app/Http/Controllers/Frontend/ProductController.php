<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        $productsQuery = Product::query()
            ->search(request('search'))
            ->orderByPrice(request('order_by'))
            ->categoryfilter(request('selectedcategory')); //

        $products = $productsQuery->paginate(10)->withQueryString()->through(fn ($product) => [
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
    
        return Inertia::render('Frontend/Product', [
            'products' => $products,
            'categories' => Category::all(),
            'filters' => request()->all(['search','selectedcategory','order_by']),
        ]);
    }
}
/*  ->through(fn ($product) => [
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
            ]);*/
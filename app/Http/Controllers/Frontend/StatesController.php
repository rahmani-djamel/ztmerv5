<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\State;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StatesController extends Controller
{
    public function index()
    {
        $states = State::query()
            ->withCount('products')
            ->having('products_count', '>', 0) // Add this line to filter states with products
            ->search(request('search'))
            ->paginate(10)
            ->withQueryString()
            ->through(fn ($state) => [
                'id' => $state->id,
                'name' => $state->name,
                'slug' => $state->slug,
                'products_count' => $state->products_count, // Include the product count
            ]);
    
        return Inertia::render('Frontend/States', [
            'states' => $states,
            'filters' => request()->all(['search']),
        ]);
    }

    public function show()
    {
        $state = State::where('slug', request('state'))->firstOrFail();
        $cities = City::where('state_id',$state->id)->get();

        $products = $state->products()
        ->search(request('search'))
        ->cityfilter(request('selectedcity'))
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
    
        return Inertia::render('Frontend/State/Show', [
            'state' => $state,
            'cities' => $cities,
            'products' => $products,
            'filters' => request()->all(['search','order_by','selectedcity']),
        ]);

    }
}

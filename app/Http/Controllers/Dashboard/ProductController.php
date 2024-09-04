<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\State;
use App\Models\Unit;
use Illuminate\Http\Request;
use Inertia\Inertia;


class ProductController extends Controller
{
    public function index()
    {
        $productsQuery = Product::query()
            ->search(request('search'))
            ->with('category', 'unit', 'state', 'city')
            ->orderBy('created_at', 'desc')
            ->role();
    
        $products = $productsQuery->paginate(10)->withQueryString()->through(fn ($product) => [
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'category' => $product->category->name,
            'unit' => $product->unit->name,
            'state' => $product->state->name,
            'qte' => $product->qte,
            'city' => $product->city->name,
            'created_at' => $product->created_at->toDateTimeString(),
        ]);
    
        return Inertia::render('Dashboard/Product/Index', [
            'products' => $products,
            'can' => [
                'createProduct' => auth()->user()->hasRole('Vendor'),
            ],
        ]);
    }

    public function create()
    {
        $categories = Category::all();
        $unites = Unit::all();
        $states = State::all();
        return Inertia::render('Dashboard/Product/Create',[
            'categories' => $categories,
            'states' => $states,
            'units' => $unites
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'qte' => 'required',
            'category_id' => 'required',
            'unit_id' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'media' => 'required|array',
            'media.*.file' => 'required|file|mimes:jpeg,png,jpg,gif,mp4,mov,avi|max:6144', // 6144 KB = 6 MB
        ]);
        
        $product = auth()->user()->products()->create($request->only('name', 'description', 'price', 'category_id', 'unit_id', 'state_id', 'city_id'));
        
        foreach ($request->media as $media) {
            $file = $media['file'];
            $path = $file->store('products', 'public');
            $product->media()->create([
                'path' => $path,
                'name' => $file->getClientOriginalName(),
                'use' => 'product', // Assuming 'use' is a static value
                'type' => $file->getClientOriginalExtension(),
                'size' => $file->getSize(),
            ]);
        }



        return redirect()->route('product.index');
    }
}

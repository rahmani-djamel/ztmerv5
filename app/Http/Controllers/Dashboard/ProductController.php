<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Package;
use App\Models\Product;
use App\Models\Role;
use App\Models\State;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;


class ProductController extends Controller
{
    public function index()
    {
        $productsQuery = Product::query()
            ->search(request('search'))
            ->categoryfilter(request('selectedcategory'))
            ->vendorfilter(request('selectedvendor'))
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
            'categories' => Category::all(),
            'vendors' => auth()->user()->hasRole('SuperAdmin') ? Role::where('name', 'Vendor')->first()->users->pluck('id','name') : [],
            'can' => [
                'createProduct' => auth()->user()->hasRole('Vendor'),
            ],
            'filters' => request()->all(['search','selectedcategory','selectedvendor']),
        ]);
    }

    public function create()
    {
        $categories = Category::all();
        $unites = Unit::all();
        $states = State::all();
        $packages = Package::all();
        return Inertia::render('Dashboard/Product/Create',[
            'categories' => $categories,
            'states' => $states,
            'units' => $unites,
            'packages' => $packages
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
            'package_id' => 'required',
            'city_id' => 'required',
            'weight' => 'required',
            'media' => 'required|array|min:1',
            'media.*.file' => 'required|file|mimes:jpeg,png,jpg,gif,mp4,mov,avi|max:6144', // 6144 KB = 6 MB
        ]);
        
        $product = auth()->user()->products()->create($request->only('name', 'description', 'price', 'category_id', 'unit_id', 'state_id','weight','package_id', 'qte','city_id'));
        
        foreach ($request->media as $key => $media) {
            $file = $media['file'];
            $path = $file->store('products', 'public');
            $product->media()->create([
                'order' => $key,
                'path' => $path,
                'name' => $file->getClientOriginalName(),
                'use' => 'product', // Assuming 'use' is a static value
                'type' => $file->getClientOriginalExtension(),
                'size' => $file->getSize(),
            ]);
        }
        return redirect()->route('product.index');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $unites = Unit::all();
        $states = State::all();
        $packages = Package::all();
        return Inertia::render('Dashboard/Product/Edit', [
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'qte' => $product->qte,
                'category_id' => $product->category_id,
                'unit_id' => $product->unit_id,
                'state_id' => $product->state_id,
                'package_id' => $product->package_id,
                'weight' => $product->weight,
                'city_id' => $product->city_id,
                'media' => $product->media->map(function ($media) {
                    return [
                        'id' => $media->id,
                        'order' => $media->order,
                        'is_exist' => true,
                        'name' => $media->name,
                        'path' => $media->path,
                        'url' => app()->environment('production') 
                            ? asset('storage/' . $media->path) 
                            : asset($media->path),
                    ];
                }),
            ],
            'categories' => $categories,
            'states' => $states,
            'units' => $unites,
            'packages' => $packages
        ]);
    }

    public function update(Request $request, Product $product)
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
            'weight' => 'required',
            'media' => 'array|min:1',
            'media.*' => [
                function ($attribute, $value, $fail) {
                    if (!isset($value['id'])) {
                        // Validate as a new file with specific rules
                        $validator = Validator::make($value, [
                            'file' => 'required|file|mimes:jpeg,png,jpg,gif,mp4,mov,avi|max:6144',
                        ]);

                        if ($validator->fails()) {
                            $fail('The '.$attribute.' is invalid: ' . implode(', ', $validator->errors()->all()));
                        }
                    }
                }
            ],
        ]);
    
        $product->update($request->only('name', 'description', 'price', 'category_id', 'unit_id', 'state_id','weight','package_id', 'qte', 'city_id'));
    
        $existingMediaIds = $product->media->pluck('id')->toArray();
        $requestMediaIds = collect($request->media)->pluck('id')->filter()->toArray();
    
        // Delete media that are not in the request
        $mediaToDelete = array_diff($existingMediaIds, $requestMediaIds);
        $product->media()->whereIn('id', $mediaToDelete)->delete();
    
        if ($request->has('media')) {
            foreach ($request->media as $key => $media) {
                if (isset($media['id'])) {
                    // Existing media, update order
                    $product->media()->where('id', $media['id'])->update(['order' => $key]);
                } else {
                    // New media, upload and create
                    $file = $media['file'];
                    $path = $file->store('products', 'public');
                    $product->media()->create([
                        'order' => $key,
                        'path' => $path,
                        'name' => $file->getClientOriginalName(),
                        'use' => 'product', // Assuming 'use' is a static value
                        'type' => $file->getClientOriginalExtension(),
                        'size' => $file->getSize(),
                    ]);
                }
            }
        }
    
        return redirect()->route('product.index');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('product.index');
    }
}

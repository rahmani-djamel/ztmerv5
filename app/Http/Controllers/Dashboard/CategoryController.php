<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Illuminate\Support\Str; // Add this line to import the Str class


class CategoryController extends Controller
{
    public function index()
    {

        $categories = Category::query()
        ->search(Request::input('search')) // Use the scopeSearch method
        ->paginate(10)
        ->withQueryString()
        ->through(fn ($category) => [
            'id' => $category->id,
            'name' => $category->name,
           'image' => $category->image 
            ? (app()->environment('production') 
                ? asset('storage/' . $category->image->path) 
                : asset($category->image->path)) 
            : asset('images/default-category.jpg'),
        ]);

        return Inertia::render('Dashboard/Category/Index', [
            'categories' => $categories,
            'filters' => Request::only(['search']),

        ]);
    }

    public function create()
    {
        return Inertia::render('Dashboard/Category/Create');
    }

    public function store()
    {
        Request::validate([
            'name' => ['required', 'max:255','unique:categories,name'],
            'image' => ['required', 'file', 'mimes:jpeg,png,jpg,gif,svg', 'max:5120'], 
        ]);

        $slug = Str::slug(Request::input('name'));

        $category = Category::create([
            'name' => Request::input('name'),
            'slug' => $slug,
        ]);


        if (Request::hasFile('image')) {
            $category->image()->create([
                'path' => Request::file('image')->store('categories', 'public'),
                'name' => Request::file('image')->getClientOriginalName(),
                'use' => 'avatar',
                'type' => Request::file('image')->getClientOriginalExtension(),
                'size' => Request::file('image')->getSize(),
            ]);
        }

        return redirect()->route('category.index');
    }

    public function edit(Category $category)
    {
        return Inertia::render('Dashboard/Category/Edit', [
            'category' => [
                'id' => $category->id,
                'name' => $category->name,
                'image' => $category->image 
                ? (app()->environment('production') 
                    ? asset('storage/' . $category->image->path) 
                    : asset($category->image->path)) 
                : asset('images/default-category.jpg'),
            ],
        ]);
    }

    public function update(Category $category)
    {
        Request::validate([
            'name' => ['required', 'max:255','unique:categories,name,' . $category->id],
            'image' => ['nullable', 'file', 'mimes:jpeg,png,jpg,gif,svg', 'max:5120'], 
        ]);

        $slug = Str::slug(Request::input('name'));

        $category->update([
            'name' => Request::input('name'),
            'slug' => $slug,
        ]);

        if (Request::hasFile('image')) {
            $category->image()->update([
                'path' => Request::file('image')->store('categories', 'public'),
                'name' => Request::file('image')->getClientOriginalName(),
                'use' => 'avatar',
                'type' => Request::file('image')->getClientOriginalExtension(),
                'size' => Request::file('image')->getSize(),
            ]);
        }

        return redirect()->route('category.index');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('category.index');
    }
}

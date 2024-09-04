<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\State;
use App\Models\Unit;
use Illuminate\Http\Request;
use Inertia\Inertia;


class ProductController extends Controller
{
    public function index()
    {

        return Inertia::render('Dashboard/Product/Index',[
            'can' => [
                'createProduct' => auth()->user()->hasRole('Vendor'),
            ]
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
            'category_id' => 'required',
            'unit_id' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'media' => 'required|array',
            'media.*' => 'required|file|mimes:jpeg,png,jpg,gif,mp4,mov,avi|max:6144', // 6144 KB = 6 MB
        ]);



        return redirect()->route('dashboard');
    }
}

<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
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
        return Inertia::render('Dashboard/Product/Create',[
            'categories' => $categories,
            'units' => $unites
        ]);
    }
}

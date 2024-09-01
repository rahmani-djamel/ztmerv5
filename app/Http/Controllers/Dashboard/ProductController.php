<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;


class ProductController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard/Product/Index');
    }

    public function create()
    {
        return Inertia::render('Dashboard/Product/Create');
    }
}

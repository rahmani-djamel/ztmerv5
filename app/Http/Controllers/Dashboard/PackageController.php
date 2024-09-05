<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::query()
        ->search(Request::input('search')) // Use the scopeSearch method
        ->paginate(10)
        ->withQueryString()
        ->through(fn ($package) => [
            'id' => $package->id,
            'name' => $package->name,
        ]);
        return Inertia::render('Dashboard/Package/Index',[
            'packages' => $packages,
            'filters' => Request::only(['search']),
        ]);
    }

    public function create()
    {
        return Inertia::render('Dashboard/Package/Create');
    }

    public function store()
    {
        $validatedData = Request::validate([
            'name' => ['required','unique:packages,name'],
        ]);

        Package::create($validatedData);

        return to_route('package.index');
    }

    public function edit(Package $package)
    {
        return Inertia::render('Dashboard/Package/Edit', [
            'package' => $package,
        ]);
    }

    public function update(Package $package)
    {
        $validatedData = Request::validate([
            'name' => ['required','unique:packages,name,'.$package->id],
        ]);

        $package->update($validatedData);

        return to_route('package.index');
    }

    public function destroy(Package $package)
    {
        $package->delete();

        return redirect()->route('package.index');
    }
}

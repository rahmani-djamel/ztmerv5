<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Market;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MarketController extends Controller
{
    public function index()
    {
        $markets = Market::query()
            ->paginate(10)
            ->withQueryString()
            ->through(fn ($market) => [
                'id' => $market->id,
                'market_name' => $market->market_name,
                'phone' => $market->phone,
                'lat' => $market->lat,
                'lng' => $market->lng,
            ]);
        return Inertia::render('Dashboard/Market/Index',[
            'markets' => $markets,
            'can' => [
                'createMarket' => auth()->user()->hasRole('Vendor'),
            ]
        ]);
    }

    public function create()
    {
        return Inertia::render('Dashboard/Market/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'market_name' => ['required', 'max:255'],
            'lat' => ['required', 'numeric'],
            'lng' => ['required', 'numeric'],
            'phone' => ['required', 'max:255'],
        ]);


        $market = auth()->user()->markets()->create($validated);






        return redirect()->route('market.index')->with('success', 'Market created successfully');
    }
}

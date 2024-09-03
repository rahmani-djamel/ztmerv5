<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Market;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class MarketController extends Controller
{
    public function index()
    {
        $marketsQuery = Market::query()
            ->search(Request::input('search'))
            ->markets();
    
        $markets = $marketsQuery->paginate(10)->withQueryString()->through(fn ($market) => [
            'id' => $market->id,
            'market_name' => $market->market_name,
            'phone' => $market->phone,
            'lat' => $market->lat,
            'lng' => $market->lng,
        ]);
    
        return Inertia::render('Dashboard/Market/Index', [
            'markets' => $markets,
            'can' => [
                'createMarket' => auth()->user()->hasRole('Vendor'),
            ],
            'filters' => Request::only(['search']),
        ]);
    }

    public function create()
    {
        return Inertia::render('Dashboard/Market/Create');
    }

    public function destroy(Market $market)
    {
        $market->delete();

        return redirect()->route('market.index');
    }



    public function store()
    {
        $validated =  Request::validate([
            'market_name' => ['required', 'max:255'],
            'address' => ['required', 'max:255'],
            'city' => ['required', 'max:255'],
            'state' => ['required', 'max:255'],
            'lat' => ['required', 'numeric'],
            'lng' => ['required', 'numeric'],
            'phone' => ['required', 'max:255'],
        ]);


        $market = auth()->user()->markets()->create($validated);
        return redirect()->route('market.index')->with('success', 'Market created successfully');
    }

    public function edit(Market $market)
    {
        return Inertia::render('Dashboard/Market/Edit', [
            'market' => [
                'id' => $market->id,
                'market_name' => $market->market_name,
                'address' => $market->address,
                'city' => $market->city,
                'state' => $market->state,
                'lat' => $market->lat,
                'lng' => $market->lng,
                'phone' => $market->phone,
            ],
        ]);
    }

    public function update(Market $market)
    {
        $validated = Request::validate([
            'market_name' => ['required', 'max:255'],
            'address' => ['required', 'max:255'],
            'city' => ['required', 'max:255'],
            'state' => ['required', 'max:255'],
            'lat' => ['required', 'numeric'],
            'lng' => ['required', 'numeric'],
            'phone' => ['required', 'max:255'],
        ]);

        $market->update($validated);

        return redirect()->route('market.index')->with('success', 'Market updated successfully');
    }
}

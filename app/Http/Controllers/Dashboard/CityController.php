<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\State;
use Inertia\Inertia;
use Illuminate\Support\Facades\Request;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::query()
        ->search(Request::input('search')) // Use the scopeSearch method
        ->with('state') // Ensure the state relationship is loaded
        ->paginate(10)
        ->withQueryString()
        ->through(fn ($city) => [
            'id' => $city->id,
            'name' => $city->name,
            'state' => $city->state->name,
        ]);


        return Inertia::render('Dashboard/City/Index', [
            'cities' => $cities,
            'filters' => Request::only(['search']),

        ]);
    }

    public function destroy(City $city)
    {
        $city->delete();

        return redirect()->route('city.index');
    }

    public function create()
    {
        $states = State::all();
        return Inertia::render('Dashboard/City/Create', [
            'states' => $states,
        ]);
    }

    public function store()
    {
        try {
            $validatedData = Request::validate([
                'name' => ['required'],
                'state_id' => ['required', 'exists:states,id'],
            ]);
    
            City::create($validatedData);
    
            return to_route('city.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            dd($e->errors());
        }
    }

    public function edit(City $city)
    {
        $states = State::all();
        return Inertia::render('Dashboard/City/Edit', [
            'city' => [
                'id' => $city->id,
                'name' => $city->name,
                'state_id' => $city->state_id,
            ],
            'states' => $states,
        ]);
    }

    public function update(City $city)
    {
        try {
            $validatedData = Request::validate([
                'name' => ['required'],
                'state_id' => ['required', 'exists:states,id'],
            ]);
    
            $city->update($validatedData);
    
            return to_route('city.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            dd($e->errors());
        }
    }
}

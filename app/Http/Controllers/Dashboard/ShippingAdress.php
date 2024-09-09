<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ShippingAdress as ModelsShippingAdress;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class ShippingAdress extends Controller
{
    
    public function index()
    {
        $addressQuery = ModelsShippingAdress::query()
        ->search(Request::input('search'))
        ->adresses();

    $addresses = $addressQuery->paginate(10)->withQueryString()->through(fn ($address) => [
        'id' => $address->id,
        'user_name' => $address->user_name,
        'phone' => $address->phone,
        'city' => $address->city,
        'address' => $address->address,
        'lat' => $address->lat,
        'lng' => $address->lng,
    ]);
        return Inertia::render('Dashboard/ShippingAdress/Index',[
            'addresses' => $addresses,
            'can' => [
                'createAddress' => auth()->user()->hasRole('User'),
            ],
            'filters' => Request::only(['search']),
        ]);
    }

    public function create()
    {
        return Inertia::render('Dashboard/ShippingAdress/Create');
    }

    public function store()
    {
        $validatedData = Request::validate([
            'user_name' => ['required'],
            'address' => ['required'],
            'city' => ['required'],
            'state' => ['required'],
            'phone' => ['required'
        
        ],
            'lat' => ['required'],
            'lng' => ['required'],
        ]);

        //add user id to the validated data
        $validatedData['user_id'] = auth()->id();

        ModelsShippingAdress::create($validatedData);

        return to_route('addresses.index');
    }

    public function edit(ModelsShippingAdress $address)
    {
        return Inertia::render('Dashboard/ShippingAdress/Edit', [
            'address' => [
                'id' => $address->id,
                'user_name' => $address->user_name,
                'address' => $address->address,
                'city' => $address->city,
                'state' => $address->state,
                'phone' => $address->phone,
                'lat' => $address->lat,
                'lng' => $address->lng,
            ],
        ]);
    }

    public function update(ModelsShippingAdress $address)
    {
        $validatedData = Request::validate([
            'user_name' => ['required'],
            'address' => ['required'],
            'city' => ['required'],
            'state' => ['required'],
            'phone' => ['required'],
            'lat' => ['required'],
            'lng' => ['required'],
        ]);

        $address->update($validatedData);

        return to_route('addresses.index');
    }

    public function destroy(ModelsShippingAdress $address)
    {
        $address->delete();

        return redirect()->route('addresses.index');
    }
}

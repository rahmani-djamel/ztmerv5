<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Support\Facades\Request;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::query()
        ->search(Request::input('search')) // Use the scopeSearch method
        ->paginate(10)
        ->withQueryString()
        ->through(fn ($unit) => [
            'id' => $unit->id,
            'name' => $unit->name,
            'symbole' => $unit->symbole,
            'value' => $unit->value,
        ]);
        
        return inertia('Dashboard/Unit/Index', [
            'units' => $units,
            'filters' => Request::only(['search']),
        ]);
    }

    public function create()
    {
        return inertia('Dashboard/Unit/Create');
    }

    public function store()
    {
        Request::validate([
            'name' => ['required', 'string', 'max:255','unique:units,name'],
            'symbole' => ['required', 'string', 'max:255','unique:units,symbole'],
            'value' => ['required', 'numeric','min:0'],
        ]);

        Unit::create(Request::only('name', 'symbole', 'value'));

        return redirect()->route('unit.index')->with('success', 'Unit created.');
    }

    public function edit(Unit $unit)
    {
        return inertia('Dashboard/Unit/Edit', [
            'unit' => [
                'id' => $unit->id,
                'name' => $unit->name,
                'symbole' => $unit->symbole,
                'value' => $unit->value,
            ],
        ]);
    }

    public function update(Unit $unit)
    {
        Request::validate([
            'name' => ['required', 'string', 'max:255','unique:units,name,'.$unit->id],
            'symbole' => ['required', 'string', 'max:255','unique:units,symbole,'.$unit->id],
            'value' => ['required', 'numeric','min:0'],
        ]);

        $unit->update(Request::only('name', 'symbole', 'value'));

        return redirect()->route('unit.index')->with('success', 'Unit updated.');
    }

    public function destroy(Unit $unit)
    {
        $unit->delete();

        return redirect()->route('unit.index')->with('success', 'Unit deleted.');
    }


}

<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function getCities($stateId)
    {
        $state = State::find($stateId);
        return response()->json($state->cities);
    }
}

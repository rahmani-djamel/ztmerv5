<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;

use Inertia\Inertia;

class UserController extends Controller
{
    public function Index()
    {
       $users =  User::query()
        ->search(Request::input('search')) // Use the scopeSearch method
        ->role(Request::input('role')) // Use the role scope
        ->with('roles') // Ensure the state relationship is loaded
        ->paginate(10)
        ->withQueryString()
        ->through(fn ($user) => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->roles->first()->display_name,
            'is_admin' => $user->hasRole('SuperAdmin'),
        ]);
        return Inertia::render('Dashboard/User/Index',[
            'users' => $users,
            'filters' => Request::only(['search','role']),
        ]);
    }

    public function create()
    {
        return Inertia::render('Dashboard/User/Create');
    }

    public function store()
    {
        try {
            $validatedData = Request::validate([
                'name' => ['required'],
                'email' => ['required', 'email', 'unique:users,email'],
                'password' => ['required', 'min:8'],
                'role' => ['required', 'exists:roles,name'],
            ]);

            $validatedData['password'] = Hash::make($validatedData['password']);


            $user = User::create($validatedData);
            $user->addRole($validatedData['role']);

            return redirect()->route('user.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator->errors());
        }
    }



    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('user.index');
    }
}

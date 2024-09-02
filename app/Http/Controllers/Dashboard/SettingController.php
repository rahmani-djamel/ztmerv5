<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class SettingController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard/Setting/Index');
    }

    public function update($tab)
    {
        if ($tab == 'personal-information') {

            $user = Auth::user();

            $phone = Request::input('phone');

            if ($phone) {
                $phone = '966' . substr($phone, 1);
                Request::merge(['phone' => $phone]);
            }


            $validatedData = Request::validate([
                'name' => ['required'],
                'email' => ['required', 'email', 'unique:users,email,' . $user->id],
                'phone' => ['nullable','regex:/^9665\d{8}$/', 'unique:users,phone,' . $user->id],
                'date_of_birth' => ['nullable', 'date'],
                'avatar' => ['nullable', 'file', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            ]);

            $user->update($validatedData);

            if (Request::file('avatar')) {
                $user->avatar()->delete();
                $user->avatar()->create([
                    'name' => Request::file('avatar')->getClientOriginalName(),
                    'use' => 'avatar',
                    'type' => Request::file('avatar')->getClientOriginalExtension(),
                    'size' => Request::file('avatar')->getSize(),
                    'path' => Request::file('avatar')->store('avatars', 'public'),
                ]);
            }




            
            
        } elseif ($tab == 'password-update') {
            $validatedData = Request::validate([
                'current_password' => ['required'],
                'password' => ['required', 'confirmed', 'min:8'],
            ]);

            if (!Hash::check($validatedData['current_password'], Auth::user()->password)) {
                return back()->withErrors(['current_password' => 'كلمة المرور الحالية غير صحيحة.']);
            }

            Auth::user()->update([
                'password' => Hash::make($validatedData['password']),
            ]);
           
        }
    }
}

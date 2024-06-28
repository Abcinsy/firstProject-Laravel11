<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    
    public function register(){
        return view('auth.register');
    }

    public function store(){

        // validate user data
        $validated = request()->validate(
            [
                'name' => 'required|min:3|max:30',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|confirmed|min:8'
            ]
        );

        // create the user
        $user = User::create(
            [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]
        );

        // login

        // redirect
        return redirect()->route('dashboard')->with('success', 'Account created successfully!');

    }

}

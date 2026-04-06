<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function index() {
        return view('register');
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'student_id' => ['required', 'string', 'max:255', 'unique:users'],
            'university' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        $user = \App\Models\User::create($validatedData);

        Auth::login($user);

        return redirect()->route('homepage');
    }
}

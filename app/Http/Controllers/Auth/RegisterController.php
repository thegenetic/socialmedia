<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware(['guest']);
    }

    public function index(){
        return view('auth.register');
    }

    public function store(Request $request){
        /*

        Steps to follow:
        1. Validation
        2. Store User
        3. Sign the user in
        4. redirect page

        */

        // validation
        $this->validate($request, [
            // different ways to define rules
            'name' => 'required|max:255',
            'username' => ['required', 'max:255'],
            'email' => 'required|email|max:255',
            'password' => 'required|confirmed'
        ]);

        // store user
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        // sign user in
        Auth::attempt($request->only('email', 'password'));

        // redirect
        return redirect()->route('dashboard');
    }
}

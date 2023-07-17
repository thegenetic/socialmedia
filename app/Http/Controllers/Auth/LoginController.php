<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index(){
        return view('auth.login');
    }

    public function store(Request $request){
        $this->validate($request, [
            // different ways to define rules
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);

        if (!Auth::attempt($request->only('email', 'password'),$request->remember)){
            return back()->with('status', 'invalid credentials');
        }

        return redirect()->route('dashboard');
    }
}

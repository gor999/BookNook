<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    
    public function login(Request $request)
    {
        // dump($request->all());
        
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
       ]);

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Մուտքանունը կամ գաղտնաբառը սխալ է։',
        ])->onlyInput('email');
    }
}

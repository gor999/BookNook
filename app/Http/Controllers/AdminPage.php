<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminPage extends Controller
{
    public function dashboard()
    {
        return view('static.dashboard');
    }   

    
}

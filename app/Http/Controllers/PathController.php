<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PathController extends Controller
{
    public function show(string $id): View
    {
        dd($id);
        return view('user.profile', [
            'user' => User::findOrFail($id)
        ]);
    }



}

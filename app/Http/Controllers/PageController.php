<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\contact;

class PageController extends Controller
{
    public function home()
{
    $books = Book::with('authorRelation')->latest()->take(10)->get();
    return view('static.home', compact('books'));
}

    public function contact()
    {
        return view('static.contact');
    }
    public function about()
    {
        return view('static.about');
    }
    public function shop()
    {
        return view('static.shop');
    }

    


    public function submit(Request $request) 
{
    // Валидация (необязательно, но полезно)
    $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'message' => 'required',
    ]);

    // dd(request()->all());
    $contact = new contact();
    $contact->fill($request->only('name', 'email', 'message'));
    $contact->save();

    // Пока что просто вернемся назад с сообщением об успехе
    return back()->with('success', 'Շնորհակալություն! Ձեր հաղորդագրությունն ուղարկված է:');
}

}

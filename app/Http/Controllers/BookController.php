<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    public function index() {
        $books = Book::all();
        // $books = Book::with('author')->get();
        return view('static.shop', compact('books'));
    }
  public function expandedSearch(Request $request)
{
    
    $genreIds = $request->input('genre_ids');

    if ($genreIds) {
        $books = Book::whereHas('genres', function($query) use ($genreIds) {
            $query->whereIn('genres.id', $genreIds);
        })->get();
    } else {
        $books = collect(); 
    }

    return view('static.expanded_search', compact('books'));
}
}
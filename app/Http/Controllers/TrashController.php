<?php

namespace App\Http\Controllers;
use App\Models\Book;
use Illuminate\Http\Request;


class TrashController extends Controller
{
    public function index()
    {
        $books = Book::onlyTrashed()->latest()->get();
        return view('static.trash', compact('books'));
    }

    public function restore(string $id)
{
    $book = Book::withTrashed()->findOrFail($id);
    $book->restore();
    return redirect()->route('trash')->with('success', 'Գիրքը վերականգնվեց');
}

public function restoreAll()
{
    Book::onlyTrashed()->restore();
    return redirect()->route('trash')->with('success', 'Բոլոր գրքերը վերականգնվեցին');
}

}

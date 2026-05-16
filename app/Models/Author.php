<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $fillable = ['name'];

    public function show(Author $author){
        $books = $author->books;
        return view('authors.show', compact('author', 'books'));
    }


    public function books()
    {
        return $this->hasMany(Book::class);
    }
}

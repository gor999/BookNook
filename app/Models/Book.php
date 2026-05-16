<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Book extends Model
{
    protected $fillable = ['title', 'author_id', 'genre', 'price', 'author', 'genre_id'];
    use SoftDeletes;

    public function authorRelation()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'book_genre');
    }

    public function author()
{
    return $this->belongsTo(Author::class);
}
   
}
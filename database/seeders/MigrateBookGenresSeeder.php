<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Genre;
use App\Models\Book;

class MigrateBookGenresSeeder extends Seeder
{

    public function run(): void
    {
        $oldBooksData = DB::table('books')->whereNotNull('genre_id')->get();

        foreach ($oldBooksData as $oldData) {
            $genre = Genre::firstOrCreate(
                ['id' => $oldData->genre_id],
                ['name' => $oldData->genre]  
            );
           $book = Book::find($oldData->id);
            if ($book) {
                $book->genres()->syncWithoutDetaching([$genre->id]);
            }
        }
        
        $this->command->info('Տվյալները հաջողությամբ տեղափոխվեցին։');
    }
    
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Book;
use App\Models\Author;
use App\Models\Genre;

class ImportBooks extends Command
{
    /**
     * Հրամանի անունը, որը գրելու ես տերմինալում:
     * Օգտագործիր: php artisan import:books
     */
    protected $signature = 'import:books';

    /**
     * Հրամանի նկարագրությունը:
     */
    protected $description = 'Import books from JSON file into the database';

    public function handle()
    {
        // 1. Ստուգում ենք ֆայլի գոյությունը storage/app/books.json թղթապանակում
        $path = storage_path('book.json');

        if (!file_exists($path)) {
            $this->error("Ֆայլը չի գտնվել հետևյալ հասցեով: $path");
            return;
        }

        // 2. Կարդում ենք JSON-ը
        $jsonContent = file_get_contents($path);
        $books = json_decode($jsonContent, true);

        if (is_null($books)) {
            $this->error("JSON ֆայլը դատարկ է կամ ունի սխալ կառուցվածք:");
            return;
        }

        $this->info('Իմպորտը սկսված է...');

        foreach ($books as $bookData) {
            // Գնի մաքրում նշաններից (եթե կան)
            $price = preg_replace('/[^\d]/', '', $bookData['price']);

            // 3. Հեղինակի ստեղծում կամ ստացում
            $author = Author::firstOrCreate([
                'name' => $bookData['author']
            ]);

            // 4. Գրքի ստեղծում
            // Լրացնում ենք բոլոր դաշտերը, որոնք բազան պահանջում է
            $book = Book::create([
                'title'     => $bookData['title'],
                'author'    => $bookData['author'], // Տեքստային դաշտի համար
                'author_id' => $author->id,         // Foreign key-ի համար
                'price'     => (int) $price,
                'genre'     => $bookData['genres'][0] ?? 'Անհայտ', // Վերցնում ենք առաջին ժանրը զանգվածից
                'genre_id'  => $bookData['genre_ids'][0] ?? null,  // Վերցնում ենք առաջին ID-ն[cite: 1]
            ]);

            // 5. Many-to-Many կապի ստեղծում (Pivot table)
            // Սա կլրացնի book_genre աղյուսակը բոլոր ID-ներով[cite: 1]
            if (!empty($bookData['genre_ids'])) {
                $book->genres()->sync($bookData['genre_ids']);
            }

            $this->line("Ներմուծվեց: {$bookData['title']}");
        }

        $this->info('✅ Բոլոր գրքերը հաջողությամբ ներմուծվեցին!');
    }
}
<?php

namespace Database\Seeders;

use App\Helpers\Apis\Book;
use App\Interfaces\Book as BookInterface;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StoreBooks extends Seeder
{
    use WithoutModelEvents;
    /**
     * Run the database seeds.
     *
     * @return void
     */

    private BookInterface $book;

    public function __construct(BookInterface $book)
    {
        $this->book = $book;
    }
    public function run()
    {
        $booksApi = new Book();
        $response = $booksApi->get('books', ['_quantity' => 500]);
        if ($response->status() == 200) {
            $books = $response->json()['data'];
            if (count($books) > 0) {
                foreach($books as $book) {
                    $insertableData[] = [
                        'title' => $book['title'],
                        'author' => $book['author'],
                        'genre' => $book['genre'],
                        'description' => $book['description'],
                        'isbn' => $book['isbn'],
                        'image' => $book['image'],
                        'published_on' => $book['published'],
                        'publisher' => $book['publisher'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                $this->book->insert($insertableData);
            }
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;
use App\Models\Book;

class HomeController extends Controller
{
    private $author;
    private $book;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Author $author,Book $book)
    {
        $this->author = $author;
        $this->book = $book;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $authors_count = $this->author->count();
        $books_count = $this->book->count();
        return view('home')
                ->with('authors_count',$authors_count)
                ->with('books_count',$books_count);
    }
}

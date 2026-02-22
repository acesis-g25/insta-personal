<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public const LOCAL_STORAGE_FOLDER = "covers/";
    private $book;
    private $author;

    public function __construct(Book $book,Author $author)
    {
        $this->book = $book;
        $this->author = $author;
    }

    public function index()
    {
        $all_books = $this->book->get();
        $all_authors = $this->author->get();

        return view('books.index')
                ->with('all_authors', $all_authors)
                ->with('all_books', $all_books);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'             => 'required|min:1|max:50',
            'year_published'    => 'required|digits:4|integer|between:1800,2100',
            'cover'             => 'mimes:jpg,jpeg,png,gif|max:1048',
        ],[
            'between' => 'The year published must be between 1800 - 2100'
        ]);

        $this->book->title = $request->title;
        $this->book->year_published = $request->year_published;
        $this->book->author_id = $request->author_id;
        if($request->cover_photo){
            $this->book->cover_photo = $this->saveCover($request);
        }
        $this->book->save();

        return redirect()->back();
    }

    public function saveCover($request)
    {
        $cover_name = time().".". $request->cover_photo->extension();

        $request->cover_photo->storeAs(self::LOCAL_STORAGE_FOLDER, $cover_name);

        return $cover_name;
    }

    public function show($id)
    {
        $book = $this->book->findOrFail($id);

        return view('books.show')->with('book',$book);
    }

    public function edit($id)
    {
        $book = $this->book->findOrFail($id);
        $all_authors = $this->author->get();

        return view('books.edit')
                ->with('all_authors',$all_authors)
                ->with('book',$book);
    }

    public function update($id,Request $request)
    {
        $request->validate([
            'title' => 'required|min:1|max:50',
            'year_published' => 'required|digits:4|integer|between:1800,2100',
            'cover' => 'mimes:jpg,jpeg,png,gif|max:1048',
        ],[
            'between' => 'The year published must be between 1800 - 2100'
        ]);

        $book = $this->book->findOrFail($id);
        $book->title = $request->title;
        $book->year_published = $request->year_published;
        $book->author_id = $request->author_id;
        if($request->cover_photo){
            if($book->cover_photo)
            {
                $this->deleteCover($book->cover_photo);
            }

            $book->cover_photo = $this->saveCover($request);
        }
        $book->save();

        return redirect()->route('book.show', $id);

    }

    public function deleteCover($cover_name)
    {
        $cover_path = self::LOCAL_STORAGE_FOLDER . $cover_name;

        if(Storage::disk('public')->exists($cover_path)){
            Storage::disk('public')->delete($cover_path);
        }
    }

    public function delete($id)
    {
        $book = $this->book->findOrFail($id);

        return view('books.delete')->with('book',$book);
    }
    
    public function destroy($id)
    {
        $book = $this->book->findOrFail($id);
        $this->deleteCover($book->cover_photo);

        $this->book->destroy($id);
        return redirect()->route('book.index');
    }
}

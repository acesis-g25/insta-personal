<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;

class AuthorController extends Controller
{
    private $author;

    public function __construct(Author $author)
    {
        $this->author = $author;
    }

    public function index()
    {
        $all_authors = $this->author->get();

        return view('authors.index')->with('all_authors',$all_authors);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:1|max:50|unique:authors,name'
        ]);

        $this->author->name = $request->name;
        $this->author->save();

        return redirect()->back();
    }

    public function edit($id)
    {
        $author = $this->author->findOrFail($id);

        return view('authors.edit')->with('author',$author);
    }

    public function update($id,Request $request)
    {
        $request->validate([
            'name' => 'required|min:1|max:50|unique:authors,name,' . $id
        ]);

        $author = $this->author->findOrFail($id);
        $author->name = $request->name;
        $author->save();

        return redirect()->route('author.index');
    }

    public function delete($id)
    {
        $author = $this->author->findOrFail($id);

        return view('authors.delete')->with('author',$author);
    }
    
    public function destroy($id)
    {
        $this->author->destroy($id);

        return redirect()->route('author.index');
    }
}

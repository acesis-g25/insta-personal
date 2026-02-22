@extends('layouts.app')

@section('title', 'Book')

@section('content')
    <h3>Add a new book</h3>
    <form action="{{ route('book.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control w-100" name="title" id="title" value="{{ old('title') }}" autofocus>
            @error('title')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <div class="row">
                <div class="col">
                    <label for="year-published" class="form-label">Year Published</label>
                    <input type="number" class="form-control" name="year_published" id="year-published"
                        placeholder="YYYY" value="{{ old('year_published') }}">
                    @error('year_published')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col">
                    <label for="author_id" class="form-label">Author</label>
                    <select class="form-select" name="author_id" id="author_id">
                        <option value="">ANONYMOUS</option>
                        @foreach ($all_authors as $author)
                            <option value="{{ $author->id }}">{{ $author->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label for="cover-photo" class="form-label">Cover Photo <span class="fst-italic">(optional)</span></label>
            <div class="row justify-content-center">
                <div class="col">
                    <input type="file" name="cover_photo" id="cover-photo" class="form-control" aria-describedby="cover-info">
                    <div id="cover-info" class="form-text">
                        Acceptable formats: jpeg, jpg, png, gif only 
                        <br>
                        Maximum file size: 1048kb
                    </div>
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-success w-100"><i class="fa-solid fa-plus me-1"></i>Add</button>
                </div>
            </div>
            @error('cover_photo')
                <p class="text-danger small">{{ $message }}</p>
            @enderror
        </div>
    </form>

    <hr class="my-5">

    <h3>List of books</h3>
    <ul class="list-group">
        @forelse ($all_books as $book)
            <li class="list-group-item">
                <div class="row">
                    <div class="col">
                        <a href="{{ route('book.show', $book->id) }}">
                            {{ $book->title }}
                        </a>
                    </div>
                    <div class="col text-end">
                        <a href="{{ route('book.edit', $book->id) }}" title="Edit"
                            class="btn btn-outline-warning btn-sm border-0"><i class="fa-solid fa-file-pen "></i></a>
                        <a href="{{ route('book.delete', $book->id) }}" title="Delete"
                            class="btn btn-outline-danger btn-sm border-0"><i class="fa-solid fa-trash-can "></i></a>
                    </div>
                </div>
            </li>
        @empty
            <h4 class="text-center text-secondary fst-italic">No Books Yet</h4>
        @endforelse
    </ul>
@endsection

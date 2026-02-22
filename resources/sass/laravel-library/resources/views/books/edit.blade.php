@extends('layouts.app')

@section('title', $book->title)

@section('content')

    <h3>Edit book</h3>

    <div class="row">
        <div class="col-4">
            @if ($book->cover_photo)
                <img src="{{ asset('/storage/covers/' . $book->cover_photo) }}" alt="{{ $book->cover_photo }}" class="w-100">
            @else
                <i class="fa-solid fa-image fa-10x text-secondary"></i>
            @endif
        </div>
        <div class="col">
            <form action="{{ route('book.update', $book->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('patch')

                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control w-100" name="title" id="title"
                        value="{{ old('title', $book->title) }}" autofocus>
                    @error('title')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col">
                            <label for="year-published" class="form-label">Year Published</label>
                            <input type="number" maxlength="4" class="form-control" name="year_published"
                                id="year-published" placeholder="YYYY"
                                value="{{ old('year_published', $book->year_published) }}">
                            @error('year_published')
                                <p class="text-danger small">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col">
                            <label for="author_id" class="form-label">Author</label>
                            <select class="form-select" name="author_id" id="author_id">
                                @if (!$book->author_id)
                                    <option value="" selected>ANONYMOUS</option>
                                @endif
                                @forelse ($all_authors as $author)
                                    @if ($book->author_id === $author->id)
                                        <option value="{{ $author->id }}" selected>{{ $author->name }}</option>
                                    @else
                                        <option value="{{ $author->id }}">{{ $author->name }}</option>
                                    @endif
                                @empty
                                @endforelse
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="cover-photo" class="form-label">Cover Photo <span class="fst-italic">(optional)</span></label>
                    <div class="row">
                        <div class="col">
                            <input type="file" name="cover_photo" id="cover-photo" class="form-control"
                                aria-describedby="cover-info">
                            <div id="cover-info" class="form-text">
                                Acceptable formats: jpeg, jpg, png, gif only
                                <br>
                                Maximum file size: 1048kb
                            </div>
                            @error('cover_photo')
                                <p class="text-danger small">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <a href="{{ route('book.show', $book->id) }}" class="btn btn-outline-warning w-100">Cancel</a>
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-warning w-100">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

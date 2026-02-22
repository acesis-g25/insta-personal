@extends('layouts.app')

@section('title', $book->title)

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <h2 class="h3 mb-0">Book Preview</h2>
                </div>
                <div class="col text-end">
                    <a href="{{ route('book.index') }}" class="btn btn-warning">Back</a>
                    <a href="{{ route('book.edit', $book->id) }}" class="btn btn-warning">Edit this book</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-3">
                    @if ($book->cover_photo)
                        <img src="{{ asset('/storage/covers/' . $book->cover_photo) }}" alt="{{ $book->cover_photo }}" class="w-100">
                    @else
                        <i class="fa-solid fa-image fa-10x text-secondary d-block text-center"></i>
                    @endif
                </div>
                <div class="col">
                    <h3 class="mb-0">{{ $book->title }}</h3>
                    <p class="text-muted fw-bold">
                        @if ($book->author_id)
                            by {{ $book->author->name }}
                        @else
                            by Anonymous
                        @endif
                    </p>
                    <p class="text-muted">
                        Published in {{ $book->year_published }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection

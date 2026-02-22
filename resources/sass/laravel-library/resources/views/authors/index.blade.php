@extends('layouts.app')

@section('title', 'Author')

@section('content')
    <h3>Authors</h3>
    <form action="{{ route('author.store') }}" method="post">
        @csrf
        <div class="row justify-content-center">
            <div class="col-10">
                <input type="text" class="form-control" name="name" placeholder="Add new author" value="{{ old('name') }}" autofocus>
            </div>
            <div class="col">
                <button type="submit" class="btn btn-success w-100"><i class="fa-solid fa-plus me-1"></i>Add</button>
            </div>
        </div>
        @error('name')
            <p class="text-danger small">{{ $message }}</p>
        @enderror
    </form>

    <ul class="list-group mt-4">
        @forelse ($all_authors as $author)
        <li class="list-group-item">
            <div class="row">
                <div class="col">{{ $author->name }}</div>
                <div class="col text-end">
                    <a href="{{ route('author.edit', $author->id) }}" title="Edit" class="btn btn-outline-warning btn-sm border-0"><i class="fa-solid fa-file-pen "></i></a>
                    <a href="{{ route('author.delete', $author->id) }}" title="Delete" class="btn btn-outline-danger btn-sm border-0"><i class="fa-solid fa-trash-can "></i></a>
                </div>
            </div>
        </li>
        @empty
            <h4 class="text-center text-secondary fst-italic">No Authors Yet</h4>
        @endforelse
    </ul>
@endsection
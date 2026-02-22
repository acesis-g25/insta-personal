@extends('layouts.app')

@section('title', 'Delete Author')

@section('content')
    <h3>Delete author</h3>
    <p>Are you sure you want to delete <span class="fw-bold">{{ $author->name }}</span>?</p>

    <form action="{{ route('author.destroy', $author->id) }}" method="POST" class="mt-4">
        @csrf
        @method('DELETE')
        <div class="row">
            <div class="col">
                <a href="{{ route('author.index') }}" class="btn btn-outline-danger w-100">Cancel</a>
            </div>
            <div class="col p-0">
                <button type="submit" class="btn btn-danger w-100"><i class="fa-solid fa-triangle-exclamation me-1"></i>Delete</button>
            </div>
        </div>
    </form>
@endsection

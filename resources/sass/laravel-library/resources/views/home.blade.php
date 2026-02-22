@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="row justify-content-center">
    <div class="col">
        <a href="{{ route('author.index') }}" class="text-decoration-none">
            <div class="card py-5">
                <div class="card-body">
                    <h2 class="text-primary text-center fw-bold display-4">
                        Authors {{ $authors_count }}
                    </h2>
                </div>
            </div>
        </a>
    </div>
    <div class="col">
        <a href="{{ route('book.index') }}" class="text-decoration-none">
            <div class="card py-5">
                <div class="card-body">
                    <h2 class="text-success text-center fw-bold display-4">
                        Books {{ $books_count }}
                    </h2>
                </div>
            </div>
        </a>
    </div>
</div>
@endsection

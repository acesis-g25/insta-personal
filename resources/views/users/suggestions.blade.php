@extends('layouts.app')

@section('title', 'Suggestions For You')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <h4 class="text-center fw-bold mb-4">Suggested Users</h4>

            @foreach($suggested_users as $user)
                <div class="row align-items-center mb-3">
                    <div class="col-auto">
                        <a href="{{ route('profile.show', $user->id) }}">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="" class="rounded-circle avatar-md">
                            @else
                                <i class="fa-solid fa-circle-user text-secondary icon-md"></i>
                            @endif
                        </a>
                    </div>
                    <div class="col ps-0">
                        <a href="{{ route('profile.show', $user->id) }}" class="text-decoration-none text-dark fw-bold">
                            {{ $user->name }}
                        </a>
                        <p class="text-muted small mb-0">{{ $user->email }}</p>
                    </div>
                    <div class="col-auto">
                        <form action="{{ route('follow.store', $user->id) }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-link text-primary p-0 text-decoration-none small">Follow</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
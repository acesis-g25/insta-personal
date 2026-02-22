@extends('layouts.app')

@section('title', 'Admin:Posts')

@section('content')
    <table class="table table-hover align-middle bg-white border text-secondary">
        <thead class="small table-primary text-secondary">
            <tr>
                <th></th>
                <th></th>
                <th>CATEGORY</th>
                <th>OWNER</th>
                <th>CREATED AT</th>
                <th>STATUS</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($all_posts as $post)
                <tr>
                    <td>{{ $post->id }}</td>
                    <td>
                            @if ($post->image)
                                <img src="{{$post->image}}" alt="{{$post->id}}" class="d-block  mx-auto avatar-md">
                            @else
                                <i class="fa-solid fa-square-user d-block text-center icon-md"></i>
                            @endif
                    </td>
                    <td>
                        @forelse ($post->categoryPost as $category_post)
                        <div class="badge bg-secondary opacity-50">
                            {{ $category_post->category->name}}
                        </div>
                        @empty
                            <div class="badge bg-dark">
                                uncategorized
                            </div>              
                        @endforelse
                    </td>
                    {{-- <td>
                        <a href="{{route('profile.show', $post->id)}}" class="text-decoration-none text-dark fw-bold">{{$post->name}}</a>
                    </td> --}}
                    <td>{{$post->user->name}}</td>
                    <td>{{$post->created_at}}</td>
                    <td>
                        @if ($post->trashed())
                            <i class="fa-regular fa-circle text-secondary"></i>&nbsp;Hidden
                        @else
                             <i class="fa-solid fa-circle text-success"></i>&nbsp;Visible
                        @endif
                       
                    </td>
                    <td>
                         {{-- @if (Auth::post()->id !== $post->id) --}}

                            <div class="dropdown">
                                <button class="btn btn-sm shadow-none" data-bs-toggle="dropdown">
                                    <i class="fa-solid fa-ellipsis"></i>
                                </button>

                                <div class="dropdown-menu">
                                    @if ($post->trashed())
                                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#visible-post-{{$post->id}}"><i class="fa-solid fa-eye"></i>Unhide Post{{$post->id}}</button>
                                    @else
                                         <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#hidden-post-{{$post->id}}"><i class="fa-solid fa-eye-slash"></i>Hide post{{$post->id}}</button>
                                    @endif
                                   
                                </div>
                                @include('admin.posts.modals.status')
                            </div>
                        {{-- @endif --}}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{-- <div class="d-flex justify-content-center">
        {{ $all_posts->links() }}
    </div> --}}
@endsection
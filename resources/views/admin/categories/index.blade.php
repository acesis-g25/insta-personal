@extends('layouts.app')

@section('title', 'Admin:categories')

@section('content')

<form action="{{ route('admin.categories.store') }}" method="post" class="mb-3">
        @csrf
        <div class="row justify-content-center">
            <div class="col-10">
                <input type="text" class="form-control" name="name" placeholder="Add a category" value="{{ old('name') }}" autofocus>
            </div>
            <div class="col">
                <button type="submit" class="btn btn-primary w-100"><i class="fa-solid fa-plus me-1"></i>Add</button>
            </div>
        </div>
        @error('name')
            <p class="text-danger small">{{ $message }}</p>
        @enderror
</form>
    
<table class="table table-hover align-middle bg-white border text-secondary">
   
    <thead class="small table-primary text-secondary">
        <tr>
            <th>#</th>
            <th>NAME</th>
            <th>COUNT</th>
            <th>LAST UPDATED</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($all_categories as $category)
        <tr>
            <td>{{ $category->id }}</td>
            
            <td>{{$category->name}}</td>
            <td>{{$category->categoryPost->count()}}</td>
            <td>{{$category->updated_at}}</td>
            <td>
                <button class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#update-category-{{$category->id}}"><i class="fa-solid fa-pen"></i></button>
                <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete-category-{{$category->id}}"><i class="fa-regular fa-trash-can"></i></button>
            </td>
            @include('admin.categories.modals.status')
        </tr>
        @endforeach
    </tbody>
    <tbody>
    @foreach ($all_categories as $category)
        {{-- ... 既存のカテゴリー表示行 ... --}}
    @endforeach
    {{-- ここから Uncategorized 行を手動で追加 --}}
    <tr>
        <td>0</td> {{-- IDは便宜上0などにします --}}
        <td>
            Uncategorized
            <p class="xsmall text-muted mb-0">Hidden posts are not included.</p>
        </td>
        <td>{{ $uncategorized_count }}</td> {{-- コントローラーから渡された数 --}}
        <td></td> {{-- 更新日時は空欄 --}}
        <td></td> {{-- 編集・削除ボタンは不要 --}}
    </tr>
</tbody>
</table>
<div class="d-flex justify-content-center mt-3">
    {{ $all_categories->links() }}
</div>
@endsection
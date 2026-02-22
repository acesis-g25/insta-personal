{{-- @if ($category->trashed()) --}}
    <div class="modal fade" id="update-category-{{$category->id}}">
    <div class="modal-dialog">
        <div class="modal-content border-warning">
            <div class="modal-header border-warning">
                <h3 class="h5 modal-title text-warning">
                    <i class="fa-solid fa-pen-to-square"></i>Edit Category
                </h3>
            </div>
            
               
        
            
                <form action="{{route('admin.categories.update', $category->id)}}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="modal-body">
                        <div class="mt-3">
                            <input type="text" name="name" class="form-control" value="{{ old('name', $category->name)}}" required>
                        </div>
                    </div>
                    <div class="modal-footer border-0">

                        <button type="button" class="btn btn-outline-warning btn-sm" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning btn-sm">Update</button>
                       
                    </div>
                </form>    
        </div>
    </div>
</div>
{{-- @else --}}
    <div class="modal fade" id="delete-category-{{$category->id}}">
    <div class="modal-dialog">
        <div class="modal-content border-danger">
            <div class="modal-header border-danger">
                <h3 class="h5 modal-title text-danger">
                    <i class="fa-regular fa-trash-can"></i>Delete Category
                </h3>
            </div>
            <div class="modal-body">
               <p>Are you sure you want to delte {{ $category->name }} category?</p> 
               <p>This action will affect all the posts under this category. Posts without a category will fallunder Uncategorized</p>
            </div>
               
        
            <div class="modal-footer border-0">
                <form action="{{route('admin.categories.delete', $category->id)}}" method="POST">
                    @csrf
                    @method('DELETE')

                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- @endif --}}


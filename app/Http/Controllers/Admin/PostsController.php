<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;


class PostsController extends Controller
{
    private $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    //opens the admin index page
    public function index(){
        // $all_users = $this->post->latest()->get();
        
         //withTrashed() will include the soft deleted records in a query result.
        $all_posts = Post::withTrashed()->latest()->paginate(10); 
         $all_posts = $this->post->withTrashed()->latest()->get();
        
         
        return view('admin.posts.index')->with('all_posts', $all_posts);
    }

    public function hidden($id){

        $this->post->destroy($id);

        return redirect()->back();
    }

    public function visible($id){
        
        $this->post->onlyTrashed()->findOrFail($id)->restore();
        //onlyTrashed() retrieves soft deleted record only
        //restore() will set the 'deleted_at' column to null
        return redirect()->back();
    }
//      public function hidden($id)
// {
//     // 論理削除（ユーザーが消したもの）されていても見つけられるように withTrashed() を使用
//     $post = $this->post->withTrashed()->findOrFail($id);

//     // データベースからレコードを物理的に削除（抹消）
//     $post->forceDelete();

//     return redirect()->back();
// }
    
    



}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Post;

class CategoriesController extends Controller
{
    private $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    //opens the admin index page
    public function index(){
        // $all_users = $this->category->latest()->get();
         $all_categories = $this->category->latest()->paginate(5);
         //withTrashed() will include the soft deleted records in a query result.
        // カテゴリーがNULL（未設定）の投稿をカウント
        // 中間テーブル(category_post)に紐付けがない投稿をカウント
    $uncategorized_count = Post::doesntHave('categoryPost')->count();

    return view('admin.categories.index')
        ->with('all_categories', $all_categories)
        ->with('uncategorized_count', $uncategorized_count);
    }

    public function update(Request $request, $id){


        $request->validate([
            'name' => 'required|min:1|max:50' . $id
        ]);

        $category = $this->category->findOrFail($id);

        $category->name = $request->name;

        $category->save();

        return redirect()->back();
    }

    public function delete($id){
        
        $category = $this->category->findOrFail($id);
        $category->delete(); 

        return redirect()->back();
    }
    public function store(Request $request){
    
        $request->validate([
            'name' => 'required|min:1|max:50'
        ]);

        $this->category->name = $request->name;
        $this->category->save();

        return redirect()->back();
    }
   
}

<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Post;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class PostController extends Controller
{
    private $post;
    private $category;
    public function __construct(Post $post, Category $category)
    {
        $this->post = $post;
        $this->category = $category;
    }


    //Opens the post create page.
    public function create(){
        $all_categories = $this->category->all();
        //daisy chain
        return view('users.posts.create')->with('all_categories', $all_categories);
    }
    
    //Stores a post in posts table and categories in pivot table.
    public function store(Request $request){
        #1. Validate all form data
        $request->validate([
            'category' => 'required|array|between:1,3',//between will check the number of items in an array
            'description' => 'required|min:1|max:1000',
            'image' => 'required|mimes:jpeg,jpg,png,gif|max:1048'
        ]);

        #2 save the post
        $this->post->user_id        = Auth::user()->id;
        $this->post->image          ='data:image/' . $request->image->extension() . ';base64,' .  base64_encode(file_get_contents($request->image));
        $this->post->description    =$request->description;
        $this->post->save();

        #3 ssave the categories to the category_post table
        foreach($request->category as $category_id){
            $category_post[] = ['category_id' => $category_id];
        }
        $this->post->categoryPost()->createMany($category_post);

        #4 Go back to homepage
        return redirect()->route('index');
    }

        //opens the post show and displays the info of a post
        public function show($id){
            $post = $this->post->findOrFail($id);

            return view('users.posts.show')->with('post', $post);
        }

        //opens the edit show page and displays the info of a post
        public function edit($id){
            $post= $this->post->findOrFail($id);

            #if the Auth user is not the owner of the post, redirect to homepage
            if(Auth::user()->id !=$post->user->id){
                return redirect()->route('index');
            }
            $all_categories = $this->category->all();

            #Get all the category IDs of this post. save in an array.
            $selected_categories = [];
            foreach($post->categoryPost as $category_post){
                $selected_categories[] = $category_post->category_id;
            }

            return view('users.posts.edit')
                ->with('post', $post)
                ->with('all_categories', $all_categories)
                ->with('selected_categories', $selected_categories);
        }
        //update the past
        public function update(Request $request, $id){
            #1 validate the data from the form
            $request->validate([
                'category' => 'required|array|between:1,3',
                'description' => 'required|min:1|max:1000',
                'img'         =>'mimes:jpeg,png,jpg,gif|max:1048'
            ]);

            #2 Update the post
            $post = $this->post->findOrFail($id);
            $post->description = $request->description;

            //if there is a new image
            if($request->image){
                $post->image = 'data:image/' . $request->image->extension() . ';base64,' .  base64_encode(file_get_contents($request->image));
            }
            $post->save();

            #3 delete all records from category_post releated to this post
            $post->categoryPost()->delete();
            //use the relationship post::categoryPost()to select the records related to a post.
            //equivalent:elete from category_post where post_id = $id;

            #4 save the new categories to category_post table
            foreach($request->category as $category_id){
                $category_post[] = ['category_id' => $category_id];
            }
            $post->categoryPost()->createMany($category_post);

            #5 redirect to show Post page
            return redirect()->route('post.show', $post->id);
        }

        //Deletes a post
        public function destroy($id){
            // $this->post->destroy($id);
            $post = $this->post->findOrFail($id);
            $post->forceDelete();
            return redirect()->route('index');
        }

       

}

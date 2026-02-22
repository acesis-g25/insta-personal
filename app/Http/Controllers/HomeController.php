<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    private $post;
    private $user;

    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Post $post, User $user)
    {
        $this->post = $post;
        $this->user = $user;
        //$this->middleaware('auth)
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //$all_posts = $this->post->latest()->get();
        $home_posts = $this->getHomePosts();
        $suggested_users = $this->getSuggestedUsers();
        return view('users.home')// opens resources/views/...
                ->with('home_posts', $home_posts)
                ->with('suggested_users', $suggested_users);
    }

    #get the posts of the users that the Auth user is following
    private function getHomePosts(){
        $all_posts = $this->post->latest()->get();
        $home_posts = [];

        foreach($all_posts as $post){
            if($post->user->isFollowed() || $post->user->id === Auth::user()->id){
                $home_posts[] = $post;
                //$home_posts = []
            }
        }

        return $home_posts;
    }

    private function getSuggestedUsers(){
        $all_users = $this->user->all()->except(Auth::user()->id);
        $suggested_users = [];

        foreach($all_users as $user){
            if(!$user->isFollowed()){
                $suggested_users[] = $user;
            }
        }

        return array_slice($suggested_users,0,5);
        //array_slice(x,y,z)
        //x -> array
        //y ->affset/staring index
        //z -> Length/how many
    }
    public function suggestions(){

    // getSuggestedUsers と同じロジックで全件取得する
    $all_users = $this->user->all()->except(Auth::user()->id);
    $suggested_users = [];

    foreach($all_users as $user){
        if(!$user->isFollowed()){
            $suggested_users[] = $user;
        }
    }

    // array_slice をせず、全ての $suggested_users を渡す
    return view('users.suggestions')->with('suggested_users', $suggested_users);
}


   

    
}

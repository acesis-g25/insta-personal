<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    //opens profile page and display the infar of the user
    public function show($id){
        $user = $this->user->findOrFail($id);
        return view('users.profile.show')->with('user', $user);
    }

    //opens profile edit page and display the info of the logged in user
    public function edit(){
        $user = $this->user->FindOrFail(Auth::user()->id);
        return view('users.profile.edit')->with('user',$user);
    }

    //updates the logged in user
    public function update(Request $request){
        $request->validate([
            'name' =>'required|min:1|max:50',
            'email' =>'required|email|max:50|unique:users,email,' .Auth::user()->id,
            'avatar' =>'mimes:jpg,jpeg,gif,png|max:1048',
            'introduction' =>'max:100'

        ]);

        //unique:table,column,exceptID

        $user = $this->user->findOrFail(Auth::user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->introduction = $request->introduction;

        //if there is anew avatar
        if($request->avatar){
                $user->avatar = 'data:image/' . $request->avatar->extension() . ';base64,' .  base64_encode(file_get_contents($request->avatar));
            }

        #save
        $user->save();

        return redirect()->route('profile.show', Auth::user()->id);
    }

    public function followers($id){
        $user = $this->user->findOrFail($id);
        return view('users.profile.followers')->with('user', $user); 
    }


    public function following($id){
        $user = $this->user->findOrFail($id);
        return view('users.profile.following')->with('user', $user); 
    }
}

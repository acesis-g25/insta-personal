<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;


class UsersController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    //opens the admin index page
    public function index(){
        // $all_users = $this->user->latest()->get();
         $all_users = $this->user->withTrashed()->latest()->get();
         //withTrashed() will include the soft deleted records in a query result.
         
        return view('admin.users.index')->with('all_users', $all_users);
    }

    public function deactivate($id){
        $this->user->destroy($id);
        return redirect()->back();
    }

    public function activate($id){
        $this->user->onlyTrashed()->findOrFail($id)->restore();
        //onlyTrashed() retrieves soft deleted record only
        //restore() will set the 'deleted_at' column to null
        return redirect()->back();
    }
    
}

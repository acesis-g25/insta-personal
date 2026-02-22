<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;
    

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    # to get all the pasts of user
    public function posts(){
        return $this->hasMany(Post::class)->latest();
    }

    #to get all the followers of a user
    public function followers(){
        return $this->hasMany(Follow::class, 'following_id');
    }
    #to get all the followers the user is following
    public function following(){
        return $this->hasMany(Follow::class, 'follower_id');
    }


    #Return TRUE if the logged in user is following a user
    public function isFollowed(){
        return $this->followers()->where('follower_id', Auth::user()->id)->exists();
        //Auth::user()->id is the follower_id
        //Firstly, get all the followers of the User($this->followers()). Then, from that list, search for the Auth user from the follower form column (where('follower_id', Auth::user()->id))

    }

}

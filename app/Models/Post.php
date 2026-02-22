<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
class Post extends Model
{
    #a post belongs to a user
    #To get the owner of the next
    use SoftDeletes;

    public function user(){
        return $this->belongsTo(User::class)->withTrashed();
    }

    #to get the categories under a post
    public function categoryPost(){
        return $this->hasMany(CategoryPost::class);
    }
    public function comments(){
        return $this->hasMany(Comment::class);
    }
      #TO get the likes of a post
    public function likes(){
        return $this->hasMany(Like::class);
    }
     #returns True if the auth already liked the post
    public function isliked(){
        return $this->likes()->where('user_id', Auth::user()->id)->exists();
    }

    // app/Models/Post.php

protected static function boot()
{
    parent::boot();

    static::deleting(function($post) {
        // forceDelete() が実行された時だけ、子データを道連れにする
        if ($post->isForceDeleting()) {
            $post->comments()->delete();     // コメント削除
            $post->likes()->delete();        // いいね削除
            $post->categoryPost()->delete(); // ピボットテーブルの紐付け削除
        }
    });
}
}

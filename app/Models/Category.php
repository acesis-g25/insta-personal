<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    #admin side[soon]
    #To get the number of categories for each post.
    public function categoryPost(){
        return $this->hasMany(CategoryPost::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    # To get the books of an author
    public function books()
    {
        return $this->hasMany(Book::class);
    }
}

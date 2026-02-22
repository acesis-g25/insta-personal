<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    # To get the author of a book
    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}

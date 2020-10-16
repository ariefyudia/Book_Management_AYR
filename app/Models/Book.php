<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','description'
    ];

    public function author()
    {
        return $this->belongsToMany('App\Models\Author','book_authors','book_id','author_id');
    }
}
